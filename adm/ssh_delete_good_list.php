<?
include_once("./_common.php");

$g4[title] = "베스트 게시물 일괄 삭제(Flag Off만 하고 게시글 삭제는 안합니다)" . $act;
include_once("$g4[path]/head.sub.php");

// 참조 : /bbs/delete_all.php (해당 코드가 변경되면 이 코드도 반드시 수정해야 함)

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($sw == "d" || $sw == "r")
    ;
else
    alert("바르지 못한 사용입니다.");

// $_POST[chk_wr_id] : $list[$i][wr_id]}|{$list[$i][bo_table]}

$tmp_array = array();
if ($gp_id) // 건별삭제
    $tmp_array[0] = $gl_id;
else // 일괄삭제
    $tmp_array = $_POST[chk_gl_id];

for ($i=count($tmp_array)-1; $i>=0; $i--) {

    if ($sw == "r") {
        $sql = " update $g4[good_list_table] set gl_flag = 0 where gl_id = '{$tmp_array[$i]}' ";
        $write = sql_query($sql);
        $gl_flag = 1;
    } else {
        $sql = " update $g4[good_list_table] set gl_flag = 1 where gl_id = '{$tmp_array[$i]}' ";
        $write = sql_query($sql);
        $gl_flag = 0;
    }

} // for loop의 끝

goto_url("$g4[bbs_path]/good_list.php?gr_id=$gr_id&bo_table=$bo_table&gl_flag=$gl_flag&page=$page" . $qstr);
?>
