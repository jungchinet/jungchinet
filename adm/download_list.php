<?
$sub_menu = "300500";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$g4[board_file_download_table] = $g4[board_file_table] . "_download";
$sql_common = " from $g4[board_file_download_table] a left join $g4[board_file_table] b on (a.bo_table = b.bo_table and a.wr_id = b.wr_id and a.bf_no = b.bf_no ) ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "all_dn":
            $sql_search .= " (a.bo_table = '$bo_table' and a.wr_id = '$wr_id' ) ";
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
    $sst  = "a.dn_id";
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

$sql = " select a.*, b.bf_source, b.bf_download, b.bf_content, b.bf_type, b.bf_datetime
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

if ($sfl == "mb_id" && $stx)
    $mb = get_member($stx);

$g4[title] = "다운로드내역";
include_once ("./admin.head.php");

$colspan = 8;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script language="JavaScript">
var list_update_php = "";
var list_delete_php = "download_list_delete.php";
</script>

<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left>
        <?=$listall?> (건수 : <?=number_format($total_count)?>)
        <? 
        $row = sql_fetch(" select sum(download_point) as sum_point from $g4[board_file_download_table] ");
        echo "&nbsp;(전체 포인트 합계 : " . number_format($row[sum_point]) . "점)";
        ?>
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='a.mb_id'>회원아이디</option>
            <option value='a.bo_table'>게시판</option>
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
<colgroup width=80>
<colgroup width=''>
<colgroup width=120>
<colgroup width=80>
<colgroup width=80>
<colgroup width=100>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td><?=subject_sort_link('a.mb_id')?>회원아이디</a></td>
    <td><?=subject_sort_link('a.bo_table')?>게시판</a></td>
    <td>게시글</td>
    <td>파일명</td>
    <td><?=subject_sort_link('a.download_point')?>포인트</a></td>
    <td><?=subject_sort_link('a.dn_datetime')?>다운로드일시</a></td>
    <td><?=subject_sort_link('b.bf_download')?>다운횟수</a>(<?=subject_sort_link('a.dn_count')?>누적</a>)</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $board = sql_fetch(" select bo_subject from $g4[board_table] where bo_table = '$row[bo_table]' ");
    $tmp_table = $g4['write_prefix'] . $row[bo_table];
    $wr = sql_fetch(" select wr_subject from $tmp_table where wr_id = '$row[wr_id]' ", false);
    if (!$board[bo_subject])
        $board[bo_subject] = "게시판없슴(" . $row[bo_table] .")";
    if (!$wr[wr_subject])
        $wr[wr_subject] = "게시글 없슴";
    echo "
    <input type=hidden name=dn_id[$i] value='$row[dn_id]'>
    <input type=hidden name=mb_id[$i] value='$row[mb_id]'>
    <input type=hidden name=bo_table_list[$i] value='$row[bo_table]'>
    <input type=hidden name=wr_id[$i] value='$row[wr_id]'>
    <tr class='list$list col1 ht center'>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td><a href='?sfl=a.mb_id&stx=$row[mb_id]'>$row[mb_id]</a></td>
        <td><a href='?sfl=a.bo_table&stx=$row[bo_table]'>" . cut_str($board[bo_subject],20) . "</a></td>
        <td><a href='$g4[bbs_path]/board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]' target=_new>" . cut_str($wr[wr_subject],40) . "</a></td>
        <td>" . cut_str($row[bf_source],20) . "</td>
        <td align=right>$row[download_point]&nbsp;</td>
        <td align=right>" . get_datetime($row[dn_datetime]) . "</td>
        <td align=right>$row[dn_count] (<a href='?sfl=all_dn&stx=all_dn&bo_table=$row[bo_table]&wr_id=$row[wr_id]'>".number_format($row[bf_download])."</a>)</td>
    </tr> ";
} 

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 bgcolor=#ffffff>자료가 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";
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
