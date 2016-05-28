<?
include_once("./_common.php");

// 회원만 사용이 가능하게
if (!$is_member) 
{
    $href = "./login.php?$qstr&url=".urlencode("./singo_search.php");

    echo "<script language='JavaScript'>alert('회원만 가능합니다.'); top.location.href = '$href';</script>";
    exit;
}

$sql_common = " from $g4[singo_table] ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "sg_reason" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if ($is_admin != 'super')
    $sql_search .= " and sg_mb_id = '$member[mb_id]' ";

if (!$sst) {
    $sst = "sg_id";
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

$g4[title] = "게시물신고관리";
include_once("./_head.php");

$sql = " select * 
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$colspan = 6;
?>

<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>

<link rel="stylesheet" href="<?=$g4['admin_path']?>/admin.style.css" type="text/css">
<style>
.bg_menu1 { height:22px; 
            padding-left:15px; 
            padding-right:15px; } 
.bg_line1 { height:1px; background-color:#EFCA95; } 

.bg_menu2 { height:22px; 
            padding-left:25px; } 
.bg_line2 { background-image:url('<?=$g4['admin_path']?>/img/dot.gif'); height:3px; } 
.dot {color:#D6D0C8;border-style:dotted;}

#csshelp1 { border:0px; background:#FFFFFF; padding:6px; }
#csshelp2 { border:2px solid #BDBEC6; padding:0px; }
#csshelp3 { background:#F9F9F9; padding:6px; width:200px; color:#222222; line-height:120%; text-align:left; }
</style>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (신고된 게시물 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>신고된 회원아이디</option>
            <option value='sg_reason'>신고한 이유</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<? echo $stx ?>'>
        <input type=image src='<?=$g4[bbs_path]?>/img/btn_post_search.gif' align=absmiddle></td>
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
    <td width=40  align='center'><?=subject_sort_link('sg_id')?>no.</a></td>
    <td width=110 align='center'><?=subject_sort_link('mb_id')?>신고된 회원</a></td>
    <td align='left'>게시물</td>
    <td width=70>게시물등록</td>
    <td width=70><?=subject_sort_link('sg_datetime')?>신고한 일시</a></td>
    <td align='left' width=200><?=subject_sort_link('sg_reason')?>신고한 이유</a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $mb = array();
    $sg_mb = array();

    if ($row[mb_id]) {
        //$mb = sql_fetch(" select mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date from $g4[member_table] where mb_id = '$row[mb_id]' ");
        $mb = get_member($row[mb_id], "mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date");
        $mb_nick = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);
        //$mb_nick = str_replace(" class='member'", " class='member' style='color:#555555;'", $mb_nick);
    } else 
        $mb_nick = "<span style='color:#222222;'>비회원</a>";

    if ($row[sg_mb_id]) {
        $sg_mb = sql_fetch(" select mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date from $g4[member_table] where mb_id = '$row[sg_mb_id]' ");
        $sg_mb_nick = get_sideview($sg_mb[mb_id], $sg_mb[mb_nick], $sg_mb[mb_email], $sg_mb[mb_homepage]);
        $sg_mb_nick = str_replace(" class='member'", " class='member' style='color:#C15B27;'", $sg_mb_nick);
    } else
        $sg_mb_nick = "<span style='color:#C15B27;'>비회원</a>";

    $write_table = $g4['write_prefix'].$row[bo_table];
    $sql = " select wr_subject, wr_ip, wr_is_comment, wr_parent, wr_datetime from $write_table where wr_id = '$row[wr_id]' ";
    $write_row = sql_fetch($sql);
    if ($write_row[wr_is_comment]) {
        $sql = " select wr_subject, wr_ip, wr_datetime from $write_table where wr_id = '$write_row[wr_parent]' ";
        $parent_row = sql_fetch($sql);
        $wr_subject = "[코] ".$parent_row[wr_subject];
        $wr_ip = $parent_row[wr_ip];
        $wr_datetime = $parent_row[wr_datetime];
    } else {
        $wr_subject = $write_row[wr_subject];
        $wr_ip = $write_row[wr_ip];
        $wr_datetime = $write_row[wr_datetime];
    }

    $wr_subject = get_text($wr_subject);

    if (!$is_admin && $member[mb_id] != $row[mb_id]) $row[sg_reason] = "";

    // 당일인 경우 시간으로 표시함
    $wr_datetime2 = substr($list['wr_datetime'],0,10);
    if ($wr_datetime2 == $g4['time_ymd'])
        $wr_datetime = substr($wr_datetime,11,5);
    else
        $wr_datetime = substr($wr_datetime,5,5);
    $sg_datetime2 = substr($row['sg_datetime'],0,10);
    if ($sg_datetime2 == $g4['time_ymd'])
        $sg_datetime = substr($row['sg_datetime'],11,5);
    else
        $sg_datetime = substr($row['sg_datetime'],5,5);

    if ($is_admin || $member['mb_id'] == $row['sg_mb_id'])
        $delete_link = " <a onClick=\"del('./singo_search_delete.php?sg_id= " . $row[sg_id] . "')\"><img src='./img/btn_comment_delete.gif' align=absmiddle></a>";

    echo "
    <tr class='list$list col1 center' height=25>
        <td align='center'>$row[sg_id]</td>
        <td title='$row[mb_id]' align='center'>$mb_nick</td>
        <td align=left style='padding:0 5px 0 5px;'>
            <a href='$g4[bbs_path]/board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]' target='_blank'>
                <span style='color:#555555;'>$wr_subject</span></a></td>
        <td>$wr_datetime</td>
        <td><span style='color:#C15B27;'>$sg_datetime</span></td>
        <td align=left style='padding:0 5px 0 5px;'><span style='color:#C15B27;'>". get_text($row[sg_reason])."$delete_link</span></td>
    </tr>
    ";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>내역이 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");
echo "</form>";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>

<p>* 신고사유는 본인만 확인할 수 있습니다.
<br>* 신고된 글을 삭제하는 경우 관련 신고 카운터는 없어집니다. 
<br>* 신고글에 대한 소명 또는 삭제가 필요한 경우 운영자에게 문의하세요.

<?
include_once ("./_tail.php");
?>
