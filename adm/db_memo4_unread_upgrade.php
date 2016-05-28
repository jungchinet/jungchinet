<?
$sub_menu = "100600";
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
include_once("./admin.head.php");


sql_query("ALTER TABLE `$g4[member_table]` ADD `mb_memo_unread` INT( 11 ) NOT NULL ", FALSE);

$sql = " select distinct me_recv_mb_id from $g4[memo_recv_table] ";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
    $mb_id = $row[me_recv_mb_id];
    $sql1 = " select count(*) as cnt from $g4[memo_recv_table] 
           where me_recv_mb_id = '$mb_id' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row1 = sql_fetch($sql1);
    sql_query(" update $g4[member_table] set mb_memo_unread = '$row1[cnt]' where mb_id = '$mb_id' ");
}

echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
