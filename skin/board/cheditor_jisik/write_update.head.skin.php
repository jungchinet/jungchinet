<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($w == '') {
    if ($wr_1 > $member[mb_point]) {
        alert('회원님의 보유포인트보다 포인트를 더 많이 거실 수 없습니다.');
    }
}
?>
