<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$gr_id)
  alert("그룹 아이디가 지정되지 않았습니다.");

if (!$gr_edit)
  alert("그룹 이름이 입력되지 않았습니다.");
  
$gr_edit = addslashes($gr_edit);

$sql = " update $g4[memo_group_table] set gr_name = '$gr_edit', gr_datetime = now() where gr_id = '$gr_id' and mb_id = '$member[mb_id]' ";
sql_fetch($sql);

goto_url("$g4[bbs_path]/memo.php?kind=memo_group_admin");
?>
