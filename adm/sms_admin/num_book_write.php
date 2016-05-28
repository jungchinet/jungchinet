<?
$sub_menu = "900800";
include_once("./_common.php");

$colspan = 4;

auth_check($auth[$sub_menu], "r");

$g4[title] = "핸드폰번호 ";

if ($w == 'u' && is_numeric($bk_no)) {
    $write = sql_fetch("select * from $g4[sms4_book_table] where bk_no='$bk_no'");
    if (!$write)
        alert('데이터가 없습니다.');

    if ($write[mb_id]) {
        $res = sql_fetch("select mb_id from $g4[member_table] where mb_id='$write[mb_id]'");
        $write[mb_id] = $res[mb_id];
    }
    $g4[title] .= '수정';
}
else  {
    $write[bg_no] = $bg_no;
    $g4[title] .= '추가';
}

if (!is_numeric($write[bk_receipt]))
    $write[bk_receipt] = 1;

$no_group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no = 1");

include_once("$g4[admin_path]/admin.head.php");
?>

<?=subtitle($g4[title])?>

<form name=book_form method=post action=num_book_update.php target=hiddenframe style="padding:0; margin:0;">
<input type=hidden name=w value='<?=$w?>'>
<input type=hidden name=page value='<?=$page?>'>
<input type=hidden name=ap value='<?=$ap?>'>
<input type=hidden name=bk_no value='<?=$write[bk_no]?>'>
<input type=hidden name=mb_id value='<?=$write[mb_id]?>'>
<input type=hidden name=get_bg_no value='<?=$bg_no?>'>
<table cellpadding=0 cellspacing=0 width=100% border=0>
<tbody align=center>
<tr><td colspan=<?=$colspan?> height=2 bgcolor=#0E87F9></td></tr>
<tr height=30>
    <td width=100> 그룹 </td>
    <td align=left> 
        <select name=bg_no required itemname='그룹' tabindex=1>
        <option value='1'><?=$no_group[bg_name]?> (<?=number_format($no_group[bg_count])?> 명)</option>
        <?
        $qry = sql_query("select * from $g4[sms4_book_group_table] where bg_no>1 order by bg_name");
        while($res = sql_fetch_array($qry)) {
        ?>
        <option value='<?=$res[bg_no]?>' <?=$res[bg_no]==$write[bg_no]?'selected':''?>> <?=$res[bg_name]?>  (<?=number_format($res[bg_count])?> 명) </option>
        <?}?>
        </select>
    </td>
</tr>
<tr height=30>
    <td width=100> 이름 </td>
    <td align=left> <input type=text size=20 name=bk_name required itemname='이름' maxlength=50 value='<?=$write[bk_name]?>' tabindex=2> </td>
</tr>
<tr height=30>
    <td> 핸드폰번호 </td>
    <td align=left> <input type=text size=20 name=bk_hp required telnumber itemname='핸드폰번호' value='<?=$write[bk_hp]?>' tabindex=3> </td>
</tr>
<tr height=30>
    <td> 수신여부 </td>
    <td align=left> 
        <input type=radio name=bk_receipt value=1 <?=$write[bk_receipt]?'checked':''?> tabindex=4> 수신허용
        <input type=radio name=bk_receipt value=0 <?=!$write[bk_receipt]?'checked':''?> tabindex=5> 수신거부
    </td>
</tr>
<?if ($w == 'u') {?>
<tr height=30>
    <td> 등급 </td>
    <td align=left> <?=$write[mb_id] ? "회원 ID : <a href='$g4[admin_path]/member_form.php?&w=u&mb_id=$write[mb_id]'>$write[mb_id]</a> <font color='#999999'>(수정시 회원정보에도  반영됩니다.)</font>" : '비회원'?> </td>
</tr>
<tr height=30>
    <td> 업데이트 </td>
    <td align=left> <?=$write[bk_datetime]?> </td>
</tr>
<?}?>
<tr height=180>
    <td> 메모 </td>
    <td align=left> 
        <textarea name=bk_memo cols=100 rows=10><?=$write[bk_memo]?></textarea>
    </td>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</tbody>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' tabindex=6 value='  확  인  '>&nbsp;
    <input type=button class=btn1 accesskey='l' tabindex=7 value='  목  록  ' onclick="document.location.href='./num_book.php?<?=$QUERY_STRING?>';">
</p>
</form>

<script language=javascript>
document.book_form.bg_no.focus();
</script>
<?
include_once("$g4[admin_path]/admin.tail.php");
?>
