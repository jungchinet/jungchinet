<?
include_once("./_common.php");
include_once("$g4[path]/lib/mailer.lib.php");

check_token();

$mb_id          = mysql_real_escape_string(trim($_POST[mb_id]));
$reg_mb_email   = mysql_real_escape_string(trim($_POST[mb_email]));

if ($mb_id == "" || $reg_mb_email == "")
    alert("E000 : 부적절한 접근 입니다.");

// 중복된 이메일인지 체크 합니다.
$sql = " select count(*) as cnt from $g4[member_table] where mb_email = '$reg_mb_email' and mb_id <> '$mb_id' ";
$mb_check = sql_fetch($sql);
if ($mb_check[cnt] > 0)
    alert("E001 : 부적절한 접근 입니다.");

// 회원 DB를 업데이트 합니다.
$sql = " update $g4[member_table] set mb_email='$reg_mb_email', mb_email_certify='0000-00-00 00:00:00' where mb_id = '$mb_id' ";
sql_query($sql);

// 데이터를 맞춰줍니다.
$admin = get_admin('super');
$mb = get_member($mb_id, "mb_email, mb_name, mb_datetime");
$mb_email = $mb[mb_email];
$mb_name = $mb[mb_name];
$mb_datetime = $mb[mb_datetime];

// ----------- bbs/register_form_update.php에서 가져온 코드 입니다.

// 인증메일 발송
$subject = "$config[cf_title] - 인증확인 메일입니다.";

$mb_md5 = md5($mb_id.$mb_email.$mb_datetime);
$certify_href = "$g4[url]/$g4[bbs]/email_certify.php?mb_id=$mb_id&mb_md5=$mb_md5";
        
ob_start();
include_once ("./register_form_update_mail3.php");
$content = ob_get_contents();
ob_end_clean();
        
mailer($config[cf_title], $admin[mb_email], $mb_email, $subject, $content, 1);

alert("인증메일을 발송했습니다. 확인해 보시기 바랍니다.", $g4[path]);
?>
