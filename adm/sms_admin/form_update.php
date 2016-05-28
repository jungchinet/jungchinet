<?
$sub_menu = "900600";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$g4[title] = "이모티콘 업데이트";

if ($w == 'u') // 업데이트
{
    if (!$fg_no) $fg_no = 0;

    if (!$fo_receipt) $fo_receipt = 0; else $fo_receipt = 1;

    if (!strlen(trim($fo_name)))
        alert_just('이름을 입력해주세요');

    if (!strlen(trim($fo_content)))
        alert_just('이모티콘을 입력해주세요');

    $res = sql_fetch("select * from $g4[sms4_form_table] where fo_no<>'$fo_no' and fo_content='$fo_content'");
    if ($res)
        alert_just('같은 이모티콘이 존재합니다.');

    $res = sql_fetch("select * from $g4[sms4_form_table] where fo_no='$fo_no'");
    if (!$res)
        alert_just('존재하지 않는 데이터 입니다.');

    if ($fg_no != $res[fg_no]) {
        if ($res[fg_no])
            sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count - 1 where fg_no='$res[fg_no]'");

        sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count + 1 where fg_no='$fg_no'");
    }

    $group = sql_fetch("select * from $g4[sms4_form_group_table] where fg_no = '$fg_no'");

    sql_query("update $g4[sms4_form_table] set fg_no='$fg_no', fg_member='$group[fg_member]', fo_name='$fo_name', fo_content='$fo_content', fo_datetime='$g4[time_ymdhis]' where fo_no='$fo_no'");
}
else if ($w == 'd') // 삭제
{
    if (!is_numeric($fo_no))
        alert_just('고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_form_table] where fo_no='$fo_no'");
    if (!$res)
        alert_just('존재하지 않는 데이터 입니다.');

    sql_query("delete from $g4[sms4_form_table] where fo_no='$fo_no'");
    sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count - 1 where fg_no = '$res[fg_no]'");

    $get_fg_no = $fg_no;
}
else // 등록
{
    if (!$fg_no) $fg_no = 0;

    if (!strlen(trim($fo_name)))
        alert_just('이름을 입력해주세요');

    if (!strlen(trim($fo_content)))
        alert_just('이모티콘을 입력해주세요');

    $res = sql_fetch("select * from $g4[sms4_form_table] where fo_content='$fo_content'");
    if ($res)
        alert_just('같은 이모티콘이 존재합니다.');

    $group = sql_fetch("select * from $g4[sms4_form_group_table] where fg_no = '$fg_no'");

    sql_query("insert into $g4[sms4_form_table] set fg_no='$fg_no', fg_member='$group[fg_member]', fo_name='$fo_name', fo_content='$fo_content', fo_datetime='$g4[time_ymdhis]'");
    sql_query("update $g4[sms4_form_group_table] set fg_count = fg_count + 1 where fg_no = '$fg_no'");

    $get_fg_no = $fg_no;

    echo "<script language=javascript>
    if (confirm('입력작업을 계속 하시겠습니까?')) 
        parent.document.location.reload(); 
    else
        parent.document.location.href = './form_list.php?page=$page&fg_no=$get_fg_no';
    </script>";
    exit;
}

?>
<script language=javascript>
parent.document.location.href = "./form_list.php?page=<?=$page?>&fg_no=<?=$get_fg_no?>";
</script>
