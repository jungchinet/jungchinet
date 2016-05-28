<?php
include("_common.php");

if (function_exists("date_default_timezone_set"))
    date_default_timezone_set("Asia/Seoul");

   /*
	* @file  zmSpamFree.php
	* @author 지앤미(ZnMee) <znmee@naver.com>
	* ZmSpamFree(zmCaptcha) Main Program ver. 1.1
	* 2009-11-02 Released.
	* System requirements : PHP 4.3+ / GD Library
	* @section intro 소개
	* ZmSpamFree 는 오픈 프로젝트로 개발되는 오픈 소스입니다.
	* 자세한 내용은 아래 링크를 참조하세요.
	* 공식홈페이지 : http://www.casternet.com/spamfree/
	*
	* "ZmSpamFree"는 자유 소프트웨어입니다.
	* 소프트웨어의 피양도자는 자유 소프트웨어 재단이 공표한 GNU 일반 공중 사용 허가서 2판 또는
	* 그 이후 판을 임의로 선택해서, 그 규정에 따라 프로그램을 개작하거나 재배포할 수 있습니다.
	*
	* 이 프로그램은 유용하게 사용될 수 있으리라는 희망에서 배포되고 있지만, 특정한 목적에 맞는 적합성
	* 여부나 판매용으로 사용할 수 있으리라는 묵시적인 보증을 포함한 어떠한 형태의 보증도 제공하지 않습니다.
	* 보다 자세한 사항에 대해서는 GNU 일반 공중 사용 허가서를 참고하시기 바랍니다.
	*
	* GNU 일반 공중 사용 허가서는 이 프로그램과 함께 제공됩니다. 만약, 이 문서가 누락되어 있다면
	* 자유 소프트웨어 재단으로 문의하시기 바랍니다.
	* (자유 소프트웨어 재단: Free Software Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA)
	*/
