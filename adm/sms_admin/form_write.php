<?
$sub_menu = "900600";
include_once("./_common.php");

$colspan = 4;

auth_check($auth[$sub_menu], "w");

$g4[title] = "이모티콘 ";

if ($w == 'u' && is_numeric($fo_no)) {
    $write = sql_fetch("select * from $g4[sms4_form_table] where fo_no='$fo_no'");
    $g4[title] .= '수정';
}
else  {
    $write[fg_no] = $fg_no;
    $g4[title] .= '추가';
}

include_once("$g4[admin_path]/admin.head.php");
?>

<?=subtitle($g4[title])?>

<form name=book_form method=post action=form_update.php target=hiddenframe style="padding:0; margin:0;">
<input type=hidden name=w value='<?=$w?>'>
<input type=hidden name=page value='<?=$page?>'>
<input type=hidden name=fo_no value='<?=$write[fo_no]?>'>
<input type=hidden name=get_fg_no value='<?=$fg_no?>'>
<table cellpadding=0 cellspacing=0 width=100% border=0>
<tbody align=center>
<tr><td colspan=<?=$colspan?> height=2 bgcolor=#0E87F9></td></tr>
<tr height=190>
    <td width=100> 메세지 </td>
    <td width=160 align=left>

        <!-- 액정화면 -->
        <div style="width:150px; background-color:#F8F8F8; border:1px solid #ccc; text-align:center;">
        <div style="background-image:url('img/smsbg.gif'); width:120px; height:120px; margin-top:20px;">
            <div style="margin-top:20px; overflow:hidden; width:100px; height:88px; font-size: 9pt; background-color:#88C8F8; text-align:left; word-break:break-all;">
            <textarea name='fo_content' id='sms_contents' class=ed style="font-family:굴림체; color:#000; line-height:15px; overflow:hidden; width:100px; height:88px; font-size:9pt; border:0; background-color:#88C8F8;" cols="16" onkeyup="byte_check('sms_contents', 'sms_bytes');" accesskey="m" itemname='이모티콘'><?=$write[fo_content]?></textarea>
            </div>
        </div>
        <div style="text-align:center; margin:5px 0 10px 0;">
            <span id=sms_bytes>0</span> / 80 byte
        </div>
        </div>
        <!-- 액정화면 -->
    </td>
    <td align=left>
        <table width="82" border="0" cellspacing="0" cellpadding="0" style="margin-left:3px;">
        <tr> 
            <td width="18"><a href="Javascript:add('■')"><img src="sms_img/c.gif" width="19" height="19" border=0></a></td>
            <td width="18"><a href="Javascript:add('□')"><img src="sms_img/c1.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▣')"><img src="sms_img/c2.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('◈')"><img src="sms_img/c3.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('◆')"><img src="sms_img/c4.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('◇')"><img src="sms_img/c5.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♥')"><img src="sms_img/c6.gif" width="18" height="19" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♡')"><img src="sms_img/c7.gif" width="19" height="19" border="0"></a></td>
        </tr>
        <tr> 
            <td width="18"><a href="Javascript:add('●')"><img src="sms_img/c8.gif" width="19" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('○')"><img src="sms_img/c9.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▲')"><img src="sms_img/c10.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▼')"><img src="sms_img/c11.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▶')"><img src="sms_img/c12.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▷')"><img src="sms_img/c13.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('◀')"><img src="sms_img/c14.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('◁')"><img src="sms_img/c15.gif" width="19" height="17" border="0"></a></td>
        </tr>
        <tr> 
            <td width="18"><a href="Javascript:add('☎')"><img src="sms_img/c16.gif" width="19" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('☏')"><img src="sms_img/c17.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♠')"><img src="sms_img/c18.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♤')"><img src="sms_img/c19.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♣')"><img src="sms_img/c20.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♧')"><img src="sms_img/c21.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('★')"><img src="sms_img/c22.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('☆')"><img src="sms_img/c23.gif" width="19" height="17" border="0"></a></td>
        </tr>
        <tr> 
            <td width="18"><a href="Javascript:add('☞')"><img src="sms_img/c24.gif" width="19" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('☜')"><img src="sms_img/c25.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('▒')"><img src="sms_img/c26.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('⊙')"><img src="sms_img/c27.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('㈜')"><img src="sms_img/c28.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('№')"><img src="sms_img/c29.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('㉿')"><img src="sms_img/c30.gif" width="18" height="17" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♨')"><img src="sms_img/c31.gif" width="19" height="17" border="0"></a></td>
        </tr>
        <tr> 
            <td width="18"><a href="Javascript:add('™')"><img src="sms_img/c32.gif" width="19" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('℡')"><img src="sms_img/c33.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('∑')"><img src="sms_img/c34.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('∏')"><img src="sms_img/c35.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♬')"><img src="sms_img/c36.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♪')"><img src="sms_img/c37.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♩')"><img src="sms_img/c38.gif" width="18" height="18" border="0"></a></td>
            <td width="18"><a href="Javascript:add('♭')"><img src="sms_img/c39.gif" width="19" height="18" border="0"></a></td>
        </tr>
        <tr>
            <td colspan=8 height=5></td>
        </tr>
        <tr> 
            <td width="36" colspan=2><a href="Javascript:add('*^^*')"><img src="sms_img/i1.gif" width="36" height="18" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('♡.♡')"><img src="sms_img/i2.gif" width="36" height="18" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('@_@')"><img src="sms_img/i3.gif" width="36" height="18" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('☞_☜')"><img src="sms_img/i4.gif" width="36" height="18" border="0"></a></td>
        </tr>
        <tr>
            <td width="36" colspan=2><a href="Javascript:add('ㅠ ㅠ')"><img src="sms_img/i5.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('Θ.Θ')"><img src="sms_img/i6.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('^_~♥')"><img src="sms_img/i8.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('~o~')"><img src="sms_img/i7.gif" width="36" height="17" border="0"></a></td>
        </tr>
        <tr>
            <td width="36" colspan=2><a href="Javascript:add('★.★')"><img src="sms_img/i9.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('(!.!)')"><img src="sms_img/i10.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('⊙.⊙')"><img src="sms_img/i12.gif" width="36" height="17" border="0"></a></td>
            <td width="36" colspan=2><a href="Javascript:add('q.p')"><img src="sms_img/i11.gif" width="36" height="17" border="0"></a></td>
        </tr>
        <tr>
            <td width="73" colspan=4><a href="Javascript:add('┏( \'\')┛')"><img src="sms_img/i13.gif" width="73" height="17" border="0"></a></td>
            <td width="73" colspan=4><a href="Javascript:add('@)-)--')"><img src="sms_img/i14.gif" width="73" height="17" border="0"></a></td>
        </tr>
        <tr>
            <td width="73" colspan=4><a href="Javascript:add('↖(^-^)↗')"><img src="sms_img/i15.gif" width="73" height="18" border="0"></a></td>
            <td width="73" colspan=4><a href="Javascript:add('(*^-^*)')"><img src="sms_img/i16.gif" width="73" height="18" border="0"></a></td>
        </tr>
        </table>
    </td>
