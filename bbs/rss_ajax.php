<?
include_once("./_common.php");

$w = strip_tags($_POST[w]);
$bo_table = strip_tags($_POST[bo_table]);

if ($is_admin !== "super")
  alert("관리자에게 문의 하시기 바랍니다");

if ($w == "on")
    sql_query(" update $g4[board_table] set bo_use_rss_view = 1 where bo_table='$bo_table' ");
else
    sql_query(" update $g4[board_table] set bo_use_rss_view = 0 where bo_table='$bo_table' ");

goto_url("./rss_list.php");
?>
