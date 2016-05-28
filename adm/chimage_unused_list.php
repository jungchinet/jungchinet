<?
$sub_menu = "300810";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$sql_common = " from $g4[board_cheditor_table] ";

// 낙동강 오리알이 된 시간 - 12시간 이후까지 아무것도 없으면 낙장으로 분류
$date_gap = date("Y-m-d H:i:s", $g4[server_time] - 3600*12);

$sql_search = " where (del = 1 or wr_id is null) and (bc_datetime < '$date_gap') ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_id" :
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "bc_id";
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

$g4[title] = "안쓰는이미지목록보기";
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
<script language="JavaScript">
var list_delete_php = "chimage_unused_delete.php";
</script>

<script language="JavaScript">
function unused_clear()
{
    if (confirm("안쓰는 이미지 정리를 선택하시면, 현재부터 하루 이전의 모든 사용되지 않은 이미지룰 모두 삭제 합니다.\n\n삭제된 이미지는 _delete로 끝나는 디렉토리에 저장 되므로 백업후 삭제 하시기 바랍니다.\n\n\n그래도 진행하시겠습니까?"))
    {
        document.location.href = "./chimage_unused_clear.php?ok=1";
    }
}
</script>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (안쓰는이미지갯수 : <?=number_format($total_count)?>) <a href="javascript:unused_clear();">전체 안쓰는 이미지 정리</a>
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>회원아이디</option>
            <option value='bo_table'>게시판</option>
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
    <td width=110 align='left'><?=subject_sort_link('mb_id')?>회원아이디</a></td>
    <td width=110><?=subject_sort_link('bo_table')?>게시판</a></td>
    <td align='left'>이미지파일 이름</td>
    <td align='left' width=100><?=subject_sort_link('bc_filesize')?>이미지용량(KB)</a></td>
	  <td width=100><?=subject_sort_link('bc_datetime')?>날짜</a></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($row[mb_id]) {
        $mb = sql_fetch(" select mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date from $g4[member_table] where mb_id = '$row[mb_id]' ");
        $mb_nick = $mb[mb_nick];
    } else 
        $mb_nick = "<span style='color:#222222;'>비회원</a>";
    $mbinfo = "<a href='$_SERVER[PHP_SELF]?sfl=mb_id&stx=$row[mb_id]'>$mb_nick</a>";

    $subject = get_text($row[wr_subject]);
    $bo = get_board($row[bo_table], "bo_subject");
    $bo_subject = $bo[bo_subject];
    $boinfo = "<a href='$_SERVER[PHP_SELF]?sfl=bo_table&stx=$row[bo_table]'>$bo_subject</a>";

    // $img[src] 웹 상의 절대경로 이므로 이미지 파일의 상대경로를 구합니다.
    // 이렇게 잘라줘야 제대로 된 경로가 나온다.
    $fl = explode("/$g4[data]/",$row[bc_dir]);
    $rel_path = "../" . $g4[data] . "/" . $fl[1];

    $img_link = $rel_path . "/" . $row[bc_file];
    $imginfo = "<a href='$img_link' target=new>" . $row[bc_source] . "</a>";

    $bc_filesize = number_format($row[bc_filesize]);

    echo "
    <input type=hidden name=bc_id[$i] value='$row[bc_id]'>
    <tr class='list$list col1 center' height=25>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td title='$row[mb_id]' align='left'>$mbinfo</td>
        <td style='padding:0 5px 0 5px;'>" . $boinfo . "</td>
        <td align=left>&nbsp;" . $imginfo. "</td>
        <td align=left>&nbsp$bc_filesize</td>
        <td>" . get_datetime($row[bc_datetime]) . "</a>
        </td>
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

<form name="fsingo" method="post" action="" style="margin:0px;">
<input type="hidden" name="mb_id">
<input type="hidden" name="ip">
<input type="hidden" name="page" value="<?=$page?>">
</form>

<script language="javascript">
function singo_intercept(mb_id, ip) 
{
    var f = document.fsingo;
    if (confirm(ip+" : IP를 정말 차단 하시겠습니까?")) {
        f.mb_id.value = ''; // 로그인 오류의 경우 회원정보는 차단하지 않습니다.
        f.ip.value = ip;
        f.action = "singo_intercept.php";
        f.submit();
    }
}
</script>

<?
include_once ("./admin.tail.php");
?>
