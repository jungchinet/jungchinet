<?
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!$member[mb_id]) 
  alert("회원만 사용할 수 있습니다");

$tmp_write_table = $g4[write_prefix] . $bo_table; // 게시판 테이블 전체이름
if ($is_admin)
  $sql = " update $tmp_write_table set wr_10 = '$wr_10' where wr_id='$wr_id' ";
else
  $sql = " update $tmp_write_table set wr_10 = '$wr_10' where wr_id='$wr_id' and mb_id='$member[mb_id]' ";
sql_query($sql);

goto_url("$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id");
?>
