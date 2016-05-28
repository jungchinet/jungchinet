<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($w == '') {
    insert_point($member[mb_id], $wr_1 * -1, "$board[bo_subject] $wr_id 포인트걸기", $bo_table, $wr_id, '포인트걸기');
}
?>
