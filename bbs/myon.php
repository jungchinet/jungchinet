<?
include_once("./_common.php");

$g4[title] = "$config[cf_title] - My on";

$head = (int) $head;
$rows = (int) $rows;

if ($member[mb_id]) 
    ;
else 
    alert("MyOn은 회원을 위한 서비스 입니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?url=".urlencode("myon.php?head=$head"));

if ($head)
    include_once("../head.sub.php");
else
    include_once("./_head.php");

// 스킨을 $_GET으로 값을 넘겨준다
$myon_skin = strip_tags($myon_skin);
if ($myon_skin)
    $skin = $myon_skin;
else
    $skin = "basic";

if ($rows > 0) {
    if ($rows > 50)
        $rows = 50;
}
else
    $rows = 20;

// 최근 Whats On
$sql = " select * from $g4[whatson_table] where mb_id='$member[mb_id]' order by wo_id desc limit 0, $rows";
$whatson_result = sql_query($sql);

// 내가 방문한 게시판
$sql = " select b.bo_table, b.bo_subject, a.my_datetime from $g4[my_board_table] a left join $g4[board_table] b on a.bo_table = b.bo_table
          where a.mb_id = '$member[mb_id]' group by b.bo_table order by a.my_datetime desc limit 0, $rows ";
$myboard_result = sql_query($sql);

// 최근 게시글
$sql = " select * from $g4[board_new_table]
          where mb_id = '$member[mb_id]' and wr_is_comment = '0' order by bn_id desc limit 0, $rows ";
$recent_result = sql_query($sql);

// 최근 코멘트
$sql = " select * from $g4[board_new_table]
          where mb_id = '$member[mb_id]' and wr_is_comment = '1' order by bn_id desc limit 0, $rows ";
$comment_result = sql_query($sql);

// 내글의 반응
$sql = " select bo_table, wr_id from $g4[board_new_table] 
          where mb_id = '$member[mb_id]'  and wr_is_comment = '0' and my_datetime not like '0%' and bn_datetime > '$sql_datetime' 
          order by my_datetime desc limit 0, $rows ";
$my_result = sql_query($sql);

// 휴지통
$sql = " select * from $g4[recycle_table] where rc_wr_id = rc_wr_parent and mb_id = '$member[mb_id]' order by rc_no desc limit 0, $rows ";
$recycle_result = sql_query($sql);

// 신고된 글
$sql = " select * from $g4[singo_table] where mb_id= '$member[mb_id]' order by sg_id desc limit 0, $rows ";
$singoed_result = sql_query($sql);

// 신고한 글
$sql = " select * from $g4[singo_table] where sg_mb_id= '$member[mb_id]' order by sg_id desc limit 0, $rows ";
$singo_result = sql_query($sql);

// 최근 포인트
$sql = " select * from $g4[point_table] where mb_id='$member[mb_id]' order by po_id desc limit 0, $rows";
$point_result = sql_query($sql);


$myon_skin_path = "$g4[path]/skin/myon/$skin";

include_once("$myon_skin_path/myon.skin.php");

if ($head)
    include_once("./_tail.php");
else
    include_once("../tail.sub.php");
?>
