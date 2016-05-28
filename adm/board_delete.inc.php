<?
// board_delete.php , boardgroup_delete.php 에서 include 하는 파일

if (!defined("_GNUBOARD_")) exit;
if (!defined("_BOARD_DELETE_")) exit; // 개별 페이지 접근 불가 

// $tmp_bo_table 에는 $bo_table 값을 넘겨주어야 함
if (!$tmp_bo_table) { return; }

// 게시판 1개는 삭제 불가 (게시판 복사를 위해서)
//$row = sql_fetch(" select count(*) as cnt from $g4[board_table] ");
//if ($row[cnt] <= 1) { return; }

// 게시판 설정 삭제
sql_query(" delete from $g4[board_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 최신글 삭제
sql_query(" delete from $g4[board_new_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 스크랩 삭제
sql_query(" delete from $g4[scrap_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 파일 삭제
sql_query(" delete from $g4[board_file_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 게시판 테이블 DROP
sql_query(" drop table $g4[write_prefix]$tmp_bo_table ", FALSE);

// 게시판 폴더 전체 삭제
rm_rf("$g4[data_path]/file/$tmp_bo_table");

// 불당팩 - 게시판 바로가기 삭제
sql_query(" delete from $g4[my_menu_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 불당팩 - 신고내역 삭제
sql_query(" delete from $g4[singo_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 불당팩 - 인기글 삭제
sql_query(" delete from $g4[popular_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 불당팩 - 내가 방문한 게시판 삭제
sql_query(" delete from $g4[my_board_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 불당팩 - 게시판 방문자 통계 삭제
sql_query(" delete from $mw[board_visit_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 포인트 삭제 하기전에 sum 포인트를 압축해서 넣어준다
$sql = " select mb_id, sum(po_point)as po_sum from $g4[point_table] where po_rel_table = '$tmp_bo_table' group by mb_id ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result))
{
    insert_point($row[mb_id], $row[po_sum], "$board[bo_subject] 삭제로 인한 포인트정리", $bo_table, '', '게시판삭제 포인트정리');
}
sql_query(" delete from $g4[point_table] where po_rel_table = '$tmp_bo_table' and rel_action <> '게시판삭제 포인트정리' ", FALSE);

// 추천 정보 삭제
sql_query(" delete from $g4[board_good_table] where bo_table = '$tmp_bo_table' ", FALSE);

// whatson 삭제
sql_query(" delete from $g4[whatson_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 베스트글 삭제
sql_query(" delete from $g4[good_list_table] where bo_table = '$tmp_bo_table' ", FALSE);

// chimage 삭제
sql_query(" delete from $g4[board_cheditor_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 인기검색어 합계 삭제
sql_query(" delete from $g4[popular_sum_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 전체공지 테이블 삭제
sql_query(" delete from $g4[notice_table] where bo_table = '$tmp_bo_table' ", FALSE);

// 불당팩 - 다운로드 내역 삭제, 요고는 case by case라서 코멘트로 해둔다.
$g4[board_file_download_table] = $g4[board_file_table] . "_download";
//sql_query(" delete from $g4[board_file_download_table] where po_rel_table = '$tmp_bo_table' ");

// SEO 키워드 삭제
sql_query(" delete from $g4[seo_tag_table] where bo_table = '$tmp_bo_table' ", FALSE);
sql_query(" delete from $g4[seo_history_table] where bo_table = '$tmp_bo_table' ", FALSE);

//RSS 정보 삭제
sql_query(" delete from rss_info where bo_table = '$tmp_bo_table' ", FALSE);

?>
