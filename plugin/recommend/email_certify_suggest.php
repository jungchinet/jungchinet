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

// 이메일이 없으면 return
if (trim($email) == "")
    alert("이메일정보가 없습니다.", "./index.php");
$email = mysql_real_escape_string($email);

// 이미 발송된 이메일의 경우에는 재발송을 금지
$sql = " select count(*) as cnt from $g4[member_suggest_table] 
            where mb_id = '$member[mb_id]' and join_hp = '$email' ";
$result = sql_fetch($sql);
if ($result[cnt] > 0) alert("이미 인증번호를 발송 하였습니다", "./index.php");

// 나에게 인증번호 발신하는 것을 금지
if ($email == $member[email]) alert("나에게는 인증번호를 발송할 수 없습니다", "./index.php");


// Email 발송 BEGIN   -------------------------------------------------------- 
include_once("$g4[path]/lib/mailer.lib.php");

$mb_name = $member[mb_nick];
$subject = $g4['member_suggest_email_subject'];

// 임시 인증번호 생성. 링크 확인시 정식 인증번호 발생
$mb_md5 = md5($mb_id.$mb_email.$member[mb_datetime]);
$certify_href = "$g4[url]/plugin/recommend/email_certify.php?mb_md5=$mb_md5";
        
ob_start();
include_once ("./email_certify_mail3.php");
$content = ob_get_contents();
ob_end_clean();
        
mailer($member[mb_nick], $member[mb_email], $email, $subject, $content, 1);
// SMS END   -------------------------------------------------------- 

// 추천회원 정보를 DB에 insert
$sql = " insert 
            into $g4[member_suggest_table]
            set mb_id = '$member[mb_id]',
                mb_hp = '$member[mb_hp]',
                mb_email = '$member[mb_email]',
                suggest_datetime = '$g4[time_ymdhis]',
                join_hp = '$email',
                join_code = '$mb_md5',
                email_certify = '$mb_md5'
                ";
sql_query($sql);

// 추천을 할 때마다 포인트를 차감
insert_point($member[mb_id], -1 * $config[cf_recommend_point], "회원가입추천", '@member', $member[mb_id], "{$receive_number} 추천");

alert("신규회원 추천정보를 전송하였습니다.", "./index.php"); 
?> 
