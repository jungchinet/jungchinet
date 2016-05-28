<?
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "그누보드4 -> 불당팩 업그레이드";
include_once("./admin.head.php");

// 쪽지4 관련 설정 읽어들이기
include_once("../memo.config.php");

// 최신글 게시판을 업데이트 (그룹정보 추가)
$sql = " select distinct bo_table from $g4[board_new_table] ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result))
{    
    $sql2 = " select gr_id from $g4[board_table] where bo_table = '$row[bo_table]' ";
    $result2 = sql_fetch($sql2);
    
    $sql3 = "update $g4[board_new_table] set gr_id = '$result2[gr_id]' where bo_table = '$row[bo_table]' ";
    sql_query($sql3);
}
echo "<br>최근글 게시판 - gr_id UPGRADE 완료.";

// 최신글 게시판을 업데이트 (코멘트 관련정보 추가)
$sql = " select bn_id, bo_table, wr_id from $g4[board_new_table] ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result))
{    
    $tmp_write_table = $g4[write_prefix] . $row[bo_table];
    $sql2 = " select wr_is_comment from $tmp_write_table where wr_id = '$row[wr_id]' ";
    $result2 = sql_fetch($sql2);
    
    $sql3 = "update $g4[board_new_table] set wr_is_comment = '$result2[wr_is_comment]' where bn_id = '$row[bn_id]' ";
    sql_query($sql3);
}
echo "<br>최근글 게시판 - wr_is_comment UPGRADE 완료.";

// 튜닝 (board_table : wr_file_count)
include_once("./upgrade_turning1.php");

// 튜닝 (board_table : min_wr_num)
include_once("./upgrade_turning2.php");

// 튜닝 (member_table : mb_auth_count)
include_once("./upgrade_turning3.php");

// 튜닝 (게시판의 index 추가)
include_once("./upgrade_board_index.php");

// 튜닝 (게시판의 ccl 추가)
include_once("./upgrade_ccl.php");

// 튜닝 (게시판의 쓰기 index)
include_once("./upgrade_turning_write_idx.php");

// 관련글
include_once("./upgrade_related.php");

// 닉네임 히스토리
include_once("./upgrade_mb_nick.php");

// 스크랩 
include_once("./upgrade_scrap.php");

// 신고
include_once("./upgrade_singo.php");

include_once("./admin.tail.php");
?>
