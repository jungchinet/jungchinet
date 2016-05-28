<? 
$g4_path = ".."; 
include_once($g4_path."/common.php"); 
include_once("$g4[path]/lib/sms.lib.php"); 

// SMS 설정값 배열변수
$sms4 = sql_fetch("select * from $g4[sms4_config_table]");

if (!$is_member)
    die("로그인 해주세요.");

if (!($token && get_session("ss_token") == $token))
    die("올바른 방법으로 사용해 주십시오.");

if (!trim($hp))
    alert('보내는 번호를 입력해주세요.');

if (!trim($config[cf_hp_certify_message]))
    alert('메세지를 입력해주세요.');

if (!trim($config[cf_hp_certify_return]))
    alert('받는 번호를 입력해주세요.');
    
// 6자리의 인증번호를 생성
$certify_number = rand(100000, 999999); 

// 생성된 인증번호를 세션에 저장함 
// form 에서 넘어온 인증번호와 비교하여 같으면 글쓰기 허용함 
set_session("ss_hp_certify_number", $certify_number); 

$mh_hp[][bk_hp] = get_hp($hp,0); // 수신자번호 - 반드시 [bk_hp]에 넣어야 합니다.

$mh_reply = str_replace("-", "", $config[cf_hp_certify_return]);
if (!check_string($mh_reply, _G4_NUMERIC_))
    alert("보내는 번호가 올바르지 않습니다.");
        
$hp_message = "**" . str_replace("\$certify_number","$certify_number",$config[cf_hp_certify_message]);
$hp_message = str_replace("\\n", PHP_EOL, $hp_message);

$total = 1;
$booking = '';

$SMS = new SMS4;
$SMS->SMS_con($sms4[cf_ip], $sms4[cf_id], $sms4[cf_pw], $sms4[cf_port]);

$result = $SMS->Add($mh_hp, $mh_reply, '', '', $hp_message, $booking, $total);

$is_success = null;

if ($result) 
{
    $result = $SMS->Send();

    if ($result) //SMS 서버에 접속했습니다.
    {
        foreach ($SMS->Result as $result) 
        {
            list($hp, $code) = explode(":", $result);

            if (substr($code,0,5) == "Error")
            {
                $is_success = false;

                switch (substr($code,6,2)) {
                    case '02':	 // "02:형식오류"
                        $mh_log = "형식이 잘못되어 전송이 실패하였습니다.";
                        break;
                    case '16':	 // "16:발송서버 IP 오류"
                        $hs_memo = "발송서버 IP가 잘못되어 전송이 실패하였습니다.";
                        break;
                    case '23':	 // "23:인증실패,데이터오류,전송날짜오류"
                        $mh_log = "데이터를 다시 확인해 주시기바랍니다.";
                        break;
                    case '97':	 // "97:잔여코인부족"
                        $mh_log = "잔여코인이 부족합니다.";
                        break;
                    case '98':	 // "98:사용기간만료"
                        $mh_log = "사용기간이 만료되었습니다.";
                        break;
                    case '99':	 // "99:인증실패"
                        $mh_log = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
                        break;
                    default:	 // "미 확인 오류"
                        $mh_log = "알 수 없는 오류로 전송이 실패하었습니다.";
                        break;
                }
            } 
            else
            {
                $is_success = true;
                $mh_log = "문자전송:".get_hp($hp, 1);
            }

            $hp = get_hp($hp, 1);
            $log = array_shift($SMS->Log);
            sql_query("insert into $g4[sms4_member_history_table] set mb_id='$member[mb_id]', mh_reply='$mh_reply', mh_hp='$hp', mh_datetime='$g4[time_ymdhis]', mh_booking='$mh_booking', mh_log='$mh_log', mh_ip='$REMOTE_ADDR'");

            if ($is_admin == 'super')
                $sms4[cf_point] = 0;

            if ($is_success)
                insert_point($member[mb_id], (-1) * $sms4[cf_point], "$mh_log");

            if (!$sms4[cf_point]) { // 포인트 차감이 없어도 내역을 남김
                $sql  = " insert into $g4[point_table] set ";
                $sql .= " mb_id = '$member[mb_id]' ";
                $sql .= " ,po_datetime = '$g4[time_ymdhis]' ";
                $sql .= " ,po_content = '".addslashes($mh_log)."' ";
                $sql .= " ,po_point = '$sms4[cf_point]'";
                sql_query($sql);
            }
        }
        $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
    }
    else alert_close("에러: SMS 서버와 통신이 불안정합니다.");
}
else alert_close("에러: SMS 데이터 입력도중 에러가 발생하였습니다.");

alert_close("인증번호를 전송하였습니다. 인증번호를 확인 후 입력하여 주십시오.");
?> 
