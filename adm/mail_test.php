<?
$sub_menu = "200300";
include_once("./_common.php");

if (!$config[cf_email_use])
    alert("환경설정에서 \'메일발송 사용\'에 체크하셔야 메일을 발송할 수 있습니다.");

include_once("$g4[path]/lib/mailer.lib.php");

auth_check($auth[$sub_menu], "w");

check_demo();

$g4[title] = "회원메일 테스트";

$name = $member[mb_name];
$nick = $member[mb_nick];
$mb_id = $member[mb_id];
$email = $member[mb_email];
$birth = $member[mb_birth];

$sql = "select ma_subject, ma_content from $g4[mail_table] where ma_id = '$ma_id' ";
$ma = sql_fetch($sql);

$subject = $ma[ma_subject];

$content = $ma[ma_content];
$content = preg_replace("/{이름}/", $name, $content);
$content = preg_replace("/{별명}/", $nick, $content);
$content = preg_replace("/{회원아이디}/", $mb_id, $content);
$content = preg_replace("/{이메일}/", $email, $content);
$content = preg_replace("/{생일}/", (int)substr($birth,4,2).'월 '.(int)substr($birth,6,2).'일', $content);

$mb_md5 = md5($member[mb_id].$member[mb_email].$member[mb_datetime]);

$content = $content . "<hr size=0><p><span style='font-size:9pt; font-familye:굴림'>▶ 더 이상 정보 수신을 원치 않으시면 [<a href='$g4[url]/$g4[bbs]/email_stop.php?mb_id=$mb_id&mb_md5=$mb_md5' target='_blank'>수신거부</a>] 해 주십시오.</span></p>";

mailer($config[cf_title], $member[mb_email], $member[mb_email], $subject, $content, 1);

alert("$member[mb_nick]($member[mb_email])님께 테스트 메일을 발송하였습니다.\\n\\n확인하여 주십시오.");
?>
