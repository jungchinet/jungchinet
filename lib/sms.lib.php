<?
if (!defined('_GNUBOARD_')) exit;

function array_overlap($arr, $val) {
    for ($i=0, $m=count($arr); $i<$m; $i++) {
        if ($arr[$i] == $val)
            return true;
    }
    return false;
}

function get_sock($url)
{
    // host 와 uri 를 분리
    if (preg_match("`http://([a-zA-Z0-9_\-\.]+)([^<]*)`", $url, $res))
    {
        $host = $res[1];
        $get  = $res[2];
    }

    // 80번 포트로 소캣접속 시도
    $fp = fsockopen ($host, 80, $errno, $errstr, 30);
    if (!$fp)
    {
        die("$errstr ($errno)\n");
    }
    else
    {
        fputs($fp, "GET $get HTTP/1.0\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "\r\n");

        // header 와 content 를 분리한다.
        while (trim($buffer = fgets($fp,1024)) != "")
        {
            $header .= $buffer;
        }
        while (!feof($fp))
        {
            $buffer .= fgets($fp,1024);
        }
    }
    fclose($fp);

    // content 만 return 한다.
    return $buffer;
}

function get_hp($hp, $hyphen=1)
{
    global $g4;

    if (!is_hp($hp)) return '';

    if ($hyphen) $preg = "$1-$2-$3"; else $preg = "$1$2$3";

    $hp = str_replace('-', '', trim($hp));
    $hp = preg_replace("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $preg, $hp);

    if ($g4[sms4_demo])
        $hp = '0100000000';

    return $hp;
}

function is_hp($hp)
{
    $hp = str_replace('-', '', trim($hp));
    if (preg_match("/^(01[016789])([0-9]{3,4})([0-9]{4})$/", $hp))
        return true;
    else
        return false;
}

// 경고메세지를 경고창으로
function alert_just($msg='', $url='')
{
	global $g4;

    if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

	//header("Content-Type: text/html; charset=$g4[charset]");
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
	echo "<script language='javascript'>alert('$msg');";
    echo "</script>";
    exit;
}

/**
 * SMS 발송을 관장하는 메인 클래스이다.
 *
 * 접속, 발송, URL발송, 결과등의 실질적으로 쓰이는 모든 부분이 포함되어 있다.
 */

class SMS4 {
	var $smshub_id;
	var $smshub_pw;
	var $socket_host;
	var $socket_port;
	var $Data = array();
	var $Result = array();
	var $Log = array();

	// 접속을 위해 사용하는 변수를 정리한다.
	function SMS_con($host,$id,$pw,$portcode) {

        $port=7192; // 충전식만 지원

		$this->socket_host	= $host;
		$this->socket_port	= $port;
		$this->smshub_id		= FillSpace($id, 12);
		$this->smshub_pw		= FillSpace($pw, 20);
	}

	function Init() {
		$this->Data		= "";	// 발송하기 위한 패킷내용이 배열로 들어간다.
		$this->Result	= "";	// 발송결과값이 배열로 들어간다.
	}

	function Add($strDest, $strCallBack, $strCaller, $strURL, $strMessage, $strDate="", $nCount) {
        global $g4;

        if (strtolower($g4['charset']) == 'utf-8') {
            $strMessage = iconv('utf-8', 'cp949', $strMessage);
        }

        $Error = CheckCommonTypeDest($strDest, $nCount);
		$Error = CheckCommonTypeCallBack($strCallBack);
		$Error = CheckCommonTypeDate($strDate);

		$strCallBack    = FillSpace($strCallBack,11);
		$strCaller      = FillSpace($strCaller,10);

        if ($strDate) $strDate .= '00';
		$strDate		= FillSpace($strDate,14);

		for ($i=0; $i<$nCount; $i++) {
			$hp_number	= FillSpace($strDest[$i][bk_hp],11);
            $strData    = str_replace("{이름}", $strDest[$i][bk_name], $strMessage);

			if (!$strURL) {
                $strURL = FillSpace($strURL, 50);
				$strData	= FillSpace(CutChar($strData,80),80);

				$this->Data[$i]	= '02'.$this->smshub_id.$this->smshub_pw.$hp_number.$strCallBack.$strURL.$strDate.$strData;
                $strURL = '';
			} else {
				$strURL		= FillSpace($strURL,50);
				$strData	= FillSpace(CheckCallCenter($strURL, $hp_number, $strData),80);

				$this->Data[$i]	= '00'.$this->smshub_id.$this->smshub_pw.$hp_number.$strCallBack.$strURL.$strDate.$strData;
			}
		}
		return true; // 수정대기
	}

	function Send() {
        global $g4;

        $count = 1;

        if ($g4[sms4_demo_send]) {
            foreach($this->Data as $puts) {
                if (rand(0,10)) {
                    $phone = substr($puts,34,11);
                    $code = '0001012345678';
                } else {
                    $phone = substr($puts,34,11);
                    $code = 'Error(02)';
                }
                $this->Result[] = "$phone:$code";
                $this->Log[] = $puts;
            }
            $this->Data = "";
            return true;
            exit;
        }

		$fsocket=fsockopen($this->socket_host,$this->socket_port);
		if (!$fsocket) return false;
		set_time_limit(300);

		## php4.3.10일경우
        ## zend 최신버전으로 업해주세요..
        ## 또는 69번째 줄을 $this->Data as $tmp => $puts 로 변경해 주세요.

		foreach($this->Data as $puts) {
			$dest = substr($puts,34,11);
			fputs($fsocket, $puts);
			while(!$gets) {
				$gets = fgets($fsocket,14);
			}
			if (substr($gets,0,2) == "00") {
				$this->Result[] = $dest.":".substr($gets,0,2);
				$this->Log[] = $puts;
            } else {
				$this->Result[$dest] = $dest.":Error(".substr($gets,0,2).")";
				$this->Log[] = $puts;
            }
			$gets = "";

            // 1천건씩 전송 후 5초 쉼
            if ($count++%1000 == 0) sleep(5);
		}
		fclose($fsocket);
		$this->Data = "";
		return true;
	}
}

/**
 * 원하는 문자열의 길이를 원하는 길이만큼 공백을 넣어 맞추도록 합니다.
 *
 * @param	text	원하는 문자열입니다.
 *			size	원하는 길이입니다.
 * @return			변경된 문자열을 넘깁니다.
 */
function FillSpace($text,$size) {
	for ($i=0; $i<$size; $i++) $text.=" ";
	$text = substr($text,0,$size);
	return $text;
}


/**
 * 원하는 문자열을 원하는 길에 맞는지 확인해서 조정하는 기능을 합니다.
 *
 * @param	word	원하는 문자열입니다.
 *			cut		원하는 길이입니다.
 * @return			변경된 문자열입니다.
 */
function CutChar($word, $cut) {
	$word=substr($word,0,$cut);						// 필요한 길이만큼 취함.
	for ($k=$cut-1; $k>1; $k--) {
		if (ord(substr($word,$k,1))<128) break;		// 한글값은 160 이상.
	}
	$word=substr($word,0,$cut-($cut-$k+1)%2);
	return $word;
}


/**
 * 발송번호의 값이 정확한 값인지 확인합니다.
 *
 * @param	strDest	발송번호 배열입니다.
 *			nCount	배열의 크기입니다.
 * @return			처리결과입니다.
 */
function CheckCommonTypeDest($strDest, $nCount) {
	for ($i=0; $i<$nCount; $i++) {
		$hp_number = preg_replace("`[^0-9]`","",$strDest[$i][bk_hp]);
		if (strlen($hp_number)<10 || strlen($hp_number)>11) return "휴대폰 번호가 틀렸습니다";

		$CID=substr($hp_number,0,3);
		if ( preg_match("`[^0-9]`",$CID) || ($CID!='010' && $CID!='011' && $CID!='016' && $CID!='017' && $CID!='018' && $CID!='019') ) return "휴대폰 앞자리 번호가 잘못되었습니다";
	}
}


/**
 * 회신번호의 값이 정확한 값인지 확인합니다.
 *
 * @param	strDest	회신번호입니다.
 * @return			처리결과입니다.
 */
function CheckCommonTypeCallBack($strCallBack) {
	if (preg_match("`[^0-9]`", $strCallBack)) return "회신 전화번호가 잘못되었습니다";
}


/**
 * 예약날짜의 값이 정확한 값인지 확인합니다.
 *
 * @param	text	원하는 문자열입니다.
 *			size	원하는 길이입니다.
 * @return			처리결과입니다.
 */
function CheckCommonTypeDate($strDate) {
	$strDate=preg_replace("`[^0-9]`","",$strDate);
	if ($strDate) {
		if (!checkdate(substr($strDate,4,2),substr($strDate,6,2),substr($rsvTime,0,4))) return "예약날짜가 잘못되었습니다";
		if (substr($strDate,8,2)>23 || substr($strDate,10,2)>59) return "예약시간이 잘못되었습니다";
	}
}


/**
 * URL콜백용으로 메세지 크기를 수정합니다.
 *
 * @param	url		URL 내용입니다.
 *			msg		결과메시지입니다.
 *			desk	문자내용입니다.
 */
function CheckCallCenter($url, $dest, $data) {
	switch (substr($dest,0,3)) {
		case '010': //20바이트
			return CutChar($data,20);
			break;
		case '011': //80바이트
			return CutChar($data,80);
			break;
		case '016': // 80바이트
			return CutChar($data,80);
			break;
		case '017': // URL 포함 80바이트
			return CutChar($data,80 - strlen($url));
			break;
		case '018': // 20바이트
			return CutChar($data,20);
			break;
		case '019': // 20바이트
			return CutChar($data,20);
			break;
		default:
			return CutChar($data,80);
			break;
	}
}
?>
