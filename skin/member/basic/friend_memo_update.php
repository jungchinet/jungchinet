<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$fr_edit = addslashes($fr_edit);

$sql = " update $g4[friend_table] set fr_memo = '$fr_edit' where fr_no = '$fr_no' and mb_id = '$member[mb_id]' ";
sql_fetch($sql);

goto_url("$g4[bbs_path]/memo.php?kind=$kind&fr_type=$fr_type");
?>
