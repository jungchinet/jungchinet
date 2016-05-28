<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$chk_fr_id  = $_POST['chk_fr_id'];
$gr_id      = $_POST['gr_id'];

for ($i=0; $i < count($chk_fr_no); $i++) {
    $sql = " delete from $g4[memo_group_member_table] where gr_id = '$gr_id' and gr_mb_no = '$chk_fr_no[$i]' ";
    sql_fetch($sql);
}

goto_url("$g4[bbs_path]/memo.php?kind=memo_group&gr_id=$gr_id");
?>
