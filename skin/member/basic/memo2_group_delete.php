<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$chk_gr_id = $_POST['chk_gr_id'];

for ($i=0; $i < count($chk_gr_id); $i++) {
    $sql = " delete from $g4[memo_group_table] where gr_id = '$chk_gr_id[$i]' and mb_id = '$member[mb_id]' ";
    sql_fetch($sql);
}

goto_url("$g4[bbs_path]/memo.php?kind=memo_group_admin");
?>
