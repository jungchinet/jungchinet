<?
include_once("./_common.php");

// 회원만 사용이 가능하게
if (!$is_member) 
{
    $href = "./login.php?$qstr&url=".urlencode("./singo_search.php");

    echo "<script language='JavaScript'>alert('회원만 가능합니다.'); top.location.href = '$href';</script>";
    exit;
}

$sql_common = " from $g4[hidden_comment_table] a left join $g4[board_table] b on a.bo_table = b.bo_table ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "sg_reason" :
            $sql_search .= " (a.$sfl like '%$stx%') ";
            break;
        default :
            $sql_search .= " (a.$sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "co_id";
    $sod = "desc";
}

$sql_order = " order by a.$sst $sod ";

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

$g4[title] = "딴지걸기관리";
include_once("./_head.php");

$sql = " select * 
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$colspan = 5;
?>

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
        (딴지걸린 게시물 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='co_content'>딴지하는 이유</option>
            <option value='co_mb_id'>게시자 id</option>
            <option value='bo_table'>게시판</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<? echo $stx ?>'>
        <input type=image src='<?=$g4[bbs_path]?>/img/btn_post_search.gif' align=absmiddle></td>
</tr>
</table>
</form>

<form name=flist method=post style="margin:0px;">
<input type=hidden name=sst  value='<?=$sst?>'>
<input type=hidden name=sod  value='<?=$sod?>'>
<input type=hidden name=sfl  value='<?=$sfl?>'>
<input type=hidden name=stx  value='<?=$stx?>'>
<input type=hidden name=page value='<?=$page?>'>

<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=40>
<colgroup width=180>
<colgroup width=60>
<colgroup width=''>
<colgroup width=70>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 center'>
    <td align='center'><?=subject_sort_link('co_id')?>no.</a></td>
    <td><?=subject_sort_link('bo_table')?>게시판</a></td>
    <td><?=subject_sort_link('mb_id')?>게시자</a></td>
    <td align='left'>딴&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;지</td>
    <td><?=subject_sort_link('co_datetime')?>날짜</a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {

    // 회원닉네임
    $sql = " select mb_id from $g4[board_prefix]$g4[write_prefix]$row[bo_table] where wr_id = '$row[wr_id]' ";
    $res2 = sql_fetch($sql);
    $mb = get_member($res2[mb_id], "mb_nick");
    // 원글자 mb_id를 db에 업데이트 (별도의 db 업글 프로그램을 안만들려고 추가한 기능)
    if ($mb[mb_nick]) {
        if (!$row[co_mb_id])
            sql_query(" update $g4[hidden_comment_table] set co_mb_id = '$mb[mb_nick]' where co_id = '$row[co_id]' ");

        $mb_nick = "<a href='./hidden_comment_search.php?sfl=co_mb_id&stx=$mb[mb_nick]&sod=$sod&sst=$sst'>$mb[mb_nick]</a>";
    } else 
        $mb_nick = "-deleted-";
    
    echo "
    <tr class='list$list col1 center' height=25>
        <td align='center'>$row[co_id]</td>
        <td align=left><a href='./hidden_comment_search.php?sfl=bo_table&stx=$row[bo_table]&sod=$sod&sst=$sst'>" . cut_str($row[bo_subject], 30) . "</a></td>
        <td align=center>$mb_nick</td>
        <td align=left style='padding:5px 5px 5px 5px;'>";
    
    if ($mb[mb_nick])
        echo "
            <a href='$g4[bbs_path]/board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]' target='_blank'>
            <span style='color:#555555;'>$row[co_content]</span></a>";
    else
        echo "
            <span style='color:#555555;'>$row[co_content]</span>";        

    echo "
        </td>
        <td>" . get_datetime($row['co_datetime']) . "</td>
    </tr>
    <tr><td colspan=$colspan height=1 bgcolor=#E7E7E7></td></tr>
    ";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>내역이 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

echo "</form>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");

echo "<form name=fpage method=get style='margin:0px;'>";
echo "<table><tr><td>";
echo $pagelist;
echo "</td></tr></table>";
echo "</form>";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>

<?
include_once ("./_tail.php");
?>
