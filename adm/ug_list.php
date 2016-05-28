<?
$sub_menu = "200600";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$sql_common = " from $g4[user_group_table] ";

$sql_search = " where (1) ";
if ($is_admin != "super")
    $sql_search .= " and (gr_admin = '$member[mb_id]') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "ug_id" :
        case "ug_admin" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default : 
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if ($sst)
    $sql_order = " order by $sst $sod ";
else
    $sql_order = " order by ug_id asc ";

$sql = " select count(*) as cnt
         $sql_common 
         $sql_search 
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * 
          $sql_common 
          $sql_search
          $sql_order 
          limit $from_record, $rows ";
$result = sql_query($sql);
$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

$g4[title] = "사용자그룹설정";
include_once("./admin.head.php");

$colspan = 10;
?>

<script language="JavaScript">
var list_update_php = "./ug_list_update.php";
</script>

<table width=100% cellpadding=3 cellspacing=1>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left><?=$listall?> (그룹수 : <?=number_format($total_count)?>개)</td>
    <td width=50% align=right>
        <select name=sfl>
            <option value="ug_subject">제목</option>
            <option value="ug_id">ID</option>
            <option value="ug_admin">그룹관리자</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<form name=fboardgrouplist method=post>
<table width=100% cellpadding=0 cellspacing=1 border=0>
<input type=hidden name=sst  value='<?=$sst?>'>
<input type=hidden name=sod  value='<?=$sod?>'>
<input type=hidden name=sfl  value='<?=$sfl?>'>
<input type=hidden name=stx  value='<?=$stx?>'>
<input type=hidden name=page value='<?=$page?>'>
<input type=hidden name=token value="<?=$token?>">
<colgroup width=30>
<colgroup width=120>
<colgroup width=''>
<colgroup width=''>
<colgroup width=80>
<colgroup width=80>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value="1" onclick="check_all(this.form)"></td>
    <td><?=subject_sort_link("ug_id")?>그룹아이디</a></td>
    <td><?=subject_sort_link("ug_subject")?>제목</a></td>
    <td><?=subject_sort_link("ug_admin")?>그룹관리자</a></td>
    <td>회원수</td>   
    <td><? if ($is_admin == "super") { echo "<a href='./ug_form.php'><img src='$g4[admin_path]/img/icon_insert.gif' border=0 title='생성'></a>"; } ?></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{ 
    // 그룹회원수
    $sql1 = " select count(*) as cnt from $g4[member_table] where ug_id = '$row[ug_id]' ";
    $row1 = sql_fetch($sql1);

    $s_upd = "<a href='./ug_form.php?$qstr&w=u&gr_id=$row[ug_id]'><img src='img/icon_modify.gif' border=0 title='수정'></a>";
    $s_del = "";
    if ($is_admin == "super")
		if(!eregi('reg_', $row[ug_id])){
        	$s_del = "<a href=\"javascript:post_delete('ug_delete.php', '$row[ug_id]');\"><img src='img/icon_delete.gif' border=0 title='삭제'></a>";
		}
        //$s_del = "<a href=\"javascript:del('./ug_delete.php?$qstr&gr_id=$row[ug_id]');\"><img src='img/icon_delete.gif' border=0 title='삭제'></a>";
        
    $list = $i%2;
    echo "<input type=hidden name=gr_id[$i] value='$row[ug_id]'>";
    echo "<tr class='list$list' onmouseover=\"this.className='mouseover';\" onmouseout=\"this.className='list$list';\" height=27 align=center>";
    echo "<td><input type=checkbox name=chk[] value='$i'></td>";
    echo "<td><a href='$g4[admin_path]/member_list.php?sfl=ug_id&stx=$row[ug_id]'><b>$row[ug_id]</b></a></td>";
    echo "<td><input type=text class=ed name=gr_subject[$i] value='".get_text($row[ug_subject])."' size=30></td>";

    if ($is_admin == "super")
        //echo "<td>".get_member_id_select("gr_admin[$i]", 9, $row[gr_admin])."</td>";
        echo "<td><input type=text class=ed name=gr_admin[$i] value='$row[ug_admin]' maxlength=20></td>";
    else
        echo "<input type=hidden name='gr_admin[$i]' value='$row[ug_admin]'><td>$row[gr_admin]</td>";

    echo "<td><a href='$g4[admin_path]/member_list.php?sfl=ug_id&stx=$row[ug_id]'>$row1[cnt]</a></td>";
    echo "<td>$s_upd $s_del</td>";
    echo "</tr>\n";
} 

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 bgcolor=#ffffff>자료가 없습니다.</td></tr>"; 

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=70%>";
echo "<input type=button class='btn1' value='선택수정' onclick=\"btn_check(this.form, 'update')\">";
//echo " <input type=button value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";
echo "</td>";
echo "<td width=30% align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script>document.fsearch.sfl.value = '$sfl';</script>";
?>
</form>

<script>
// POST 방식으로 삭제
function post_delete(action_url, val)
{
	var f = document.fpost;

	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
    f.gr_id.value = val;
		f.action         = action_url;
		f.submit();
	}
}
</script>

<form name='fpost' method='post'>
<input type='hidden' name='sst'   value='<?=$sst?>'>
<input type='hidden' name='sod'   value='<?=$sod?>'>
<input type='hidden' name='sfl'   value='<?=$sfl?>'>
<input type='hidden' name='stx'   value='<?=$stx?>'>
<input type='hidden' name='page'  value='<?=$page?>'>
<input type='hidden' name='token' value='<?=$token?>'>
<input type='hidden' name='gr_id'>
</form>

<?
include_once("./admin.tail.php");
?>
