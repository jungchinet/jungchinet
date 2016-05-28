<?
include_once("./_common.php");

if (!$is_member)
    alert_only("로그인 후 이용하실 수 있습니다.");

if (!$bo_table)
    alert_only("bo_table 이 없습니다.");
	
$row = sql_fetch("select * from $g4[my_menu_table] where bo_table = '$bo_table' and mb_id = '$member[mb_id]'");
if ($row){
    //alert_only("이미 등록되어 있습니다.");
	sql_query("delete from $g4[my_menu_table] where bo_table = '$bo_table' and mb_id = '$member[mb_id]'");
	sql_query("insert into $g4[my_menu_table] set mb_id = '$member[mb_id]', bo_table = '$bo_table'");
	
	alert_only("\'$board[bo_subject]\'를 등록하였습니다.");	

}else{

	sql_query("insert into $g4[my_menu_table] set mb_id = '$member[mb_id]', bo_table = '$bo_table'");
	
	alert_only("\'$board[bo_subject]\'를 등록하였습니다.");
}

?>
<script>parent.location.reload();</script>
