<?
include_once("./_common.php");

include_once("$g4[path]/_head.php");

// 불당썸의 라이브러리를 읽어 줍니다.
include_once("$g4[path]/lib/thumb.lib.php");
 
////////////////basic cf control///////////
$one_rows = "25";   // 이미지 출력수량
$cols  = "5";       //  이미지 가로갯수
$width_o = "120";   //이미지 가로값
$height_o = "100";  //이미지 세로값
$image_h  = "17";   // 이미지 상하 간격

//jpg, gif, png 파일만 검색한다.
$sql_common = " a.bf_type in (1, 2, 3) and b.bo_use_search = 1 ";

$one_count_sql = " select count(*) as cnt from $g4[board_file_table] a left join $g4[board_table] b on (a.bo_table = b.bo_table) where $sql_common ";
$row = sql_fetch($one_count_sql);

$total_count = $row[cnt]; 
$total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산 
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;
      
$one_sql = " select * from $g4[board_file_table] a left join $g4[board_table] b on (a.bo_table = b.bo_table) where $sql_common order by bf_datetime desc limit $from_record, $one_rows";
$one_result = sql_query($one_sql);
?>

<!-----------기간별 출력시작--------->


<table width=100% cellpadding=0 cellspacing=0>
<tr><td height="4"></td></tr>
<tr><td align=left><font style="font-size:12pt;"><b>이미지</b>&nbsp;(총 <?=$total_count?>개중 <?=$from_record+1?> -
<? 
if (($from_record + ($one_rows-1)) < $total_count) {
echo "{$to_record}";
} else {
echo "{$total_count}";
}
?>)
</font>
</td></tr>
<tr><td height="10"></td></tr>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr><td height="10"></td></tr>
</table>
<table width=100% cellpadding=0 cellspacing=0>
<tr>
<?//출력
  for ($i=0; $one_row = sql_fetch_array($one_result); $i++){
    if ($i>0 && $i%$cols==0) { echo "</tr><tr><td colspan='$cols' height='$image_h'></td></tr><tr>"; }
?>
    <td valign=top align="center" width="150">
        <table width="140" height="120" border="0" cellpadding="0" cellspacing="0" bgcolor='#ECECEC' onMouseOver="bgColor='#71AEFE'" onMouseOut="bgColor='#ECECEC'">        
        <tr><td align="center"><table bgcolor="#FFFFFF" width="136" height="116" border="0" cellpadding="0" cellspacing="0">
		<tr><td align="center"><a href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$one_row[bo_table]?>&wr_id=<?=$one_row[wr_id]?>' onfocus='this.blur()'>
		<?
		$thumb_file = thumbnail("$g4[path]/data/file/$one_row[bo_table]/$one_row[bf_file]", $width_o, $height_o);
		?>
		<img src="<?=$thumb_file?>" border="0" width='<?=$width_o?>' height='<?=$height_o?>' >
		</a>
		</td></tr>
        </table></td></tr>
        </table>

    <table width=140 cellpadding=0 cellspacing=0><tr><td height="5"></td></tr><tr><td align="left">
		<?
            $sql = " select wr_subject from $g4[write_prefix]$one_row[bo_table] where wr_id = '$one_row[wr_id]' ";
            $row = sql_fetch($sql); 
			
            $sql2 = " select bo_subject from $g4[board_table] where bo_table = '$one_row[bo_table]' ";
            $row2 = sql_fetch($sql2);
        ?>
        &nbsp;<a href='<?=$g4[bbs_path]?>/board.php?bo_table=<?=$one_row[bo_table]?>&wr_id=<?=$one_row[wr_id]?>' onfocus='this.blur()'><b><u><?=cut_str($row[wr_subject], 16)?></u></a></td></tr>
		<tr><td height="5"></td></tr>
		<tr><td align="left">&nbsp;<?=$row2[bo_subject]?></td></tr>
		</table>
    </td>
<? } ?>
</tr>

<tr><td width="150" height="10"></td><td width="150" height="10"></td><td width="150" height="10"></td><td width="150" height="10"></td><td width="150" height="10"></td></tr>
</table>

<table width=100% cellpadding=0 cellspacing=0>
<tr><td height=1 bgcolor=#E7E7E7></td></tr>
<tr><td height="10"></td></tr>
<tr><td>
<? 
$page = get_paging($config[cf_write_pages], $page, $total_page, "?&page="); 
echo "$page";
?>
</td></tr>
<tr><td height="10"></td></tr>
</table>

<?
include_once("$g4[path]/_tail.php"); 
?>
