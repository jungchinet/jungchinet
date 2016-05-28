<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($view[wr_nogood] >= $board[bo_2])
    alert("비추천을 많이 받은 글은 다운로드가 불가합니다.");
?>
