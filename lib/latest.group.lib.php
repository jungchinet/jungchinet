<?
if (!defined('_GNUBOARD_')) exit;

function latest_group($skin_dir="", $gr_id="", $rows=10, $subject_len=40, $content_len="", $skin_title="", $skin_title_link="", $sort_order="", $secret=0)
{
    global $g4, $is_admin;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    if ($sort_order)
      $sort_sql = " order by a." . $sort_order;
    else
      $sort_sql = " order by a.bn_id ";

    // $secret = 0/기타, 일반사용자: 비밀글 안보임, 관리자 : 비밀글 보임
    // $secret = 1, 일반사용자: 비밀글 보임, 관리자 : 비밀글 보임
    // $secret = 2, 일반사용자: 비밀글 안보임, 관리자 : 비밀글 안보임
    if ($secret == 1)
        $sql_secret = " ";
    else if ($secret == 2)
        $sql_secret = " and a.wr_option not like '%secret%' ";
    else {
      if ($is_admin)
          $sql_secret = " ";
      else
          $sql_secret = " and a.wr_option not like '%secret%' ";
    }

    // 검색이 허용된 게시판의 글만 select 합니다 ^^
    if ($gr_id == "")
        $gr_search = " 1 ";
    else
        $gr_search = " a.gr_id = '$gr_id' ";

    if ($g4['old_stype_search'] == 1) {
        // tmp 테이블 생성 오류가 나오는 경우, 이 코드를 쓰면 됩니다. 속도는 좀 많이 나쁘겠죠.
          $sql = " select a.bo_table, a.wr_id 
                     from $g4[board_new_table] a, 
                          ( select d.bo_table from $g4[board_table] d left join $g4[group_table] e on (d.gr_id=e.gr_id) where d.bo_use_search=1 and e.gr_use_search=1 ) b 
                    where $gr_search and a.bo_table = b.bo_table and a.wr_is_comment = '0' $sql_secret $sort_sql desc limit 0, $rows ";
        $result = sql_query($sql);
    } else if ($g4['old_stype_search'] == 2) {
        // MySQL DB 버젼이 너무나도 낮아서 sub query가 안먹히는 경우, 어쩔 수 없이 sql에서 기능을 일부 degration
        $rows2 = $rows * 3;
        $sql = " select a.bo_table, a.wr_id 
                  from $g4[board_new_table] a ,$g4[board_table] b
                  where a.gr_id = '$gr_id'  and a.bo_table = b.bo_table and b.bo_use_search = 1 and  a.wr_is_comment = '0' $sql_secret $sort_sql desc limit 0, $rows2 ";
        /*
        $sql = " select bo_table, wr_id 
                  from $g4[board_new_table] a 
                  where gr_id = '$gr_id' and wr_is_comment = '0' $sql_secret $sort_sql desc limit 0, $rows2 ";
        */
        $result = sql_query($sql);
    } else {
        // tmp 테이블을 만들고 그것에서 select를 한다.
        $sql = "select d.bo_table, d.bo_use_search, e.gr_use_search from $g4[board_table] d left join $g4[group_table] e on (d.gr_id=e.gr_id) ";
        $tmp_table = "g4_tmp_" . time();
        $sql_tmp = " create TEMPORARY table $tmp_table as $sql ";
        @mysql_query($sql_tmp) or die("<p>$sql_tmp<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");

        $sql = " select a.bo_table, a.wr_id 
                     from $g4[board_new_table] a
                     left join $tmp_table b on (a.bo_table = b.bo_table)
                    where $gr_search and a.wr_is_comment = '0'
                          and b.bo_use_search=1 and b.gr_use_search=1
                          $sql_secret $sort_sql desc limit 0, $rows ";
        $result = sql_query($sql);
    
        $sql = " drop table $tmp_table ";
        sql_query($sql);
    }

    // 게시판 정보를 별도로 가져오게 코딩을 변경
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql_select = " wr_id, wr_subject, wr_option, wr_content, wr_comment, wr_parent, wr_datetime, wr_last, wr_homepage, wr_name, wr_reply, wr_link1, wr_link2, ca_name, wr_hit, wr_file_count ";
        $bo_select = " '" . $row[bo_table] . "' as bo_table ";
        if ($i == 0 )
            $sql2 .= " select $sql_select , $bo_select from $tmp_write_table where wr_id = '$row[wr_id]' ";
        else
            $sql2 .= " union all select $sql_select , $bo_select from $tmp_write_table where wr_id = '$row[wr_id]' ";
    }

    // Query set이 있는 경우에만 작업을
    if ($sql2) {
        $result2 = sql_query($sql2);
        $j = 0;
        for ($i=0; $row2 = sql_fetch_array($result2); $i++) {
            if ($j >= $rows)
                break;
            $board = get_board($row2[bo_table], "bo_table, bo_notice, bo_subject, bo_subject_len, bo_use_list_content, bo_use_sideview, bo_use_comment, bo_hot, bo_use_search, bo_new ");
            // 게시판에 값이 없으면 그냥 지나간다. 어쩔 수 없다. 빈칸이 하나 더 생기는거 감수하고 속도를 높인다. 게시판만 안지우면 이런일 사실 없다. ㅎㅎ
            if (!$board)
                continue;
            $write = $row2;
            $list[$j] = get_list($write, $board, $latest_skin_path, $subject_len);
            $j++;
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

// imagetype code (getimagesize)
// 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(orden de bytes intel), 8 = TIFF(orden de bytes motorola), 9 = JPC, 10 = JP2, 
// 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM. 
function latest_images($skin_dir="", $bo_table="", $gr_id="", $rows=10, $subject_len=40, $content_len="", $skin_title="", $skin_title_link="", $sort_order="", $secret=0)
{
    global $g4, $is_admin;

    if ($skin_dir)
        $latest_skin_path = "$g4[path]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[path]/skin/latest/basic";

    $list = array();

    if ($gr_id) {
        // 그룹의 경우
        $sql = " select bo_table from $g4[board_table] where gr_id = '$gr_id' ";
        $result = sql_query($sql);
        $bo_sql = " a.bo_table in( ";
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            if ($i == 0)
                $one = " '$row[bo_table] ' ";
            else
                $bo_sql .= "'" . $row[bo_table] . "', ";
        }
        $bo_sql .= $one . " ) ";
    } else if ($bo_table) {
        // 게시판의 경우
        $bo_sql = " a.bo_table = '$bo_table' ";
    } else {
        return;
    }
    if ($sort_order)
      $sort_sql = " order by a." . $sort_order;
    else
      $sort_sql = " order by a.bf_datetime desc ";

    // bo_table의 이미지(bf_type > 0)만 가져 옵니다.
    $sql = " select * from $g4[board_file_table] a where $bo_sql and a.bf_type > 0 $sort_sql limit 0, $rows  ";

    // Query set이 있는 경우에만 작업을
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];

        $sql2 = " select * from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $row2 = sql_fetch($sql2);
        $write = $row2;

        $board = get_board($row[bo_table]);

        $list[$i] = get_list($write, $board, $latest_skin_path, $subject_len);

        $list[$i][bo_table] = $row[bo_table];
        $list[$i][bf_source] = $row[bf_source];
        $list[$i][bf_file] = $row[bf_file];
        $list[$i][bf_download] = $row[bf_download];
        $list[$i][bf_content] = $row[bf_content];
        $list[$i][bf_filesize] = $row[bf_filesize];
        $list[$i][bf_width] = $row[bf_width];
        $list[$i][bf_height] = $row[bf_height];
        $list[$i][bf_type] = $row[bf_type];
        $list[$i][bf_datetime] = $row[bf_datetime];
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
