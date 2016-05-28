<?
$g4_path = "../../..";
include_once("$g4_path/common.php");
include_once("$board_skin_path/auction.lib.php");

$g4[title] = "경매 입찰 내역";

include_once("$g4[path]/head.sub.php");

echo "<script language=\"javascript\" src=\"$g4[path]/js/sideview.js\"></script>\n";

// 경매진행중 -> 종료시간이 지났을 때 -> 경매종료
if ($write[wr_8] == "1" && $write[wr_2] <= $g4[time_ymdhis])
{
    $result = auction_successful($wr_id);
    if ($result[wr_8] > 1) {
        $write[wr_7] = $result[wr_7];
        $write[wr_8] = $result[wr_8];
        $write[wr_9] = $result[wr_9];
        $write[wr_10] = $result[wr_10];
    }
}

if ($write[wr_8] >= 2) {
    $order_info = "포인트 오름차순 정렬";
    $orderby = "td_tender_point";
} else {
    $order_info = "입찰일시 내림차순 정렬";
    $orderby = "td_datetime desc";
}

$row = sql_fetch(" select count(*) as cnt from $tender_table where wr_id = '$wr_id' ");
$total = $row[cnt];
?>
<div style="height:50px; clear:both;">

    <div style="float:left; margin:20px 20px 0 10px;">
        <b style="color:#0000A0;">입찰내역</b>
        <span style="color:#888;">(<?=$order_info?>)</span>
    </div>

    <div style="float:right; margin:20px 10px 10px 0;">
    총 참여수 : <?=number_format($total)?> 
    </div>
</div>

<table border=0 cellspacing=1 width=450 align=center>
<tr>
    <td colspan=4 height=2 bgcolor="#cccccc"></td>
</tr>
<tr bgcolor="#e7e7e7">
    <td align=center style="font-weight:bold;" width=50 height=30> 번호 </td>
    <td align=center style="font-weight:bold;" width=100> 회원 </td>
    <td align=center style="font-weight:bold;"> 입찰일시 </td>
    <td align=center style="font-weight:bold;" width=100> 입찰금액 </td>
</tr>
<?
if (!$total)
    echo "<tr><td colspan=4 height=50 align=center> 입찰내역이 없습니다. </td></tr>";


$qry = sql_query(" select * from $tender_table where wr_id = '$wr_id' order by $orderby");
$num = mysql_num_rows($qry);
while ($row = sql_fetch_array($qry)) 
{
    if (!$is_admin && $write[wr_8] == 1 && $row[mb_id] != $member[mb_id]) 
        $tender_point = "**";
    else
        $tender_point = number_format($row[td_tender_point]);

    if ($row[td_tender_point] == $write[wr_9]) $bgcolor = "#FAB074"; else $bgcolor = "#ffffff";
?>
<tr bgcolor="<?=$bgcolor?>">
    <td align=center height=25> <?=$num--?> </td>
    <td align=center> <?=get_sideview($row[mb_id], $row[mb_nick], $row[mb_email], $row[mb_homepage])?> </td>
    <td align=center> <?=date("Y-m-d H:i", strtotime($row[td_datetime]))?> </td>
    <td align=right> <?=$tender_point?> 포인트 &nbsp; </td>
</tr>
<tr>
    <td colspan=4 height=1 bgcolor="#efefef"></td>
</tr>
<? } ?>
<tr>
    <td colspan=4 height=2 bgcolor="#cccccc"></td>
</tr>
</table>

<div style="text-align:center; margin-top:30px;">
<input type=button value="닫     기" onclick="self.close()">
</div>

<div style="height:50px;">&nbsp;</div>

</div>

<?
include_once("$g4[path]/tail.sub.php");
?>
