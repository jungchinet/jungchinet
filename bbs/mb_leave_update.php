<?
$g4[title] = "회원탈퇴";
include_once("./_common.php");

include_once("$g4[path]/zmSpamFree/zmSpamFree.php");
if ( !zsfCheck( $_POST['wr_key'], 'sms_admin' ) ) { alert ('스팸차단코드가 틀렸습니다.'); }    

// 변수들을 setting 합니다
$mb_id        = $_POST[mb_id];
$mb_name      = $_POST[mb_name];
$mb_password  = $_POST[mb_password];
$leave_reason = $_POST[leave_reason];

// 회원정보를 가져 옵니다
$mb = get_member($mb_id, "mb_name, mb_password");
if (!$mb_id || !$mb_name || !$mb_password || $mb_name != $mb[mb_name] || (sql_password($mb_password) != $mb[mb_password] and sql_old_password($mb_password) != $mb[mb_password]))
    alert("회원아이디/비밀번호가 틀리거나 정상적인 접근이 아닌것 같습니다.");

// 회원탈퇴일과 탈퇴사유를 저장
$date = date("Ymd");
$sql = " update $g4[member_table] set mb_leave_date = '$date', mb_profile = '$leave_reason' where mb_id = '$member[mb_id]'";
sql_query($sql);

// 3.09 수정 (로그아웃)
unset($_SESSION['ss_mb_id']);

if (!$url) 
    $url = $g4[path]; 

alert("{$member[mb_nick]}님께서는 " . date("Y년 m월 d일") . "에 회원에서 탈퇴 하셨습니다.", $url);
?>
