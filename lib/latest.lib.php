<?
if (!defined('_GNUBOARD_')) exit;

// 최신글 추출
function latest($skin_dir="", $bo_table, $rows=10, $subject_len=40, $gallery_view=0, $notice=0, $options="")
{
    global $g4,$member;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    // $options를 explode
    if (!is_array($options))
        $opt = explode(",", $options);

    $list = array();

    $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_list_level, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search, bo_new from $g4[board_table] where bo_table = '$bo_table'";
    $board = sql_fetch($sql);

    // 공지글은 기본으로 포함한다, $notice=1이면 공지글을 제외
    $sql_notice = "";
    if ($notice) {
        // 공지글을 쪼개서 배열에 넣습니다.
        $arr_notice = preg_split("/\n/i", trim($board[bo_notice]));
        for ($i=0; $i < count($arr_notice); $i++) { 
            // 가끔 빈줄 공지글도 있는데, 그거는 지나가게...
            if (trim($arr_notice[$i]) == "") 
              continue; 
            else {
              // 마지막꺼만 빼고 모두 뒤에 콤마를. 그거 함수로 하는거도 가능은 한데...음...
              if ( ($i + 1) == count($arr_notice) ) 
                  $sql_notice .= $arr_notice[$i] ; 
              else 
                  $sql_notice .= $arr_notice[$i] . ","; 
            } 
        } 
        if ($i > 0) 
            $sql_notice = " and wr_id not in (" . $sql_notice . ") "; 
    }

    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_file_count, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";
    $sql = " select $sql_select from $tmp_write_table where wr_is_comment = 0 $sql_notice order by wr_num limit 0, $rows ";

    // 게시판목록보기 권한이 회원 레벨 이상인 경우에는, 아무것도 노출되지 않게 코딩을 바꿔줍니다.
    if (is_array($opt) && in_array("list_level", $opt) && $board[bo_list_level] > $member[mb_level])
        $result = "";
    else
        $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) 
        $list[$i] = get_list($row, $board, $latest_skin_path, $subject_len, $gallery_view);
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 지정하는 게시판의 공지글 추출
function latest_bo_notice($skin_dir="", $bo_table, $rows=10, $subject_len=40, $gallery_view=0, $sod="rand", $skin_title="", $skin_title_link="", $options="")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $sql = " select bo_notice from $g4[board_table] where bo_table = '$bo_table' ";
    $result = sql_fetch($sql);

    $arr_notice = preg_split("/\n/i", trim($result[bo_notice]));
    $arr_notice_count = count($arr_notice);

    // $rows가 $arr_notice_count 보다 크면
    if ($rows < $arr_notice_count)
        $rows = $arr_notice_count;

    // 랜덤이면 배열을 셔플링
    if ($sod == "rand")
        shuffle($arr_notice);

    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $board = get_board($bo_table);
    $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_file_count, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";
    $list = array();

    for ($i=0; $i<$rows; $i++) {
        $wr_id = $arr_notice[$i];
        $sql = " select $sql_select from $tmp_write_table where wr_id = '$wr_id' ";
        $wr = sql_fetch($sql);
        $list[$i] = get_list($wr, $board, $latest_skin_path, $subject_len, $gallery_view);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 전체 공지글 추출
function latest_notice($skin_dir="", $rows=10, $subject_len=40, $gallery_view=0, $sod="rand", $skin_title="", $skin_title_link="", $options="")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    if ($sod == "rand")
        $sql_order = "order by rand() ";
    else
        $sql_order = "order by $sod";

    $sql = " select * from $g4[notice_table] where 1 $sql_order limit 0, $rows";
    $result = sql_query($sql);

    $list = array();
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
        $board = get_board($row[bo_table]);
        $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_file_count, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";
        $sql = " select $sql_select from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $wr = sql_fetch($sql);
        $list[$i] = get_list($wr, $board, $latest_skin_path, $subject_len, $gallery_view);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 최근 인기글추출
// $bo_hot_list : 1(실시간) 2(주간) 3(월간) 4(일간)
// $bo_hot_list_basis : 인기글 산출기준
function latest_popular($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="", $bo_hot_list=1, $bo_hot_list_basis="hit")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    $sql = " select bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search, bo_new from $g4[board_table] where bo_table = '$bo_table'";
    $board = sql_fetch($sql);

    switch ($bo_hot_list) {
        case "1": $hot_start = ""; $hot_title = "실시간"; break;
        case "2": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24*7); $hot_title = "주간"; break;
        case "3": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24*30); $hot_title = "월간"; break;
        case "4": $hot_start = date("Y-m-d H:i:s", $g4[server_time]-60*60*24); $hot_title = "일간"; break;
    }
    $sql_between = 1;
    if ($bo_hot_list > 1) 
    {
        $sql_between = " wr_datetime between '$hot_start' and '$g4[time_ymdhis]' ";
    }

    // 공지사항제외
    $arr_notice = preg_split("/\n/i", trim($board[bo_notice]));

    $not_sql = " ";
    for ($k=0; $k<count($arr_notice); $k++) {
        if (trim($arr_notice[$k]) !== "") {
            $not_sql .= " and wr_id <> '$arr_notice[$k]' "; 
        }
    }

    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_id desc limit 0, $rows ";
    // 위의 코드 보다 속도가 빠름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_num limit 0, $rows ";
    $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit ";
    $sql = " SELECT $sql_select 
               FROM $tmp_write_table 
              WHERE wr_is_comment = 0 
                and $sql_between
                    $not_sql
           order by wr_{$bo_hot_list_basis} desc 
              limit 0, $rows ";
    $result = sql_query($sql);
    
    for ($i=0; $row = sql_fetch_array($result); $i++) 
        $list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 단 하나의 게시글 추출
