<?
$sub_menu = "300920";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "시간별 배너클릭현황";
include_once("./admin.head.php");
include_once("./banner.sub.php");

$colspan = 4;
?>

<table width=100% cellpadding=0 cellspacing=1 border=0>
<colgroup width=100>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht center'>
    <td>시간</td>
    <td>클릭수</td>
    <td>비율(%)</td>
    <td>그래프</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
$max = 0;
$sum_count = 0;
$sql = " select SUBSTRING(bc_datetime,12,2) as bc_hour, count(bc_id) as cnt 
           from $g4[banner_click_table]
          where bc_datetime between '$fr_date 00:00:00' and '$to_date 23:59:59'
          group by bc_hour
          order by bc_hour ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row[bc_hour]] = $row[cnt];

    if ($row[cnt] > $max) $max = $row[cnt];

    $sum_count += $row[cnt];
}

$k = 0;
if ($i) {
    for ($i=0; $i<24; $i++) {
        $hour = sprintf("%02d", $i);
        $count = (int)$arr[$hour];

        $rate = ($count / $sum_count * 100);
        $s_rate = number_format($rate, 1);

        $bar = (int)($count / $max * 100);
        $graph = "<img src='{$g4[admin_path]}/img/graph.gif' width='$bar%' height='18'>";

        $list = ($k++%2);
        echo "
        <tr class='list$list ht center'>
            <td>$hour</td>
            <td>".number_format($count)."</td>
            <td>$s_rate</td>
            <td align=left>$graph</td>
        </tr>";
    }

    echo "
    <tr><td colspan='$colspan' class='line2'></td></tr>
    <tr class='bgcol2 bold col1 ht center'>
        <td>합계</td>
        <td>".number_format($sum_count)."</td>
        <td colspan=2>&nbsp;</td>
    </tr>";
} else {
    echo "<tr><td colspan='$colspan' height=100 align=center>자료가 없습니다.</td></tr>";
}
?>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
</table><br><br>

<?
include_once("./admin.tail.php");
?>
