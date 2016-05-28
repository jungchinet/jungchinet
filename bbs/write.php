<?
include_once("./_common.php");

set_session('ss_bo_table', $_REQUEST['bo_table']);
set_session('ss_wr_id', $_REQUEST['wr_id']);

// 090713
if (!$board[bo_table])
{
    if ($cwin) // 코멘트 보기
       alert_close("존재하지 않는 게시판입니다.", $g4[path]);
    else
       alert("존재하지 않는 게시판입니다.", $g4[path]);
}

if (!$bo_table)
    alert("bo_table 값이 넘어오지 않았습니다.\\n\\nwrite.php?bo_table=code 와 같은 방식으로 넘겨 주세요.", $g4[path]);

if (file_exists("$g4[path]/skin/board/write.head.skin.php"))
    @include_once ("$g4[path]/skin/board/write.head.skin.php");
if (file_exists("$board_skin_path/write.head.skin.php"))
    @include_once ("$board_skin_path/write.head.skin.php");

$notice_array = explode("\n", trim($board[bo_notice]));

// 불당팩 : 신고 - 게시글 쓰기제한
if ($board['bo_singo_nowrite']) {
    $singo_result = check_singo_nowrite($board[bo_singo_nowrite]);
    if ($singo_result)
        alert("[신고] 글쓰기 제한입니다. 관리자에게 문의하시기 바랍니다", "$g4[bbs_path]/board.php?bo_table=$bo_table");
}

// 불당팩 : 핸드폰 인증받은 회원만 글쓰기 가능하게
if ($board[bo_hhp]) { 
    if (!trim($member[mb_hp_certify_datetime]) || trim($member[mb_hp_certify_datetime]) == "0000-00-00 00:00:00") { 
        alert("이 게시판은 핸드폰번호 인증을 받은 회원만 글쓰기가 가능합니다.\\n\\n회원정보 수정에서 핸드폰 인증을 받으시기 바랍니다."); 
    } 
}

// 불당팩 : 실명인증된 회원만 글쓰게 하기
if ($w == "" && $board[bo_realcheck] && !$is_admin) { 
    if ($member[mb_realcheck] == "0000-00-00 00:00:00") { 
        alert("이 게시판은 본인인증을 받은 회원만 글쓰기가 가능합니다.", "$g4[path]/plugin/kcb/index.php"); 
    } 
}

// 연속쓰기 방지
if ($w == "" || $w == "r") 
{
    $delay = $_SESSION["ss_datetime2"] - $g4[server_time] + $config[cf_delay_sec];
    if ($delay > 0 && !$is_delay) 
        alert("너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.");

    set_session("ss_datetime2", $g4[server_time]);
    
    // 하나의 아이디로 세션을 다르게 하는 넘들을 위해서 쿠키도 같이 씁니다.
    if (get_cookie("ck_datetime2") >= ($g4[server_time] - $config[cf_delay_sec]) && !$is_delay) 
        alert("너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.");

    set_cookie("ck_datetime2", "$g4[server_time]", 86400) ;
}

