<?
include_once("./_common.php");

include_once("$g4[path]/_head.php");

if ($my) {
  $my_sql = "and my_datetime != '0000-00-00 00:00:00'"; // 내글의 반응
  $title = "내글에 대한 반응";
  $order_sql = " order by my_datetime desc ";
} else {
  $my_sql = "";
  $title = "내가 올린 글";
  $order_sql = " order by bn_id desc ";
}

$one_rows = "25";  // 한줄에 출력할 라인수

$sql = " select count(*) as cnt from $g4[board_new_table] 
          where mb_id = '$member[mb_id]'  and wr_is_comment = '0' 
                $my_sql ";
$row = sql_fetch($sql); 
$total_count = $row[cnt]; 
$total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산

echo "&nbsp;&nbsp;$title : " . $total_count;

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
      <td width=50>번호</td>
      <td>제목</td>
      <td width=110>글쓴이</td>
      <td width=40>날짜</td>
  </tr>
  <? 
  $sql = " select * from $g4[board_new_table] 
            where mb_id = '$member[mb_id]'  and wr_is_comment = '0' 
            $my_sql  
            $order_sql
            limit $from_record, $one_rows
          ";
  $result = sql_query($sql);

  $i=0;
  while($row = sql_fetch_array($result)) 
   { 
        $write_table = $g4['write_prefix'] . $row[bo_table];
        $sql2 = " select wr_id, wr_parent, wr_subject, wr_name, wr_datetime
                          from $write_table where wr_id = '$row[wr_id]' ";
        $result2 = sql_fetch($sql2);
   ?>
   <tr height=28 align=center>
      <td>
      <?=$total_count - ($page-1)*$one_rows + $i?>
      </td>
      <td align=left><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$row[bo_table]?>&wr_id=<?=$result2[wr_id]?>"><?=cut_str($result2[wr_subject], 50);?></a></td>
      <td><?=$result2[wr_name];?></td>
      <td><?=cut_str($result2[wr_datetime],10,"");?></td>      
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
