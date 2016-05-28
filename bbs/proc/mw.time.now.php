<?
include_once("_common.php");

// post로 들어온 값을 변수로
$sst        = strip_tags($_POST[sst]);
$sod        = strip_tags($_POST[sod]);
$sfl        = strip_tags($_POST[sfl]);
$stx        = strip_tags($_POST[stx]);
$page       = (int) strip_tags($_POST[page]);
$token      = strip_tags($_POST[token]);
$mb_id      = strip_tags($_POST[mb_id]);
$bo_table   = strip_tags($_POST[bo_table]);
$wr_id      = strip_tags($_POST[wr_id]);
$comment_id = strip_tags($_POST[comment_id]);
$flag       = strip_tags($_POST[flag]);

// 필요한 정보가 없거나, 회원이 아니거나, 관리자 또는게시글 작성자가 아닌 경우
if (!$bo_table || !$wr_id || !$member[mb_id] || !($is_admin || $mb_id == $member['mb_id']))
    alert("부적절한 접근 입니다.");

$url = "../board.php?bo_table=$bo_table&wr_id=$wr_id&page=$page&mnb=$mnb&snb=$snb#board";

// 게시글을 업데이트
sql_query(" update $write_table set wr_datetime='$g4[time_ymdhis]' where wr_id='$wr_id'");

// 최근글을 업데이트
$sql = " select * from $g4[board_new_table] where bo_table='$bo_table' and wr_id='$wr_id'";
$result = sql_fetch($sql);

// 일단 새로운거 먼저 insert 하고,
$sql = "insert into $g4[board_new_table] 
                set bo_table        = '$bo_table',
                    wr_id           = '$wr_id',
                    wr_parent       = '$result[wr_parent]',
                    bn_datetime     = '$g4[time_ymdhis]',
                    mb_id           = '$result[mb_id]',
                    parent_mb_id    = '$result[parent_mb_id]',
                    wr_is_comment   = '$result[wr_is_comment]',
                    gr_id           = '$result[gr_id]',
                    wr_option       = '$result[wr_option]',
                    my_datetime     = '$g4[time_ymdhis]'
                    ";
sql_query($sql);

// 최신글 정보가 있는 경우에만 옛날꺼를 삭제 해야하죠? ㅋㅋ
if ($result) {
    $sql = " delete from $g4[board_new_table] where bn_id = '$result[bn_id]' ";
    sql_query($sql);
}

$msg = "게시글 및 최신글 정보를 현재시간으로 업데이트 하였습니다";

alert($msg, $url);
?>
