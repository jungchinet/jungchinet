<?
$g4_path = "../.."; // common.php 의 상대 경로
include_once ("$g4_path/common.php");

// 디렉토리 
$g4['manual']          = "manual"; 
$g4['manual_path']    = $g4['path'] . "/" . $g4['admin'] . "/" . $g4['manual']; 

include_once("$g4[admin_path]/manual/admin.lib.php");
?>