if ($w == "") 
{
    if (isset($wr_id))
        alert("글쓰기에는 \$wr_id 값을 사용하지 않습니다.", "$g4[bbs_path]/board.php?bo_table=$bo_table");

    if ($member[mb_level] < $board[bo_write_level]) {
        if ($member[mb_id])
            alert("글을 쓸 권한이 없습니다.");
        else
            alert("글을 쓸 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]?bo_table=$bo_table"));
    }

    /*
    if ($member[mb_point] + $board[bo_write_point] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글쓰기(".number_format($board[bo_write_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글쓰기 해 주십시오.");
    */

    // 음수도 true 인것을 왜 이제야 알았을까?
    //$tmp_point = $member[mb_point] ? $member[mb_point] : 0;
    $tmp_point = ($member[mb_point] > 0) ? $member[mb_point] : 0;
    if ($tmp_point + $board[bo_write_point] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글쓰기(".number_format($board[bo_write_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글쓰기 해 주십시오.");

    $title_msg = "글쓰기";
}
else if ($w == "u")
{
    // 김선용 1.00 : 글쓰기 권한과 수정은 별도로 처리되어야 함
    //if ($member[mb_level] < $board[bo_write_level]) {
    if($member['mb_id'] && $write['mb_id'] == $member['mb_id'])
        ;
    else if ($member[mb_level] < $board[bo_write_level]) {
        if ($member[mb_id])
            alert("글을 수정할 권한이 없습니다.");
        else
            alert("글을 수정할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]?bo_table=$bo_table"));
    }

    $len = strlen($write[wr_reply]);
    if ($len < 0) $len = 0;
    $reply = substr($write[wr_reply], 0, $len);

    // 원글만 구한다.
    $sql = " select count(*) as cnt from $write_table
              where wr_reply like '$reply%'
                and wr_id <> '$write[wr_id]'
                and wr_num = '$write[wr_num]'
                and wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    if ($row[cnt] && !$is_admin)
        alert("이 글과 관련된 답변글이 존재하므로 수정 할 수 없습니다.\\n\\n답변글이 있는 원글은 수정할 수 없습니다.");

    // 코멘트 달린 원글의 수정 여부
    $sql = " select count(*) as cnt from $write_table
              where wr_parent = '$wr_id'
                and mb_id <> '$member[mb_id]'
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($row[cnt] >= $board[bo_count_modify] && !$is_admin)
        alert("이 글과 관련된 코멘트가 존재하므로 수정 할 수 없습니다.\\n\\n코멘트가 {$board[bo_count_modify]}건 이상 달린 원글은 수정할 수 없습니다.");

    $title_msg = "글수정";
}
else if ($w == "r")
{
    if ($member[mb_level] < $board[bo_reply_level]) {
        if ($member[mb_id])
            alert("글을 답변할 권한이 없습니다.");
        else
            alert("글을 답변할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]?bo_table=$bo_table"));
    }

    /*
    if ($member[mb_point] + $board[bo_comment_point] < 0)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글답변(".number_format($board[bo_comment_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글답변 해 주십시오.");
    */

    $tmp_point = $member[mb_point] ? $member[mb_point] : 0;
    if ($tmp_point + $board[bo_write_point] < 0 && !$is_admin)
        alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 글답변(".number_format($board[bo_comment_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글답변 해 주십시오.");

    //if (preg_match("/[^0-9]{0,1}{$wr_id}[\r]{0,1}/",$board[bo_notice]))
    if (in_array((int)$wr_id, $notice_array))
        alert("공지에는 답변 할 수 없습니다.");

    //----------
    // 4.06.13 : 비밀글을 타인이 열람할 수 있는 오류 수정 (헐랭이, 플록님께서 알려주셨습니다.)
    // 코멘트에는 원글의 답변이 불가하므로
    if ($write[wr_is_comment])
        alert("정상적인 접근이 아닙니다.");

    // 비밀글인지를 검사
    if (strstr($write[wr_option], "secret")) {
        if ($write[mb_id]) {
            // 회원의 경우는 해당 글쓴 회원 및 관리자
            if (!($write[mb_id] == $member[mb_id] || $is_admin))
                alert("비밀글에는 자신 또는 관리자만 답변이 가능합니다.");
        } else {
            // 비회원의 경우는 비밀글에 답변이 불가함
            if (!$is_admin)
                alert("비회원의 비밀글에는 답변이 불가합니다.");
        }
    }
    //----------

    // 게시글 배열 참조
    $reply_array = &$write;

    // 최대 답변은 테이블에 잡아놓은 wr_reply 사이즈만큼만 가능합니다.
    if (strlen($reply_array[wr_reply]) == 10)
        alert("더 이상 답변하실 수 없습니다.\\n\\n답변은 10단계 까지만 가능합니다.");

    $reply_len = strlen($reply_array[wr_reply]) + 1;
    if ($board[bo_reply_order]) {
        $begin_reply_char = 'A';
        $end_reply_char = 'Z';
        $reply_number = +1;
        $sql = " select MAX(SUBSTRING(wr_reply, $reply_len, 1)) as reply from $write_table where wr_num = '$reply_array[wr_num]' and SUBSTRING(wr_reply, $reply_len, 1) <> '' ";
    } else {
        $begin_reply_char = 'Z';
        $end_reply_char = 'A';
        $reply_number = -1;
        $sql = " select MIN(SUBSTRING(wr_reply, $reply_len, 1)) as reply from $write_table where wr_num = '$reply_array[wr_num]' and SUBSTRING(wr_reply, $reply_len, 1) <> '' ";
    }
    if ($reply_array[wr_reply]) $sql .= " and wr_reply like '$reply_array[wr_reply]%' ";
    $row = sql_fetch($sql);

    if (!$row[reply])
        $reply_char = $begin_reply_char;
    else if ($row[reply] == $end_reply_char) // A~Z은 26 입니다.
        alert("더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.");
    else
        $reply_char = chr(ord($row[reply]) + $reply_number);

    $reply = $reply_array[wr_reply] . $reply_char;

    $title_msg = "글답변";
} else
    alert("w 값이 제대로 넘어오지 않았습니다.");


