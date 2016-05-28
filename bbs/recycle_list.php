<?
include_once("./_common.php");

$sql_common = " from $g4[recycle_table] ";

$sql_search = " where rc_wr_id = rc_wr_parent and mb_id = '$member[mb_id]' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_id" :
            break;
        case "bo_table" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "rc_no";
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

// 삭제 게시글 수
$sql = " select count(*) as cnt
         $sql_common
         $sql_search
            and rc_delete = '1'
         $sql_order ";
$row = sql_fetch($sql);
$delete_count = $row[cnt];

$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>";

$g4[title] = "휴지통관리";
include_once("./_head.php");

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$colspan = 15;
?>
<link rel="stylesheet" href="<?=$g4['admin_path']?>/admin.style.css" type="text/css">

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>
<script language="JavaScript">
var list_delete_php = "recycle_list_delete.php";
</script>

<script language="JavaScript">
function recycle_delete(ok)
{
    var msg;

    if (ok == 1)
        msg = "<?=$config[cf_recycle_days]?>일이 지난 휴지글을 완전히 삭제합니다.\n\n\n그래도 진행하시겠습니까?";
    else
        msg = "<?=$config[cf_recycle_days]?>일이 지난 휴지글을 삭제합니다.\n\n\n그래도 진행하시겠습니까?";

    if (confirm(msg))
    {
        document.location.href = "<?=$g4[admin_path]?>/recycle_delete.php?ok=" + ok;
    }
}
</script>

<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left><?=$listall?> 
        (휴지글수 : <?=number_format($total_count)?>, 삭제글수 : <?=number_format($delete_count)?>)
        <!--
        &nbsp;&nbsp;<a href="javascript:recycle_delete();">휴지글삭제</a>
        &nbsp;&nbsp;<a href="javascript:recycle_delete(1);">휴지글완전삭제</a>
        -->
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='bo_table'>게시판</option>
        </select>
        <input type=text name=stx class=ed required itemname='검색어' value='<? echo $stx ?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<form name=fmemberlist method=post>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=30>
<colgroup width=100>
<colgroup width=80>
<colgroup width=60>
<colgroup width=''>
<colgroup width=80>
<colgroup width=80>
<colgroup width=80>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><!--<input type=checkbox name=chkall value='1' onclick='check_all(this.form)'>--></td>
    <td><?=subject_sort_link('mb_id')?>회원아이디</a></td>
    <td><?=subject_sort_link('bo_table')?>게시판id</a></td>
    <td>게시글id</td>
    <td>게시글제목</td>
    <td>작성일</td>
    <td><?=subject_sort_link('rc_datetime', '', 'desc')?>삭제일</a></td>
  	<td>복구</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    
    $mb = get_member($row[mb_id]);
    $mb_nick = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);    

    // 게시글 제목
    $tmp_write_table = $g4['write_prefix'] . $row[rc_bo_table];
    $sql2 = " select wr_subject, wr_content, wr_datetime from $tmp_write_table where wr_id = '$row[rc_wr_id]' ";
    $write = sql_fetch($sql2);

    // 코멘트인지 여부
    $c_flag="";
    if ($row[wr_is_comment])
        $c_flag = " C";
    
    // wr_id
    if ($c_flag)
        $wr_id = $row[wr_id] . $c_flag;
    else
        $wr_id = "<a href='$g4[bbs_path]/recycle_view.php?bo_table=$row[rc_bo_table]&wr_id=$row[rc_wr_id]&org_bo_table=$row[bo_table]' target=_blank>" . $row[wr_id] . "</a>";

    // 복구 버튼을 출력
    if ($row[rc_delete] == 0)
        $s_recover = "<a href=\"javascript:post_recover('$g4[bbs_path]/recycle_recover.php', '$row[rc_no]');\"><img src='$g4[admin_path]/img/icon_recover.gif' border=0 title='복구'></a>";
    else
        $s_recover = "";

    // 운영자가 삭제한거 (mb_id와 rc_mb_id가 다른 경우)에는 뒤에 mark
    $mb_remover="";
    if ($row[mb_id] !== $row[rc_mb_id])
        $mb_remover="&nbsp;<img src='$g4[admin_path]/img/icon_admin.gif' align=absmiddle border=0 title='관리자가 지워버린 글'>";

    // 게시판아이디. 게시판 정렬
    $bo_info = get_board($row[bo_table],"bo_subject");
    $bo_table1 = "<a href='$g4[bbs_path]/recycle_list.php?sfl=bo_table&stx=$row[bo_table]' title='$bo_info[bo_subject]'>$row[bo_table]</a>";

    $list = $i%2;
    echo "
    <input type=hidden name=rc_no[$i] value='$row[rc_no]'>
    <tr class='list$list col1 ht center'>
        <td><!--<input type=checkbox name=chk[] value='$i'>--></td>
        <td title='$row[mb_id]'><nobr style='display:block; overflow:hidden; width:90;'>&nbsp;$mb_nick$mb_remover</nobr></td>
        <td><nobr style='display:block; overflow:hidden; width:90px;'>$bo_table1</nobr></td>
        <td><nobr style='display:block; overflow:hidden; width:90px;'>$wr_id</nobr></td>
        <td>" . conv_subject($write[wr_subject],80) . "</td>
        <td>" . get_datetime($write[wr_datetime]) . "</td>
        <td>" . get_datetime($row[rc_datetime]) . "</td>
        <td>$s_recover</td>
    </tr>";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>자료가 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");

echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";
/*
echo "<input type=button class='btn1' value='선택삭제' onclick=\"btn_check(this.form, 'delete')\">";
*/
echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";
echo "<br><br>";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>
</form>

* 휴지글 삭제시 삭제 mark만 하고 실제로는 삭제하지 않습니다. 실제 게시글 삭제를 원하시면 관리자에게 문의하시기 바랍니다.<br>
* 회원아이디 옆에 아이콘이 있는 글은, 사용자가 삭제한 것이 아니라 관리자가 삭제한 글 입니다.<br>
* 게시판id를 클릭하면 해당 게시판의 삭제글이 정렬되며, 게시글 id를 클릭하면 해당 게시글의 새창이 뜹니다.

<script>
// POST 방식으로 삭제
function post_recover(action_url, val)
{
	var f = document.fpost;

	if(confirm("선택한 자료를 복구 합니다.\n\n정말 복구하시겠습니까?")) {
        f.rc_no.value = val;
		f.action      = action_url;
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
<input type='hidden' name='rc_no'>
</form>

<?
include_once ("./_tail.php");
?>
