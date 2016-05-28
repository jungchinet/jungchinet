<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($is_admin !== "super") {
    if (!$is_member)
        alert("비회원은 접속할 수 없습니다 ");
    else if ($write[mb_id] !== $member[mb_id])
        // 애러 메시지를 야릇하게. ㅎㅎ
        alert("알수없는 오류 입니다. 운영자에게 문의하세요.", $g4[url]); 
}
?>
