<?
if (!defined("_GNUBOARD_")) exit;

$mod = 40; //이 숫자를 140정도로 했었더니 오른쪽 여백 스크롤이 생겨버렸던거다, 이 숫자의 의미를 잘 모르겠다, 걍 낮게 써놓으면 되는것같다
$td_width = (int)(100 / $mod);

include_once("$latest_skin_path/skin.lib.php");

if (!function_exists("imagecopyresampled")) alert("GD 2.0.1 이상 버전이 설치되어 있어야 사용할 수 있는 갤러리 게시판 입니다.");

if (!$board[bo_3]) {
    $board[bo_3] = "125";
    $sql = " update $g4[board_table] set bo_3 = '$board[bo_3]', bo_3_subj = '최신글 가로 픽셀' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_4]) {
    $board[bo_4] = "125";
    $sql = " update $g4[board_table] set bo_4 = '$board[bo_4]', bo_4_subj = '최신글 세로 픽셀' where bo_table = '$bo_table' ";
    sql_query($sql);
}
?>





<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
<?
for ($i=0; $i<count($list); $i++) {
  if ($i && $i%$mod==0) {
    echo "</tr><tr>";
  }
?>
<td style="padding:10px 5px; text-align:center;">
  <?

  $isql="select bf_file from g4_board_file where bo_table='$bo_table' and wr_id='{$list[$i]['wr_id']}' and bf_no='0'";
  $irst=sql_fetch($isql);
  //$irst['bf_file']; 이것이 게시물의 첫번째 파일명

  echo "<a href='{$list[$i][href]}#board'>";
  echo "<div style='border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px; border:1px solid #bbb; background:#fff; width:{$board[bo_3]}px; height:{$board[bo_4]}px; margin:0 auto; padding:9px;'>";
  //echo makeThumbs($g4[path]."/data/file/$bo_table", $list[$i][file][0][file], $board[bo_3], $board[bo_4], stripslashes($list[$i][subject]), $latest_skin_path);
  if($irst['bf_file']){
    $imgPath=$g4[path]."/data/file/".$bo_table.'/'.$irst['bf_file'];
    $realImg=thumbnail($imgPath,$board[bo_3],$board[bo_4],0,1,80,1,0,0);
    echo "<img src='$realImg' width='100%' />";
  }else{
    echo "<img src='../skin/latest/thumb/img/noimage.gif' width='100%' />";
  }
  //echo "<img src=".$g4[path]."/data/file/".$bo_table.'/'.$irst['bf_file'].">";
  echo "</div>";

  echo "<div style='padding-top:5px; height:100px; margin:0 auto;'>";
  if ($list[$i]['is_notice'])
      echo "<strong>{$list[$i]['subject']}</strong>";
  else
      //echo "{$list[$i]['subject']}";
    echo stripslashes($list[$i]['subject']);
  
  echo "</div></a>";
  ?>
</td>
<?
}

// 나머지 td
$cnt = $i%$mod;
if ($cnt)
    for ($i=$cnt; $i<$mod; $i++)
        echo "<td width='{$td_width}%'>&nbsp;</td>";
?>
</tr>
<? if (count($list) == 0) { ?><tr><td align="center" height="50"><span style="color:#555;">게시물이 없습니다.</span></td></tr><? } ?>

</table>
