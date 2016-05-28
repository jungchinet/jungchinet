<?
$sub_menu = "300210";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "게시판 스킨 목록";
include_once("./admin.head.php");

$colspan=3;

// 게시판 스킨목록
$arr = get_skin_dir("board");

?>
<table width=100% cellpadding=0 cellspacing=1>
<colgroup width=150>
<colgroup width=50>
<colgroup width=>
<tr><td colspan='<?=$colspan?>' class='line1'></td></tr>
<tr class='bgcol1 bold col1 ht2 center'>
    <td>skin 이름</td>
    <td>갯수</td>
    <td>skin 적용 게시판</td>
</tr>
<tr><td colspan='<?=$colspan?>' class='line2'></td></tr>

<?
$i=1;
foreach ($arr as $skin) {
    $sql = " select bo_subject, bo_table from $g4[board_table] where bo_skin = '$skin' order by bo_table desc ";
    $result = sql_query($sql);
    $list = $i % 2;
    echo "<tr class='list$list col1 ht center'>";
    echo "<td>$skin</td>";
    $cnt = mysql_num_rows($result);
    echo "<td>$cnt</td>";
    echo "<td align=left>";
    while ($row = sql_fetch_array($result))
    {
        echo "<a href='$g4[bbs_path]/board.php?bo_table=$row[bo_table]' target=_blank>" . cut_str($row[bo_subject], 30) . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    echo "</td>";
    echo "</tr>";
    $i++;
}
?>

</table>

<?
include_once("./admin.tail.php");
?>
