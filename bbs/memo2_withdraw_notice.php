<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$mb_id = $member['mb_id'];
$me_id = $me_id;

if (!$me_id || !$mb_id || $is_admin != 'super')
    alert("부적절한 사용입니다");

// 공지쪽지를 발송하고 1시간 이내에만 취소 가능 합니다.
$sql = " select * from $g4[memo_notice_table] where me_id = '$me_id' ";
$memo = sql_fetch($sql);

$time_diff = strtotime("-1 hour") - strtotime($memo['me_send_datetime']);

if ($time_diff > 0)
    alert("공지쪽지를 발송하고 1시간 이내에만 취소 가능 합니다.");

// 공통조건
$sql_where = " where me_send_mb_id = '$memo[me_send_mb_id]' and 
                     me_subject = '$memo[me_subject]' and 
                     me_send_datetime = '$memo[me_send_datetime]' 
              ";
// 받은쪽지함의 공지쪽지 삭제
$sql = " delete from $g4[memo_recv_table] " . $sql_where;
sql_query($sql);

// 보낸쪽지함의 공지쪽지 삭제
$sql = " delete from $g4[memo_send_table] " . $sql_where;
sql_query($sql);

// 보관한쪽지함의 공지쪽지 삭제
$sql = " delete from $g4[memo_save_table] " . $sql_where;
sql_query($sql);

// 공지쪽지 삭제
$sql = " delete from $g4[memo_notice_table] " . $sql_where;
sql_query($sql);

alert("공지쪽지를 삭제하고, 발송된 쪽지를 모두 회수하였습니다.", "./memo.php?kind=$kind");
?>
