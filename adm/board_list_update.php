<?
$sub_menu = "300100";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $chk[$i];

    if ($is_admin != "super")
    {
        $sql = " select count(*) as cnt from $g4[board_table] a, $g4[group_table] b
                  where a.gr_id = '{$_POST['gr_id'][$k]}' 
                    and a.gr_id = b.gr_id 
                    and b.gr_admin = '$member[mb_id]' ";
        $row = sql_fetch($sql);
        if (!$row[cnt])
            alert("최고관리자가 아닌 경우 다른 관리자의 게시판($board_table[$k])은 수정이 불가합니다.");
    }

    // 게시판 그룹이 변경 되었는지 확인
    $bo_table = $_POST[board_table][$k];
    $board = get_board($bo_table);  // 현재의 gr_id
    $gr_id = $_POST[gr_id][$k];     // form에서 넘어온 gr_id
    if ($board[gr_id] !== $gr_id) {
        // 최근글의 gr_id 변경
        sql_query(" update $g4[board_new_table] set gr_id='$gr_id' where bo_table = '$bo_table' ");

        // 베스트글의 gr_id 변경
        sql_query(" update $g4[good_list_table] set gr_id='$gr_id' where bo_table = '$bo_table' ");
        
        // 첨부파일 다운로드의 gr_id 변경
        sql_query(" update $g4[board_file_download_table] set gr_id='$gr_id' where bo_table = '$bo_table' ");
        
        // 게시판별 방문자의 gr_id 변경
        //sql_query(" update $mw[board_visit_table] set gr_id='$gr_id' where bo_table = '$bo_table' ");
    }

    $sql = " update $g4[board_table]
                set gr_id               = '{$_POST['gr_id'][$k]}',
                    bo_subject          = '{$_POST['bo_subject'][$k]}',
                    bo_skin             = '{$_POST['bo_skin'][$k]}',
                    bo_read_point       = '{$_POST['bo_read_point'][$k]}',
                    bo_write_point      = '{$_POST['bo_write_point'][$k]}',
                    bo_comment_point    = '{$_POST['bo_comment_point'][$k]}',
                    bo_download_point   = '{$_POST['bo_download_point'][$k]}',
                    bo_use_search       = '{$_POST['bo_use_search'][$k]}',
                    bo_order_search     = '{$_POST['bo_order_search'][$k]}'
              where bo_table            = '{$_POST['board_table'][$k]}' ";
    sql_query($sql);
}

goto_url("./board_list.php?$qstr");
?>
