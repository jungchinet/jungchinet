<?
include_once("./_common.php");

// 게시글 대피를 위해서 move_update.php를 복사해서 수정한 것 입니다.
// move_update.php를 수정할 때 반드시 같이 수정해 주셔야 합니다.

// 게시글 대피는 본인 또는 관리자만 가능
if ($is_admin == "super") // 최고관리자 통과
    ;
else if ($is_admin == "group") { // 그룹관리자 통과
    $mb = get_member($write[mb_id]);
    if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
        alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
} else if ($is_admin == "board") { // 게시판관리자 통과
    $mb = get_member($write[mb_id]);
    if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
        alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
} else if ($write['mb_id'] && $write['mb_id'] != $member['mb_id'])
    alert_close("자신의 글만 이동하는 것이 가능합니다.");

// move_update.php에 맞춰서 데이터를 재입력
$sw = "move";
$_POST['chk_bo_table'][0] = $board['bo_move_bo_table']; // 대피할 게시판
$wr_id_list = $wr_id; // 이동할 게시글

// 이곳 이하는 /bbs/move_update.php와 동일 합니다.

// move_update.php는 하나의 글 꾸러미 전체를 이동해주는 기능을 하게 됩니다.
// 답글의 이동이 일어나게 되면 본글도 같이 움직여지고, 밑의 글도 같이 갑니다.
// 이건 아니죠??? ㅠ..ㅠ...
// 그래서 다시 수정을 했습니다. 
// wr_num을 모두 뒤져서 이동할 목록을 만들지 않고, 1개의 해당 파일만 이동하게 했어요.

// 원본 파일 디렉토리
$src_dir = "$g4[data_path]/file/$bo_table";

$save = array();
$save_count_write = 0;
$save_count_comment = 0;
$cnt = 0;

