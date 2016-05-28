<?
$sub_menu = "200500";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>";

$g4[title] = "회원등업관리";
include_once("./admin.head.php");

$sql = " select * from $g4[member_level_table] where member_level >= 2 order by member_level asc";
$result = sql_query($sql);

$colspan = 11;
if ($g4['singo_table'])
    $colspan = $colspan + 1;
?>

<script language="JavaScript">
var list_update_php = "member_level_update.php";
</script>

<table width=100%>
<tr>
    <td align=left><?=$listall?>&nbsp;&nbsp;회원 레벨업 조건을 설정합니다.</td>
    <td><a href="./member_level_execute.php">레벌업실행</a></td>
</tr>
</table>

<form name=fmember_list method=post>
<input type=hidden name=token value='<?=$token?>'>
<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=30>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width=60>
<colgroup width="">
	<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
	<tr class='bgcol1 bold col1 ht center'>
    <td rowspan=2><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td rowspan=2>회원레벨</td>
    <td>레벨업</td>
		<td>최소일수</td>
		<td>포 인 트</td>
		<td>게시글수</td>
		<td>전체글수</td>
		<td>검증일수</td>
		<td>추 천 수</td>
		<td></td>
    <? if ($g4['singo_table']) { ?>
		<td></td>
		<? } ?>
		<td rowspan=2><a href='./member_level_history.php'>HISTORY</a></td>
	</tr>
	<tr class='bgcol1 bold col1 ht center'>
    <td>레벨다운</td>
    <td></td>
		<td>포 인 트</td>
		<td>게시글수</td>
		<td>전체글수</td>
		<td>검증일수</td>
		<td></td>
		<td>비추천수</td>
    <? if ($g4['singo_table']) { ?>
		<td>신고건수</td>
		<? } ?>
	</tr>
	<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $list = $i%2;
?>    
    <input type=hidden name="member_level[<?=$i?>]" value='<?=$row[member_level]?>'>
    <tr class='list<?=$list?> col1 ht center'>
        <td rowspan=2><input type="checkbox" name="chk[]" value='<?=$i?>'></td>
        <td>&nbsp;<?=$row[member_level]?>→<?=$row[member_level]+1?></td>
        <td><input type="checkbox" name="use_levelup[<?=$i?>]" value='1' <?=$row[use_levelup]?'checked':'';?>></td>
        <td><input type=text class=ed name="up_days[<?=$i?>]" size=8 itemname='레벨업 최소일수' value='<?=$row[up_days]?>'></td>
        <td><input type=text class=ed name="up_point[<?=$i?>]" size=8 itemname='레벨업 포인트' value='<?=$row[up_point]?>'></td>
        <td><input type=text class=ed name="up_post[<?=$i?>]" size=8 itemname='레벨업 게시글수' value='<?=$row[up_post]?>'></td>
        <td><input type=text class=ed name="up_post_all[<?=$i?>]" size=8 itemname='레벨업 전체글수' value='<?=$row[up_post_all]?>'></td>
        <td><input type=text class=ed name="up_audit_days[<?=$i?>]" size=8 itemname='레벨업 검증기간(추천)' value='<?=$row[up_audit_days]?>'></td>
        <td><input type=text class=ed name="good[<?=$i?>]" size=8 itemname='레벨업 추천수' value='<?=$row[good]?>'></td>
        <td></td>
        <? if ($g4['singo_table']) { ?>
        <td></td>
        <? } ?>
        <td><a href='./member_level_history.php?sst=id&sod=desc&sfl=from_level&stx=<?=$row[member_level]?>'>레벨업</a></td>
    </tr>
    <tr class='list<?=$list?> col1 ht center'>
        <td>&nbsp;<?=$row[member_level]?>→<?=$row[member_level]-1?></td>
        <td><input type="checkbox" name="use_leveldown[<?=$i?>]" value='1' <?=$row[use_leveldown]?'checked':'';?>></td>
        <td></td>
        <td><input type=text class=ed name="down_point[<?=$i?>]" size=8 itemname='레벨다운 포인트' value='<?=$row[down_point]?>'></td>
        <td><input type=text class=ed name="down_post[<?=$i?>]" size=8 itemname='레벨다운 게시글수' value='<?=$row[down_post]?>'></td>
        <td><input type=text class=ed name="down_post_all[<?=$i?>]" size=8 itemname='레벨다운 전체글수' value='<?=$row[down_post_all]?>'></td>
        <td><input type=text class=ed name="down_audit_days[<?=$i?>]" size=8 itemname='레벨업 검증기간(비추천.신고)' value='<?=$row[down_audit_days]?>'></td>
        <td></td>
        <td><input type=text class=ed name="nogood[<?=$i?>]" size=8 itemname='레벨다운 비추천수' value='<?=$row[nogood]?>'></td>
        <? if ($g4['singo_table']) { ?>
        <td><input type=text class=ed name="singo[<?=$i?>]" size=8 itemname='레벨다운 신고건수' value='<?=$row[singo]?>'></td>
        <? } ?>
        <td><a href='./member_level_history.php?sst=id&sod=desc&sfl=to_level&stx=<?=($row[member_level]-1)?>'>레벨다운</a></td>
    </tr>
  	<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
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

<table width=100% cellpadding=0 cellspacing=0>
	<tr class='bgcol1 col1 ht left'>
		<td width=60px>레벨업</td>
		<td>
		최소일수 : 회원가입후 바로 레벨업을 시도하는 사람을 차단하기 위해, 최소 얼마의 시간이 경과후 레벨업 가능하게 함<br>
		검증일수 : 게시글, 전체글의 숫자를 검증할 때 사용하는 기간 (전체 기간으로 게시글, 전체글수를 체크 하는것 좀...<br>
    추천제안 : 최소일수 1일 (가입후 바로 레벨업 시도하는 것은 스패머...) + 포인트 5500(조금 활동)
		</td>
	</tr>
	<tr class='bgcol1 col1 ht left'>
		<td width=60px>레벨다운</td>
		<td>
    레벨다운을 시스템으로 하는 것은 분쟁의 소지가 조금은 있으므로 추천하지 않습니다.<br>
    추천제안 : 신고건수 5건이상 (이것은 스패머 등을 제한하기 위한 것인데, 안쓰는게 좋습니다)
		</td>
	</tr>
</table>

</form>

<?
include_once ("./admin.tail.php");
?>
