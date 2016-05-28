<?
include_once("./_common.php");

if (!$board[bo_table])
{
    if ($cwin) // 코멘트 보기
       alert_close("존재하지 않는 게시판입니다.", $g4[path]);
    else
       alert("존재하지 않는 게시판입니다.", $g4[path]);
}

if ($write[wr_is_comment]) 
{
    /*
    if ($cwin) // 코멘트 보기
        alert_close("코멘트는 상세보기 하실 수 없습니다.");
    else
        alert("코멘트는 상세보기 하실 수 없습니다.");
    */
    goto_url("./board.php?bo_table=$bo_table&wr_id=$write[wr_parent]#c_{$wr_id}");
}

if (!$bo_table) 
{
    $msg = "bo_table 값이 넘어오지 않았습니다.\\n\\nboard.php?bo_table=code 와 같은 방식으로 넘겨 주세요.";
    if ($cwin) // 코멘트 보기
        alert_close($msg);
    else 
        alert($msg);
}

// wr_id 값이 있으면 글읽기 
if ($wr_id) 
{
    // 글이 없을 경우 해당 게시판 목록으로 이동
    if (!$write[wr_id]) 
    {
        $msg = "글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.";
        if ($cwin)
            alert_close($msg);
        else
            alert($msg, "./board.php?bo_table=$bo_table");
    }

    // 그룹접근 사용
    if ($group[gr_use_access]) 
    {
        if (!$member[mb_id]) {
            $msg = "비회원은 이 게시판에 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.";
            if ($cwin)
                alert_close($msg);
            else 
                alert($msg, "./login.php?wr_id=$wr_id{$qstr}&url=".urlencode("./board.php?bo_table=$bo_table&wr_id=$wr_id"));
        }

        // 그룹관리자 이상이라면 통과 
        if ($is_admin == "super" || $is_admin == "group") 
            ; 
        else 
        {
            // 그룹접근
            $sql = " select count(*) as cnt 
                       from $g4[group_member_table] 
                      where gr_id = '$board[gr_id]' and mb_id = '$member[mb_id]' ";
            $row = sql_fetch($sql);
            if (!$row[cnt]) 
                alert("그룹접근 - 접근 권한이 없으므로 글읽기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.", $g4[path]);
        }
    }

    // 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
    if ($member[mb_level] < $board[bo_read_level]) 
    {
        if ($member[mb_id]) 
            //alert("글을 읽을 권한이 없습니다.");
            alert("글을 읽을 권한이 없습니다.", $g4[path]);
        else 
            alert("글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?wr_id=$wr_id{$qstr}&url=".urlencode("./board.php?bo_table=$bo_table&wr_id=$wr_id"));
    }

    // 자신의 글이거나 관리자라면 통과
    if (($write[mb_id] && $write[mb_id] == $member[mb_id]) || $is_admin)
        ;
    else 
    {
        // 비밀글이라면
        if (strstr($write[wr_option], "secret")) 
        {
            // 기본으로는 비밀글은 볼 수 없다.
            $is_unlock_secret = 0;
            $is_owner = false;

            // 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
            // 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
            if ($write[wr_reply] && $member[mb_id])
            {
                $sql = " select mb_id from $write_table 
                          where wr_num = '$write[wr_num]' 
                            and wr_reply = ''
                            and wr_is_comment = '0' ";
                $row = sql_fetch($sql);
                if ($row['mb_id'] == $member['mb_id']) 
                    $is_owner = true;
            }
            
            // 댓글을 달았을 경우에 원글을 잠그는 것은 댓글을 단 회원의 주권을 박탈하는 것임
            // 비회원의 경우까지 확대하는 것은 패스워드 입력으로 인한 보안 사고의 risk가 커지므로 회원의 경우에 대해서만 고려
            if ($member['mb_id']) {
                $sql = " select count(*) as cnt from $write_table 
                          where wr_parent = '$wr_id'
                            and mb_id = '$member[mb_id]' 
                            and wr_is_comment = '1' ";
                $row = sql_fetch($sql);
                if ($row['cnt'] > 0 && !$is_owner) {
                    $is_unlock_secret = 1;
                    $is_owner = 1;
                }
            }

			$ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

            if (!$is_owner)
            {
                //$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
                // 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 패스워드를 묻지 않습니다.
                // 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
                //if ("$bo_table|$write[wr_num]" != get_session("ss_secret")) 
                if (!get_session($ss_name)) 
                    goto_url("./password.php?w=s&bo_table=$bo_table&wr_id=$wr_id{$qstr}");
            }

            // $write[wr_num] -> $wr_id... 답글의 권한이 댓글만 달면 모두 다 오는 오류 수정
            $ss_name = "ss_secret_{$bo_table}_{$wr_id}";
            set_session($ss_name, TRUE);
        }
    }

    // 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
    $ss_name = "ss_view_{$bo_table}_{$wr_id}";

    if (!get_session($ss_name)) 
    {
        sql_query(" update $write_table set wr_hit = wr_hit + 1 where wr_id = '$wr_id' ");

        // 자신의 글이면 통과
        if ($write[mb_id] && $write[mb_id] == $member[mb_id]) {
            ;
        } else if ($is_guest && $board[bo_read_level] == 1 && $write[wr_ip] == $_SERVER['REMOTE_ADDR']) {
            // 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
            ;
        } else {
            /*
            // 회원이상 글읽기가 가능하다면
            if ($board[bo_read_level] > 1) {
                if ($member[mb_point] + $board[bo_read_point] < 0)
                    alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글읽기(".number_format($board[bo_read_point]).")가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.");
            }
            
            // 회원에게만 포인트를 insert
            if ($member[mb_id])
                insert_point($member[mb_id], $board[bo_read_point], "$board[bo_subject] $wr_id 글읽기", $bo_table, $wr_id, '읽기');
            */
            // 글읽기 포인트가 설정되어 있다면
            if ($board[bo_read_point_lock] && $board[bo_read_point] && $member[mb_point] + $board[bo_read_point] < 0)
                alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글읽기(".number_format($board[bo_read_point]).")가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.");

            // 회원에게만 포인트를 insert
            if ($member[mb_id])
                insert_point($member[mb_id], $board[bo_read_point], "$board[bo_subject] $wr_id 글읽기", $bo_table, $wr_id, '읽기');
            
            // 불당팩 - 조회수가 일정숫자 이상이면 인기글로 뽀로롱~ 그런데, $write[wr_view]를 쓰기 때문에, 숫자의 차이가 1 날 수 있다.
            $write['wr_hit2'] = $write['wr_hit'] + 1;
            if ($board[bo_list_view] > 0) {
                if ($write[wr_hit2] > 0 && $write[wr_hit2] >= $board[bo_list_view]) {
                    // UPDATE를 먼저하고 오류가 발생시 insert를 실행
                    $sql = " update $g4[good_list_table] set hit = '$write[wr_hit2]' where bo_table='$bo_table' and wr_id='$wr_id' ";
                    $result = sql_query($sql, FALSE);
                    if ( mysql_affected_rows() == 0 ) {
                        // select를 해서 있으면, 패스, 없으면 insert
                        $sql = " insert $g4[good_list_table] ( mb_id, gr_id, bo_table, wr_id, gl_datetime, hit, wr_datetime) values ( '$write[mb_id]', '$board[gr_id]', '$bo_table', '$wr_id', '$g4[time_ymdhis]', '$write[wr_hit2]',  '$write[wr_datetime]') ";
                        $result = sql_query($sql, FALSE);
                    }
                }
            }

        }

        set_session($ss_name, TRUE);
    }

    // 불당팩 - SEO를 위해서 순서를 변경
    if($cwin)
        $g4[title] =  stripslashes(strip_tags(conv_subject($write[wr_subject], 255))) . " [코멘트] > $board[bo_subject] > $group[gr_subject]"; 
    else
        $g4[title] =  stripslashes(strip_tags(conv_subject($write[wr_subject], 255))) . " > $board[bo_subject] > $group[gr_subject]"; 
} 
else 
{
    if ($member[mb_level] < $board[bo_list_level]) 
    {
        if ($member[mb_id]) 
            alert("목록을 볼 권한이 없습니다.", $g4[path]);
        else 
            alert("목록을 볼 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?wr_id=$wr_id{$qstr}&url=".urlencode("board.php?bo_table=$bo_table&wr_id=$wr_id"));
    }

    if (!$page) $page = 1; 

    $g4[title] = "정치넷";
}

