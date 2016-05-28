<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/_head.php");

$one_rows = "25";  // 한줄에 출력할 라인수

$sql = " select count(*) as cnt from $g4[point_table] 
                where (po_rel_table not like '@%' and mb_id='{$member[mb_id]}' and po_rel_action='읽기') ";
$row = sql_fetch($sql); 
$total_count = $row[cnt]; 
$total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산

echo "&nbsp;&nbsp;내가 읽은 게시글 : " . $total_count;

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
  //게시판에서 자기가 본글추출: 포인트테이블 이용.  
  $sql = "select * from $g4[point_table]
            where (po_rel_table not like '@%'
                  and mb_id='{$member[mb_id]}' and po_rel_action='읽기') 
            order by po_datetime desc 
            limit $from_record, $one_rows
        ";
  $result = sql_query($sql);
  $i=0;
  while($po_data = sql_fetch_array($result)) 
   { 
        $write_table = $g4['write_prefix'] . $po_data[po_rel_table];
        $sql2 = " select wr_id, wr_parent, wr_subject, wr_name, wr_datetime
                          from $write_table where wr_id = '$po_data[po_rel_id]' ";
        $result2 = sql_fetch($sql2);
   ?>
   <tr height=28 align=center>
      <td>
      <?=$total_count - ($page-1)*$one_rows + $i?>
      </td>
      <td align=left><a href="<?=$g4[bbs_path]?>/board.php?bo_table=<?=$po_data[po_rel_table]?>&wr_id=<?=$result2[wr_id]?>"><?=cut_str($result2[wr_subject], 50);?></a></td>
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

