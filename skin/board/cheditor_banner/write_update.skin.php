<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 자신만의 코드를 넣어주세요.

// 게시글 등록시 사용자의 포인트를 차감
if ($board[bo_4]) {
    // 게시물당 한번만 차감하도록 수정
    insert_point($member[mb_id], -1 * $board[bo_4], "$board[bo_subject] $wr_id 배너등록", $bo_table, $wr_id, "배너등록");
}
?>
