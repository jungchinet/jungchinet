<?
$sub_menu = "900700";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($w == 'u') // 업데이트
{
    if (!is_numeric($bg_no))
        alert_just('그룹 고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no='$bg_no'");
    if (!$res)
        alert_just('존재하지 않는 그룹입니다.');

    if (!strlen(trim($bg_name)))
        alert_just('그룹이름을 입력해주세요');

    $res = sql_fetch("select bg_name from $g4[sms4_book_group_table] where bg_no<>'$bg_no' and bg_name='$bg_name'");
    if ($res)
        alert_just('같은 그룹이름이 존재합니다.');

    sql_query("update $g4[sms4_book_group_table] set bg_name='$bg_name' where bg_no='$bg_no'");
}
else if ($w == 'd') // 그룹삭제
{
    if (!is_numeric($bg_no))
        alert_just('그룹 고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no='$bg_no'");
    if (!$res)
        alert_just('존재하지 않는 그룹입니다.');

    sql_query("delete from $g4[sms4_book_group_table] where bg_no='$bg_no'");
    sql_query("update $g4[sms4_book_table] set bg_no=0 where bg_no='$bg_no'");
}
else if ($w == 'empty') // 비우기
{
    sql_query("update $g4[sms4_book_group_table] set bg_count = 0, bg_member = 0, bg_nomember = 0, bg_receipt = 0, bg_reject = 0 where bg_no='$bg_no'");
    sql_query("delete from $g4[sms4_book_table] where bg_no='$bg_no'");
}
else // 등록
{
    if (!strlen(trim($bg_name)))
        alert_just('그룹이름을 입력해주세요');

    $res = sql_fetch("select bg_name from $g4[sms4_book_group_table] where bg_name='$bg_name'");
    if ($res)
        alert_just('같은 그룹이름이 존재합니다.');

    sql_query("insert into $g4[sms4_book_group_table] set bg_name='$bg_name'");
}

?>
<script language=javascript>
parent.document.location.reload();
</script>