// 그룹접근 가능
if ($group[gr_use_access])
{
    if (!$member[mb_id])
        alert("접근 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]?bo_table=$bo_table"));

    if ($is_admin == 'super' || $group[gr_admin] == $member[mb_id] || $board[bo_admin] == $member[mb_id])
        ; // 통과
    else {
        // 그룹접근
        $sql = " select gr_id from $g4[group_member_table] where gr_id = '$board[gr_id]' and mb_id = '$member[mb_id]' ";
        $row = sql_fetch($sql);
        if (!$row[gr_id])
            alert("접근 권한이 없으므로 글쓰기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.");
    }
}

$g4[title] = "$group[gr_subject] > $board[bo_subject] > " . $title_msg;

if (($w == "u" || $w == "r") && !$write[wr_id])
    alert("글이 존재하지 않습니다.\\n\\n삭제되었거나 이동된 경우입니다.", $g4[path]);

$is_notice = false;
if ($is_admin && $w != "r")
{
    $is_notice = true;

    if ($w == "u")
    {
        // 답변 수정시 공지 체크 없음
        if ($write[wr_reply])
            $is_notice = false;
        else
        {
            $notice_checked = "";
            //if (preg_match("/^".$wr_id."/m", trim($board[bo_notice])))
            //if (preg_match("/[^0-9]{0,1}{$wr_id}[\r]{0,1}/",$board[bo_notice]))
            if (in_array((int)$wr_id, $notice_array))
                $notice_checked = "checked";
        }
    }
}

// 불당팩 - 전체공지 쓰기
$is_g_notice = false;
if ($is_admin == "super" && $w != "r")
{
    $is_g_notice = true;

    if ($w == "u") 
    {
        $sql = " SELECT count(*) as cnt from $g4[notice_table] where bo_table = '$bo_table' and wr_id = '$wr_id' ";
        $cnt = sql_fetch($sql);
        if ($cnt[cnt] > 0)
            $g_notice_checked = "checked";
    }
}

$is_html = false;
if ($member[mb_level] >= $board[bo_html_level])
    $is_html = true;

/*
// 에서 무조건 비밀글 사용으로 인한 코드 수정 : 061021
$is_secret = false;
if ($board[bo_use_secret])
    $is_secret = true;
*/
$is_secret = $board[bo_use_secret];
// DHTML 에디터 사용 선택 가능하게 수정 : 061021
//$is_dhtml_editor = $board[bo_use_dhtml_editor];
// 090713
if ($board[bo_use_dhtml_editor] && $member[mb_level] >= $board[bo_dhtml_editor_level] && !$g4[g4_mobile_device])
    $is_dhtml_editor = true;
