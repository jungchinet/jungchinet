<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " ALTER TABLE `$g4[member_table]` ADD `mb_auth_count` TINYINT( 4 ) NOT NULL ";
sql_query($sql, false);

$sql = " select mb_id, count(*) as cnt from $g4[auth_table] group by mb_id ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

    $sql4 = " update $g4[member_table] set mb_auth_count = '$row[cnt]' where mb_id = '$row[mb_id]' ";
    sql_query($sql4);

    echo "<BR>" . $i . " : " . $row[mb_id] . "님의 mb_auth_count를 업데이트 했습니다 <br>";
}

echo "<br>mb_auth_count 추가 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