// SQL Injection 으로 인한 코드 보완
//$sql = " select distinct wr_num from $write_table where wr_id in (" . stripslashes($wr_id_list) . ") order by wr_id ";
$sql = " select distinct wr_num from $write_table where wr_id in ($wr_id_list) order by wr_id ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) 
{
    $wr_num = $row[wr_num];
    for ($i=0; $i<count($_POST['chk_bo_table']); $i++) 
    {
        $move_bo_table = $_POST['chk_bo_table'][$i];
        $move_write_table = $g4['write_prefix'] . $move_bo_table;

        // 옮겨가는 테이블의 gr_id를 찾기 by. 불당
        $move_gr_id = sql_fetch(" select gr_id from $g4[board_table] where bo_table = '$move_bo_table' ");

        $src_dir = "$g4[data_path]/file/$bo_table"; // 원본 디렉토리
        $dst_dir = "$g4[data_path]/file/$move_bo_table"; // 복사본 디렉토리

        $count_write = 0;
        $count_comment = 0;

        $next_wr_num = get_next_num($move_write_table);

        //$sql2 = " select * from $write_table where wr_num = '$wr_num' order by wr_parent, wr_comment desc, wr_id ";
        // http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=18926
        //$sql2 = " select * from $write_table where wr_num = '$wr_num' order by wr_parent, wr_is_comment, wr_comment desc, wr_id ";
        // 불당팩 - 한개의 게시글만 이동하게 수정
        $sql2 = " select * from $write_table where wr_parent = '$wr_id_list' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2)) 
        {
            $nick = cut_str($member[mb_nick], $config[cf_cut_name]);
            if (!$row2[wr_is_comment] && $config[cf_use_copy_log]) 
                $row2[wr_content] .= " \n[이 게시물은 {$nick}님에 의해 $g4[time_ymdhis] {$board[bo_subject]}에서 " . ($sw == 'copy' ? '복사' : '이동') ." 됨]";

            $sql = " insert into $move_write_table
                        set wr_num            = '$next_wr_num',
                            wr_reply          = '$row2[wr_reply]',
                            wr_is_comment     = '$row2[wr_is_comment]',
                            wr_comment        = '$row2[wr_comment]',
                            wr_comment_reply  = '$row2[wr_comment_reply]',
                            ca_name           = '".addslashes($row2[ca_name])."',
                            wr_option         = '$row2[wr_option]',
                            wr_subject        = '".addslashes($row2[wr_subject])."',
                            wr_content        = '".addslashes($row2[wr_content])."',
                            wr_link1          = '".addslashes($row2[wr_link1])."',
                            wr_link2          = '".addslashes($row2[wr_link2])."',
                            wr_link1_hit      = '$row2[wr_link1_hit]',
                            wr_link2_hit      = '$row2[wr_link2_hit]',
                            wr_hit            = '$row2[wr_hit]',
                            wr_good           = '$row2[wr_good]',
                            wr_nogood         = '$row2[wr_nogood]',
                            mb_id             = '$row2[mb_id]',
                            wr_password       = '$row2[wr_password]',
                            wr_name           = '".addslashes($row2[wr_name])."',
                            wr_email          = '".addslashes($row2[wr_email])."',
                            wr_homepage       = '".addslashes($row2[wr_homepage])."',
                            wr_datetime       = '$row2[wr_datetime]',
                            wr_singo          = '$row2[wr_singo]',
                            wr_last           = '$row2[wr_last]',
                            wr_ip             = '$row2[wr_ip]',
                            wr_1              = '".addslashes($row2[wr_1])."',
                            wr_2              = '".addslashes($row2[wr_2])."',
                            wr_3              = '".addslashes($row2[wr_3])."',
                            wr_4              = '".addslashes($row2[wr_4])."',
                            wr_5              = '".addslashes($row2[wr_5])."',
                            wr_6              = '".addslashes($row2[wr_6])."',
                            wr_7              = '".addslashes($row2[wr_7])."',
                            wr_8              = '".addslashes($row2[wr_8])."',
                            wr_9              = '".addslashes($row2[wr_9])."',
                            wr_10             = '".addslashes($row2[wr_10])."',
                            wr_file_count     = '".$row2[wr_file_count]."',
                            wr_ccl            = '".$row2[wr_ccl]."',
                            wr_related        = '".$row2[wr_related]."',
                            wr_imagesize      = '".$row2[wr_imagesize]."' ";
            sql_query($sql);

            $insert_id = mysql_insert_id();

            // 코멘트가 아니라면
            if (!$row2[wr_is_comment]) 
            {
                $save_parent = $insert_id;

                $sql3 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' order by bf_no ";
                $result3 = sql_query($sql3);
                for ($k=0; $row3 = sql_fetch_array($result3); $k++) 
                {
                    if ($row3[bf_file]) 
                    {
                        // $file에 디렉토리가 들어 있는 경우, 문제를 해결해야죠. - 불당팩
                        $tmp = explode("/", $row3[bf_file]);
                        $encode_url = "";
                        $d_dir = $dst_dir;
                        for ($i=0; $i < count($tmp) - 1; $i++) {
                            if ($tmp[$i] !== "/") {
                                $d_dir .= "/" . $tmp[$i];
                                @mkdir("$d_dir", 0707);
                                @chmod("$d_dir", 0707);
                            }
                        }

                        // 원본파일을 복사하고 퍼미션을 변경
                        @copy("$src_dir/$row3[bf_file]", "$dst_dir/$row3[bf_file]");
                        @chmod("$dst_dir/$row3[bf_file]", 0606);
                    }

                    $sql = " insert into $g4[board_file_table] 
                                set bo_table = '$move_bo_table', 
                                    wr_id = '$insert_id', 
                                    bf_no = '$row3[bf_no]', 
                                    bf_source = '$row3[bf_source]', 
                                    bf_file = '$row3[bf_file]', 
                                    bf_download = '$row3[bf_download]', 
                                    bf_content = '".addslashes($row3[bf_content])."',
                                    bf_filesize = '$row3[bf_filesize]',
                                    bf_width = '$row3[bf_width]',
                                    bf_height = '$row3[bf_height]',
                                    bf_type = '$row3[bf_type]',
                                    bf_datetime = '$row3[bf_datetime]' ";
                    sql_query($sql);

                    if ($sw == "move" && $row3[bf_file])
                        $save[$cnt][bf_file][$k] = "$src_dir/$row3[bf_file]";
                }

                $sql4 = " select * from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ";
                $result4 = sql_query($sql4);
                for ($k=0; $row4 = sql_fetch_array($result4); $k++)
                {
                    $sql = " insert into $g4[board_cheditor_table]
                                SET bo_table = '$move_bo_table',
                                    wr_id = '$insert_id',
                                    bc_url = '$row4[bc_url]',
                                    bc_dir = '$row4[bc_dir]',
                                    bc_source = '$row4[bc_source]',
                                    bc_file = '$row4[bc_file]',
                                    bc_filesize = '$row4[bc_filesize]',
                                    bc_width = '$row4[bc_width]',
                                    bc_height = '$row4[bc_height]',
                                    bc_type = '$row4[bc_type]',
                                    bc_datetime = '$row4[bc_datetime]' ";
                    sql_query($sql);
                }

                $count_write++;

                if ($sw == "move" && $i == 0)
                {
                    // 스크랩 이동
                    sql_query(" update $g4[scrap_table] set bo_table = '$move_bo_table', wr_id = '$save_parent' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 최신글 이동
                    sql_query(" update $g4[board_new_table] 
                                    set bo_table = '$move_bo_table', wr_id = '$save_parent', wr_parent = '$save_parent', gr_id = '$move_gr_id[gr_id]' 
                                    where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 신고글 이동
                    sql_query(" update $g4[singo_table] set bo_table = '$move_bo_table', wr_id = '$insert_id', wr_parent = '$save_parent' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 추천 이동
                    sql_query(" update $g4[board_good_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 베스트글 이동
                    sql_query(" update $g4[good_list_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 불당팩 - 유니크로
                    $sql6 = " select * from $g4[unicro_item_table] where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ";
                    $result6 = sql_fetch($sql6, false);
                    if ($result6['item_no']) { // 유니크로 아이템이 있는 경우
                        $sql7 = " update $g4[unicro_item_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' 
                                  where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ";
                        sql_query($sql7, false);
                    }
                    
                    // 불당팩 - 다운로드 내역 업데이트
                    $g4[board_file_download_table] = $g4[board_file_table] . "_download";
                    sql_query(" update $g4[board_file_download_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // cheditor 정보 삭제
                    sql_query(" delete from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");
                    
                    // 불당팩 - 전체 공지사항 정보 업데이트
                    $sql8 = " select count(*) as cnt from $g4[notice_table] where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ";
                    $result8 = sql_fetch($sql8);
                    if ($result8[cnt] > 0) {
                        $sql7 = " update $g4[notice_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ";
                        sql_query($sql7);

                        $move_board = get_board($move_bo_table);
                        $bo_notice = $insert_id . "\n" . $move_board[bo_notice];
                        sql_query(" update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$move_bo_table' ");
                    }
                }
            } 
            else 
            {
                $count_comment++;

                if ($sw == "move")
                {
                    // 최신글 이동
                    sql_query(" update $g4[board_new_table] 
                                    set bo_table = '$move_bo_table', wr_id = '$insert_id', wr_parent = '$save_parent', gr_id = '$move_gr_id[gr_id]' 
                                    where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");

                    // 신고글 이동
                    sql_query(" update $g4[singo_table] set bo_table = '$move_bo_table', wr_id = '$insert_id' where bo_table = '$bo_table' and wr_id = '$row2[wr_id]' ");
                }
            }

            sql_query(" update $move_write_table set wr_parent = '$save_parent' where wr_id = '$insert_id' ");

            // 불당팩 - 새로 생성된 wr_id를 저장
            $save[$cnt][insert_id] = $insert_id;

            if ($sw == "move")
                $save[$cnt][wr_id] = $row2[wr_parent];

            $cnt++;
        }


        sql_query(" update $g4[board_table] set bo_count_write   = bo_count_write   + '$count_write'   where bo_table = '$move_bo_table' ");
        sql_query(" update $g4[board_table] set bo_count_comment = bo_count_comment + '$count_comment' where bo_table = '$move_bo_table' ");

        // 불당팩 - min_wr_num 업데이트
        $result4 = sql_fetch(" select MIN(wr_num) as min_wr_num from $move_write_table ");
        $sql5 = " update $g4[board_table] set min_wr_num = '$result4[min_wr_num]' where bo_table = '$move_bo_table' ";
        sql_query($sql5); 
    }

    $save_count_write += $count_write;
    $save_count_comment += $count_comment;
}

if ($sw == "move") 
{
    for ($i=0; $i<count($save); $i++) 
    {
        // 불당팩 - 휴지통 기능, 휴지통 사용게시판에서 휴지통으로 move를 할 때, 여기 코드는 bbs/delete.php의 앞부분과 같아야 합니다
        if ($config[cf_use_recycle] && $move_bo_table == $config[cf_recycle_table]) {

            // 삭제할 최신글의 정보를 가져오고
            $sql00 = " select * from $g4[board_new_table] where bo_table = '$move_bo_table' and wr_id = '{$save[$i][insert_id]}' ";
            $bn = sql_fetch($sql00);

            // recycle action - recycle 게시판에 글쓰고
            $sql = " insert into $g4[recycle_table]
                        set 
                    rc_bo_table     = '$config[cf_recycle_table]',
                    rc_mb_id        = '$member[mb_id]',
                    rc_wr_id        = '{$save[$i][insert_id]}',
                    rc_wr_parent    = '$bn[wr_parent]',
                    rc_parent_mb_id = '$bn[parent_mb_id]',
                    mb_id           = '$bn[mb_id]',
                    bo_table        = '$bo_table',
                    wr_id           = '{$save[$i][wr_id]}',
                    wr_is_comment   = '$bn[wr_is_comment]',
                    bn_id           = '$bn[bn_id]',
                    rc_datetime     = '$g4[time_ymdhis]' ";
            sql_query($sql);
            
            // 휴지통에 있는 최신글을 지워주고
            $sql09 = " delete from $g4[board_new_table] where bo_table = '$move_bo_table' and wr_id = '{$save[$i][insert_id]}' ";
            sql_query($sql09);
        }

        for ($k=0; $k<count($save[$i][bf_file]); $k++)
            @unlink($save[$i][bf_file][$k]);    

        sql_query(" delete from $write_table where wr_parent = '{$save[$i][wr_id]}' ");
        sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_id = '{$save[$i][wr_id]}' ");
        sql_query(" delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '{$save[$i][wr_id]}' ");
    }
    sql_query(" update $g4[board_table] set bo_count_write = bo_count_write - '$save_count_write', bo_count_comment = bo_count_comment - '$save_count_comment' where bo_table = '$bo_table' ");

    // 불당팩 - min_wr_num 업데이트
    $result4 = sql_fetch(" select MIN(wr_num) as min_wr_num from $write_table ");
    $sql5 = " update $g4[board_table] set min_wr_num = '$result4[min_wr_num]' where bo_table = '$bo_table' ";
    sql_query($sql5); 
}

$msg = "해당 게시물을 선택한 게시판으로 $act 하였습니다.";
$opener_href = "./board.php?bo_table=$bo_table&page=$page&$qstr";

// 이 곳이상은 /bbs/move.php와 동일 합니다.
if ($recycle == "recycle")
    ;
else
    goto_url($opener_href . $qstr);
?>
