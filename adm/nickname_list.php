<?
$sub_menu = "200190";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$sql_common = " from $g4[mb_nick_table] ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
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
    $sst  = "nick_no";
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

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
$listall = "<a href='$_SERVER[PHP_SELF]'>처음</a>";

$g4[title] = "닉네임변경이력";
include_once ("./admin.head.php");

$colspan = 8;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script language="JavaScript">
var list_update_php = "";
var list_delete_php = "nickname_list_delete.php";
</script>

<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left>
        <?=$listall?> (건수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>회원아이디</option>
            <option value='mb_nick'>닉네임</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<table width=100% cellpadding=0 cellspacing=1>
<form name=fpointlist method=post>
<input type=hidden name=sst  value='<?=$sst?>'>
<input type=hidden name=sod  value='<?=$sod?>'>
<input type=hidden name=sfl  value='<?=$sfl?>'>
<input type=hidden name=stx  value='<?=$stx?>'>
<input type=hidden name=page value='<?=$page?>'>
<input type=hidden name=token value="<?=$token?>">
<colgroup width=30>
<colgroup width=30>
<colgroup width=100>
<colgroup width=80>
<colgroup width=140>
<colgroup width=140>

<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td>번호</td>
    <td><?=subject_sort_link('mb_id')?>회원아이디</a></td>
    <td>별명</td>
    <td><?=subject_sort_link('start_datetime')?>사용시작일</a></td>
    <td><?=subject_sort_link('end_datetime')?>사용종료일</a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    if ($row2[mb_id] != $row[mb_id])
    {
        $sql2 = " select *  from $g4[mb_nick_table] where mb_id = '$row[mb_id]' ";
        $row2 = sql_fetch($sql2);
    }

    $mb_nick = get_sideview($row[mb_id], $row2[mb_nick], $row2[mb_email], $row2[mb_homepage]);

    $link1 = $link2 = "";
    if (!preg_match("/^\@/", $row[po_rel_table]) && $row[po_rel_table])
    {
        $link1 = "<a href='$g4[bbs_path]/board.php?bo_table={$row[po_rel_table]}&wr_id={$row[po_rel_id]}' target=_blank>";
        $link2 = "</a>";
    }

    $list = $i%2;
    echo "
    <input type=hidden name=nick_no[$i] value='$row[nick_no]'>
    <input type=hidden name=mb_id[$i] value='$row[mb_id]'>
    <tr class='list$list col1 ht center'>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td>$row[nick_no]</td>
        <td><a href='?sfl=mb_id&stx=$row[mb_id]'>$row[mb_id]</a></td>
        <td>$row[mb_nick]</td>
        <td>$row[start_datetime]</td>
        <td>$row[end_datetime]</td>
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

<?$colspan=4?>
<p>

<?
include_once ("./admin.tail.php");
?>
