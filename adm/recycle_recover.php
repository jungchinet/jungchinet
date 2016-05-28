<?
$sub_menu = "300700";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if ($is_admin != "super")
    alert("휴지통 복구는 최고관리자만 가능합니다.");

$g4[title] = "휴지통 복구";

include_once("./admin.head.php");

include_once("./recycle_recover.inc.php");
?>
