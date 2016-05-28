<?
if (!defined('_GNUBOARD_')) exit;

// 최신 다운로드 추출
function latest_download($skin_dir="", $gr_id="", $bo_table="", $rows=10, $subject_len=40, $gallery_view=0, $options="")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    if ($options=="rand")
        $sql_order = " order by rand() ";
    else
        $sql_order = " order by dn_id desc ";

    // 최근의 download history
    if ($gr_id) {
        $sql = " select bo_table, wr_id from " . $g4[board_file_table] ."_download where gr_id='$gr_id' $sql_order limit $rows ";
    } else if ($bo_table) {
        $sql = " select bo_table, wr_id from " . $g4[board_file_table] ."_download where bo_table='$bo_table' $sql_order desc limit $rows ";
    } else {
        $sql = " select bo_table, wr_id from " . $g4[board_file_table] . "_download $sql_order limit $rows ";
    }
    $result = sql_query($sql);

    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql);
        $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
        $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";
        $sql2 = " select $sql_select from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        $list[$i] = get_list($row2, $board, $latest_skin_path, $subject_len, $gallery_view);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 인기 download 추출
function popular_download($skin_dir="", $gr_id="", $bo_table="", $rows=10, $subject_len=40, $days=1, $gallery_view=0, $options="")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    // 며칠동안 다운로드?
    $sql_days = " and dn_datetime > '" . date("Y-m-d h:i:s", $g4[server_time] - ($days * 86400)) ."' ";

    // 최근의 download history
    if ($gr_id) {
        $sql = " select bo_table, wr_id, count(*) as cnt from " . $g4[board_file_table] ."_download where gr_id='$gr_id' $sql_days group by bo_table, wr_id order by cnt desc limit $rows ";
    } else if ($bo_table) {
        $sql = " select bo_table, wr_id, count(*) as cnt from " . $g4[board_file_table] ."_download where bo_table='$bo_table' $sql_days group by wr_id  order by cnt desc limit $rows ";
    } else {
        $sql = " select bo_table, wr_id, count(*) as cnt from " . $g4[board_file_table] . "_download where 1 $sql_days group by bo_table, wr_id order by cnt desc limit $rows ";
    }
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql);
        $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
        $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";
        $sql2 = " select $sql_select from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        $list[$i] = get_list($row2, $board, $latest_skin_path, $subject_len, $gallery_view);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
