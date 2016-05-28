<?
$sub_menu = "900300";
include_once("./_common.php");

$colspan = 3;

auth_check($auth[$sub_menu], "r");

$lev = array();

for ($i=1; $i<=10; $i++)
{
    $lev[$i] = 0;
}

$qry = sql_query("select mb_level, count(*) as cnt from $g4[member_table] where mb_sms=1 and not (mb_hp='') group by mb_level");

while ($row = sql_fetch_array($qry))
{
    $lev[$row[mb_level]] = $row[cnt];
}

include_once("$g4[path]/head.sub.php");
?>

<link rel=StyleSheet href='<?=$g4[admin_path]?>/admin.style.css' type=text/css />

<script language=javascript>

function level_add(lev, cnt)
{
    if (cnt == '0') {
        alert(lev + ' 레벨은 아무도 없습니다.');
        return;
    }

    var hp_list = parent.document.getElementById('hp_list');
    var item    = "회원 권한 " + lev + " 레벨 (" + cnt + " 명)";
    var value   = 'l,' + lev;

    for (i=0; i<hp_list.length; i++) {
        if (hp_list[i].value == value) {
            alert('이미 같은 목록이 있습니다.');
            return;
        }
    }

    hp_list.options[hp_list.length] = new Option(item, value);
}
</script>

<table cellpadding=0 cellspacing=0 width=100% border=0>
<colgroup height=30>
<colgroup width=100>
<colgroup width=60>
<?
for ($i=1; $i<=10; $i++) {
    if ($i%2) $bgcolor = '#ffffff'; else $bgcolor = '#F8F8F8';
?>
<tr bgcolor='<?=$bgcolor?>'>
    <td height=30 style="padding-left:20px;"> 
        <img src="<?=$g4[sms_admin_path]?>/img/icon_close.gif" alt='그룹' align=absmiddle>
        <?=$i?> 레벨
    </td>
    <td align=center>
        <?=number_format($lev[$i])?>
    </td>
    <td align=center>
        <input type=button value='추가' onfocus="this.blur()" class=btn1 onclick="level_add(<?=$i?>, '<?=number_format($lev[$i])?>')">
    </td>
</tr>
<?}?>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</table>

<?
include_once("$g4[path]/tail.sub.php");
?>