</tr>
<tr height=30>
    <td> 그룹 </td>
    <td align=left colspan=3> 
        <select name=fg_no required itemname='그룹' tabindex=1>
        <option value='0'>미분류</option>
        <?
        $qry = sql_query("select * from $g4[sms4_form_group_table] order by fg_name");
        while($res = sql_fetch_array($qry)) {
        ?>
        <option value='<?=$res[fg_no]?>' <?=$res[fg_no]==$write[fg_no]?'selected':''?>> <?=$res[fg_name]?> </option>
        <?}?>
        </select>
    </td>
</tr>
<tr height=30>
    <td> 제목 </td>
    <td align=left colspan=3> <input type=text size=30 maxlength=50 name=fo_name required itemname='제목' value='<?=$write[fo_name]?>' tabindex=2> </td>
</tr> 
<?if ($w == 'u') {?>
<tr height=30>
    <td> 업데이트 </td>
    <td align=left colspan=3> <?=$write[fo_datetime]?> </td>
</tr>
<?}?>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</tbody>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' tabindex=6 value='  확  인  '>&nbsp;
    <input type=button class=btn1 accesskey='l' tabindex=7 value='  목  록  ' onclick="document.location.href='./form_list.php?<?=$QUERY_STRING?>';">
</p>
</form>

<script language="JavaScript">
function add(str) {
    var conts = document.getElementById('sms_contents');
    var bytes = document.getElementById('sms_bytes');
	conts.focus();
	conts.value+=str; 
    byte_check('sms_contents', 'sms_bytes');
	return;
}
function byte_check(sms_contents, sms_bytes)
{
    var conts = document.getElementById(sms_contents);
    var bytes = document.getElementById(sms_bytes);

    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';

    for (i=0; i<conts.value.length; i++) 
    {
        ch = conts.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    bytes.innerHTML = cnt;

    if (cnt > 80) 
    {
        exceed = cnt - 80;
        alert('메시지 내용은 80바이트를 넘을수 없습니다.\n\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\n\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = conts.value;
        for (i=0; i<tmp.length; i++) 
        {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > 80) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        conts.value = tmp;
        bytes.innerHTML = xcnt;
        return;
    }
}

byte_check('sms_contents', 'sms_bytes');
document.getElementById('sms_contents').focus();
</script>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
