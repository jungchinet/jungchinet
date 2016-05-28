<?
$sub_menu = "100600";
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
include_once("./admin.head.php");


sql_query("ALTER TABLE `$g4[member_table]` ADD `mb_memo_unread_datetime` DATETIME NOT NULL ", FALSE);

echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
