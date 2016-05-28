<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$gr_name)
  alert("그룹 이름이 입력되지 않았습니다.");
  
$gr_name  = $_POST['gr_name'];

$sql = " select count(*) as cnt from $g4[memo_group_table] where gr_name = '$gr_name' ";
$result = sql_fetch($sql);
if ($result['cnt'] > 0)
  alert("$gr_name은 이미 등록된 그룹 입니다. 다른 이름을 입력해 주세요");

$sql = " insert $g4[memo_group_table] set mb_id = '$member[mb_id]', gr_name = '$gr_name', gr_datetime = now() ";
sql_query($sql, $error);

goto_url("$g4[bbs_path]/memo.php?kind=memo_group_admin");
?>
