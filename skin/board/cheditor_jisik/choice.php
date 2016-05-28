<?
include_once("./_common.php");

//print_r2($GLOBALS);


if ($write[wr_2]) {
    echo "<script language='javascript'>alert('이미 채택 되었습니다.');window.close();</script>";
    exit;
}

$sql = " select * from $write_table 
          where wr_parent = '$wr_id'
            and wr_id = '$comment_id' ";
$comment = sql_fetch($sql);
//print_r2($comment); exit;
//echo $sql; exit;

// 게시물번호가 같고 자신의 게시물과 같은 회원아이디라면
// 코멘트 아이디가 존재하는것이라면
if ($write[wr_id] && $write[wr_id] == $wr_id && 
    $member[mb_id] && $member[mb_id] == $write[mb_id] &&
    $comment[wr_id] && $comment[wr_id] == $comment_id) {
    // 채택된 회원에게 bo_3에 지정된 포인트 비율만큼을 지급한다
    insert_point($comment[mb_id], (int)($write[wr_1] * $board[bo_3]), "$board[bo_subject] $wr_id 답변채택", $bo_table, $wr_id, '답변채택');
    //insert_point($comment[mb_id], (int)($write[wr_1] * 0.9), "$board[bo_subject] $wr_id 답변채택", $bo_table, $wr_id, '답변채택');

    $sql = " update $write_table 
                set wr_2 = '$comment_id',
                    wr_3 = '$comment[mb_id]'
              where wr_id = '$wr_id' ";
    sql_query($sql);

//    echo "<script language='javascript'>alert('답변을 채택후 포인트를 부여하였습니다.');window.close();</script>";
    echo "<script language='javascript'>top.location.reload();alert('답변을 채택 하였습니다.');</script>";
    exit;
} else {
    echo "<script language='javascript'>alert('오류');window.close();</script>";
    exit;
}    
?>
