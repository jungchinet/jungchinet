<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!$member[mb_id])
    alert("회원만 이용하실 수 있습니다.");

// $me_from_kind가 없는 경우가 있다...
if ($me_from_kind == "")
    alert("해당 쪽지는 삭제취소를 할 수 없습니다", "./memo.php?kind=trash");

// 해당 게시글이 존재하는지 여부를 확인
$sql = " select * from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind' ";
$result = sql_fetch($sql);

if ($result['me_id']) {
    // 원래의 쪽지함으로 복구
    $sql_select = " me_id, me_recv_mb_id, me_send_mb_id,me_send_datetime,me_read_datetime, me_memo, me_file_local, me_file_server, me_subject, memo_type, memo_owner, me_option ";
    $sql_table = "memo_{$me_from_kind}_table";
    $sql = " insert into $g4[$sql_table] select $sql_select from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind' ";
    sql_query($sql);

    // 복구가 끝났으면 삭제를...
    $sql = " delete from $g4[memo_trash_table] where me_id = '$me_id' and me_from_kind = '$me_from_kind'  ";
    sql_query($sql);
    
    if ($me_from_kind == "recv" && $result[me_read_datetime] == '0000-00-00 00:00:00') {
        // 안읽은 쪽지 갯수를 업데이트
        $sql1 = " select count(*) as cnt from $g4[memo_recv_table] 
                   where me_recv_mb_id = '$member[mb_id]' and me_read_datetime = '0000-00-00 00:00:00' ";
        $row1 = sql_fetch($sql1);
        sql_query(" update $g4[member_table] set mb_memo_unread = '$row1[cnt]' where mb_id = '$member[mb_id]' ");
    }

} else {
    alert("쪽지를 삭제취소를 할 수 없습니다.", "./memo.php?kind=trash");
}

alert("쪽지를 삭제취소 하였습니다.", "./memo.php?kind=trash");
?>
