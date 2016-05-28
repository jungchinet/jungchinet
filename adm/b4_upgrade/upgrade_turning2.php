<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " ALTER TABLE `$g4[board_table]` ADD `min_wr_num` INT( 11 ) NOT NULL ";
sql_query($sql, false);

$sql = " select * from $g4[board_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];

    $sql2 = " select min(wr_num) as min_wr_num from $tmp_write_table ";
    $result2 = sql_fetch($sql2);

    $sql4 = " update $g4[board_table] set min_wr_num = '$result2[min_wr_num]' where bo_table = '$row[bo_table]' ";
    sql_query($sql4);

    echo "<BR>" . $i . " : " . $row[bo_table] . " 게시판의 min_wr_num 을 업데이트 했습니다 <br>";
}

echo "<br>min_wr_num 추가 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