include_once("$g4[path]/head.sub.php");

$width = $board[bo_table_width];
if ($width <= 100) $width .= '%'; 

// IP보이기 사용 여부
$ip = "";
$is_ip_view = $board[bo_use_ip_view];
if ($is_admin) {
    $is_ip_view = true;
    $ip = $write[wr_ip];
} else // 관리자가 아니라면 IP 주소를 감춘후 보여줍니다.
    $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $write[wr_ip]);

// 분류 사용
$is_category = false;
$category_name = "";
if ($board[bo_use_category]) {
    $is_category = true;
    $category_name = $write[ca_name]; // 분류명
}

// 추천 사용
$is_good = false;
if ($board[bo_use_good]) 
    $is_good = true;

// 비추천 사용
$is_nogood = false;
if ($board[bo_use_nogood]) 
    $is_nogood = true;

$admin_href = "";
// 최고관리자 또는 그룹관리자라면
if ($member[mb_id] && ($is_admin == 'super' || $group[gr_admin] == $member[mb_id])) 
    $admin_href = "$g4[admin_path]/board_form.php?w=u&bo_table=$bo_table";

if (!($board[bo_use_comment] && $cwin)) 
    include_once("./board_head.php");

echo "<script type=\"text/javascript\" src=\"$g4[path]/js/sideview.js\"></script>\n";

if (!($board[bo_use_comment] && $cwin)) {
    // 게시물 아이디가 있다면 게시물 보기를 INCLUDE
    if ($wr_id) 
        include_once("./view.php");

    // 전체목록보이기 사용이 "예" 또는 wr_id 값이 없다면 목록을 보임
    //if ($board[bo_use_list_view] || empty($wr_id)) 
    if ($member[mb_level] >= $board[bo_list_level] && $board[bo_use_list_view] || empty($wr_id))
        include_once ("./list.php"); 

    include_once("./board_tail.php");
}
else 
    include_once("./view_comment.php");

echo "\n<!-- 사용스킨 : $board[bo_skin] -->\n";

include_once("$g4[path]/tail.sub.php");
?>

<?
// 내가 방문한 게시판 정보를 db에 기록
if ($member[mb_id]) {
    sql_query(" update $g4[my_board_table] set my_datetime = '$g4[time_ymdhis]' where mb_id = '$member[mb_id]' and bo_table = '$bo_table' ");
    if (mysql_affected_rows() == 0) 
        sql_query(" insert $g4[my_board_table] set mb_id = '$member[mb_id]', bo_table = '$bo_table', my_datetime = '$g4[time_ymdhis]' ", FALSE );
}

?>
