<?
include_once("./_common.php");

$singo_href = "./singo_search.php";
$href = "./login.php?$qstr&url=".urlencode("$singo_href");

// 회원만 사용이 가능하게
if (!$is_member) 
{
    echo "<script language='JavaScript'>alert('회원만 가능합니다.'); top.location.href = '$href';</script>";
    exit;
}

if (!$sg_id) 
{
    echo "<script language='JavaScript'>alert('부적절한 삭제요청 입니다.'); top.location.href = '$singo_href';</script>";
    exit;
}

// 신고테이블에서 게시판 테이블과 아이디를 읽어
$sql = " select bo_table, wr_id, mb_id from $g4[singo_table] where sg_id = '$sg_id' ";
$row = sql_fetch($sql);

// 그룹, 게시판 관리자 정보 가져오기
$board = sql_fetch(" select bo_admin, gr_id from $g4[board_table] where bo_table = '$row[bo_table]' ");
$group = sql_fetch(" select gr_admin from $g4[group_table] where gr_id = '$board[gr_id]' ");

// 신고 자료를 삭제
if ($is_admin == 'super' or $board['bo_admin'] == $member['mb_id'] or $group['gr_admin'] == $member['mb_id'])
    $member_sql = "";
else
    $member_sql = " and sg_mb_id = '$member[mb_id]' ";

$sql = " delete from $g4[singo_table] where sg_id = '$sg_id' $member_sql ";
sql_query($sql);

// 신고 필드의 신고 카운트를 수정한다
$sql = " select count(*) as cnt from $g4[singo_table] where bo_table = '$row[bo_table]' and wr_id = '$row[wr_id]' ";
$sg_result = sql_fetch($sql);
$write_table = $g4['write_prefix'].$row[bo_table];
$sql = " update $write_table set wr_singo = '$sg_result[cnt]' where wr_id = '$row[wr_id]' ";
sql_query($sql);
    
goto_url("$singo_href");
?>
