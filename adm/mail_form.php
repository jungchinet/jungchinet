<?
$sub_menu = "200300";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$html_title = "회원메일";

if ($w == "u") {
    $html_title .= "수정";
    $readonly = " readonly";

    $sql = " select * from $g4[mail_table] where ma_id = '$ma_id' ";
    $ma = sql_fetch($sql);
    if (!$ma[ma_id]) 
        alert("등록된 자료가 없습니다.");
} else {
    $html_title .= "입력";
}

$g4[title] = $html_title;
include_once("./admin.head.php");

include_once("$g4[path]/lib/cheditor4.lib.php");
echo "<script type='text/javascript' src='$g4[cheditor4_path]/cheditor.js'></script>";
echo cheditor1('ma_content', '100%', '350px');
echo "<script type='text/javascript'>ed_ma_content.config.includeHostname = true;</script>";
?>

<form name=fmailform method=post action="./mail_update.php" onsubmit="return fmailform_check(this);">
<input type=hidden name=w     value='<?=$w?>'>
<input type=hidden name=ma_id value='<?=$ma[ma_id]?>'>
<input type=hidden name=token value='<?=$token?>'>
<table cellpadding=0 cellspacing=0 width=100%>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=80% class='col2 pad2'>
<tr>
    <td colspan=2 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$html_title?></td>
</tr>
<tr><td colspan=2 class='line1'></td></tr>
<tr class='ht'>
    <td>메일 제목</td>
    <td><input type=text class='ed w99' name=ma_subject value='<?=$ma[ma_subject]?>' required itemname='메일 제목'></td>
</tr>
<tr>
    <td>메일 내용</td>
    <td class=lh>
        <?=cheditor2('ma_content', $ma[ma_content]);?>
        <br>{이름} , {별명} , {회원아이디} , {이메일} , {생일}
        <br>위와 같이 HTML 코드에 삽입하면 해당 내용에 맞게 변환하여 메일 발송합니다. 
    </td>
</tr>
<tr><td colspan=2 class='line1'></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>
</form>



<script language="javascript">
function fmailform_check(f) 
{
    errmsg = "";
    errfld = "";

    check_field(f.ma_subject, "제목을 입력하세요.");

    <? echo cheditor3('ma_content'); ?>
    <? echo cheditor4('ma_content'); ?>

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}

document.fmailform.ma_subject.focus();
</script>

<?
include_once("./admin.tail.php");
?>