function latest_one($skin_dir="", $bo_table, $wr_id, $subject_len=40, $content_len=0, $gallery_view=0, $options="") {
    global $g4, $qstr;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    $board = get_board($bo_table);
    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $row = sql_fetch(" select * from $tmp_write_table where wr_id = '$wr_id' ");

    $view = get_list($row, $board, $latest_skin_path, $subject_len, $gallery_view);

    $skin_title_link = $g4[bbs_path] . "/board.php?bo_table=$bo_table&wr_id=$wr_id" . $qstr;

    $html = 0;
    if (strstr($view[wr_option], "html1"))
        $html = 1;
    else if (strstr($view[wr_option], "html2"))
        $html = 2;

    $view[content] = conv_content($view[wr_content], $html);
    $view[content] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' \\2 \\3", $view[content]);

    if ($content_len > 0)
        $view[content] = cut_str($view[content], $content_len);

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}


// 추천 기준으로 게시글 추출
function latest_good($skin_dir="", $bo_table, $rows=10, $subject_len=40, $bg_flag="good", $gallery_view=0, $options="") {
    global $g4, $qstr;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    // 게시판의 최근의 추천에서 골라낸다
    $board = get_board($bo_table);
    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

    $sql = " select distinct wr_id from $g4[board_good_table] where bo_table='$bo_table' and bg_flag='$bg_flag' $sql_search order by bg_id desc limit $rows ";
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $row = sql_fetch(" select * from $tmp_write_table where wr_id = '$row[wr_id]' ");
        $list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 추천 기준으로 유효한 소셜 게시글 추출
function latest_good_metacoupon($skin_dir="", $bo_table, $rows=10, $subject_len=40, $bg_flag="good", $gallery_view=0, $options="") {
    global $g4, $qstr;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    if (is_array($options)) {
        extract($options);
        if ($stx)
            $sql_search = " AND $sfl $sop $stx ";
    }

    $list = array();

    // 게시판의 최근의 추천에서 쿠폰 딜의 날짜가 유효한 골라낸다
    $board = get_board($bo_table);
    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

    $sql = " select distinct A.wr_id
                    from $g4[board_good_table] A left join $tmp_write_table B on A.wr_id = B.wr_id
                    where A.bo_table='$bo_table' and A.bg_flag='$bg_flag' and B.wr_5 > '$g4[time_ymdhis]'
                          $sql_search 
                    order by A.bg_id desc limit $rows ";
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $row = sql_fetch(" select * from $tmp_write_table where wr_id = '$row[wr_id]' ");
        $list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);
        $deal = explode("|", $list[$i][wr_6]);
        $list[$i][subject] = "<b>" . number_format($deal[0]) . "원</b>," .$list[$i][subject];
    }

    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
