<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " ALTER TABLE `$g4[scrap_table]` ADD `ms_memo` TEXT NOT NULL , ADD `wr_mb_id` VARCHAR( 255 ) NOT NULL , ADD `wr_subject` VARCHAR( 255 ) NOT NULL ";
sql_query($sql, false);

$sql = " select * from $g4[scrap_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];

    $sql1 = " select wr_subject, mb_id from $tmp_write_table where wr_id = '$row[wr_id]' ";
    $result1 = sql_fetch($sql1, false);
    $sql4 = " update $g4[scrap_table] set wr_mb_id = '$result1[mb_id]', wr_subject = '$result1[wr_subject]' where ms_id = '$row[ms_id]'";
    sql_query($sql4, false);
}

echo "<br>scrap UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
