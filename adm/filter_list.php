<?
$sub_menu = "200710";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$sql_common = " from $g4[filter_table] ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "pp_level" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        case "pp_word" :
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "pp_id";
    $sod = "desc";
}

$sql_order = " order by $sst $sod ";

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

$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>";

$g4[title] = "필터관리";
include_once("./admin.head.php");

$sql = " select * 
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
$colspan = 15;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script type="text/javascript">
var list_delete_php = "filter_delete.php";
var list_update_php = "filter_update.php";
</script>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (필터갯수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='pp_word'>필터</option>
            <option value='pp_level'>필터레벨</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<? echo $stx ?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</table>
</form>

<form name=fsingolist method=post style="margin:0px;">
<input type=hidden name=sst  value='<?=$sst?>'>
<input type=hidden name=sod  value='<?=$sod?>'>
<input type=hidden name=sfl  value='<?=$sfl?>'>
<input type=hidden name=stx  value='<?=$stx?>'>
<input type=hidden name=page value='<?=$page?>'>

<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 center'>
    <td width=30><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td width=110 align='left'><?=subject_sort_link('pp_id')?>pp_id</a></td>
    <td align='left'><?=subject_sort_link('pp_word')?>필터</td>
    <td width=100><?=subject_sort_link('pp_level')?>필터 레벨</a></td>
	  <td width=100>필터된 갯수</td>
    <td width=110>필터일시</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {

    // 필터된 갯수 구하기
    $sql2 = " select count(*) as cnt from $g4[popular_table] where pp_word = '$row[pp_word]' ";
    $result2 = sql_fetch($sql2);

    echo "
    <input type=hidden name=log_id[$i] value='$row[pp_id]'>
    <tr class='list$list col1 center' height=25>
        <td><input type=checkbox name=chk[] value='$row[pp_id]'></td>
        <td>$row[pp_id]</td>
        <td align='left'><a href='./popular_list.php?sfl=a.pp_word&stx=" . urlencode($row[pp_word]) . "'>$row[pp_word]</a></td>
        <td>" . get_member_level_select("pp_level[$i]", 1, 10, $row[pp_level]) . "</td>
        <td>$result2[cnt]</td>
        <td>" . get_datetime($row[pp_datetime]) . "</td>
    </tr>
    ";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>내역이 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";

if ($is_admin == "super") {
    echo "<input type=button class='btn1' value='선택수정' onclick=\"btn_check(this.form, 'update')\">&nbsp;";

    echo "<input type=hidden name=act  value='delete'>";
    echo "<input type=button class='btn1' value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";
}

echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";

echo "</form>";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>

<?$colspan=4?>
<p>
<form name=fpointlist2 method=post onsubmit="return f_filter_submit(this);" autocomplete="off">
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=act   value='insert'>
<table width=100% cellpadding=0 cellspacing=1 class=tablebg>
<colgroup width=150>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td>필터</td>
    <td>필터레벨</td>
    <td></td>
    <td></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<tr class='ht center'>
    <td><input type=text class=ed name=pp_word required itemname='필터' value=''></td>
    <td><?=get_member_level_select('pp_level', 1, 10, 5) ?></td>
    <td><input type=submit class=btn1 value='  확  인  '></td>
    <td></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</form>
</table>

<script type="text/javascript">
function f_filter_submit(f)
{
    f.action = "./filter_delete.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php");
?>
