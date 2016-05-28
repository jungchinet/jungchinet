<?
$sub_menu = "300310";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$sql_common = " from $g4[unsingo_table] ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "wr_id" :
            $wr = explode(",", $stx);
            $sql_search .= " (bo_table = '$wr[0]' and wr_id = $wr[1]) ";
            break;
        case "unsg_reason" :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "unsg_id";
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

$g4[title] = "게시물신고해제관리";
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
var list_delete_php = "unsingo_list_delete.php";
</script>

<form name=fsearch method=get style="margin:0px;">
<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (신고해제 게시물 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
        <select name=sfl class=cssfl>
            <option value='mb_id'>신고된 회원아이디</option>
            <option value='unsg_mb_id'>신고해제한 회원아이디</option>
            <option value='unsg_ip'>신고해제한 IP</option>
            <option value='unsg_reason'>신고해제한 이유</option>
            <option value='bo_table'>게시판</option>
            <option value='wr_id'>게시판,게시글</option>
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
<tr class='bgcol1 bold col1 ht2 center'>
    <td width=30 rowspan=2><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td width=110 align='left'><?=subject_sort_link('mb_id')?>신고된 회원</a></td>
    <td align='left'>게시판 - 게시물 - 신고</td>
    <td width=110>게시물 등록일시</td>
    <td width=100>게시물 IP</td>
	  <td width=60 rowspan=2></td>
</tr>
<tr class='bgcol1 bold col1 ht2 center'>
    <td align='left'><?=subject_sort_link('unsg_mb_id')?>신고해제한 회원</a></td>
    <td align='left'>신고해제한 이유</td>
    <td>신고해제한 일시</td>
    <td>신고해제한 IP</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $mb = array();
    $unsg_mb = array();

    if ($row[mb_id]) {
        $mb = get_member($row[mb_id], "mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date");
        $mb_nick = $mb[mb_nick];
        $mb_id = $mb[mb_id];
    } else {
        $mb_nick = "비회원";
        $mb_id = "비회원";
    }

    if ($row[unsg_mb_id]) {
        $unsg_mb = get_member($row[unsg_mb_id], "mb_id, mb_nick, mb_email, mb_homepage, mb_intercept_date");
        $unsg_mb_nick = $unsg_mb[mb_nick];
        $unsg_mb_id = $unsg_mb[mb_id];
    } else {
        $unsg_mb_nick = "비회원";
        $unsg_mb_id = "비회원";
    }

    $wr_subject = "";
    $wr_ip = "";
    $wr_datetime = "";
    $singo_href = "";

    if ($row['sg_notes']) {
        ;
    } else if ($row['bo_table'] == "@memo") {
        // 쪽지 신고
        ;
    } else if ($row['bo_table'] == "@user") {
        // 사용자 신고
        ;
    } else if ($row['bo_table'] == "@hidden_comment") {
        // 딴지걸기 신고
        ;
    } else {
        // 게시글 신고
        $write_table = $g4['write_prefix'].$row[bo_table];
        $bo = get_board($row[bo_table], "bo_subject");
        $sql = " select wr_subject, wr_ip, wr_is_comment, wr_parent, wr_datetime, wr_singo from $write_table where wr_id = '$row[wr_id]' ";
        $write_row = sql_fetch($sql);
        if ($write_row[wr_is_comment]) {
            $sql = " select wr_subject, wr_ip, wr_datetime from $write_table, wr_singo where wr_id = '$write_row[wr_parent]' ";
            $parent_row = sql_fetch($sql);
            $wr_subject = "[코] ".$parent_row[wr_subject];
            $wr_ip = $parent_row[wr_ip];
            $wr_datetime = $parent_row[wr_datetime];
        } else {
            // wr_singo == 0, 신고해제가 되어 무효가 된 신고라는거. 신고해제는 원글에만 해당.
            if ($write_row[wr_singo] == 0)
                $wr_subject = "<del>" . $write_row[wr_subject] . "</del>";
            else
                $wr_subject = $write_row[wr_subject];

            $wr_subject = "<a href='./unsingo_list.php?sfl=wr_id&stx=$row[bo_table],$row[wr_id]'>" . $wr_subject . "</a>";

            $wr_ip = $write_row[wr_ip];
            $wr_datetime = $write_row[wr_datetime];

            // 신고 건수를 계산
            $sql3 = " select count(*) as cnt from $g4[singo_table] where bo_table='$row[bo_table]' and wr_id = '$row[wr_id]' ";
            $result3 = sql_fetch($sql3);
            if ($result3[cnt] > 0) {
                // 신고 건수에 링크를 걸어줘야죠
                $unsingo = " - <b><a href=./singo_list.php?sfl=wr_id&stx=$row[bo_table],$row[wr_id] target=new>$result3[cnt]<a></b>";
            }
            else
                $unsingo = " - 0";
        }
        $singo_href = "<a href='$g4[bbs_path]/board.php?bo_table=$row[bo_table]&wr_id=$row[wr_id]' target='_blank'>";

        // 게시판 제목
        $bo_subject = "<a href='./unsingo_list.php?sfl=bo_table&stx=$row[bo_table]'>" . cut_str($bo[bo_subject],30) . "</a>";
    } 

    // 닉을 누르면, 해당 닉의 모든게 검색되게 수정해 주시고
    $mb_nick = "<a href=./unsingo_list.php?sfl=mb_id&stx=$mb_id>$mb_nick</a>";
    $unsg_mb_nick = "<a href=./unsingo_list.php?sfl=unsg_mb_id&stx=$unsg_mb_id>$unsg_mb_nick</a>";

    if ($mb[mb_intercept_date]) $mb_nick = $mb_nick." <span style='color:#ff0000' title='$mb[mb_intercept_date]'>*</span>";
    if ($unsg_mb[mb_intercept_date]) $unsg_mb_nick = $unsg_mb_nick." <span style='color:#ff0000' title='$unsg_mb[mb_intercept_date]'>*</font>";

    $ip_intercept = preg_match("/[\n]?$wr_ip/", $config['cf_intercept_ip']);
    $wr_ip_intercept = "";
    if ($ip_intercept)
        $wr_ip_intercept = " <span style='color:#ff0000'>*</span>";

    $ip_intercept = preg_match("/[\n]?$row[unsg_ip]/", $config['cf_intercept_ip']);
    $unsg_ip_intercept = "";
    if ($ip_intercept)
        $unsg_ip_intercept = " <span style='color:#ff0000'>*</span>";

    $unsg_ip = "<a href=./unsingo_list.php?sfl=unsg_ip&stx=$row[unsg_ip]>" . $row[unsg_ip] . "</a>";

    $list = $i%2;
    
    echo "
    <input type=hidden name=unsg_id[$i] value='$row[unsg_id]'>
    <tr class='list$list col1 center' height=25>
        <td rowspan=2><input type=checkbox name=chk[] value='$i'></td>
        <td title='$row[mb_id]' align='left'>$mb_nick</td>
        <td align=left style='padding:0 5px 0 5px;'>
                $bo_subject -
                <span style='color:#555555;'>$wr_subject</span> 
                $unsingo
                {$singo_href}<img src='./img/icon.gif' align=absmiddle><img src='./img/icon.gif' align=absmiddle></a>
        </td>
        <td>".substr($wr_datetime,2,14)."</td>
        <td align=left>&nbsp; $wr_ip $wr_ip_intercept</td>
        <td>
        </td>
    </tr>
    <tr class='list$list col1 center' height=25>
        <td title='$row[unsg_mb_id]' align='left'>: $unsg_mb_nick</td>
        <td align=left style='padding:0 5px 0 5px;'><span style='color:#C15B27;'>".get_text($row[unsg_reason])."</span></td>
        <td><span style='color:#C15B27;'>".substr($row[unsg_datetime],2,14)."</span></td>
        <td align=left>&nbsp; <span style='color:#C15B27;'>$unsg_ip</span> $unsg_ip_intercept</td>
        <td>
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

<p>* 삭제시 신고해제된 내역만을 삭제하며 게시물의 삭제는 하지 않습니다.
<br>* 신고해제에서는 차단을 하지 않습니다. 이것은 방어권이라 존중합니다.
<br>* 회원별명 옆의 <font color='#ff0000'>*</font> 표시는 차단된 회원임을 나타냅니다. 마우스 오버시 차단일자가 표시됩니다.

<?
include_once ("./admin.tail.php");
?>
