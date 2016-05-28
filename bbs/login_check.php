<?
include_once("./_common.php");

$mb_id       = $_POST[mb_id];
$mb_password = $_POST[mb_password];

if (!trim($mb_id) || !trim($mb_password))
    alert("회원아이디나 패스워드가 공백이면 안됩니다.");

/*
// 자동 스크립트를 이용한 공격에 대비하여 로그인 실패시에는 일정시간이 지난후에 다시 로그인 하도록 함
if ($check_time = get_session("ss_login_check_time")) {
    if ($check_time > $g4['server_time'] - 15) {
        alert("로그인 실패시에는 15초 이후에 다시 로그인 하시기 바랍니다.");
    }
}
set_session("ss_login_check_time", $g4['server_time']);
*/

$mb = get_member($mb_id);

// 가입된 회원이 아니다. 패스워드가 틀리다. 라는 메세지를 따로 보여주지 않는 이유는 
// 회원아이디를 입력해 보고 맞으면 또 패스워드를 입력해보는 경우를 방지하기 위해서입니다.
// 불법사용자의 경우 회원아이디가 틀린지, 패스워드가 틀린지를 알기까지는 많은 시간이 소요되기 때문입니다.
//if (!$mb[mb_id] || (sql_password($mb_password) != $mb[mb_password]))
//if (!$mb[mb_id] || ($check_password !== $mb[mb_password] and sql_old_password($mb_password) !== $mb[mb_password])) {

$login_check=0;
if (!$mb[mb_id]) {
    $login_check = 1;
} else if (sql_password($mb_password) !== $mb[mb_password]) {

    // 옛날 버젼의 패스워드일지도 모르니까 한번 더 확인합니다.
    if (sql_old_password($mb_password) != $mb[mb_password]) {
        $login_check = 1;
    } else {
        // 옛날 패스워드를 새로운 패스워드로 바꿉니다.
        $sql = " update $g4[member_table] set mb_password='" . sql_password($mb_password) . "' where mb_id='$mb_id' ";
        sql_query($sql);
    }

}

if ($login_check) {
    // 로그인 오류를 db에 기록 합니다.
    $sql = " insert into $g4[login_fail_log_table] (mb_id, ip_addr, log_datetime, log_url) values ('$mb_id', '$remote_addr', '$g4[time_ymdhis]', '/bbs/login_check.php') ";
    sql_query($sql);
    
    // 오류 횟수를 체크해서 차단할지를 결정 합니다.
    if ($config['cf_retry_time_interval'] > 0 && $config['cf_retry_count']) {
        $sql = " select count(*) as cnt from $g4[login_fail_log_table] where log_datetime >= '" . date("Y-m-d H:i:s", $g4[server_time] - $config['cf_retry_time_interval'] ) . "' and ip_addr='$remote_addr' ";
        $result = sql_fetch($sql);
        
        $ip = $_SERVER[REMOTE_ADDR];
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
    
    alert("가입된 회원이 아니거나 패스워드가 틀립니다.\\n\\n패스워드는 대소문자를 구분합니다.");
}

// 차단된 아이디인가?
if ($mb[mb_intercept_date] && $mb[mb_intercept_date] <= date("Ymd", $g4[server_time])) {
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_intercept_date]); 
    alert("회원님의 아이디는 접근이 금지되어 있습니다.\\n\\n처리일 : $date");
}

// 탈퇴한 아이디인가?
if ($mb[mb_leave_date] && $mb[mb_leave_date] <= date("Ymd", $g4[server_time])) {
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_leave_date]); 
    alert("탈퇴한 아이디이므로 접근하실 수 없습니다.\\n\\n탈퇴일 : $date");
}

if ($config[cf_use_email_certify] && !preg_match("/[1-9]/", $mb[mb_email_certify])) {
    set_session('email_mb_id', $mb[mb_id]);
    alert("메일인증을 받으셔야 로그인 하실 수 있습니다.\\n\\n회원님의 메일주소는 $mb[mb_email] 입니다.", "$g4[bbs_path]/email_re_certify.php");
}

