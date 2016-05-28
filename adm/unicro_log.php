<?
$sub_menu = "300600";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$unicro_log_table = "$g4[table_prefix]unicro_log";
$sql_common = " from $unicro_log_table ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default : 
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "log_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common 
         $sql_search 
         $sql_order ";
$row = sql_fetch($sql, false);
if (!$row)
    alert("unicro 연동 모듈이 정상 설치되지 않았습니다. 유니크로 모듈을 다시 확인하시기 바랍니다.");
else
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

$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>";

$g4[title] = "유니크로 로그";
include_once("./admin.head.php");

$colspan = 7;

$log_url = "$g4[admin_path]/unicro_log.php";
?>

<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left><?=$listall?> (로그수 : <?=number_format($total_count)?>개)</td>
    <td width=50% align=right>
        <select name=sfl>
            <option value='msg'>메시지</option>
            <option value='mb_id'>mb_id</option>
            <option value='mode'>mode</option>
            <option value='item_no'>item no</option>
        </select>
        <input type=text name=stx required itemname='검색어' value='<?=$stx?>'>
        <input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
</tr>
</form>
</table>

<table width=100% cellpadding=0 cellspacing=0>
<colgroup width=60>
<colgroup width=70>
<colgroup width=60>
<colgroup width=''>
<colgroup width=''>
<colgroup width=70>
<colgroup width=70>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
	<td>번호</td>
	<td>회원명</td>
	<td>mode</td>
	<td>item no</td>
	<td>메시지</td>
	<td>바로가기</td>
	<td>날짜</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {

    // 당일인 경우 시간으로 표시함
    $log_datetime = substr($row['log_datetime'],0,10);
    $log_datetime2 = $row['log_datetime'];
    if ($log_datetime == $g4['time_ymd'])
        $log_datetime2 = substr($log_datetime2,11,5);
    else
        $log_datetime2 = substr($log_datetime2,5,5);
        
    if ($row['mode'] == "status")
        $mode = '';
    else 
        $mode = $row['mode'];
        
    if (!$row[bo_table]) {
        $result2 = sql_fetch(" select * from $g4[unicro_item_table] where item_no = $row[item_no] ");
        $bo_table = $result2['bo_table'];
        $wr_id = $result2['wr_id'];
    } else {
        $bo_table = $row['bo_table'];
        $wr_id = $row['wr_id'];
    }
    
    // 복수개의 item이 존재하는 경우를 위해서  
    $item_array = explode("|", trim($row[item_no]));
    $item_url = "";
    for ($k=0; $k<count($item_array); $k++) {
        $item_url .= "<a href='$log_url?sfl=item_no&stx=$item_array[$k]'>$item_array[$k]</a>|";
    }

    echo "
    <tr class='list$list col1 ht center'>
        <td>$row[log_id]</td>
        <td align=left><a href='$log_url?sfl=mb_id&stx=$row[mb_id]'>".$row[mb_id]."</a></td>
        <td><a href='$log_url?sfl=mode&stx=$mode'>$mode</a></td>
        <td>$item_url</td>
        </td>
        <td>$row[msg]</td>
        <td><a href='$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id' target=_new><img src='./img/icon_viewer.gif'></a>&nbsp;&nbsp;
            <a href='http://www.unicro.co.kr/main/itemDetail.jsp?item_no=$item_array[0]' target=_new><img src='./img/unicro.ico'></a></td>
        <td>$log_datetime2</td>
    </tr>";

}

if ($i==0) 
    echo "<tr><td colspan='$colspan' height=100 align=center bgcolor='#FFFFFF'>자료가 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");
if ($pagelist)
    echo "<table width=100% cellpadding=3 cellspacing=1><tr><td align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script language='javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>

<script language='javascript'>
    document.fsearch.stx.focus();
</script>

<?
include_once ("./admin.tail.php");
?>
