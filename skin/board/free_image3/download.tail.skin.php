<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 자신이 다운로드 받는 경우 차감한 포인트를 삭제한다
if ($is_admin || ($write[mb_id] == $member[mb_id] && $member[mb_id]))
//    $write[wr_datetime] < date("Y-m-d H:i:s", $g4[server_time] - 86400 * 30))
{
    delete_point($member[mb_id], $bo_table, $wr_id, '다운로드');
}
else
{
    // 한달이 지나지 않은 게시물
    //echo "if ($write[wr_datetime] > date(\"Y-m-d\", $g4[server_time] - 86400 * 30)) {"; exit;
    if ($write[wr_datetime] > date("Y-m-d", $g4[server_time] - 86400 * 30)) {
        // 게시자에게 포인트 50% 부여
        insert_point($write[mb_id], (int)(abs($board[bo_download_point])/2), "{$member[mb_nick]}님이 $board[bo_subject] $wr_id 파일 다운로드", $bo_table, $wr_id, "{$member[mb_nick]}님이 다운로드");
    }
}
?>
