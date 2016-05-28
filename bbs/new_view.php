<?
include_once("./_common.php");

$g4[title] = "최근 게시물";

// 무조건 목록이 나오지 않게
$board[bo_use_list_view] = 0;

// 파일이나 그런거 인클루드 하지 못하게
$board[bo_include_head] = 0;
$board[bo_image_head] = 0;
$board[bo_content_head] = 0;

$board[bo_include_tail] = 0;
$board[bo_image_tail] = 0;
$board[bo_content_tail] = 0;

include_once("./_head.php");

include_once("./board.php");

if ($g4['new_use_list_view'])
    include_once("./new.php");

include_once("./_tail.php");
?>

<script type="text/javascript">
var btn_hide = function() {
    $('img[src*="btn_copy.gif"]').hide();
    $('img[src*="btn_move.gif"]').hide();
    $('img[src*="btn_prev.gif"]').hide();
    $('img[src*="btn_next.gif"]').hide();
    $('img[src*="btn_write.gif"]').hide();
    //$('img[src*="btn_reply.gif"]').hide();
    //$('img[src*="btn_modify.gif"]').hide();
    //$('img[src*="btn_del.gif"]').hide();
    $('img[src*="btn_list.gif"]').closest('a').attr("href", "<?=$g4[bbs_path]?>/new.php?page=<?=$page?>&bo_table_search=<?=$bo_table_search?>&qstr=<?=$qstr?>");
};

$(function() {
    btn_hide();
});
</script>
