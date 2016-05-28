<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

for ($i=0; $i < count($chk_fr_no); $i++) {
    $sql = " delete from $g4[friend_table] where fr_no = '$chk_fr_no[$i]' and mb_id = '$member[mb_id]' ";
    sql_fetch($sql);
}

goto_url("$g4[bbs_path]/memo.php?kind=$kind&fr_type=$fr_type");
?>
