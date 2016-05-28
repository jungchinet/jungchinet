<?
// 경로줄이기 - http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=20648
include_once("_common.php");

// 나쁜 xx들의 공격을 방어하기 위해서
$bo_table = strip_tags($bo_table);
$wr_id = strip_tags($wr_id);
$c = strip_tags($c);

$url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table";
if ($wr_id)
    $url .= "&wr_id=$wr_id";
if ($c)
    $url .= "#c_$c";

goto_url($url);
?>
