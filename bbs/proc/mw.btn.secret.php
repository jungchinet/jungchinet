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

// comment_id가 있는 경우는 comment_id를 잠궈주고, wr_option과 mb_id 값을 가져 옵니다.
if ($comment_id) {
    $wr_id = $comment_id;
    $result = sql_fetch(" select wr_option, mb_id from $write_table where wr_id = '$wr_id' ");
    $wr_option = $result[wr_option];
    $write["mb_id"] = $result[mb_id];
    $url = "../board.php?bo_table=$bo_table&wr_id=$wr_id#c_{$comment_id}&page=$page&mnb=$mnb&snb=$snb#board";
} else {
    $wr_option = $write["wr_option"];
    $url = "../board.php?bo_table=$bo_table&wr_id=$wr_id&page=$page&mnb=$mnb&snb=$snb#board";
}

if (!$is_admin && $write["mb_id"] != $member["mb_id"])
    alert("접근권한이 없습니다. - $write[mb_id]", $url);

if ($flag == 'no') 
{
    if (!strstr($wr_option, "secret"))
        alert("비밀글이 아닙니다.", $url);

    $wr_option = str_replace("secret", "", $wr_option);

    $msg = "비밀글 설정을 해제하였습니다.";
} 
else 
{
    if (strstr($wr_option, "secret"))
        alert("이미 잠겨져 있는 게시물입니다.", $url);

    if ($wr_option) {
        $wr_option = "$wr_option,secret";
    } else {
        $wr_option = "secret";
    }

    $msg = "게시물을 비밀글로 잠궜습니다.";
}

$sql = "update $write_table set wr_option = '$wr_option' where wr_id = '$wr_id'";
sql_query($sql);

alert($msg, $url);
?>
