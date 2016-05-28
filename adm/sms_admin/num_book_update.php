<?
$sub_menu = "900800";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$g4[title] = "핸드폰번호 업데이트";

$g4[sms4_demo] = 0;

$bk_hp = get_hp($bk_hp);

if ($w=='u') // 업데이트
{
    if (!$bg_no) $bg_no = 0;

    if (!$bk_receipt) $bk_receipt = 0; else $bk_receipt = 1;

    if (!strlen(trim($bk_name)))
        alert_just('이름을 입력해주세요');

    if ($bk_hp == '')
        alert_just('핸드폰번호만 입력 가능합니다.');
/*
    $res = sql_fetch("select * from $g4[sms4_book_table] where bk_no<>'$bk_no' and bk_hp='$bk_hp'");
    if ($res)
        alert_just('같은 번호가 존재합니다.');
*/
    $res = sql_fetch("select * from $g4[sms4_book_table] where bk_no='$bk_no'");
    if (!$res)
        alert_just('존재하지 않는 데이터 입니다.');

    if ($bg_no != $res[bg_no]) {
        if ($res[mb_id]) $mem = "bg_member"; else $mem = "bg_nomember";
        if ($res[bk_receipt] == 1) $sms = "bg_receipt"; else $sms = "bg_reject";
        sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count - 1, $mem = $mem - 1, $sms = $sms - 1 where bg_no='$res[bg_no]'");
        sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + 1, $mem = $mem + 1, $sms = $sms + 1 where bg_no='$bg_no'");
    }

    if ($bk_receipt != $res[bk_receipt]) {
        if ($bk_receipt == 1)
            sql_query("update $g4[sms4_book_group_table] set bg_receipt = bg_receipt + 1, bg_reject = bg_reject - 1 where bg_no='$bg_no'");
        else
            sql_query("update $g4[sms4_book_group_table] set bg_receipt = bg_receipt - 1, bg_reject = bg_reject + 1 where bg_no='$bg_no'");
    }

    sql_query("update $g4[sms4_book_table] set bg_no='$bg_no', bk_name='$bk_name', bk_hp='$bk_hp', bk_receipt='$bk_receipt', bk_datetime='$g4[time_ymdhis]', bk_memo='$bk_memo' where bk_no='$bk_no'");
    if ($res[mb_id]) 
        sql_query("update $g4[member_table] set mb_name='$bk_name', mb_hp='$bk_hp', mb_sms='$bk_receipt' where mb_id='$res[mb_id]'");

    $get_bg_no = $bg_no;
}
else if ($w=='d') // 삭제
{
    if (!is_numeric($bk_no))
        alert_just('고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_book_table] where bk_no='$bk_no'");
    if (!$res)
        alert_just('존재하지 않는 데이터 입니다.');

    if ($res[bk_receipt] == 1) $bg_sms = 'bg_receipt'; else $bg_sms = 'bg_reject';
    if ($res[mb_id]) $bg_mb = 'bg_member'; else $bg_mb = 'bg_nomember';

    sql_query("delete from $g4[sms4_book_table] where bk_no='$bk_no'");
    sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count - 1, $bg_mb = $bg_mb - 1, $bg_sms = $bg_sms - 1 where bg_no = '$res[bg_no]'");

/*
    if (!is_numeric($bk_no))
        alert_just('고유번호가 없습니다.');

    $res = sql_fetch("select * from $g4[sms4_book_table] where bk_no='$bk_no'");
    if (!$res)
        alert_just('존재하지 않는 데이터 입니다.');

    if (!$res[mb_id])
    {
        if ($res[receipt] == 1)
            $sql_sms = "bg_receipt = bg_receipt - 1";
        else
            $sql_sms = "bg_reject = bg_reject - 1";

        sql_query("delete from $g4[sms4_book_table] where bk_no='$bk_no'");
        sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count - 1, bg_nomember = bg_nomember - 1, $sql_sms where bg_no = '$res[bg_no]'");
    }
    else
        alert_just("회원은 삭제할 수 없습니다.\\n\\n회원관리 메뉴에서 삭제한 후\\n\\n회원정보업데이트 메뉴를 실행 해주세요.");
*/
}
else // 등록
{
    if (!$bg_no) $bg_no = 1;

    if (!$bk_receipt) $bk_receipt = 0; else $bk_receipt = 1;

    if (!strlen(trim($bk_name)))
        alert_just('이름을 입력해주세요');

    if ($bk_hp == '')
        alert_just('핸드폰번호만 입력 가능합니다.');

    $res = sql_fetch("select * from $g4[sms4_book_table] where bk_hp='$bk_hp'");
    if ($res)
        alert_just('같은 번호가 존재합니다.');

    if ($bk_receipt == 1)
        $sql_sms = "bg_receipt = bg_receipt + 1";
    else
        $sql_sms = "bg_reject = bg_reject + 1";

    sql_query("insert into $g4[sms4_book_table] set bg_no='$bg_no', bk_name='$bk_name', bk_hp='$bk_hp', bk_receipt='$bk_receipt', bk_datetime='$g4[time_ymdhis]', bk_memo='$bk_memo'");
    sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + 1, bg_nomember = bg_nomember + 1, $sql_sms where bg_no = '$bg_no'");

    $get_bg_no = $bg_no;

    echo "<script language=javascript>
    if (confirm('입력작업을 계속 하시겠습니까?')) 
        parent.document.location.href = './num_book_write.php?bg_no=$get_bg_no&ap=$ap';
    else
        parent.document.location.href = './num_book.php?page=$page&bg_no=$get_bg_no&ap=$ap';
    </script>";
    exit;
}

?>
<script language=javascript>
parent.document.location.href = "./num_book.php?page=<?=$page?>&bg_no=<?=$get_bg_no?>&ap=<?=$ap?>";
</script>
