<?
$sub_menu = "900500";
include_once("./_common.php");

$colspan = 4;

auth_check($auth[$sub_menu], "r");

$g4[title] = "이모티콘 그룹";

$res = sql_fetch("select count(*) as cnt from $g4[sms4_form_group_table]");
$total_count = $res[cnt];

$group = array();
$qry = sql_query("select * from $g4[sms4_form_group_table] order by fg_name");
while ($res = sql_fetch_array($qry)) array_push($group, $res);

include_once("$g4[admin_path]/admin.head.php");
?>

<script language=javascript>

function del(fg_no) {
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n삭제되는 그룹에 속한 자료는 '미분류'로 이동됩니다.\n\n그래도 삭제하시겠습니까?"))
        hiddenframe.location.href = 'form_group_update.php?w=d&fg_no=' + fg_no;
}

function up(fg_no) {
    hiddenframe.location.href = 'form_group_update.php?w=up&fg_no=' + fg_no;
}

function down(fg_no) {
    hiddenframe.location.href = 'form_group_update.php?w=down&fg_no=' + fg_no;
}

function move(fg_no, fg_name, sel) {
    var msg = '';
    if (sel.value) 
    {
        msg  = "'" + fg_name + "' 그룹에 속한 모든 데이터를\n\n'";
        msg += sel.options[sel.selectedIndex].text + "' 그룹으로 이동하시겠습니까?";

        if (confirm(msg))
            hiddenframe.location.href = 'form_group_move.php?fg_no=' + fg_no + '&move_no=' + sel.value; 
        else
            sel.selectedIndex = 0;
    }
}

function empty(fg_no) {
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n그룹에 속한 데이터를 정말로 비우시겠습니까?"))
        hiddenframe.location.href = 'form_group_update.php?w=empty&fg_no=' + fg_no;
}

</script>

<?=subtitle($g4[title])?>

<table width=100% cellpadding=0 cellspacing=0>
<tr>
    <td width=50% height=30>
        <form name="group<?=$res[fg_no]?>" method="post" action="form_group_update.php" style="padding:0; margin:0;" target=hiddenframe>
        <input type=hidden name=fg_no value='<?=$res[fg_no]?>'>
        그룹 추가 :
        <input type=text id=fg_name name=fg_name size=15 required itemname='그룹이름'>
        <input type=image src="<?=$g4[admin_path]?>/img/icon_insert.gif" align=absmiddle>
        <span style="color:#999;">그룹이름순으로 정렬됩니다.</span>
        </form>
    </td>
    <td width=50% align=right>건수 : <? echo $total_count ?></td>
</tr>
</table>


<table cellpadding=0 cellspacing=0 width=100% border=0>
<tr><td colspan=<?=$colspan?> height=2 bgcolor=#0E87F9></td></tr>
<tr align=center class=ht>
    <td style="font-weight:bold;"> 그룹이름 </td>
    <td width=80 style="font-weight:bold;"> 이모티콘수 </td>
    <td width=200 style="font-weight:bold;"> 이동 </td>
    <td width=100 style="font-weight:bold;"> 비우기 </td>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
<?
$qry = sql_query("select count(*) as cnt from $g4[sms4_form_table] where fg_no=0");
$res = sql_fetch_array($qry);
?>
<tr>
    <td height=30 style="padding-left:20px;"> 
        <img src="<?=$g4[sms_admin_path]?>/img/icon_close.gif" alt='그룹' align=absmiddle>
        미분류
    </td>
    <td align=center>
        <?=number_format($res[cnt])?>
    </td>
    <td align=center>
        <select name="fg_no" onchange="move(0, '미분류', this);" style="width:150px">
        <option value=''></option>
        <? for ($i=0; $i<count($group); $i++) { ?>
        <option value="<?=$group[$i][fg_no]?>"> <?=$group[$i][fg_name]?> </option>
        <? } ?>
        </select>
    </td>
    <td align=center>
        <input type=button value='비우기' class=btn1 onclick=empty('no')>
    </td>
</tr>
<?
for ($i=0; $i<count($group); $i++) {
    if ($i%2) $bgcolor = '#ffffff'; else $bgcolor = '#F8F8F8';
?>
<tr bgcolor='<?=$bgcolor?>'>
    <td height=30 style="padding-left:20px;"> 
        <form name="group<?=$group[$i][fg_no]?>" method="post" action="form_group_update.php" style="padding:0; margin:0;" target=hiddenframe>
        <input type=hidden name=w value='u'>
        <input type=hidden name=fg_no value='<?=$group[$i][fg_no]?>'>
        <img src="<?=$g4[sms_admin_path]?>/img/icon_close.gif" alt='그룹'>
        <input type=text size=30 name=fg_name value="<?=$group[$i][fg_name]?>">
        <input type=checkbox name=fg_member value=1 <?if ($group[$i][fg_member]) echo 'checked';?>> 회원
        <a href="javascript:document.group<?=$group[$i][fg_no]?>.submit()"><img src="<?=$g4[admin_path]?>/img/icon_modify.gif" alt='수정' border=0 align=absmiddle></a>
        <a href="javascript:del(<?=$group[$i][fg_no]?>);"><img src="<?=$g4[admin_path]?>/img/icon_delete.gif" alt='삭제' border=0 align=absmiddle></a>
        <a href="./form_list.php?fg_no=<?=$group[$i][fg_no]?>"><img src="<?=$g4[admin_path]?>/img/icon_view.gif" alt='보기' border=0 align=absmiddle></a>
        <!--
        <a href="javascript:up(<?=$group[$i][fg_no]?>);"><img src="<?=$g4[sms_admin_path]?>/img/icon_up.gif" alt='위로 이동'></a>
        <a href="javascript:down(<?=$group[$i][fg_no]?>);"><img src="<?=$g4[sms_admin_path]?>/img/icon_down.gif" alt='아래로 이동'></a>
        -->
        </form>
    </td>
    <td align=center>
        <?=number_format($group[$i][fg_count])?>
    </td>
    <td align=center>
        <select name="fg_no" onchange="move(<?=$group[$i][fg_no]?>, '<?=$group[$i][fg_name]?>', this);" style="width:150px">
        <option value=''></option>
        <option value='0'>미분류</option>
        <? for ($j=0; $j<count($group); $j++) { ?>
        <? if ($group[$i][fg_no]==$group[$j][fg_no]) continue; ?>
        <option value="<?=$group[$j][fg_no]?>"> <?=$group[$j][fg_name]?> </option>
        <? } ?>
        </select>
    </td>
    <td align=center>
        <input type=button value='비우기' class=btn1 onclick=empty(<?=$group[$i][fg_no]?>)>
    </td>
</tr>
<?}?>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#CCCCCC></td></tr>
</table>
<div style="height:50px;"></div>

<script language=javascript>
document.getElementById('fg_name').focus();
</script>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
