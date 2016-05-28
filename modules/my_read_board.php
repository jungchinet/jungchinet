<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/_head.php");

$one_rows = "25";  // 한줄에 출력할 라인수

$sql = "select distinct(bo_table), mb_id, my_datetime from g4_my_board where mb_id='{$member[mb_id]}' order by my_datetime desc";
$row = mysql_query($sql);
$total_count = mysql_num_rows($row); 
$total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산

echo "&nbsp;&nbsp;내가 본 게시판 : " . $total_count;

if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;

$list = array();
?>

<table  width="100%" cellpadding=0 cellspacing=0> 
<tr>      
  <td>
  <table>
  <tr height=28 align=center>
      <th width=50>번호</th>
      <th width=400>게시판 이름</th>
      <th width=200>날짜</th>
  </tr>
  <? 
  
  while($po_data = mysql_fetch_array($row)) 
   { 
        $sql2 = "select bo_subject from g4_board where bo_table = '$po_data[bo_table]'";
        $result2 = mysql_fetch_array(mysql_query($sql2));
   ?>
   <tr height=28 align=center>
      <td>
      <?=$total_count - ($page-1)*$one_rows + $i?>
      </td>
      <td align=left><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$po_data[bo_table]?>"><?=cut_str($result2[bo_subject], 50);?></a></td>
      <td><?=cut_str($po_data[my_datetime],10,"");?></td>      
  <?
  $i--;
  } 
  ?>
  </table>
  </td>
</tr> 
<tr><td height="10"></td></tr>
<tr>      
  <td>
  <? 
  $page = get_paging($config[cf_write_pages], $page, $total_page, "?&page="); 
  echo "$page";
  ?>
  </td>
</tr> 

</table> 