DEFINE ( 'zsfNow', time() );	# 현재 시간DEFINE ( 'zsfAr' , dirname(__FILE__).'/' );
DEFINE ( 'zsfAr' , dirname(__FILE__).'/' );
DEFINE ( 'zsfAr1' , dirname(__FILE__).'/../data/log/zmSpamFree/' );
if ( isset( $_COOKIE['PHPSESSID']) ) { DEFINE ( 'zsfSessId', $_COOKIE['PHPSESSID'] ); }
# 함수 : 에러메시지 출력
function zsfErr ( $msg, $no ) { echo '<div style="clear: both; float: left; border: solid 1px #00c; background-color: #eef; margin: 0px; padding: 5px; font: normal normal 11px/1.4 Tahoma; color: #00c; "><p style="margin: 0; ">ERROR CODE : '.$no.'<br />'.$msg.'</p><p style="margin: 0; text-align: right; "><a href="http://www.casternet.com/spamfree/" onclick="window.open(this.href);return false;">SpamFree.kr</a></p></div>'; exit; }
# 환경설정파일 include
$thisZsfCfg['cfgFile'] = zsfAr.'zsfCfg.php'; # 환경설정파일 기본값
if ( isset($_REQUEST['cfg']) ) { $thisZsfCfg['cfgFile'] = zsfAr.$_REQUEST['cfg'].'.php'; }
if ( is_file( $thisZsfCfg['cfgFile'] ) ) { include ( $thisZsfCfg['cfgFile'] ); } else { zsfErr( 'There is not config file <span style="color: #c00; font-weight: bold">'. $thisZsfCfg['cfgFile'] .'</span>.', 10 ); }
/*
	이미지를 출력하는 경우 시작
*/
if ( isset($_GET['zsfimg']) ) {
	# 함수 : str_shuffle ( PHP 4.3.0 이전버전을 위한 배려)
	if ( !function_exists('str_shuffle') ) {
		function str_shuffle ( $str ) {
			$strLen = strlen( $str );
			$i=0;
			while ($i<$strLen) { $strArr[] = substr($str,$i,1); $i ++; }
			shuffle ( $strArr );
			return ( implode('',$strArr) );
		}
	}
	# 함수 : 지난 파일 삭제
	function zsfCleanFile ( $dir, $term ) {
		$zsfDir = opendir($dir);
		$termTime = zsfNow - ( 86400 * $term );
		while ( $file = readdir($zsfDir) ) {
			if ( $file!='.' && $file!='..' && fileaTime($dir.$file) < $termTime && $file!='.' ) 	{ unlink ( $dir.$file ); }
		}
	}
	# 함수 : 최소값 및 최대값 검증
	function zsfVarChk ( $var, $min, $max ) { if ( $var > $min && $var < $max ) { return true; } else { return false; } }
	# 세션쿠키가 없을 경우 다시 로드
	if ( !defined('zsfSessId') ) { session_start(); header('Location:'.$PHP_SELF.'?zsfimg'); exit; }
	# 환경설정 기본값
	$thisZsfCfg = array (
		'codeForm' => 6,
		'fontName' => 'MalgunGothic40px',
		'font-size' => 14,
		'width' => 48,
		'height' => 18,
		'padding-left' => 6,
		'padding-top' => 3,
		'letter-spacing' => 4,
		'space-width' => 4,
		'border-color' => '',
		'logPassed' => 3,
		'logDenied' => 3,
		'view' => 3,
		'line' => 0,
		'codeCfg' => 4,
		'str' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz@.?+==×÷',
		'codeCfg' => array ( 1=>4, 2=>4, 3=>2, 4=>2, 5=>1, 6=>4, 7=>4, 8=>4 )
		);
	# 'SpamFree.kr' 이미지맵
	$zsfLogoMap = array ('0100', '0200', '0300', '0500', '0600', '0700', '1100', '1200', '1500', '1900', '0001', '0501', '0801', '1001', '1301', '1501', '1601', '1801', '1901', '0102', '0202', '0502', '0602', '0702', '1002', '1102', '1202', '1302', '1502', '1702', '1902', '0303', '0503', '1003', '1303', '1503', '1903', '0004', '0104', '0204', '0504', '1004', '1304', '1504', '1904', '0007', '0107', '0207', '0407', '0507', '0607', '0907', '1007', '1107', '1307', '1407', '1507', '1907', '0008', '0408', '0708', '0908', '1308', '1908', '0009', '0109', '0409', '0509', '0609', '0909', '1009', '1309', '1409', '1909', '2109', '2309', '2409', '0010', '0410', '0710', '0910', '1310', '1910', '2010', '2310', '0011', '0411', '0711', '0911', '1011', '1111', '1311', '1411', '1511', '1711', '1911', '2111', '2311');
	# 환경설정파일 내용 검증 및 초기화 'codeForm';
	if ( isset($zsfCfg['codeForm']) && is_array($zsfCfg['codeForm']) ) { shuffle ( $zsfCfg['codeForm'] ); $thisZsfCfg['codeForm'] = $zsfCfg['codeForm'][0]; }
	# 환경설정파일 내용 검증 및 초기화 'fontName';
	$zsfFontIncOk = false;	# 폰트 로딩 확인 임시변수
	# 환경설정의 폰트파일이 있을 경우 INCLUDE
	if ( isset($zsfCfg['fontName']) && is_array($zsfCfg['fontName']) ) {
		shuffle ( $zsfCfg['fontName'] );
		if ( is_file (zsfAr.'Fonts/'.$zsfCfg['fontName'][0].'.php') ) {
			include zsfAr.'Fonts/'.$zsfCfg['fontName'][0].'.php';
			$thisZsfCfg['fontName'] = $zsfCfg['fontName'][0];
			$zsfFontIncOk = true;
		}
	}
	# 위에서 폰트파일을 못 불렀을 경우 기본 폰트파일 INCLUDE
	if ( !$zsfFontIncOk ) {
		if ( is_file ( zsfAr.'Fonts/'.$thisZsfCfg['fontName'].'.php' ) ) {
			include zsfAr.'Fonts/'.$thisZsfCfg['fontName'].'.php';
			$zsfFontIncOk = true;
		}
		else {	# 결국 폰트파일을 INCLUDE하지 못했을 때 에러
			zsfErr( 'There is not Font file <span style="color: #c00; font-weight: bold">'. $thisZsfCfg['fontName'] .'</span>.', 20 );
		}
	}
	unset ( $zsfFontIncOk );
	#	환경설정 변수 검증
	if ( isset($zsfCfg['view']) && zsfVarChk( $zsfCfg['view'], 0 , 4 ) ) { $thisZsfCfg['view'] = $zsfCfg['view']; }
	//if ( isset($zsfCfg['border-color']) && eregi('#[0-9abcdef]{6}',$zsfCfg['border-color']) ) { $thisZsfCfg['border-color'] = $zsfCfg['border-color']; }
  if ( isset($zsfCfg['border-color']) && preg_match('/#[0-9abcdef]{6}/i',$zsfCfg['border-color']) ) { $thisZsfCfg['border-color'] = $zsfCfg['border-color']; }
  if ( isset($zsfCfg['font-size']) && zsfVarChk( $zsfCfg['font-size'], 0 , 101 ) ) { $thisZsfCfg['font-size'] = $zsfCfg['font-size']; }
	if ( isset($zsfCfg['width']) && zsfVarChk( $zsfCfg['width'], 0 , 801 ) ) { $thisZsfCfg['width'] = $zsfCfg['width']; }
	if ( isset($zsfCfg['height']) && zsfVarChk( $zsfCfg['height'], 0 , 601 ) ) { $thisZsfCfg['height'] = $zsfCfg['height']; }
	if ( isset($zsfCfg['padding-left']) && zsfVarChk( $zsfCfg['padding-left'], -1 , 401 ) ) { $thisZsfCfg['padding-left'] = $zsfCfg['padding-left']; }
	if ( isset($zsfCfg['padding-top']) && zsfVarChk( $zsfCfg['padding-top'], -1 , 301 ) ) { $thisZsfCfg['padding-top'] = $zsfCfg['padding-top']; }
	if ( isset($zsfCfg['letter-spacing']) && zsfVarChk( $zsfCfg['letter-spacing'], -1 , 301 ) ) { $thisZsfCfg['letter-spacing'] = $zsfCfg['letter-spacing']; }
	if ( isset($zsfCfg['space-width']) && zsfVarChk( $zsfCfg['space-width'], -1 , 301 ) ) { $thisZsfCfg['space-width'] = $zsfCfg['space-width']; }
	# 한글이 필요할 경우 필요한 변수
	if ( $thisZsfCfg['view'] == 3 ) {
		$thisZsfCfg['jong'] = '1101001110';
		$thisZsfCfg['josa'] = array('와','과');
		$thisZsfCfg['mi'] = array('는','은');
	}
	# Log/Connect/ 디렉토리에 세션파일이 등록되어 있을 경우 INCLUDE, 아닐 경우 문제&답 만들기
	if ( defined('zsfSessId') && is_file( zsfAr1.'Connect/'.zsfSessId.'.php' ) && !isset($_GET['re']) && !isset($_GET['cfg']) ) {
		include zsfAr1.'Connect/'.zsfSessId.'.php';
	}
	else {
		# 경우에 따라 문제 만들기
		$zsfN = $thisZsfCfg['codeForm'];
		switch ( $zsfN ) {
			case 1:	# A 와 B 중 큰 수는?
				if ( isset($zsfCfg['codeCfg'][1]) && zsfVarChk($zsfCfg['codeCfg'][1],0,9) ) { $thisZsfCfg['codeCfg'][1] = intval($zsfCfg['codeCfg'][1]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][1]) - 1;
				$zsfNum = array ( mt_rand(1,$zsfMax), mt_rand(1,$zsfMax) );
				if ( $zsfNum[0] == $zsfNum[1] ) { $zsfNum[0] --; shuffle($zsfNum); }
				$zsfA = max($zsfNum);
				switch ( $thisZsfCfg['view'] ) {
					case 3:
						$zsfQ = $zsfNum[0].$thisZsfCfg['josa'][$thisZsfCfg['jong'][substr($zsfNum[0],-1)]].' '.$zsfNum[1].'중 큰 수는?';
						break;
					default:
						$zsfQ = 'WHICH IS BIGGER '.$zsfNum[0].' OR '.$zsfNum[1].' ?';
				}
				break;
			case 2:	# A 와 B 중 작은 수는?
				if ( isset($zsfCfg['codeCfg'][2]) && $zsfCfg['codeCfg'][2] > 0 && $zsfCfg['codeCfg'][2] < 9 ) { $thisZsfCfg['codeCfg'][2] = intval($zsfCfg['codeCfg'][2]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][2]) - 1;
				$zsfNum = array ( mt_rand(1,$zsfMax), mt_rand(1,$zsfMax) );
				if ( $zsfNum[0] == $zsfNum[1] ) { $zsfNum[0] --; shuffle($zsfNum); }
				$zsfA = min($zsfNum);
				switch ( $thisZsfCfg['view'] ) {
					case 3:
						$zsfQ = $zsfNum[0].$thisZsfCfg['josa'][$thisZsfCfg['jong'][substr($zsfNum[0],-1)]].' '.$zsfNum[1].'중 작은 수는?';
						break;
					default:
						$zsfQ = 'WHICH IS SMALLER '.$zsfNum[0].' OR '.$zsfNum[1].' ?';
				}
				break;
			case 3:	# A 더하기 B는?
				if ( isset($zsfCfg['codeCfg'][3]) && $zsfCfg['codeCfg'][3] > 0 && $zsfCfg['codeCfg'][3] < 9 ) { $thisZsfCfg['codeCfg'][3] = intval($zsfCfg['codeCfg'][3]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][3]) - 1;
				$zsfNum = array ( mt_rand(1,$zsfMax), mt_rand(1,9) );
				$zsfA = $zsfNum[0] + $zsfNum[1];
				switch ( $thisZsfCfg['view'] ) {
					case 1:
						$zsfQ = $zsfNum[0].' + '.$zsfNum[1].' =?';
						break;
					case 3:
						$zsfQ = $zsfNum[0].' 더하기 '. $zsfNum[1].$thisZsfCfg['mi'][$thisZsfCfg['jong'][substr($zsfNum[1],-1)]].'?';
						break;
					default:
						$zsfQ = $zsfNum[0].' PLUS '.$zsfNum[1].' ?';
				}
				break;
			case 4:	# A 빼기 B는?
				if ( isset($zsfCfg['codeCfg'][4]) && $zsfCfg['codeCfg'][4] > 0 && $zsfCfg['codeCfg'][4] < 9 ) { $thisZsfCfg['codeCfg'][4] = intval($zsfCfg['codeCfg'][4]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][4]) - 1;
				$zsfNum = array ( mt_rand(10,$zsfMax), mt_rand(1,9) );
				$zsfA = $zsfNum[0] - $zsfNum[1];
				switch ( $thisZsfCfg['view'] ) {
					case 1:
						$zsfQ = $zsfNum[0].' - '.$zsfNum[1].' =?';
						break;
					case 3:
						$zsfQ = $zsfNum[0].' 빼기 '. $zsfNum[1].$thisZsfCfg['mi'][$thisZsfCfg['jong'][substr($zsfNum[1],-1)]].'?';
						break;
					default:
						$zsfQ = $zsfNum[0].' MINUS '.$zsfNum[1].' ?';
				}
				break;
			case 5:	# A 곱하기 B는?
				if ( isset($zsfCfg['codeCfg'][5]) && $zsfCfg['codeCfg'][5] > 0 && $zsfCfg['codeCfg'][5] < 4 ) { $thisZsfCfg['codeCfg'][5] = intval($zsfCfg['codeCfg'][5]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][5]) - 1;
				$zsfNum = array ( mt_rand(1,$zsfMax), mt_rand(1,9) );
				$zsfA = $zsfNum[0] * $zsfNum[1];
				switch ( $thisZsfCfg['view'] ) {
					case 1:
						$zsfQ = $zsfNum[0].' × '.$zsfNum[1].' =?';
						break;
					case 3:
						$zsfQ = $zsfNum[0].' 곱하기 '. $zsfNum[1].$thisZsfCfg['mi'][$thisZsfCfg['jong'][substr($zsfNum[1],-1)]].'?';
						break;
					default:
						$zsfQ = $zsfNum[0].' TIMES '.$zsfNum[1].' ?';
				}
				break;
			case 7:	# QJMA
				if ( isset($zsfCfg['codeCfg'][7]) && $zsfCfg['codeCfg'][7] > 0 && $zsfCfg['codeCfg'][7] < 9 ) { $thisZsfCfg['codeCfg'][7] = intval($zsfCfg['codeCfg'][7]); }
				$zsfStr = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
				$zsfQ = substr( str_shuffle($zsfStr), 0, $thisZsfCfg['codeCfg'][7] );
				$zsfA = $zsfQ;
				break;
			case 8:	# 6R2A
				if ( isset($zsfCfg['codeCfg'][8]) && $zsfCfg['codeCfg'][8] > 0 && $zsfCfg['codeCfg'][8] < 9 ) { $thisZsfCfg['codeCfg'][8] = intval($zsfCfg['codeCfg'][8]); }
				$zsfStrDi = str_shuffle('2345679');
				$zsfStrAl = str_shuffle('ACDEFGHJKLMNPQRSTUVWXYZ');
				$zsfNum[0] = mt_rand(1,intval($thisZsfCfg['codeCfg'][8]/2));
				$zsfNum[1] = $thisZsfCfg['codeCfg'][8] - $zsfNum[0];
				shuffle ( $zsfNum );
				$zsfQ = str_shuffle(substr($zsfStrDi,0,$zsfNum[0]).substr($zsfStrAl,0,$zsfNum[1]));
				$zsfA = $zsfQ;
				break;
			default:	# 5967
				if ( isset($zsfCfg['codeCfg'][6]) && $zsfCfg['codeCfg'][6] > 0 && $zsfCfg['codeCfg'][6] < 9 ) { $thisZsfCfg['codeCfg'][6] = intval($zsfCfg['codeCfg'][6]); }
				$zsfMax = pow(10, $thisZsfCfg['codeCfg'][6]) - 1;
				$zsfQ = sprintf('%0'.$thisZsfCfg['codeCfg'][6].'d', mt_rand(1,$zsfMax));
				$zsfA = $zsfQ;
				break;
		}
	}

	if ( $thisZsfCfg['view'] == 3 && $zsfN < 6 ) {
		$zsfHanFont = zsfAr.'Fonts/han';
		$zsfHanFont .= ( isset($zsfCfg['distortion']) && $zsfCfg['distortion'] == 1 ) ? '40px.php' : '24px.php';
		if ( is_file ($zsfHanFont) ) { include $zsfHanFont; } else { zsfErr( 'There is not Font file <span style="color: #c00; font-weight: bold">han</span>.', 30 ); }
		unset ($zsfHanFont);
		$imgFontEngWidth = array_merge ( $imgFontEngWidth, $imgFontHanWidth );
	}
	# 함수 : 디렉토리 존재 여부 체크 및 권한 체크 함수
	function zsfDirChk ( $dir ) {
		if ( !is_dir($dir) ) {
			@mkdir($dir, 0755);
			zsfErr('There is not directory <span style="color: #c00; font-weight: bold">'.$dir.'</span>.',40);
		}
		elseif ( substr(sprintf('%o', fileperms($dir)),-4) < 755 ) {
			zsfErr('Directory <span style="color: #c00; font-weight: bold">'.$dir.'</span> must be 755 permission.',50);
		}
	}

	//zsfDirChk (zsfAr1);
	zsfDirChk (zsfAr1.'Connect');
	# 불당팩 - 질문을 한글로?
  if ($zsfCfg['mb_str'] == "1") {
      $zsfQ = iconv("EUC-KR", "UTF-8", $zsfQ);
  }

	# 세션 파일 저장
	$zsfFp = fopen(zsfAr1.'Connect/'.zsfSessId.'.php', 'w+');
	fwrite ($zsfFp, '<?php $zsfQ=\''.$zsfQ.'\'; $zsfA=\''.$zsfA.'\'; $zsfN=\''.$zsfN.'\';?>');
	fclose($zsfFp);
	# Passed, Denied 디렉토리 존재여부 체크 및 권한 체크
	zsfCleanFile ( zsfAr1 . 'Connect/', 1 );

	/*
		이미지 출력
	*/
	$thisZsfCfg['logoW'] = isset($zsfCfg['zsfLogo']) && $zsfCfg['zsfLogo'] ? 32: 0; # 로고 폭(여백 포함)
	$thisZsfCfg['imH'] = str_replace('px','',substr($thisZsfCfg['fontName'],-4))*1 ;	# 원래 이미지 높이
	$thisZsfCfg['ratio'] = round($thisZsfCfg['imH']/$thisZsfCfg['height'],2);	# 축소비율
	$thisZsfCfg['letter-spacing-ratio'] = round($thisZsfCfg['letter-spacing']*$thisZsfCfg['ratio']);
	$imgFontMap[' '] = array();	# 공백
	$imgFontEngWidth[' '] = round( $thisZsfCfg['space-width'] * $thisZsfCfg['ratio'] );	# 공백 폭
	# 이미지 전체 폭 구하기
	$thisZsfCfg['imW']=0;

  if ($zsfCfg['mb_str'] == "1") {
    	preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $zsfQ, $zsfQArr);	# 2바이트 문자 포함 문자열 배열변수로 ( author: gony http://mygony.com )
    	$zsfQArr = $zsfQArr[0];	# 보안코드 문제 문자열을 배열로
  } else {
      $result = array();
      $stop   = mb_strlen( $zsfQ, $zsfCfg['charset']); 
      for( $idx = 0; $idx < $stop; $idx++) 
      { 
          $result[] = mb_substr( $zsfQ, $idx, 1, $zsfCfg['charset']); 
      } 
      $zsfQArr = $result;
  }

	foreach ( $zsfQArr as $v ) { $thisZsfCfg['imW'] += $imgFontEngWidth[$v]; }
	$thisZsfCfg['imW'] += (count($zsfQArr)-1)*$thisZsfCfg['letter-spacing-ratio'];
	# 문자왜곡 옵션 선택시 이미지 사이즈 크게
	if ( isset($zsfCfg['distortion']) && $zsfCfg['distortion'] == 1 ) {
		$zsfRand = array (
			# periods
			mt_rand(750000,1200000)/10000000,	# 0
			mt_rand(750000,1200000)/10000000,	# 1
			mt_rand(750000,1200000)/10000000,	# 2
			mt_rand(750000,1200000)/10000000,	# 3
			# phases
			mt_rand(0,31415926)/10000000,		# 4
			mt_rand(0,31415926)/10000000,		# 5
			mt_rand(0,31415926)/10000000,		# 6
			mt_rand(0,31415926)/10000000,		# 7
			# amplitudes
			mt_rand(220,330)/110,				# 8
			mt_rand(220,330)/110				# 9
			);
		$thisZsfCfg['imW'] = $thisZsfCfg['imW'] + 9;
		$thisZsfCfg['imH'] = $thisZsfCfg['imH'] + 18;
	}
	$zsfIm = imageCreateTrueColor ($thisZsfCfg['imW'],$thisZsfCfg['imH']);
	$zsfCol = array ( array(mt_rand(0,115), mt_rand(0,115), mt_rand(0,115)), array(mt_rand(175,255), mt_rand(175,255), mt_rand(175,255)) );
	shuffle ( $zsfCol );
	$zsfImBg = imageColorAllocate ( $zsfIm , $zsfCol[0][0] , $zsfCol[0][1] , $zsfCol[0][2] ) ;
	$zsfImFg = imageColorAllocate ( $zsfIm , $zsfCol[1][0] , $zsfCol[1][1] , $zsfCol[1][2] ) ;
	imagefill ( $zsfIm , 0 , 0 , $zsfImBg ) ;
	# 글자 새기기
	$thisZsfCfg['offX']=0;
	foreach ( $zsfQArr as $zsfQv ) {
		foreach ( $imgFontMap[$zsfQv] as $v ) {
				$x = substr($v,0,2)*1+$thisZsfCfg['offX'];
				$y = substr($v,-2)*1;
				if ( isset($zsfCfg['distortion']) && $zsfCfg['distortion'] == 1 ) {
					$x=$x+(sin($x*$zsfRand[0]+$zsfRand[4])+sin($y*$zsfRand[2]+$zsfRand[5]))*$zsfRand[8]+2;
					$y=$y+(sin($x*$zsfRand[1]+$zsfRand[6])+sin($y*$zsfRand[3]+$zsfRand[7]))*$zsfRand[9]+3;
				}
				imageSetPixel ( $zsfIm , $x, $y, $zsfImFg );
		}
		$thisZsfCfg['offX'] += $imgFontEngWidth[$zsfQv]+$thisZsfCfg['letter-spacing-ratio'];
	}
	# 리사이징된 이미지 폭, 높이 구하기
	$thisZsfCfg['imReW'] = round($thisZsfCfg['imW']*$thisZsfCfg['font-size']/$thisZsfCfg['imH'])+($thisZsfCfg['padding-left']*2)+$thisZsfCfg['logoW'];
	if ( $thisZsfCfg['imReW'] < $thisZsfCfg['width'] ) { $thisZsfCfg['imReW'] = $thisZsfCfg['width']; }
	$thisZsfCfg['imReH'] = $thisZsfCfg['height'];
	# 리사이징된 이미지 설정
	$zsfImRe = imageCreateTruecolor ( $thisZsfCfg['imReW'] , $thisZsfCfg['imReH'] );
	imagefill ( $zsfImRe , 0 , 0 , $zsfImBg );
	imageCopyResampled ( $zsfImRe , $zsfIm , $thisZsfCfg['padding-left'] , $thisZsfCfg['padding-top'] , 0 , 0 , round($thisZsfCfg['imW']*$thisZsfCfg['font-size']/$thisZsfCfg['imH']) , $thisZsfCfg['font-size'] , $thisZsfCfg['imW'] , $thisZsfCfg['imH'] );
	imageDestroy ( $zsfIm );
	imageFilledRectangle ( $zsfImRe , $thisZsfCfg['imReW']-$thisZsfCfg['logoW'],0,$thisZsfCfg['imReW'],$thisZsfCfg['imReH'], $zsfImFg);
	if ( $zsfCfg['zsfLogo'] ) {
		# 로고 새김
		$thisZsfCfg['logoOffX'] = $thisZsfCfg['imReW']-$thisZsfCfg['logoW']+3;
		$thisZsfCfg['logoOffY'] = ($thisZsfCfg['imReH']-12)/2;
		foreach ( $zsfLogoMap as $v ) {
			imageSetPixel ( $zsfImRe , substr($v,0,2)*1+$thisZsfCfg['logoOffX'], substr($v,-2)*1+$thisZsfCfg['logoOffY'], $zsfImBg );
		}
	}
	if ( $thisZsfCfg['border-color'] ) {
		$zsfImBd = imageColorAllocate ( $zsfImRe , hexdec(substr($thisZsfCfg['border-color'],1,2)), hexdec(substr($thisZsfCfg['border-color'],3,2)), hexdec(substr($thisZsfCfg['border-color'],-2)) );
	} else { $zsfImBd = $zsfImFg; }
	imageRectangle ( $zsfImRe , 0 , 0 , $thisZsfCfg['imReW']-1 , $thisZsfCfg['imReH']-1 , $zsfImBd ) ;
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	if (function_exists('imagepng')) {
		header('Content-Type: image/x-png');
		imagepng($zsfImRe);
	} else if (function_exists('image/gif')) {
		header('Content-Type: image/gif');
		imagegif($zsfImRe);
	} else if (function_exists('imagejpeg')) {
		header('Content-Type: image/jpeg');
		imagejpeg($zsfImRe);
	}
	imageDestroy ( $zsfImRe );

  set_session("captcha_count", 0);
  set_session("captcha_keystring", "$zsfA");
 
}
/* 이미지를 출력하는 경우 끝 */
else
/* 검증 함수 시작 */
{
	function zsfCheck ( $zsfCode, $zsfLog='', $zsfMethod='POST' ) {
		# 기본 변수 설정
		$zsfCode = stripslashes(trim($zsfCode));
		$zsfQ = '';
		$zsfA = '';
		$thisZsfCfg = array ( 'Passed' => 3, 'Denied' => 3 );
		if ( isset($zsfCfg['logPassed']) && isset($zsfCfg['logDenied']) ) { $thisZsfCfg['Passed'] = $zsfCfg['Passed']; $thisZsfCfg['Denied'] = $zsfCfg['Denied']; }
		# 함수 : 로깅 및 이전 데이터 삭제
		function zsfLog ( $zsfLogFile,  $zsfQ, $zsfA, $zsfCode, $zsfMethod, $zsfLog, $zsfTerm ) {
			$zsfLogFile = zsfAr1.$zsfLogFile.'.php';
			$zsfLogDataArr = array ();
			$i = 0;
			if ( is_file($zsfLogFile) ) {
				$zsfLogDataArr = file($zsfLogFile);
				array_pop($zsfLogDataArr);
				$zsfLimit = zsfNow-$zsfTerm*86400;
				foreach ($zsfLogDataArr as $k=>$v ) {
					if ( substr($v,0,10) < $zsfLimit || !$v ) { unset($zsfLogDataArr[$k]); } else { $zsfLogDataArr[$k] = str_replace("\n",'',$v); }
				}
			}
			$zsfCode = str_replace('|','',$zsfCode);
			$zsfLog = str_replace('|','',$zsfLog);
			array_push($zsfLogDataArr, zsfNow.'|'.date('Y-m-d/H:i:s',zsfNow).'|'.$_SERVER['REMOTE_ADDR'].'|'.$zsfMethod.'|'.$zsfQ.'|'.$zsfA.'|'.$zsfCode.'|'.$zsfLog);
			$zsfLogData = implode("\n", $zsfLogDataArr);
			$zsfFp = fopen( $zsfLogFile, 'w' );
			fwrite ( $zsfFp, '<?php /*'."\n".$zsfLogData."\n".'*/ ?>' ) ;
			fclose($zsfFp);
		}
		# 세션파일 있을 경우 INCLUDE
		if ( defined( 'zsfSessId' ) && is_file( zsfAr1.'Connect/'.zsfSessId.'.php' ) ) {
			include zsfAr1.'Connect/'.zsfSessId.'.php';
			if ( $zsfMethod == 'POST' ) {
				unlink ( zsfAr1.'Connect/'.zsfSessId.'.php' );
			}
		}
		# 보안코드 입력값의 참, 거짓 검증
		$zsfR = false;
		if ( isset($zsfA) && $zsfA && $zsfCode && strtoupper($zsfCode) == $zsfA ) {	# 보안코드의 참 거짓 여부 ( 맞으면 true, 틀리면 false )
			$zsfR = true;
		}
		else {
			if ( defined( 'zsfSessId' ) && is_file( zsfAr1.'Connect/'.zsfSessId.'.php' ) ) {
				unlink ( zsfAr1.'Connect/'.zsfSessId.'.php' );
			}
		}
		$zsfRTxt = $zsfR ? 'Passed' : 'Denied';
		# 로그 기록
		zsfLog ( $zsfRTxt, $zsfQ, $zsfA, $zsfCode, $zsfMethod, $zsfLog, $thisZsfCfg[$zsfRTxt] );
		return ($zsfR);
	}
}
if ( isset($_GET['zsfCode']) && trim($_GET['zsfCode']) !='' ) {
	$zsfLog='';
	if ( isset($_GET['zsfLog']) ) { $zsfLog = $_GET['zsfLog']; }
	$rslt = zsfCheck ( $_GET['zsfCode'], $zsfLog, 'AJAX' );
	echo $rslt*1;
}
unset ( $thisZsfCfg );
?>
