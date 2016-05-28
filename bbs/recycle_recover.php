<?
include_once("./_common.php");

// id를 체크 합니다.
if (!$member[mb_id])
    alert("회원이 아닙니다.");

include_once("$g4[admin_path]/recycle_recover.inc.php");
?>
