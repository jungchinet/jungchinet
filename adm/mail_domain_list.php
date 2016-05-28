<?
$sub_menu = "200310";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

// http://sir.co.kr/bbs/board.php?bo_table=tip_mysql&wr_id=292
$sql = "  SELECT SUBSTRING_INDEX( mb_email, '@', -1 ) AS Domain, count( * ) AS Total
          FROM $g4[member_table] 
          GROUP BY Domain
          ORDER BY Total DESC, Domain ASC ";
$result = sql_query($sql);

$total_count = mysql_num_rows($result);

$g4[title] = "회원 이메일 도메인 목록";
include_once("./admin.head.php");

$colspan = 15;
?>

<table width=100%>
<tr>
    <td width=50% align=left><?=$listall?>
        (도메인 갯수 : <?=number_format($total_count)?>)
    </td>
    <td width=50% align=right>
    </td>
</tr>
</table>

<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 center'>
    <td width=30></td>
    <td width=110 align='left'>도메인이름</td>
    <td align='left'>도메인갯수</td>
    <td width=110></td>
    <td width=100></td>
	  <td width=60></td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>
<?
for ($i=0; $i < $total_count; $i++) {
    $row = sql_fetch_array($result);
    
    echo "
    <tr class='list$list col1 center' height=25>
        <td></td>
        <td title='$row[Domain]' align='left'><a href='http://$row[Domain]' target='new'>$row[Domain]</a></td>
        <td align=left style='padding:0 5px 0 5px;'><a href='member_list.php?sfl=mb_email&stx=%25@$row[Domain]'>$row[Total]</a></td>
        <td></td>
        <td align=left></td>
        <td></td>
    </tr>
    ";
}

if ($i == 0)
    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>내역이 없습니다.</td></tr>";

echo "<tr><td colspan='$colspan' class='line2'></td></tr>";
echo "</table>";
?>

<?
include_once ("./admin.tail.php");
?>
