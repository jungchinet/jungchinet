<?
$sub_menu = "300300";
include_once("./_common.php");

if ($is_admin != "super") 
    alert("최고관리자만 접근 가능합니다.");

//print_r2($_POST);

// 관리자만이 접속할 수 있으므로, 접속한 사람의 ip, mb_id는 차단하면 안됩니다.
if ($ip=="$remote_addr")
    alert("현재 로그인 중인 관리자 IP ( $remote_addr ) 는 접근 차단 할 수 없습니다.");

if ($mb_id) {
    if ($mb_id==$member[mb_id])
        alert("현재 로그인 중인 관리자 ( $member[mb_id] ) 는 접근 차단 할 수 없습니다.");

    $sql = " update $g4[member_table] 
                set mb_memo = concat('$g4[time_ymdhis] : 게시물 신고로 인한 접근 차단\n', mb_memo),
                    mb_intercept_date = '".date("Ymd", $g4[server_time])."'
              where mb_id = '$mb_id' ";
    sql_query($sql);
}

// 접근차단 IP
$pattern = explode("\n", trim($config['cf_intercept_ip']));
if (!in_array($ip, $pattern)) {
    if (empty($pattern[0])) // ip 차단목록이 비어 있을 때
        $cf_intercept_ip = $ip;
    else
        $cf_intercept_ip = trim($config['cf_intercept_ip'])."\n{$ip}";
    $sql = " update {$g4['config_table']} set cf_intercept_ip = '$cf_intercept_ip' ";
    sql_query($sql);   
}

$url = $_SERVER[HTTP_REFERER] . "?page=$page";
goto_url($url);
?>
