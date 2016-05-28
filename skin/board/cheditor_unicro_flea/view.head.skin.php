<?
if ($member[mb_id] && !$is_admin)
    if ($member['mb_seller_datetime'] !== "0000-00-00 00:00:00") {
        $board[bo_use_good] = false;
        $board[bo_use_nogood] = false;
}
?>
