<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

$sql = " 
CREATE TABLE `$g4[mb_nick_table]` (
  `nick_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL,
  `mb_nick` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  PRIMARY KEY  (`nick_no`)
)  AUTO_INCREMENT=1 
";
sql_query($sql, false);

$sql = " delete from $g4[mb_nick_table] ";
$result = sql_query($sql, false);

$sql = " select * from $g4[member_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

    $sql = " insert $g4[mb_nick_table] 
               set  mb_id = '$row[mb_id]',
                    mb_nick = '$row[mb_nick]',
                    start_datetime = '$g4[time_ymdhis]' ";
    sql_query($sql);
}

echo "<br>mb_nick 히스토리 추가 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
