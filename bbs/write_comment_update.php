<?
include_once("./_common.php");

if (file_exists("$board_skin_path/write_comment_update.head.skin.php"))
    @include_once("$board_skin_path/write_comment_update.head.skin.php");

$g4[title] = $wr_subject . "코멘트입력";

$w = $_POST["w"];
$wr_name  = strip_tags($_POST["wr_name"]);
$wr_email = strip_tags($_POST["wr_email"]);
$comment_id = (int)$_POST["comment_id"];

// 비회원의 경우 이름이 누락되는 경우가 있음
if (!$is_member)
{
    if (!trim($wr_name))
        alert("이름은 필히 입력하셔야 합니다.");
}

if ($w == "c" || $w == "cu") 
{
    if ($member[mb_level] < $board[bo_comment_level]) 
        alert("코멘트를 쓸 권한이 없습니다.");
} 
else
    alert("w 값이 제대로 넘어오지 않았습니다."); 

// 세션의 시간 검사
// 4.00.15 - 코멘트 수정시 연속 게시물 등록 메시지로 인한 오류 수정
if ($w == "c" && $_SESSION["ss_datetime"] >= ($g4[server_time] - $config[cf_delay_sec]) && !$is_delay) 
    alert("너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.");

set_session("ss_datetime", $g4[server_time]);
session_write_close();

// 동일내용 연속 등록 불가
$sql = " select MD5(CONCAT(wr_ip, wr_subject, wr_content)) as prev_md5 from $write_table ";
if ($w == "cu")
    $sql .= " where wr_id <> '$commend_id' ";
$sql .= " order by wr_id desc limit 1 ";
$row = sql_fetch($sql);
$curr_md5 = md5($_SERVER[REMOTE_ADDR].$wr_subject.$wr_content);
// 코멘트 수정의 경우에는 동일한 내용을 등록할 수 없는 오류 수정
//if ($row[prev_md5] == $curr_md5 && !$is_admin)
if ($row[prev_md5] == $curr_md5 && $w != 'cu' && !$is_admin)
    alert("동일한 내용을 연속해서 등록할 수 없습니다.");

$wr = get_write($write_table, $wr_id);
if (!$wr[wr_id]) 
    alert("글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다."); 

// 자동등록방지 검사 - 비회원의 경우만
//if (!$is_member) 
//    include_once ("./norobot_check.inc.php");

if (!$is_member) {
    if ($w=='' || $w=='c') {
        include_once("$g4[path]/zmSpamFree/zmSpamFree.php");
        if ( !zsfCheck( $_POST['wr_key'], $_GET['bo_table'] ) ) { alert ('스팸차단코드가 틀렸습니다.'); }    
    }
}


// "인터넷옵션 > 보안 > 사용자정의수준 > 스크립팅 > Action 스크립팅 > 사용 안 함" 일 경우의 오류 처리
// 이 옵션을 사용 안 함으로 설정할 경우 어떤 스크립트도 실행 되지 않습니다.
//if (!trim($_POST["wr_content"])) die ("내용을 입력하여 주십시오.");

if ($member[mb_id]) 
{
    $mb_id = $member[mb_id];
    // 4.00.13 - 실명 사용일때 코멘트에 별명으로 입력되던 오류를 수정
    $wr_name = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $wr_password = $member[mb_password];
    $wr_email = $member[mb_email];
    $wr_homepage = $member[mb_homepage];
} 
else 
{
    $mb_id = "";
    $wr_password = sql_password($wr_password);
}

