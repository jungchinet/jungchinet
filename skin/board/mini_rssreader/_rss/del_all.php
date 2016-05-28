<?
$g4_path = "../../../..";
require_once "$g4_path/common.php";

// 글 정리 /////////////////////////////////////////////////////////////////////////////////////
if($is_admin == "super" && $w == 'cl' && $bo_table) {
	$sql = "select count(*) from $write_table";
	$tmp = sql_fetch($sql);

	$sql = "delete from $write_table";
	sql_query($sql);

	sql_query(" update $g4[board_table] set bo_count_write = 0, bo_count_comment = 0 where bo_table = '$bo_table' ");

	// 최근게시물 삭제
    sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table'");
    
	// 스크랩 삭제
    sql_query(" delete from $g4[scrap_table] where bo_table = '$bo_table'");

	echo "<script>alert('모든 글을 삭제하였습니다.')</script>";
	echo "<script>location.href=\"$g4[bbs_path]/board.php?bo_table={$bo_table}\"</script>";
}

?>