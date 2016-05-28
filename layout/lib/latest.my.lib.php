<?
if (!defined('_GNUBOARD_')) exit;

// 나의 최신글 갯수
function count_latest_my($time=0, $options="")
{
    global $g4, $member;

    // 비회원이면 return
    if ($member[mb_id] == "")
        return 0;

    if ($time > 0) {
        $sql_datetime = "bn_datetime > ". date("Y-m-d H:i:s", $g4['server_time'] - ($time * 86400));
    }
    if ($options == "comment")
        $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$member[mb_id]' and wr_is_comment = '1' $sql_time and bo_table != 'oneline' ";
    else
        $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$member[mb_id]' and wr_is_comment = '0' $sql_time and bo_table != 'oneline' ";
    $result = sql_fetch($sql);

    return $result[cnt];
}

// 나의 최신글 추출
function latest_my($skin_dir="", $skin_title="내가 올린 글", $time=30, $rows=10, $subject_len=40, $options="", $target="")
{
    global $g4, $member;

    if ($member[mb_id] == "") return;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

   if ($target)
      $target_link = "target=" . $target;

    $list = array();
    
    $sql_datetime = date("Y-m-d H:i:s", $g4['server_time'] - ($time * 86400));
    if ($options == "comment")
        $sql = " select bn_id, bo_table, wr_parent as wr_id from $g4[board_new_table] where mb_id = '$member[mb_id]' and wr_is_comment = '1' and bn_datetime > '$sql_datetime' and bo_table != 'oneline' group by wr_parent order by bn_id desc limit 0, $rows ";
    else
        $sql = " select bn_id, bo_table, wr_id from $g4[board_new_table] where mb_id = '$member[mb_id]' and wr_is_comment = '0' and bn_datetime > '$sql_datetime' and bo_table != 'oneline' order by bn_id desc limit 0, $rows ";
    $result = sql_query($sql);

    $j = 0;
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql2 = " select * from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        if (!$row2) {
            // $g4_board_new에만 있고 실제는 게시글이 없으면 지워야지
            $sql = " delete from $g4[board_new_table] where bn_id = '$row[bn_id]' ";
            sql_query($sql);
            continue;
        }

        $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_new, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql);
    
        $list[$j] = get_list($row2, $board, $latest_skin_path, $subject_len);
        $j++;
    }

    if ($options == "comment")
        $skin_title_link = "$g4[bbs_path]/new.php?gr_id=&view_type=c&mb_id=$member[mb_id]";
    else
        $skin_title_link = "$g4[bbs_path]/new.php?gr_id=&view_type=&mb_id=$member[mb_id]";
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
} 


// 내글에 대한 반응
function latest_my_update($skin_dir="", $skin_title="내글에 대한 반응", $time=30, $rows=10, $subject_len=40, $options="", $target="")
{
    global $g4, $member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

   if ($target)
      $target_link = "target=" . $target;

    $list = array();
    
    $sql_datetime = date("Y-m-d H:i:s", $g4['server_time'] - ($time * 86400));
    $sql = " select bn_id, bo_table, wr_id from $g4[board_new_table] where mb_id = '$member[mb_id]'  and wr_is_comment = '0' and my_datetime not like '0%' and bn_datetime > '$sql_datetime' order by my_datetime desc limit 0, $rows ";
    $result = sql_query($sql);

    $j = 0;
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        //$sql2 = " select * from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $sql2 = " select wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        if (!$row2) {
            // $g4_board_new에만 있고 실제는 게시글이 없으면 지워야지
            $sql = " delete from $g4[board_new_table] where bn_id = '$row[bn_id]' ";
            sql_query($sql);
            continue;
        }

        $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_new, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search from $g4[board_table] where bo_table = '$row[bo_table]'";
        $board = sql_fetch($sql);
        
        $list[$j] = get_list($row2, $board, $latest_skin_path, $subject_len);
        $j++;
    }

    $skin_title_link = "$g4[path]/modules/my_comment.php?my=1";
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}



// 내가 방문한 게시판
function latest_my_board($skin_dir="", $skin_title="내가 방문한 게시판", $rows=10, $subject_len=40, $options="")
{
    global $g4, $member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();
    
    $sql = " select b.bo_table, b.bo_subject, a.my_datetime from $g4[my_board_table] a left join $g4[board_table] b on a.bo_table = b.bo_table
              where a.mb_id = '$member[mb_id]' group by b.bo_table order by a.my_datetime desc limit 0, $rows ";
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];

        $list[$i][subject] = cut_str($row[bo_subject], $subject_len);
        $list[$i][datetime] = $row[my_datetime];
        $list[$i][href] = "$g4[bbs_path]/board.php?bo_table=$row[bo_table]";
    }

    $skin_title_link = "$g4[path]/mr_board.php";

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function latest_scrap($skin_dir="", $skin_title="스크랩 최신글", $mb_id="", $rows=10, $subject_len=40, $options="")
{
    global $g4, $member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    // $mb_id가 지정되지 않으면, 로그인한 사람의 것으로 한다.
    if ($mb_id == "")
        $mb_id = $member[mb_id];

    $list = array();
    
    $sql = " select bo_table, wr_id from $g4[scrap_table] where mb_id='$mb_id' order by ms_id desc limit 0, $rows ";
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {

        // 게시판 정보
        $board = get_board($row[bo_table]);

        // 게시글 정보
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql2 = " select wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);

        $list[$i] = get_list($row2, $board, $latest_skin_path, $subject_len);
    }

    $skin_title_link = "#";

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}  
?>
