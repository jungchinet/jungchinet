<?
include_once("./_common.php");

// id를 체크 합니다.
if (!$member[mb_id])
    alert("회원이 아닙니다.");

if ($write[mb_id] !== $member[mb_id])
    alert("휴지통에 있는 타인의 글은 조회할 수 없습니다.");

// 게시판의 스킨을 원본으로 합니다.
$bo = get_board($org_bo_table, "bo_skin");
$board['bo_skin'] = $bo['bo_skin'];

$board_skin_path = "{$g4['path']}/skin/board/{$bo['bo_skin']}"; // 게시판 스킨 경로

chdir($g4[bbs_path]);

include_once("../head.sub.php");

include_once("./view.php");

include_once("../tail.sub.php");
?>
