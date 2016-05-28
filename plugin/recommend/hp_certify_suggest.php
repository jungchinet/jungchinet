<? 
include_once("./_common.php"); 

// 세션에 저장된 토큰과 폼값으로 넘어온 토큰을 비교 
$ss_token = get_session("ss_token");
if ($_GET["token"] && $ss_token == $_GET["token"]) { 
    set_session("ss_token", ""); // 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
} else {
    alert_close("인증번호 발송시 오류가 발생하였습니다."); 
    exit; 
} 

$receive_number = preg_replace("/[^0-9]/", "", $hp); // 수신자번호 
$send_number = preg_replace("/[^0-9]/", "", $default['de_sms_hp']); // 발신자번호 

// 이미 발송된 핸드폰의 경우에는 재발송을 금지
$sql = " select count(*) as cnt from $g4[member_suggest_table] 
            where mb_id = '$member[mb_id]' and join_hp = '$receive_number' ";
$result = sql_fetch($sql);
if ($result[cnt] > 0) alert_close("이미 인증번호를 발송 하였습니다", "./index.php");

// 나에게 인증번호 발신하는 것을 금지
if ($receive_number == $send_number) alert("나에게는 인증번호를 발송할 수 없습니다", "./index.php");

// SMS BEGIN -------------------------------------------------------- 

// 생성된 인증번호를 세션에 저장함 
// form 에서 넘어온 인증번호와 비교하여 같으면 글쓰기 허용함, skin/member/basic/register_update.skin.php
set_session("ss_hp_certify_number", $certify_number); 

if ($receive_number) { 
    include_once("$g4[path]/lib/icode.sms.lib.php"); 
    $SMS = new SMS; // SMS 연결 
    $SMS->SMS_con($default['de_icode_server_ip'], $default['de_icode_id'], $default['de_icode_pw'], $default['de_icode_server_port']); 
    $SMS->Add($receive_number, $send_number, $default['de_icode_id'], stripslashes($sms_contents), ""); 
    $SMS->Send(); 
} 
// SMS END   -------------------------------------------------------- 

// 추천회원 정보를 DB에 insert
$sql = " insert 
            into $g4[member_suggest_table]
            set mb_id = '$member[mb_id]',
                mb_hp = '$member[mb_hp]',
                suggest_datetime = '$g4[time_ymdhis]',
                join_hp = '$receive_number',
                join_code = '$certify_number'
                ";
sql_query($sql);

// 추천을 할 때마다 포인트를 차감
insert_point($member[mb_id], -1 * $config[cf_recommend_point], "회원가입추천", '@member', $member[mb_id], "{$receive_number} 추천");

alert_close("신규회원 추천정보를 전송하였습니다."); 
?> 
