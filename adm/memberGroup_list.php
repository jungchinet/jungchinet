<?
$sub_menu = "200400";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$g4[title] = "회원권한명관리";
include_once("./admin.head.php");

$sql = " select * from $g4[member_group_table] order by gl_id asc";
$result = sql_query($sql);

$colspan = 15;
?>

<script language="JavaScript">
var list_update_php = "memberGroup_list_update.php";
</script>

<table width=100%>
<tr>
    <td width=50% align=left>회원 레벨(권한)명을 설정합니다.</td>
</tr>
</table>

<form name=fmemberG_list method=post>
<input type=hidden name=token value='<?=$token?>'>
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=30>
<colgroup width=90>
<colgroup width=90>
<colgroup width="30">
<colgroup width="">
	<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
	<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td>회원레벨</td>
    <td>레벨명</td>
		<td></td>
		<td></td>
	</tr>
	<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $list = $i%2;
?>    
    <input type="hidden" name="gl_id[<?=$row[gl_id]?>]" value="<?=$row[gl_id]?>">
    <tr class='list<?=$list?> col1 ht center'>
        <td><input type="checkbox" name="chk[]" value='<?=$i?>'></td>
        <td title='<?=$row[gl_id]?>'><nobr style='display:block; overflow:hidden; width:90;'>&nbsp;<?=$row[gl_id]?></nobr></td>
        <td><input type='text' name='groupName_[<?=$i?>]' value='<?=$row[gl_name]?>'></nobr></td>
        <td><img src='img/icon_modify.gif' border=0 title='수정' onclick="member_group_update('<?=$row[gl_name]?>' , '<?=$row[gl_id]?>' ,'<?=$i?>');"></a></td>
				<td></td>
    </tr>
<?
}
?>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table>


<table width=100% cellpadding=3 cellspacing=1>
	<tr>
		<td width=50%><input type=button class='btn1' value='선택수정' onclick="btn_check(this.form, 'update')"></td>
		<td width=50% align=right></td>
	</tr>
</table>

</form>

<?
include_once ("./admin.tail.php");
?>
