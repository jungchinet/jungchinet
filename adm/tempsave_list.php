<?
$sub_menu = "300830";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$sql_common = " from $g4[tempsave_table] ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_id" :
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "tmp_id";
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

$g4[title] = "임시저장글목록보기";
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
var list_delete_php = "tempsave_list_delete.php";
</script>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (임시저장글갯수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>회원아이디</option>
            <option value='ip_addr'>접속한 IP</option>
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
    <td align='left'>제목</td>
    <td width=110>tempsave 일시</td>
    <td width=100><?=subject_sort_link('ip_addr')?>IP</a></td>
	  <td width=60>IP차단</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($row[mb_id]) {
        $mb = sql_fetch(" select mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date from $g4[member_table] where mb_id = '$row[mb_id]' ");
        $mb_nick = get_sideview($mb[mb_id], $mb[mb_nick], $mb[mb_email], $mb[mb_homepage]);
    } else 
        $mb_nick = "<span style='color:#222222;'>비회원</a>";

    $log_ip = $row['ip_addr'];
    $ip_intercept = preg_match("/[\n]?$log_ip/", $config['cf_intercept_ip']);
    $log_ip_intercept = "";
    if ($ip_intercept)
        $log_ip_intercept = " <span style='color:#ff0000'>*</span>";

    $subject = get_text($row[wr_subject]);

    echo "
    <input type=hidden name=tmp_id[$i] value='$row[tmp_id]'>
    <tr class='list$list col1 center' height=25>
        <td><input type=checkbox name=chk[] value='$i'></td>
        <td title='$row[mb_id]' align='left'>$mb_nick</td>
        <td align=left style='padding:0 5px 0 5px;'>$subject</td>
        <td>$row[wr_datetime]</td>
        <td align=left>&nbsp; <a href='?sfl=ip_addr&stx=" . $log_ip . "'>$log_ip</a> $log_ip_intercept</td>
        <td>
        <a href=\"javascript:singo_intercept('$row[mb_id]', '$log_ip');\"><span style='color:#222222;'>차단</span></a>
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

<br>* 차단하는 경우 기본환경설정의 접근차단IP에 등록됩니다.

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
