<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " select * from $g4[board_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];

    $sql1 = " ALTER TABLE `$tmp_write_table` ADD INDEX `list_index` ( `wr_is_comment` , `wr_num` , `wr_reply` ) ";
    sql_query($sql1, FALSE);

    $sql2 = " ALTER TABLE `$tmp_write_table` ADD INDEX `comment_index` ( `wr_is_comment` , `wr_parent` , `wr_comment`, `wr_comment_reply` ) ";
    sql_query($sql2, FALSE);

    $sql3 = " ALTER TABLE `$tmp_write_table` ADD INDEX `mb_id` ( `mb_id` ) ";
    sql_query($sql3, FALSE);
    
    $sql4 = " ALTER TABLE `$tmp_write_table` ADD INDEX `write_idx` ( `wr_parent` , `mb_id` , `wr_is_comment` ) ";
    sql_query($sql4, FALSE);

    echo "<BR>" . $i . " : " . $row[bo_table] . " 게시판의 index 테이블을 업데이트 했습니다 <br>";
}

echo "<br>index 추가 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
