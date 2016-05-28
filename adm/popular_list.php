<?
// 인기검색어 관리
$sub_menu = "200700";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$g4[board_file_download_table] = $g4[board_file_table] . "_download";
$sql_common = " from $g4[popular_table] a left join $g4[board_table] b on (a.bo_table = b.bo_table) ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table":
            $sql_search .= " (a.bo_table = '$bo_table') ";
            break;
        case "mb_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default : 
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.pp_id";
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
if ($page == "") $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.bo_subject
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

if ($sfl == "mb_id" && $stx)
    $mb = get_member($stx);

$g4[title] = "인기검색어관리";
include_once ("./admin.head.php");

$colspan = 8;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script language="JavaScript">
var list_update_php = "";
var list_delete_php = "popular_list_delete.php";
</script>

<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left>
        <?=$listall?> (건수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='a.pp_word'>검색어</option>
            <option value='a.mb_id'>회원아이디</option>
            <option value='a.bo_table'>게시판</option>
            <option value='a.pp_id'>ip</option>
            <option value='a.pp_date'>검색일자</option>
        </select>
        <? if ($stx == "all_dn") $stx = ""; ?>
        <input type=text name=stx class=ed required itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<form name=fpointlist method=post>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<table width=100% cellpadding=0 cellspacing=1>
<colgroup width=30>
<colgroup width=100>
<colgroup width=120>
<colgroup width=''>
<colgroup width=120>
<colgroup width=80>
<colgroup width=80>
<colgroup width=60>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td><?=subject_sort_link('a.mb_id')?>회원닉네임</a></td>
    <td><?=subject_sort_link('a.bo_table')?>게시판</a></td>
    <td>검색어</td>
    <td>sfl</td>
    <td>ip</td>
    <td><?=subject_sort_link('a.pp_date')?>검색일시</a></td>
    <td>검색횟수</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>

<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    if ($row[mb_id]) {
        $mb = get_member($row[mb_id], "mb_nick");
    } else {
        $mb[mb_nick] = "";
    }
    // 전체검색횟수
    $tot = sql_fetch(" select count(*) as cnt from $g4[popular_table] where pp_word='$row[pp_word]' ");
    echo "
    <input type=hidden name=pp_id[$i] value='$row[pp_id]'>
    <input type=hidden name=mb_id[$i] value='$row[mb_id]'>
    <input type=hidden name=pp_word[$i] value='$row[pp_word]'>
    <input type=hidden name=pp_ip[$i] value='$row[pp_ip]'>
    <tr class='list$list col1 ht center'>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td><a href='?sfl=a.mb_id&stx=$row[mb_id]'>$mb[mb_nick]</a></td>
        <td><a href='?sfl=a.bo_table&stx=$row[bo_table]'>" . cut_str($row[bo_subject],20) . "</a></td>
        <td><a href='?sfl=a.pp_word&stx=$row[pp_word]'>" . $row[pp_word] . "</a></td>
        <td>" . $row[sfl] . "</td>
        <td align=right><a href='?sfl=a.pp_ip&stx=$row[pp_ip]'>" . $row[pp_ip] . "</a></td>
        <td align=right><a href='?sfl=a.pp_date&stx=$row[pp_date]'>" . $row[pp_date] . "</td>
        <td align=center>". number_format($tot[cnt])."</td>
    </tr> ";
} 

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 bgcolor=#ffffff>자료가 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";

if ($is_admin == "super")
    echo "<input type=button class='btn1' value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";

echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>
</form>

<script language='javascript'> document.fsearch.stx.focus(); </script>

<?
include_once ("./admin.tail.php");
?>
