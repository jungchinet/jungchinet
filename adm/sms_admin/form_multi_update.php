<?
$sub_menu = "900600";
include_once("./_common.php");
include_once("$g4[path]/head.sub.php");

auth_check($auth[$sub_menu], "w");

$ck_no = explode(',', $ck_no);

for ($i=0; $i<count($ck_no); $i++) 
{
    $fo_no = $ck_no[$i];
    if (!trim($fo_no)) continue;

    $res = sql_fetch("select * from $g4[sms4_form_table] where fo_no='$fo_no'");
    if (!$res) continue;

    if ($w == 'del') // 삭제
    {
        if (!$res[mb_id]) {
            sql_query("delete from $g4[sms4_form_table] where fo_no='$fo_no'");
            sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count - 1 where fg_no='$res[fg_no]'");
        }
    }
    else // 그룹이동
    {
        sql_query("update $g4[sms4_form_table] set fg_no='$w' where fo_no='$fo_no'");
        sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count - 1 where fg_no='$res[fg_no]'");
        sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count + 1 where fg_no='$w'");
    }
}
?>

<script language="javascript">
parent.location.reload();
</script>
