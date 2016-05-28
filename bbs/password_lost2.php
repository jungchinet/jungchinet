<?
include_once("./_common.php");
include_once("$g4[path]/lib/mailer.lib.php");

if ($member[mb_id]) 
{
    echo "<script type='text/javascript'>";
    echo "alert('이미 로그인중입니다.');";
    echo "window.close();";
    echo "opener.document.location.reload();";
    echo "</script>";
    exit;
}

include_once("$g4[path]/zmSpamFree/zmSpamFree.php");
if ( !zsfCheck( $_POST['wr_key'], 'password_lost' ) ) { alert ('스팸차단코드가 틀렸습니다.'); }

$email = trim($_POST['mb_email']);

if (!$email) 
    // 메일주소 오류입니다.
    alert_close("정상적인 접근이 아닌것 같습니다 - 100");

$sql = " select count(*) as cnt from $g4[member_table] where mb_email = '$email' ";
$row = sql_fetch($sql);
if ($row[cnt] > 1)
    alert("동일한 메일주소가 2개 이상 존재합니다.\\n\\n관리자에게 문의하여 주십시오.");

$sql = " select mb_no, mb_id, mb_name, mb_nick, mb_email, mb_datetime from $g4[member_table] where mb_email = '$email' ";
$mb = sql_fetch($sql);
$msg = "";
if (!$mb[mb_id])
    // 존재하지 않는 회원입니다.
    $msg = "정상적인 접근이 아닌것 같습니다 - 110";
else if (is_admin($mb[mb_id])) 
    // 관리자 아이디는 접근 불가합니다.
    $msg = "정상적인 접근이 아닌것 같습니다 - 120";

// 불당팩 - 패스워드 찾기로 장난질 하는 것을 막아야죠.
if ($msg) {

    // 코드 호환성을 위해서 변수를 setting
    $mb_id = $mb[mb_id];

    // 불당팩 : 아래 코드는 불당팩의 /bbs/login_check.php와 동일 합니다. ---------------------------------------

    // 로그인 오류를 db에 기록 합니다.
    $sql = " insert into $g4[login_fail_log_table] (mb_id, ip_addr, log_datetime, log_url) values ('$mb_id', '$remote_addr', '$g4[time_ymdhis]', '/bbs/password_lost2.php') ";
    sql_query($sql);

    // 오류 횟수를 체크해서 차단할지를 결정 합니다.
    if ($config['cf_retry_time_interval'] > 0 && $config['cf_retry_count'] > 0) {
        $sql = " select count(*) as cnt from $g4[login_fail_log_table] where log_datetime >= '" . date("Y-m-d H:i:s", $g4[server_time] - $config['cf_retry_time_interval'] ) . "' and ip_addr='$remote_addr' ";
        $result = sql_fetch($sql);

        $ip = $_SERVER[REMOTE_ADDR];
        
        // 회수 -2일때, 경고 메시지, 4회 이후에 IP 차단을 하는 경우 메시지 없이 차단 될 수 있으므로, 횟수를 5회 이상으로 하는게 좋습니다.
        if (($result['cnt']+3) == $config['cf_retry_count']) {
            alert("2회 오류를 더 하는 경우, IP가 차단 됩니다.");
        }

        // 횟수 초과시 차단
        if ($result['cnt'] >= $config['cf_retry_count']) {
            $pattern = explode("\n", trim($config['cf_intercept_ip']));
            if (empty($pattern[0])) // ip 차단목록이 비어 있을 때
                $cf_intercept_ip = $ip;
            else
                $cf_intercept_ip = trim($config['cf_intercept_ip'])."\n{$ip}";
            $sql = " update {$g4['config_table']} set cf_intercept_ip = '$cf_intercept_ip' ";
            sql_query($sql);

            alert_close($msg);
        } else {
            alert($msg);
        }
    }
}

// 난수 발생
srand(time());
$randval = rand(4, 6); 

$change_password = substr(md5(get_microtime()), 0, $randval);

$mb_lost_certify = sql_password($change_password);
$mb_datetime     = sql_password($mb[mb_datetime]);

$sql = " update $g4[member_table]
            set mb_lost_certify = '$mb_lost_certify'
          where mb_id = '$mb[mb_id]' ";
$res = sql_query($sql);

// $mb_no를 암호화 합니다.
$mb_no = encrypt($mb[mb_no], $g4[encrypt_key]);

$href = "$g4[url]/$g4[bbs]/password_lost_certify.php?mb_no=$mb_no&mb_datetime=$mb_datetime&mb_lost_certify=$mb_lost_certify";

$subject = "요청하신 회원아이디/패스워드 정보입니다.";

$content = "";
$content .= "<div style='line-height:180%;'>";
$content .= "<p>요청하신 계정정보는 다음과 같습니다.</p>";
$content .= "<hr>";
$content .= "<ul>";
$content .= "<li>회원아이디 : $mb[mb_id]</li>";
$content .= "<li>변경 패스워드 : <span style='color:#ff3300; font:13px Verdana;'><strong>$change_password</strong></span></li>";
$content .= "<li>이름 : ".addslashes($mb[mb_name])."</li>";
$content .= "<li>별명 : ".addslashes($mb[mb_nick])."</li>";
$content .= "<li>이메일주소 : ".addslashes($mb[mb_email])."</li>";
$content .= "<li>요청일시 : $g4[time_ymdhis]</li>";
$content .= "<li>홈페이지 : $g4[url]</li>";
$content .= "<li>비밀번호 바꾸는 링크 : <a href='$href' target='_blank'>$href</a></p>";
$content .= "</ul>";
$content .= "<hr>";
$content .= "<p>";
$content .= "1. 위의 링크를 클릭하십시오. 링크가 클릭되지 않는다면 링크를 브라우저의 주소창에 직접 복사해 넣으시기 바랍니다.<br />";
$content .= "2. 링크를 클릭하시면 패스워드가 변경 되었다는 인증 메세지가 출력됩니다.<br />";
$content .= "3. 홈페이지에서 회원아이디와 위에 적힌 변경 패스워드로 로그인 하십시오.<br />";
$content .= "4. 로그인 하신 후 새로운 패스워드로 변경하시면 됩니다.<br />";
$content .= "5. <font color=red>위의 링크를 두번 두르면 비밀번호가 임의로 변경 되므로, 비밀번호 찾기로 새로운 패스워드를 받아야 합니다.</font><br />";
$content .= "6. 아이디만을 확인기를 원하는 경우에는, 위의 링크를 누르지 않고 회원아이디와 알고 있는 기존의 비밀번호로 로그인 하면 됩니다.<br />";
$content .= "</p>";
$content .= "<p>감사합니다.</p>";
$content .= "<p>[끝]</p>";
$content .= "</div>";

$admin = get_admin('super');
mailer($admin[mb_nick], $admin[mb_email], $mb[mb_email], $subject, $content, 1);

alert_close("$email 메일로 회원아이디와 패스워드를 인증할 수 있는 메일이 발송 되었습니다.\\n\\n메일을 확인하여 주십시오.");
?>
