<?
$sub_menu = "900500";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($w == 'u') // 업데이트
{
    if (!is_numeric($fg_no))
        alert_just('그룹 고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_form_group_table] where fg_no='$fg_no'");
    if (!$res)
        alert_just('존재하지 않는 그룹입니다.');

    if (!strlen(trim($fg_name)))
        alert_just('그룹이름을 입력해주세요');

    $res = sql_fetch("select fg_name from $g4[sms4_form_group_table] where fg_no<>'$fg_no' and fg_name='$fg_name'");
    if ($res)
        alert_just('같은 그룹이름이 존재합니다.');

    sql_query("update $g4[sms4_form_group_table] set fg_name='$fg_name', fg_member='$fg_member' where fg_no='$fg_no'");
    sql_query("update $g4[sms4_form_table] set fg_member = '$fg_member' where fg_no = '$fg_no'");
}
else if ($w == 'd') // 그룹삭제
{
    if (!is_numeric($fg_no))
        alert_just('그룹 고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_form_group_table] where fg_no='$fg_no'");
    if (!$res)
        alert_just('존재하지 않는 그룹입니다.');

    sql_query("delete from $g4[sms4_form_group_table] where fg_no='$fg_no'");
    sql_query("update $g4[sms4_form_table] set fg_no = 0, fg_member = 0 where fg_no='$fg_no'");
}
else if ($w == 'empty') 
{
    if ($fg_no == 'no') $fg_no = 0;

    if ($fg_no)
        sql_query("update $g4[sms4_form_group_table] set fg_count = 0 where fg_no = '$fg_no'");

    sql_query("delete from $g4[sms4_form_table] where fg_no = '$fg_no'");
}
else // 등록
{
    if (!strlen(trim($fg_name)))
        alert_just('그룹이름을 입력해주세요');

    $res = sql_fetch("select fg_name from $g4[sms4_form_group_table] where fg_name = '$fg_name'");
    if ($res)
        alert_just('같은 그룹이름이 존재합니다.');

    sql_query("insert into $g4[sms4_form_group_table] set fg_name = '$fg_name'");
}

?>
<script language=javascript>
parent.document.location.reload();
</script>
