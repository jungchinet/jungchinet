<?
$sub_menu = "200810";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "게시판별 접속자현황";
include_once("$g4[admin_path]/admin.head.php");
include_once("$g4[path]/lib/visit.lib.php");

if (empty($fr_date)) $fr_date = $g4[time_ymd];
if (empty($to_date)) $to_date = $g4[time_ymd];

$qstr = "fr_date=$fr_date&to_date=$to_date";

$colspan = 6;
?>

<script type="text/javascript">
function fvisit_submit(ymd, gr_id, bo_table) 
{
    var f = document.fvisit;
    f.ymd.value = ymd;
    f.gr_id.value = gr_id;
    f.bo_table.value = bo_table;
    f.action = "board_visit_list.php";
    f.submit();
}
</script>

<form name=fvisit method=get style="margin:0;">
<input type=hidden name="ymd">
<input type=hidden name="gr_id" value="<?=$gr_id?>">
<input type=hidden name="bo_table" value="<?=$bo_table?>">
<table width=100% cellpadding=3 cellspacing=1>
<tr>
    <td>
        기간 : 
        <input type='text' name='fr_date' size=11 maxlength=10 value='<?=$fr_date?>' class=ed>
        -
        <input type='text' name='to_date' size=11 maxlength=10 value='<?=$to_date?>' class=ed>
        &nbsp;
        <input type=button class=btn1 value=' 일 ' onclick="fvisit_submit('d', document.fvisit.gr_id.value, document.fvisit.bo_table.value);">
        <input type=button class=btn1 value=' 월 ' onclick="fvisit_submit('m', document.fvisit.gr_id.value, document.fvisit.bo_table.value);">
        <input type=button class=btn1 value=' 년 ' onclick="fvisit_submit('y', document.fvisit.gr_id.value, document.fvisit.bo_table.value);">
        &nbsp;&nbsp;
        <a href="<?=$PHP_SELF?>?<?=$qstr?>&ymd=<?=$ymd?>">전체</a>
        <? if ($gr_id) { ?> > <a href="<?=$PHP_SELF?>?gr_id=<?=$gr_id?>&ymd=<?=$ymd?>&<?=$qstr?>"><?=$group[gr_subject]?></a> <? } ?>
        <? if ($bo_table) { ?> > <a href="<?=$PHP_SELF?>?gr_id=<?=$gr_id?>&bo_table=<?=$bo_table?>&ymd=<?=$ymd?>&<?=$qstr?>"><?=$board[bo_subject]?></a> <? } ?>
    </td>
</tr>
</table>
</form>


<table width=100% cellpadding=0 cellspacing=1 border=0>
<colgroup width=100>
<colgroup width=80>
<colgroup width=100>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td><a href="<?=$PHP_SELF?>?stx=visit_date">년-월-일</a></td>
    <td><a href="<?=$PHP_SELF?>?stx=gr_id">그룹</a></td>
    <td><a href="<?=$PHP_SELF?>?stx=bo_table">게시판</a></td>
    <td><a href="<?=$PHP_SELF?>?stx=cnt">방문자수</a></td>
    <td>비율(%)</td>
    <td>그래프</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
$sql_select = " gr_id, bo_table, sum(bv_count) as cnt ";
$sql_common = " from $mw[board_visit_table] ";
$sql_search = " where bv_date between '$fr_date' and '$to_date' ";
$sql_group  = " group by bo_table ";

if ($gr_id) {
    $sql_search .= " and gr_id = '$gr_id' ";
}

if ($bo_table) {
    $sql_search .= " and gr_id = '$gr_id' and bo_table = '$bo_table' ";
}

switch ($ymd) {
    case "y":
        $sql_select .= ", left(bv_date, 4) as visit_date ";
        $sql_group  .= ", visit_date ";
        break;
    case "m":
        $sql_select .= ", left(bv_date, 7) as visit_date  ";
        $sql_group  = " group by visit_date, gr_id, bo_table ";
        break;
    default:
        $sql_select .= ", bv_date as visit_date  ";
        $sql_group  .= ", visit_date ";
        break;
}

switch ($stx) {
  case 'bo_table'  : $order_by = " order by bo_table ";
                      break;
  case 'cnt'  : $order_by = " order by cnt desc ";
                      break;
  case 'visit_date' : $order_by = " order by visit_date desc ";
                      break;
  case 'gr_id'      : 
  default           : $order_by = " order by gr_id, bo_table ";
}

$sql = " select $sql_select
          $sql_common
          $sql_search
          $sql_group
          $order_by ";
$qry = sql_query($sql);


$data = array();
$sum_count = 0;
$max = 0;
while ($row = sql_fetch_array($qry)) {
    $data[] = $row;
    $sum_count += $row[cnt];
    if ($row[cnt] > $max) $max = $row[cnt];
}
$i = 0;
foreach ($data as $row) {
    $count = $row[cnt];
    $rate = ($count / $sum_count * 100);
    $s_rate = number_format($rate, 1);

    $bar = (int)($count / $max * 100);
    $graph = "<img src='{$g4[admin_path]}/img/graph.gif' width='$bar%' height='18'>";

    $date_link = "";
    switch ($ymd) {
        case "y":
            $date_link = "$PHP_SELF?fr_date=$row[visit_date]-01-01&to_date=$row[visit_date]-12-31&ymd=m&gr_id=$gr_id&bo_table=$bo_table";
            break;
        case "m":
            $date_link = "$PHP_SELF?fr_date=$row[visit_date]-01&to_date=$row[visit_date]-31&ymd=d&gr_id=$gr_id&bo_table=$bo_table";
            break;
        default:
            $date_link = "$PHP_SELF?fr_date=$row[visit_date]&to_date=$row[visit_date]&ymd=d&gr_id=$gr_id&bo_table=$bo_table";
            break;
    }

    $board = sql_fetch(" select * from $g4[board_table] where bo_table = '$row[bo_table]' ");
    $group = sql_fetch(" select * from $g4[group_table] where gr_id = '$row[gr_id]' ");

    $list = ($i++%2);
    echo "
    <tr class='list$list col1 ht center'>
        <td><a href=\"$date_link\">$row[visit_date]</a></td>
        <td><a href=\"javascript:fvisit_submit('$ymd', '$row[gr_id]', '')\">$group[gr_subject]</a></td>
        <td><a href=\"javascript:fvisit_submit('$ymd', '$row[gr_id]', '$row[bo_table]')\">$board[bo_table]</a></td>
        <td>$count</td>
        <td>$s_rate</td>
        <td align=left>$graph</td>
    </tr>";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' height=100 align=center>자료가 없습니다.</td></tr>"; 

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";

$page = get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&domain=$domain&page=");
if ($page) {
    echo "<table width=100% cellpadding=3 cellspacing=1><tr><td align=right>$page</td></tr></table>";
}

include_once("$g4[admin_path]/admin.tail.php");
?>
