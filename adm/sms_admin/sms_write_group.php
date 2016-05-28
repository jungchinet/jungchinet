<?
$sub_menu = "900300";
include_once("./_common.php");

$colspan = 3;

auth_check($auth[$sub_menu], "r");

$no_group = sql_fetch("select * from $g4[sms4_book_group_table] where bg_no=1");

$group = array();
$qry = sql_query("select * from $g4[sms4_book_group_table] where bg_no>1 order by bg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once("$g4[path]/head.sub.php");
?>

<link rel=StyleSheet href='<?=$g4[admin_path]?>/admin.style.css' type=text/css />

<script language=javascript>
function person(bg_no) 
{
    parent.book_change('book_person');
    location.href = './sms_write_person.php?bg_no=' + bg_no;
}

function group_add(bg_no, bg_name, bg_count)
{
    if (bg_count == '0') {
        alert('그룹이 비어있습니다.');
        return;
    }

    var hp_list = parent.document.getElementById('hp_list');
    var item    = bg_name + " 그룹 (" + bg_count + " 명)";
    var value   = 'g,' + bg_no;

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
<tr>
    <td height=30 style="padding-left:20px;"> 
        <a href="javascript:person(1)">
        <img src="<?=$g4[sms_admin_path]?>/img/icon_close.gif" alt='그룹' border=0 align=absmiddle>
        <?=$no_group[bg_name]?></a>
    </td>
    <td align=center>
        <?=number_format($no_group[bg_receipt])?>
    </td>
    <td align=center>
        <input type=button value='추가' class=btn1 onclick="group_add(1, '<?=$no_group[bg_name]?>', '<?=number_format($no_group[bg_receipt])?>')">
    </td>
</tr>
<?
for ($i=0; $i<count($group); $i++) {
    if ($i%2) $bgcolor = '#ffffff'; else $bgcolor = '#F8F8F8';
?>
<tr bgcolor='<?=$bgcolor?>'>
    <td height=30 style="padding-left:20px;"> 
        <a href="javascript:person(<?=$group[$i][bg_no]?>)">
        <img src="<?=$g4[sms_admin_path]?>/img/icon_close.gif" alt='그룹' border=0 align=absmiddle>
        <?=$group[$i][bg_name]?></a>
    </td>
    <td align=center>
        <?=number_format($group[$i][bg_receipt])?>
    </td>
    <td align=center>
        <input type=button value='추가' onfocus="this.blur()" class=btn1 onclick="group_add(<?=$group[$i][bg_no]?>, '<?=$group[$i][bg_name]?>', '<?=number_format($group[$i][bg_receipt])?>')">
    </td>
</tr>
<?}?>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</table>

<?
include_once("$g4[path]/tail.sub.php");
?>
