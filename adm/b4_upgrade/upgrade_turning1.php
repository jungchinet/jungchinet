<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " select bo_table from $g4[board_table] ";
$result = sql_query($sql);

while ($row = sql_fetch_array($result))
{    
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];
    $sql2 = " ALTER TABLE `$tmp_write_table` ADD `wr_file_count` TINYINT( 4 ) UNSIGNED NOT NULL ";
    sql_query($sql2, false);
    echo "<BR>" . $tmp_write_table . "에 wr_file_count 필드가 추가되었습니다<br>";

    $sql3 = " select wr_id, count(*) as cnt from $g4[board_file_table] where bo_table = '$row[bo_table]' group by wr_id ";
    $result3 = sql_query($sql3);
    while ($row3 = sql_fetch_array($result3))
    {
        $sql4 = " update $tmp_write_table set wr_file_count = '$row3[cnt]' where wr_id = '$row3[wr_id]' ";
        sql_query($sql4);
    }    
}

echo "<br>wr_file_count file 추가 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