else
    $is_dhtml_editor = false;

$is_mail = false;
if ($config[cf_email_use] && $board[bo_use_email])
    $is_mail = true;

$recv_email_checked = "";
if ($w == "" || strstr($write[wr_option], "mail"))
    $recv_email_checked = "checked";

$is_name = false;
$is_password = false;
$is_email = false;
if (!$member[mb_id] || ($is_admin && $w == 'u' && $member[mb_id] != $write[mb_id])) {
    $is_name = true;
    $is_password = true;
    $is_email = true;
    $is_homepage = true;
}

$is_category = false;
if ($board[bo_use_category]) {
    $ca_name = $write[ca_name];
    $category_option = get_category_option($bo_table);
    $is_category = true;
}

$is_link = false;
if ($member[mb_level] >= $board[bo_link_level])
    $is_link = true;

$is_file = false;
if ($member[mb_level] >= $board[bo_upload_level])
    $is_file = true;

$is_file_content = false;
if ($board[bo_use_file_content])
    $is_file_content = true;

if ($w == "" || $w == "r") {
    if ($member[mb_id]) {
        $name = get_text(cut_str($write[wr_name],20));
        $email = $member[mb_email];
        $homepage = get_text($member[mb_homepage]);
    }
}

if ($w == "")
    $password_required = "required";
else if ($w == "u") {
    $password_required = "";

    if (!$is_admin) {
        if (!($member[mb_id] && $member[mb_id] == $write[mb_id]))
            if (sql_password($wr_password) != $write[wr_password])
                alert("패스워드가 틀립니다.");
    }

    $name = get_text(cut_str($write[wr_name],20));
    $email = $write[wr_email];
    $homepage = get_text($write[wr_homepage]);

    for ($i=1; $i<=$g4[link_count]; $i++) {
        $write["wr_link".$i] = get_text($write["wr_link".$i]);
        $link[$i] = $write["wr_link".$i];
    }

    if (strstr($write[wr_option], "html1")) {
        $html_checked = "checked";
        $html_value = "html1";
    } else if (strstr($write[wr_option], "html2")) {
        $html_checked = "checked";
        $html_value = "html2";
    } else
        $html_value = "";

    if (strstr($write[wr_option], "secret"))
        $secret_checked = "checked";

    $file = get_file($bo_table, $wr_id);
    
    // 불당팩 - 모바일에서 작성한 것을 html에서 수정할 때, \n을 <BR>로 바꿔야 합니다.
    if ($is_dhtml_editor && !strstr($write[wr_option], "html1") && !strstr($write[wr_option], "html1"))
        $write['wr_content'] = nl2br($write['wr_content']);

} else if ($w == "r") {
    if (strstr($write[wr_option], "secret")) {
        $is_secret = true;
        $secret_checked = "checked";
    }

    $password_required = "required";

    for ($i=1; $i<=$g4[link_count]; $i++) {
        $write["wr_link".$i] = get_text($write["wr_link".$i]);
    }
}

$subject = preg_replace("/\"/", "&#034;", get_text(cut_str($write[wr_subject], 255), 0));
if ($w == "")
    $content = $board[bo_insert_content];
else if ($w == "r") {
    //if (!$write[wr_html]) {
    if (!strstr($write[wr_option], "html")) {
        $content = "\n\n\n>"
                 //. "\n> $write[wr_datetime], \"$write[wr_name]\"님이 쓰신 글입니다. ↓"
                 . "\n>"
                 . "\n> " . preg_replace("/\n/", "\n> ", get_text($write[wr_content], 0))
                 . "\n>"
                 . "\n";

    }
} else
    $content = get_text($write[wr_content], 0);

$upload_max_filesize = number_format($board[bo_upload_size]) . " 바이트";

$width = $board[bo_table_width];
if ($width <= 100)
    $width .= '%';

// 글자수 제한 설정값
if ($is_admin)
{
    $write_min = $write_max = 0;
}
else
{
    $write_min = (int)$board[bo_write_min];
    $write_max = (int)$board[bo_write_max];
}

