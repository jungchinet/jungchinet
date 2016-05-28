<?
$sub_menu = "100500";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "r");

$g4[title] = "php info";
include_once("./admin.head.php");

include_once("./phpinfo_view.php");

include_once("./admin.tail.php");
?>
