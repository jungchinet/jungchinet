<?
if (!defined('_GNUBOARD_')) exit;

// 팝업창 추출
function popup($skin_dir="", $bo_table, $cate="", $gallery_view=0, $options="")
{
    global $g4, $is_admin;

    if ($skin_dir)
        $popup_skin_path = "$g4[path]/skin/popup/$skin_dir";
    else
        $popup_skin_path = "$g4[path]/skin/popup/basic";

    $list = array();

    // 필요한 field만 select
    $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$bo_table'";
    $board = sql_fetch($sql);

    // ca_name이 일치하고, 날짜가 범위내에 있고, 비밀글이 아닌 것만 골라 냅니다. 비밀글은 출력을 안합니다.
    if ($is_admin != "super")
        $secret_sql = " and wr_option not like '%secret%' ";

    if ($board[bo_use_category] && $cate)
        $cate_sql = " and ca_name = '$cate' ";
    else
        $cate_sql = " ";

    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $wr_select = "wr_id, wr_subject, wr_content, wr_file_count, wr_link1, wr_link2, wr_datetime, wr_option, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10";
    $sql = " select $wr_select from $tmp_write_table where ('$g4[time_ymdhis]' between wr_1 and wr_2) $secret_sql $cate_sql order by wr_num desc ";
    $result = sql_query($sql);

    // 제목이 짤리는 것은 이상하므로 제목을 무조건 모두 출력하게 설정 합니다. 값이 지정되지 않으면 40글자에서 짤립니다.
    $subject_len="255";
    
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $list[$i] = get_list($row, $board, $popup_skin_path, $subject_len, $gallery_view);
     
        // 쿠키일수가 없으면 무조건 7일로 설정 
        if (!$list[$i][wr_7])
        {
            sql_query(" update $tmp_write_table set wr_7 = '7' where wr_id = '{$list[$i][wr_id]}' ");
            $list[$i]['wr_7'] = 7;
        }
    }

    ob_start();
    include "$popup_skin_path/popup.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
