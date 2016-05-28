<?
include_once("./_common.php");

$mb_id = $_POST['mb_id'];

$sql = " select * from $g4[member_table] where mb_id='$mb_id'";
$mb = sql_fetch($sql);

$b = "<li>쪽지<li>이메일<li>홈페이지<li>트위터";
echo iconv($g4['charset'], 'UTF-8',$b);
?>
