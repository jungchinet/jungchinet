<?
if (!defined('_GNUBOARD_')) exit;

function latest_unicro($skin_dir="", $bo_table="", $rows=10, $mb_id="", $subject_len=40, $content_len="", $skin_title="", $skin_title_link="", $target="")
{
    global $g4, $is_admin, $member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    if ($target)
      $target_link = "target=" . $target;
    else
      $target_link = "target='inner1'";

    $list = array();

    if (trim($bo_table))
      $sql_where = " where bo_table = '$bo_table' ";
    else
      $sql_where = " where 1 ";

    if ($mb_id) {
      $sql_where .= " and mb_id = '$mb_id' "; 
    }
    
    $sql = " select bo_table, wr_id from $g4[unicro_item_table] $sql_where order by un_id desc limit 0, $rows ";
    $result = sql_query($sql);

    $j=0;
    while ($row = sql_fetch_array($result)) {
       	// 게시판 테이블
        $sql3 = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_new, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql3);

        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql2 = " select wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        
        $list[$j] = get_list($row2, $board, $latest_skin_path, $subject_len);
        $list[$j][bo_name] = $board[bo_subject];
        $j++;
    };
    
      
    if (!$skin_title) {
        if ($gr_id) { 
            $result4 = sql_fetch(" select gr_subject from $g4[group_table] where gr_id = '$gr_id' ");
            $skin_title = "$result4[gr_subject]";
        } else {
            $skin_title = "최근글";
        }
    }
        
    if (!$skin_title_link) {
        if ($gr_id)
          $skin_title_link = "$g4[bbs_path]/new.php?gr_id=$gr_id";
        else
          $skin_title_link = "#";
    }
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function latest_unicro_group($skin_dir="", $gr_id="", $rows=10, $mb_id="", $subject_len=40, $content_len="", $skin_title="", $skin_title_link="", $target="")
{
    global $g4, $member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    if ($target)
      $target_link = "target=" . $target;
    else
      $target_link = "target='inner1'";

    $list = array();

    if (trim($gr_id))
      $sql_where = " where b.gr_id = '$gr_id' ";
    else
      $sql_where = " where 1 ";

    if ($mb_id) {
      $sql_where .= " and a.mb_id = '$mb_id' "; 
    }
    
    //$sql = " select a.bo_table, a.wr_id from $g4[unicro_item_table] a left join $g4[board_new_table] b on a.bo_table = b.bo_table and a.wr_id = b.wr_id $sql_where order by a.un_id desc limit 0, $rows ";
    $sql = " select a.bo_table, a.wr_id from $g4[unicro_item_table] a left join $g4[board_table] b on a.bo_table = b.bo_table $sql_where order by a.un_id desc limit 0, $rows ";
    $result = sql_query($sql);

/*
    $j=0;
    while ($row = sql_fetch_array($result)) {
       	// 게시판 테이블
        $sql3 = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_new, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql3);

        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql2 = " select wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        
        $list[$j] = get_list($row2, $board, $latest_skin_path, $subject_len);
        $list[$j][bo_name] = $board[bo_subject];
        $j++;
    };
*/

    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_file_count ";
        $bo_select = " bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search ";
        if ($i == 0 )
            $sql2 .= " select $sql_select , $bo_select from $tmp_write_table a left join $g4[board_table] b on b.bo_table = '$row[bo_table]' where wr_id = '$row[wr_id]' ";
        else
            $sql2 .= " union all select $sql_select , $bo_select from $tmp_write_table a left join $g4[board_table] b on b.bo_table = '$row[bo_table]' where wr_id = '$row[wr_id]' ";
    }

    // Query set이 있는 경우에만 작업을
    if ($sql2) {
        $result2 = sql_query($sql2);
        for ($i=0; $row2 = sql_fetch_array($result2); $i++) {
            $write = $board = $row2;
            $list[$i] = get_list($write, $board, $latest_skin_path, $subject_len);
        }
    }   

    if (!$skin_title) {
        if ($gr_id) { 
            $result4 = sql_fetch(" select gr_subject from $g4[group_table] where gr_id = '$gr_id' ");
            $skin_title = "$result4[gr_subject]";
        } else {
            $skin_title = "최근글";
        }
    }
        
    if (!$skin_title_link) {
        if ($gr_id)
          $skin_title_link = "$g4[bbs_path]/new.php?gr_id=$gr_id";
        else
          $skin_title_link = "#";
    }
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
