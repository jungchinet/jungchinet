<?
// 핸드폰 그룹 이동
$sub_menu = "900700";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$res = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no='$bg_no'");
sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + $res[bg_count], bg_member = bg_member + $res[bg_member], bg_nomember = bg_nomember + $res[bg_nomember], bg_receipt = bg_receipt + $res[bg_receipt], bg_reject = bg_reject + $res[bg_reject] where bg_no='$move_no'");
sql_query("update $g4[sms4_book_group_table] set bg_count = 0, bg_member = 0, bg_nomember = 0, bg_receipt = 0, bg_reject = 0 where bg_no='$bg_no'");
sql_query("update $g4[sms4_book_table] set bg_no='$move_no' where bg_no='$bg_no'");

?>
<script language=javascript>
parent.document.location.reload();
</script>