if ($w == "c") // 코멘트 입력
{
    /*
    if ($member[mb_point] + $board[bo_comment_point] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 코멘트쓰기(".number_format($board[bo_comment_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 코멘트를 써 주십시오.");
    */
    // 코멘트쓰기 포인트설정시 회원의 포인트가 음수인 경우 코멘트를 쓰지 못하던 버그를 수정 (곱슬최씨님)
    $tmp_point = ($member[mb_point] > 0) ? $member[mb_point] : 0;
    if ($tmp_point + $board[bo_comment_point] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 코멘트쓰기(".number_format($board[bo_comment_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 코멘트를 써 주십시오.");

    // 코멘트 답변
    if ($comment_id) 
    {
        $sql = " select wr_id, wr_comment, wr_comment_reply, mb_id from $write_table 
                  where wr_id = '$comment_id' ";
        
        //불당팩 (코멘트인 경우 원글의 mb_id를 입력)
        $parent_mb_id = sql_fetch(" select mb_id from $write_table where wr_id = '$comment_id' ");

        $reply_array = sql_fetch($sql);
        if (!$reply_array[wr_id])
            alert("답변할 코멘트가 없습니다.\\n\\n답변하는 동안 코멘트가 삭제되었을 수 있습니다.");

        $tmp_comment = $reply_array[wr_comment];

        if (strlen($reply_array[wr_comment_reply]) == 5)
            alert("더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.");

        $reply_len = strlen($reply_array[wr_comment_reply]) + 1;
        if ($board[bo_reply_order]) {
            $begin_reply_char = "A";
            $end_reply_char = "Z";
            $reply_number = +1;
            $sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply 
                       from $write_table 
                      where wr_parent = '$wr_id' 
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        } 
        else 
        {
            $begin_reply_char = "Z";
            $end_reply_char = "A";
            $reply_number = -1;
            $sql = " select MIN(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply 
                       from $write_table 
                      where wr_parent = '$wr_id' 
                        and wr_comment = '$tmp_comment'
                       and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        }
        if ($reply_array[wr_comment_reply]) 
            $sql .= " and wr_comment_reply like '$reply_array[wr_comment_reply]%' ";
        $row = sql_fetch($sql);

        if (!$row[reply])
            $reply_char = $begin_reply_char;
        else if ($row[reply] == $end_reply_char) // A~Z은 26 입니다.
            alert("더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.");
        else
            $reply_char = chr(ord($row[reply]) + $reply_number);

        $tmp_comment_reply = $reply_array[wr_comment_reply] . $reply_char;
    }
    else 
    {
        //불당팩 (코멘트인 경우 원글의 mb_id를 입력)
        $parent_mb_id = sql_fetch(" select mb_id from $write_table where wr_id = '$wr_id' ");

        $sql = " select max(wr_comment) as max_comment from $write_table 
                  where wr_parent = '$wr_id' and wr_is_comment = 1 ";
        $row = sql_fetch($sql);
        //$row[max_comment] -= 1;
        $row[max_comment] += 1;
        $tmp_comment = $row[max_comment];
        $tmp_comment_reply = "";
    }

    $sql = " insert into $write_table
                set ca_name = '$wr[ca_name]',
                    wr_option = concat_ws(',','$html', '$wr_secret', '$mail'),
                    wr_num = '$wr[wr_num]',
                    wr_reply = '',
                    wr_parent = '$wr_id',
                    wr_is_comment = '1',
                    wr_comment = '$tmp_comment',
                    wr_comment_reply = '$tmp_comment_reply',
                    wr_subject = '$wr_subject',
                    wr_content = '$wr_content',
                    mb_id = '$mb_id',
                    wr_password = '$wr_password',
                    wr_name = '$wr_name',
                    wr_email = '$wr_email',
                    wr_homepage = '$wr_homepage',
                    wr_datetime = '$g4[time_ymdhis]',
                    wr_last = '',
                    wr_ip = '$remote_addr',
                    wr_1 = '$wr_1',
                    wr_2 = '$wr_2',
                    wr_3 = '$wr_3',
                    wr_4 = '$wr_4',
                    wr_5 = '$wr_5',
                    wr_6 = '$wr_6',
                    wr_7 = '$wr_7',
                    wr_8 = '$wr_8',
                    wr_9 = '$wr_9',
                    wr_10 = '$wr_10' ";
    sql_query($sql);

    $comment_id = mysql_insert_id();

    // 원글에 코멘트수 증가 & 마지막 시간 반영
    sql_query(" update $write_table set wr_comment = wr_comment + 1, wr_last = '$g4[time_ymdhis]' where wr_id = '$wr_id' ");

    //불당팩 (코멘트인 경우 원글의 mb_id를 입력)
    //$parent_mb_id = sql_fetch(" select mb_id from $write_table where wr_id = '$wr_id' ");

    // 새글 INSERT
    //sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime ) values ( '$bo_table', '$comment_id', '$wr_id', '$g4[time_ymdhis]' ) ");
    //sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$comment_id', '$wr_id', '$g4[time_ymdhis]', '$member[mb_id]' ) ");
    sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id, wr_is_comment, gr_id, my_datetime, wr_option, parent_mb_id ) 
                       values ( '$bo_table', '$comment_id', '$wr_id', '$g4[time_ymdhis]', '$member[mb_id]', '1', '$gr_id', '$g4[time_ymdhis]', '$wr_secret', '$parent_mb_id[mb_id]' ) "); 

    // 원글에 my_datetime UPDATE
    sql_query(" update $g4[board_new_table] set my_datetime = '$g4[time_ymdhis]' where bo_table = '$bo_table' and wr_id = '$wr_id' ");  
    
    // 코멘트 1 증가
    sql_query(" update $g4[board_table] set bo_count_comment = bo_count_comment + 1, bo_modify_datetime = '$g4[time_ymdhis]' where bo_table = '$bo_table' ");

    // 오래된 글에 코멘트 쓰기를 하는 경우 포인트를 부여하지 않음
    $time_diff = ($g4[server_time] - (86400 * $config['cf_no_comment_point_days'])) - strtotime($wr[wr_datetime]);
    if ($config['cf_no_comment_point_days'] && $time_diff >= 0) {
        // 포인트 안주고 깍을 경우에는 별도 수정을 해주세요.
        ;
    } else {
        // 포인트 부여
        insert_point($member[mb_id], $board[bo_comment_point], "$board[bo_subject] {$wr_id}-{$comment_id} 코멘트쓰기", $bo_table, $comment_id, '코멘트');
    }

    // 불당팩 - 베스트글을 위해서 체크
    $comment_cnt = $wr[wr_comment]+1;
    if ( $board[bo_list_comment] > 0 && $comment_cnt >= $board[bo_list_comment]) {
        // UPDATE를 먼저하고 오류가 발생시 insert를 실행
        $sql = " update $g4[good_list_table] set comment = $comment_cnt where bo_table='$bo_table' and wr_id='$wr[wr_id]' ";
        $result = sql_query($sql, FALSE);
        if ( mysql_affected_rows() == 0 ) {
            $sql = " insert $g4[good_list_table] ( mb_id, gr_id, bo_table, wr_id, wr_datetime, gl_datetime, comment) values ( '$wr[mb_id]', '$board[gr_id]', '$bo_table', '$wr_id', '$wr[wr_datetime]', '$g4[time_ymdhis]', '$comment_cnt' ) ";
            $result = sql_query($sql, FALSE);
        }
    }
    
    // 불당팩 - 왔~숑~ : 코멘트의 왔숑 통보 (원글에, mb_id가 있고, 현재 글쓴이와 다를 경우에만.)
    if ($wr[mb_id] && $wr[mb_id] !== $member[mb_id])
    {
        $tsql = " UPDATE $g4[whatson_table] 
                      SET wr_subject = '" . get_text(stripslashes($wr[wr_subject])) . "',
                          wo_count = wo_count+1,
                          wo_datetime = '$g4[time_ymdhis]' 
                    where bo_table = '$bo_table' and wr_id='$wr[wr_id]' and mb_id='$wr[mb_id]' and wo_type='write_comment' ";
        sql_query($tsql);

        // update가 안되는 경우에는 insert를 합니다.
        if (!mysql_affected_rows()) {
            $tsql = " insert into $g4[whatson_table] ( mb_id, wr_subject, wo_type, wo_count, wo_datetime, bo_table, wr_id, comment_id ) 
                      values ('$wr[mb_id]', '" . get_text(stripslashes($wr[wr_subject])) . "','write_comment','1','$g4[time_ymdhis]','$bo_table','$wr_id', '$comment_id') ";
            sql_query($tsql, FALSE);
        }
    }

    // 불당팩 - 왔~숑~ : 코멘트의 왔숑 통보 (원래 코멘트에, mb_id가 있을 때만)
    if ($comment_id && $reply_array[mb_id] && $reply_array[mb_id] !== $member[mb_id]) {
        $tsql = " UPDATE $g4[whatson_table] 
                      SET wr_subject = '" . get_text(stripslashes($wr[wr_subject])) . "',
                          wo_count = wo_count+1,
                          wo_datetime = '$g4[time_ymdhis]' 
                    where bo_table = '$bo_table' and wr_id='$wr_id' and comment_id='$comment_id' and mb_id='$reply_array[mb_id]' and wo_type='write_comment' ";
        sql_query($tsql);

        // update가 안되는 경우에는 insert를 합니다.
        if (!mysql_affected_rows()) {
            $tsql = " insert into $g4[whatson_table] ( mb_id, wr_subject, wo_type, wo_count, wo_datetime, bo_table, wr_id, comment_id ) 
                      values ('$reply_array[mb_id]', '" . get_text(stripslashes($wr[wr_subject])) . "','write_comment','1','$g4[time_ymdhis]','$bo_table', '$wr_id', '$comment_id') ";
            sql_query($tsql, FALSE);
        }
    }

    // 메일발송 사용
    if ($config[cf_email_use] && $board[bo_use_email])
    {
        // 관리자의 정보를 얻고
        $super_admin = get_admin("super");
        $group_admin = get_admin("group");
        $board_admin = get_admin("board");

        $wr_subject = get_text(stripslashes($wr[wr_subject]));
        $wr_content = nl2br(get_text(stripslashes("----- 원글 -----\n\n$wr[wr_subject]\n\n\n----- 코멘트 -----\n\n$wr_content")));

        $warr = array( ""=>"입력", "u"=>"수정", "r"=>"답변", "c"=>"코멘트", "cu"=>"코멘트 수정" );
        $str = $warr[$w];

        $subject = "'{$board[bo_subject]}' 게시판에 {$str}글이 올라왔습니다.";
        // 4.00.15 - 메일로 보내는 코멘트의 바로가기 링크 수정
        $link_url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id&$qstr#c_{$comment_id}";

        include_once("$g4[path]/lib/mailer.lib.php");

        ob_start();
        include_once ("./write_update_mail.php");
        $content = ob_get_contents();
        ob_end_clean();

        $array_email = array();
        // 게시판관리자에게 보내는 메일
        if ($config[cf_email_wr_board_admin]) $array_email[] = $board_admin[mb_email];
        // 게시판그룹관리자에게 보내는 메일
        if ($config[cf_email_wr_group_admin]) $array_email[] = $group_admin[mb_email];
        // 최고관리자에게 보내는 메일
        if ($config[cf_email_wr_super_admin]) $array_email[] = $super_admin[mb_email];

        // 옵션에 메일받기가 체크되어 있고, 게시자의 메일이 있다면
        if (strstr($wr[wr_option], "mail") && $wr[wr_email]) {
            // 원글 메일발송에 체크가 되어 있다면
            if ($config[cf_email_wr_write]) $array_email[] = $wr[wr_email];

            // 코멘트 쓴 모든이에게 메일 발송이 되어 있다면 (자신에게는 발송하지 않는다)
            if ($config[cf_email_wr_comment_all]) {
                $sql = " select distinct wr_email from $write_table
                          where wr_email not in ( '$wr[wr_email]', '$member[mb_email]', '' )
                            and wr_parent = '$wr_id' ";
                $result = sql_query($sql);
                while ($row=sql_fetch_array($result))
                    $array_email[] = $row[wr_email];
            }
        }

        // 중복된 메일 주소는 제거
        $unique_email = array_unique($array_email);
        $unique_email = array_values($unique_email);
        for ($i=0; $i<count($unique_email); $i++) {
            mailer($wr_name, $wr_email, $unique_email[$i], $subject, $content, 1);
        }
    }
} 
else if ($w == "cu") // 코멘트 수정
{ 
    $sql = " select mb_id, wr_comment, wr_comment_reply from $write_table 
              where wr_id = '$comment_id' ";
    $comment = $reply_array = sql_fetch($sql);
    $tmp_comment = $reply_array[wr_comment];

    $len = strlen($reply_array[wr_comment_reply]);
    if ($len < 0) $len = 0; 
    $comment_reply = substr($reply_array[wr_comment_reply], 0, $len);
    //print_r2($GLOBALS); exit;

    if ($is_admin == "super") // 최고관리자 통과 
        ; 
    else if ($is_admin == "group") { // 그룹관리자 
        $mb = get_member($comment[mb_id]); 
        if ($member[mb_id] == $group[gr_admin]) { // 자신이 관리하는 그룹인가? 
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과 
                ; 
            else 
                alert("그룹관리자의 권한보다 높은 회원의 코멘트이므로 수정할 수 없습니다."); 
        } else 
            alert("자신이 관리하는 그룹의 게시판이 아니므로 코멘트를 수정할 수 없습니다."); 
    } else if ($is_admin == "board") { // 게시판관리자이면 
        $mb = get_member($comment[mb_id]); 
        if ($member[mb_id] == $board[bo_admin]) { // 자신이 관리하는 게시판인가? 
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과 
                ; 
            else 
                alert("게시판관리자의 권한보다 높은 회원의 코멘트이므로 수정할 수 없습니다."); 
        } else 
            alert("자신이 관리하는 게시판이 아니므로 코멘트를 수정할 수 없습니다."); 
    } else if ($member[mb_id]) { 
        if ($member[mb_id] != $comment[mb_id]) 
            alert("자신의 글이 아니므로 수정할 수 없습니다."); 
    } 

    $sql = " select count(*) as cnt from $write_table
              where wr_comment_reply like '$comment_reply%'
                and wr_id <> '$comment_id'
                and wr_parent = '$wr_id'
                and wr_comment = '$tmp_comment' 
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($row[cnt] && !$is_admin)
        alert("이 코멘트와 관련된 답변코멘트가 존재하므로 수정 할 수 없습니다.");

    $sql_ip = "";
    if (!$is_admin)
        $sql_ip = " , wr_ip = '$remote_addr' ";

    //$sql_secret = "";
    //if ($wr_secret)
    //    $sql_secret = " , wr_option = '$wr_secret' ";

    $sql = " update $write_table
                set wr_subject = '$wr_subject',
                    wr_content = '$wr_content',
                    wr_1 = '$wr_1',
                    wr_2 = '$wr_2',
                    wr_3 = '$wr_3',
                    wr_4 = '$wr_4',
                    wr_5 = '$wr_5',
                    wr_6 = '$wr_6',
                    wr_7 = '$wr_7',
                    wr_8 = '$wr_8',
                    wr_9 = '$wr_9',
                    wr_10 = '$wr_10',
                    wr_option = concat_ws(',','$html', '$wr_secret', '$mail')
                    $sql_ip
              where wr_id = '$comment_id' ";
    sql_query($sql);

    // 수정한 글에 my_datetime, wr_option UPDATE
    sql_query(" update $g4[board_new_table] set my_datetime = '$g4[time_ymdhis]', wr_option = '$wr_secret' where bo_table = '$bo_table' and wr_id = '$comment_id' ");
    // 원글에 my_datetime UPDATE
    sql_query(" update $g4[board_new_table] set my_datetime = '$g4[time_ymdhis]' where bo_table = '$bo_table' and wr_id = '$wr_id' ");    
}

// 사용자 코드 실행
if (file_exists("$board_skin_path/write_comment_update.skin.php"))
    @include_once("$board_skin_path/write_comment_update.skin.php");
if (file_exists("$board_skin_path/write_comment_update.tail.skin.php"))
    @include_once("$board_skin_path/write_comment_update.tail.skin.php");

goto_url("./board.php?bo_table=$bo_table&wr_id=$wr[wr_parent]&page=$page" . $qstr . "&cwin=$cwin#c_{$comment_id}");
?>
