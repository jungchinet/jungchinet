<?
$sub_menu = "300150";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$sql_common = " from $g4[cache_table] ";

$sql_search = " where 1 ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "c_name" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "c_id";
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

$g4[title] = "DB Cache";
include_once("./admin.head.php");

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$colspan = 5;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script language="JavaScript">
var list_delete_php = "dbcache_list_delete.php";
</script>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (DB Cache 갯수 : <?=number_format($total_count)?>) 
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='c_name'>Cache 이름</option>
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
<tr class='bgcol1 bold col1 ht center'>
    <td width=30><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td width=40 align='center'><?=subject_sort_link('c_id')?>No</a></td>
    <td width=120 align='left'><?=subject_sort_link('c_text')?>Cache Name</a></td>
    <td align='left'>Cache Text</td>
	  <td width=80><?=subject_sort_link('c_datetime')?>날짜</a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {

    $c_text = cut_str(get_text($row[c_text]), 110);

    echo "
    <input type=hidden name=c_id[$i] value='$row[c_id]'>
    <tr class='list$list col1 ' height=25>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td align='center'>$row[c_id]</td>
        <td>" . $row[c_name] . "</td>
        <td>$c_text</td>
        <td align='center'>" . get_datetime($row[c_datetime]) . "</a></td>
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
echo "<input type=button class='btn1' value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";
echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";
echo "</form>";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>

<?
include_once ("./admin.tail.php");
?>
