<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($is_admin !== "super") {
    if (!$member[mb_id])
        alert("접근 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]?bo_table=$bo_table"));
    else {
        $sfl = "mb_id";
        $stx = "$member[mb_id]";
    }
}
?>
