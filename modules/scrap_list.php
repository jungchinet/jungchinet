<?
include_once("./_common.php");

// 회원만 사용이 가능하게
if (!$is_member) 
{
    $href = "./login.php?$qstr&url=".urlencode("./singo_search.php");

    echo "<script language='JavaScript'>alert('회원만 가능합니다.'); top.location.href = '$href';</script>";
    exit;
}

include_once("$g4[path]/_head.php");

$sql_common = " from $g4[scrap_table] GROUP BY bo_table, wr_id ";

if (!$sst) {
    $sst = "ms_datetime";
    $sod = "desc";
}
      
$sql_order = " order by $sst $sod ";

$one_rows = "20";  // 한줄에 출력할 라인수

$sql = " SELECT count( * ) AS cnt $sql_common ";
$result = sql_query($sql); 
$total_count = mysql_num_rows($result); 
$total_page  = ceil($total_count / $one_rows);  // 전체 페이지 계산

echo "&nbsp;&nbsp;게시글 스크랩 : " . $total_count;

if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지) 
$from_record = ($page - 1) * $one_rows; // 시작 열을 구함
$to_record = $from_record + $one_rows ;

$list = array();
?>

<form name=fsingolist method=post style="margin:0px;">
<input type=hidden name=sst  value='<?=$sst?>'>
<input type=hidden name=sod  value='<?=$sod?>'>
<input type=hidden name=page value='<?=$page?>'>

<table  width="100%" cellpadding=0 cellspacing=0> 
<tr>      
  <td>
  <table>
  <tr height=28 align=center>
      <td width=50><?=subject_sort_link('ms_id')?>번호</a></td>
      <td>제목</td>
      <td width=110>글쓴이</td>
      <td width=40><?=subject_sort_link('ms_datetime')?>날짜</a></td>
      <td width=60><?=subject_sort_link('cnt')?>스크랩횟수</a></td>
  </tr>
  <? 
  //게시판에서 자기가 본글추출: 포인트테이블 이용.  
  $sql = "SELECT * , count( * ) AS cnt 
            $sql_common 
            $sql_order 
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
      <td align=left><a href="<?=$g4[bbs_path]?>/board?bo_table=<?=$row[bo_table]?>&wr_id=<?=$result2[wr_id]?>"><?=cut_str($result2[wr_subject], 50);?></a></td>
      <td><?=$result2[wr_name];?></td>
      <td><?=cut_str($result2[wr_datetime],10,"");?></td>
      <td><?=$row[cnt];?></td>
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
</form>