include_once("$g4[path]/head.sub.php");
include_once("./board_head.php");

//--------------------------------------------------------------------------
// 가변 파일
$file_script = "";
$file_length = -1;
// 수정의 경우 파일업로드 필드가 가변적으로 늘어나야 하고 삭제 표시도 해주어야 합니다.
if ($w == "u")
{
    for ($i=0; $i<$file[count]; $i++)
    {
        $row = sql_fetch(" select bf_file, bf_content, bf_datetime, bf_download from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
        if ($row[bf_file])
        {
            $file_script .= "add_file(\"<input type='checkbox' name='bf_file_del[$i]' value='1'><a href='{$file[$i][href]}' title='Down : {$row[bf_download]}, {$row[bf_datetime]}'>{$file[$i][source]}({$file[$i][size]})</a> 파일 삭제";
            if ($is_file_content)
                //$file_script .= "<br><input type='text' class=ed size=50 name='bf_content[$i]' value='{$row[bf_content]}' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
                // 첨부파일설명에서 ' 또는 " 입력되면 오류나는 부분 수정
                $file_script .= "<br><input type='text' class=ed size=50 name='bf_content[$i]' value='".addslashes(get_text($row[bf_content]))."' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
            $file_script .= "\");\n";
        }
        else
            $file_script .= "add_file('');\n";
    }
    $file_length = $file[count] - 1;
}

if ($file_length < 0)
{
    $file_script .= "add_file('');\n";
    $file_length = 0;
}
//--------------------------------------------------------------------------

// 불당팩 - 임시저장, session을 만들어준다.
if ($_SESSION[ss_tempsave] == "") {
    set_session("ss_tempsave", $g4[server_time]);
} else {
    $ss_tempsave = $_SESSION[ss_tempsave];
    // 여유 있게, 5분 이내의 세션만 유효한걸루 인정한다. 실제로는 1분 이내만 인정하는게 맞는거다. 가끔 웹 브라우저가 죽기도 하니 5분 주는거다.
    $new_time = date("Y-m-d H:i:s", $g4['server_time'] - 60*5 - 1);
    $sql = " select * from $g4[tempsave_table] where wr_session = '$ss_tempsave' and bo_table='$bo_table' and wr_id= '$wr_id' and wr_datetime > '$new_time' order by tmp_id desc limit 1";
    $wr = sql_fetch($sql);
    if ($wr) {
        $content = get_text(trim($wr[wr_content]), 0);
        $subject = get_text(trim($wr[wr_subject]), 0);
    }
}

// 불당팩 - $list_href를 만들어준다
$list_href = "./board.php?bo_table=$bo_table&page=$page" . $qstr;

include_once ("$board_skin_path/write.skin.php");

if (!$member[mb_id])
    echo "<script type='text/javascript' src='$g4[path]/js/md5.js'></script>\n";

// 필터
if (!file_exists("$g4[bbs_path]/ajax.filter.php")) {
echo "<script type='text/javascript'> var g4_cf_filter = '$config[cf_filter]'; </script>\n";
echo "<script type='text/javascript' src='$g4[path]/js/filter.js'></script>\n";
}

include_once("./board_tail.php");
include_once("$g4[path]/tail.sub.php");

if (file_exists("$board_skin_path/write.tail.skin.php"))
    @include_once ("$board_skin_path/write.tail.skin.php");
?>
<? if ($g4['write_escape']) { ?>
<script type="text/javascript"> 
  var btn_submit_pressed = true; 
  $(window).bind('beforeunload', function(){ 
      if ( btn_submit_pressed ) 
          return '페이지를 나가면, 글쓰기 정보는 저장되지 않습니다.'; 
  });
  $('a[onclick]').click(function(){ btn_submit_pressed=false; });
  $('#btn_submit').click(function(){ btn_submit_pressed=false; }); 
</script> 
<? } ?>