// 불당팩 - 중복로그인 방지
if ($config['cf_double_login'] && $mb_id) {

    // db session을 사용하는 경우
    if ($g4['session_type'] == "db") {
        $sql = "select * from $g4[session_table] where mb_id = '$mb[mb_id]' and ss_ip != '$remote_addr' and ss_datetime > '$login_time' ";
        $sql.= "order by ss_datetime desc limit 1";
        
            $login_time = date("Y-m-d H:i:s", $g4[server_time] - 60*10); // 10분
            $sql = " SELECT * from $g4[session_table] 
                      WHERE mb_id = '$mb[mb_id]' and ip_addr != '$remote_addr' and ss_datetime > '$login_time' ";
            // ip를 고려하지 않는 경우 (새창을 띄우거나 불여우와 ie를 함께 사용하면 중복 로그인 오류가 나옵니다)
            //$sql = " SELECT * from $g4[session_table] where mb_id = '$mb[mb_id]' and ss_datetime > '$login_time'  ";
            $result = sql_query($sql);
        
            if (mysql_num_rows($result) > $config['cf_double_login']) {
                alert("다른 ip에서 이미 로그인되어 있습니다. 관리자에게 문의하시기 바랍니다.");
            }
    }
    // 파일세션을 사용하는 경우
    else if ($g4['session_type'] = "file") {
        $result = sql_fetch(" select count(*) as cnt from $g4[login_table] where mb_id='$mb[mb_id]' and lo_ip <> '$_SERVER[REMOTE_ADDR]' ");
        
        if ($result['cnt'] > $config['cf_double_login']) {
            alert("다른 ip에서 이미 로그인되어 있습니다. 관리자에게 문의하시기 바랍니다.");
        }
    }
    // redis 세션을 이용하는 경우
    else if ($g4['session_type'] == "redis") {

        $redis_con = new Redis();
        $redis_con->connect($g4["rhost"], $g4["rport"]);
        $redis_con->select($g4["rdb1"]);

        // ip가 같은 key들을 모두 골라 냅니다.
        $con_key = $g4["rdomain"] . "_login_" . "$remote_addr";
        $allKeys = $redis_con->keys($con_key);

        $con_cnt = 0;
        foreach ($allKeys as $rkey) {
            $rdat = explode ( "|", $redis_con->get($rkey) );
            if ($redis_con->ttl($rkey) > 0) {
                if ($mb['mb_id'] == $rdat['1']) {
                    $con_cnt++;
                }
            }
        }
        $redis_con->close();

        if ($con_cnt > $config['cf_double_login']) {
            alert("다른 ip에서 이미 로그인되어 있습니다. 관리자에게 문의하시기 바랍니다.");
        }
    }
}

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
if (file_exists("$member_skin_path/login_check.skin.php"))
    @include_once("$member_skin_path/login_check.skin.php");

// --- 불당팩 회원 레벨업/레벨다운

// db를 뒤져서 관리자인가? 아닌가를 체크.
function is_admin_check($mb_id)
{
    global $g4, $config;

    if (!$mb_id) return;

    // super 관리자인지 확인 - super는 1명뿐.
    if ($config['cf_admin'] == $mb_id) return 'super';

    // 그룹 관리자인지 확인
    $mb = sql_fetch("select gr_id from $g4[group_table] where gr_admin = '$mb_id' limit 1 ");
    if ($mb) return 'group';
    
    // 게시판 관리자인지 확인
    $mb = sql_fetch("select bo_table from $g4[board_table] where bo_admin = '$mb_id' limit 1 ");
    if ($mb) return 'board';
    
    return '';
}

// 회원의 레벨업/레벨다운
if ($g4['use_auto_levelup'] && !is_admin_check($mb_id))
{
    $res = member_level_up($mb_id);
    if ($res) {

        $tsql = " insert into $g4[whatson_table] ( mb_id, wr_subject, wo_type, wo_count, wo_datetime, bo_table, wr_id ) 
                  values ('$mb_id', '$res','mb_level','1','$g4[time_ymdhis]','','') ";
        sql_query($tsql);
    }
}
// --- 불당팩 회원 레벨업 끝

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb[mb_id]);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb[mb_datetime] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
session_write_close();

// 3.26
// 아이디 쿠키에 한달간 저장
if ($auto_login) {
    // 3.27
    // 자동로그인 ---------------------------
    // 쿠키 한달간 저장
    if ($g4['load_balance']) {
        if ($g4['g4_mobile_device'])
            $key = md5($g4['load_balance'] . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
        else
            $key = md5($g4['load_balance'] . $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
    } else {
        if ($g4['g4_mobile_device'])
            $key = md5($_SERVER[SERVER_ADDR] . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
        else
            $key = md5($_SERVER[SERVER_ADDR] . $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
    }
    // 불당팩 - 쿠키를 암호화 하여 저장
    //set_cookie('ck_mb_id', $mb[mb_id], 86400 * 31);
    $mb_key = encrypt($mb[mb_id],$g4[encrypt_key]);
    set_cookie('ck_mb_id', $mb_key, 86400 * 31);
    set_cookie('ck_auto', $key, 86400 * 31);
    // 자동로그인 end ---------------------------
} else {
    set_cookie('ck_mb_id', '', 0);
    set_cookie('ck_auto', '', 0);
}

// 불당팩 - 아이디 자동저장
if ($auto_mb_id) {
    // 쿠키 한달간 저장
    set_cookie('ck_auto_mb_id', encrypt($mb[mb_id],$g4[encrypt_key]), 86400 * 31);
} else {
    set_cookie('ck_auto_mb_id', '', 0);
}


if ($url) 
{
    $link = urldecode($url);
    // 2003-06-14 추가 (다른 변수들을 넘겨주기 위함)
    if (preg_match("/\?/", $link))
        $split= "&"; 
    else
        $split= "?"; 

    // $_POST 배열변수에서 아래의 이름을 가지지 않은 것만 넘김
    foreach($_POST as $key=>$value) 
    {
        if ($key != "mb_id" && $key != "mb_password" && $key != "x" && $key != "y" && $key != "url") 
        {
            $link .= "$split$key=$value";
            $split = "&";
        }
    }
} 
else
    $link = $g4[path];

// 개인정보 변경주기
if ($mb['mb_password_change_datetime'] != '0000-00-00 00:00:00' && !$is_admin) {
    $change_alert = $g4[server_time] - strtotime($mb['mb_password_change_datetime']);
    if ($config['cf_password_change_dates'] > 0 && $change_alert > 0)
        $link = "$g4[bbs_path]/password_chage_request.php";
}

goto_url($link);
?>
