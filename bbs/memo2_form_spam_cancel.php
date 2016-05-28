<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_admin != "super")
    alert("최고관리자만 이용하실 수 있습니다.");

$kind   = $_POST[kind];
$me_id  = $_POST[me_id];

if ($kind != "spam")
    alert("스팸취소오류 - 최고관리자에게 문의하시기 바랍니다");

$sql = " select * from $g4[memo_spam_table] where me_id = '$me_id' ";
$result = sql_fetch($sql);

// 발신자, 제목, 내용이 같으며, 발신일로 부터 +/- 10분 이내의 모든 쪽지를 스팸으로 규정
$sql_where = " me_send_mb_id = '$result[me_send_mb_id]' and me_subject = '$result[me_subject]' and me_memo = '" . addslashes($result[me_memo]) . "' and me_send_datetime > '" . date("Y-m-d H:i:s", strtotime($result[me_send_datetime]) - 60*10 ) . "' and me_send_datetime < '" . date("Y-m-d H:i:s", strtotime($result[me_send_datetime]) + 60*10 ) . "' ";
$sql = " delete from $g4[memo_recv_table] where $where_datetime $sql_where";
sql_query($sql);

$result_count = mysql_affected_rows();

alert("{$result_count} 건의 쪽지를 스팸회수 하였습니다.", "./memo.php?kind=$kind");
?>
