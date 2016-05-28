<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert_close("회원만 조회하실 수 있습니다.");

$bg_id = (int) $bg_id;

$result = sql_fetch(" select * from $g4[board_good_table] where bg_id = '$bg_id' and mb_id = '$member[mb_id]' ");
$tmp_write_table = $g4['write_prefix'] . $result[bo_table]; // 게시판 테이블 전체이름

// 당사자가 아니면 튕겨준다
if ($result['mb_id'] !== $member[mb_id])
    alert(" 타인의 글을 함부로 하면 안됩니다.");

// 지워준다
$sql = " delete from $g4[board_good_table] where bg_id = '$bg_id' and mb_id = '$member[mb_id]' ";
sql_query($sql);

// 게시글의 coount 조정
if ($result['bg_flag'] == "nogood")
    $sql = " update $tmp_write_table set wr_nogood = wr_nogood - 1 where wr_id = '$result[wr_id]' ";
else
    $sql = " update $tmp_write_table set wr_good = wr_good - 1 where wr_id = '$result[wr_id]' ";
sql_query($sql);

goto_url("./my_good.php?$qstr");
?>
