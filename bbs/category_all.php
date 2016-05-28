<?
include_once("./_common.php");

// 불당팩 - 게시판 관리자가 카테고리를 모두 싹~ 한번에 바꿔버립니다.

$tmp_array = array();
if ($wr_id) // 건별 지정
    $tmp_array[0] = $wr_id;
else // 일괄변경
    $tmp_array = $_POST[chk_wr_id];

$sca = mysql_real_escape_string(trim($_POST[sca]));
if ($sca == "" || $is_admin == "")
    alert("카테고리 일괄 수정 오류 입니다.");

// 거꾸로 읽는 이유는 delete_all.php를 수정했기 때문. 다른 이유 없슴
for ($i=count($tmp_array)-1; $i>=0; $i--) 
{
    $sql = " update $write_table set ca_name='$sca' where wr_parent = '{$tmp_array[$i]}' ";
    sql_query($sql);
}

goto_url("./board.php?bo_table=$bo_table&page=$page" . $qstr);
?>
