<?
include_once("_common.php");

$w = preg_match("/^[a-zA-Z0-9_]+$/", $w) ? $w : "";
$wo_in = (int) $wo_id;
$mb_id = $member[mb_id];
$head = (int) $head;
$page = (int) $page;
$rows = (int) $rows;
$check = (int) $check;
$url_prev = strip_tags($url_prev);

switch($w) {
  case 'd' :
      $sql = " delete from $g4[whatson_table] where wo_id = '$wo_id' and mb_id = '$mb_id' ";
      sql_query($sql);

      $url = "$g4[bbs_path]/whatson.php?head=$head&page=$page&check=$check&rows=$rows";
      if ($url_prev)
          $url = $url_prev . $url;

      goto_url("$url");
      exit;
  case 'r' :
      // 이시점에서 왔숑~의 글이 그대로 있는지 확인할 필요가 있습니다.
      // 코멘트의 경우, 경우의 수가 너무 많아서 왔숑의 처리를 안하고, 기타 사유로 글이 없어지기도 하거든요.
      $sql = " select * from $g4[whatson_table] where wo_id = '$wo_id' and mb_id = '$mb_id' ";
      $wo = sql_fetch($sql);

      $tmp_write_table = $g4['write_prefix'] . $wo[bo_table];  // 게시판 테이블 전체이름

      // 선택한 왔숑~의 원글이 존재하는지를 확인
      $sql = " select * from $tmp_write_table where wr_id='$wo[wr_id]' ";
      $wr_result = sql_fetch($sql);
      
      if (!$wr_result[wr_id])
          sql_query(" delete from $g4[whatson_table] where wo_id = '$wo_id' and mb_id = '$mb_id' ");

      // 코멘트의 경우, 본인의 코멘트가 있는지 확인
      if ($wo['comment_id']) {
          $sql = " select * from $tmp_write_table where wr_id='$wo[comment_id]' ";
          $co_result = sql_fetch($sql);

          if (!$co_result[wr_id])
              sql_query(" delete from $g4[whatson_table] where wo_id = '$wo_id' and mb_id = '$mb_id' ");
      }

      $sql = " update $g4[whatson_table] set wo_status=1 where wo_id = '$wo_id' and mb_id = '$mb_id' ";
      sql_query($sql);

      echo "000";
  default :
}
?>
