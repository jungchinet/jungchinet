<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 게시판에서 두단어 이상 검색 후 검색된 게시물에 코멘트를 남기면 나오던 오류 수정
$sop = strtolower($sop);
if ($sop != "and" && $sop != "or")
    $sop = "and";

if (file_exists("$board_skin_path/view.head.skin.php"))
    @include_once("$board_skin_path/view.head.skin.php");

$sql_search = "";
// 검색이면
if ($sca || $stx) {
    // where 문을 얻음
    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);
    $search_href = "./board.php?bo_table=$bo_table&page=$page" . $qstr;
    $list_href = "./board.php?bo_table=$bo_table" . $mstr;
} else {
    $search_href = "";
    $list_href = "./board.php?bo_table=$bo_table&page=$page" . $mstr;
}

if (!$board[bo_use_list_view]) {
    if ($sql_search)
        $sql_search = " and " . $sql_search;

    // 윗글을 얻음
    $sql = " select wr_id, wr_subject from $write_table where wr_is_comment = 0 and wr_num = '$write[wr_num]' and wr_reply < '$write[wr_reply]' $sql_search order by wr_num desc, wr_reply desc limit 1 ";
    $prev = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (!$prev[wr_id])     {
        $sql = " select wr_id, wr_subject from $write_table where wr_is_comment = 0 and wr_num < '$write[wr_num]' $sql_search order by wr_num desc, wr_reply desc limit 1 ";
        $prev = sql_fetch($sql);
    }

    // 아래글을 얻음
    $sql = " select wr_id, wr_subject from $write_table where wr_is_comment = 0 and wr_num = '$write[wr_num]' and wr_reply > '$write[wr_reply]' $sql_search order by wr_num, wr_reply limit 1 ";
    $next = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (!$next[wr_id]) {
        $sql = " select wr_id, wr_subject from $write_table where wr_is_comment = 0 and wr_num > '$write[wr_num]' $sql_search order by wr_num, wr_reply limit 1 ";
        $next = sql_fetch($sql);
    }
}

// 이전글 링크
$prev_href = "";
if ($prev[wr_id]) {
    $prev_wr_subject = get_text(cut_str($prev[wr_subject], 255));
    $prev_href = "./board.php?bo_table=$bo_table&wr_id=$prev[wr_id]&page=$page" . $qstr;
}

// 다음글 링크
$next_href = "";
if ($next[wr_id]) {
    $next_wr_subject = get_text(cut_str($next[wr_subject], 255));
    $next_href = "./board.php?bo_table=$bo_table&wr_id=$next[wr_id]&page=$page" . $qstr;
}

// 쓰기 링크
$write_href = "";
if ($member[mb_level] >= $board[bo_write_level])
    $write_href = "./write.php?bo_table=$bo_table" . $mstr;

// 답변 링크
$reply_href = "";
if ($member[mb_level] >= $board[bo_reply_level])
    $reply_href = "./write.php?w=r&bo_table=$bo_table&wr_id=$wr_id" . $qstr;

// 수정, 삭제 링크
$update_href = $delete_href = "";
// 로그인중이고 자신의 글이라면 또는 관리자라면 패스워드를 묻지 않고 바로 수정, 삭제 가능
if (($member[mb_id] && ($member[mb_id] == $write[mb_id])) || $is_admin) {
    $update_href = "./write.php?w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr;
    $delete_href = "javascript:del('./delete.php?bo_table=$bo_table&wr_id=$wr_id&page=$page".urldecode($qstr)."');";
    if ($is_admin) 
    {
        set_session("ss_delete_token", $token = uniqid(time()));
        $delete_href = "javascript:del('./delete.php?bo_table=$bo_table&wr_id=$wr_id&token=$token&page=$page".urldecode($qstr)."');";
    }
}
else if (!$write[mb_id]) { // 회원이 쓴 글이 아니라면
    $update_href = "./password.php?w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr;
    $delete_href = "./password.php?w=d&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr;
}

// 최고, 그룹관리자라면 글 복사, 이동 가능
$copy_href = $move_href = "";
if ($write[wr_reply] == "" && ($is_admin == "super" || $is_admin == "group")) {
    $copy_href = "javascript:win_open('./move.php?sw=copy&bo_table=$bo_table&wr_id=$wr_id&page=$page".$qstr."', 'boardcopy', 'left=50, top=50, width=500, height=550, scrollbars=1');";
    $move_href = "javascript:win_open('./move.php?sw=move&bo_table=$bo_table&wr_id=$wr_id&page=$page".$qstr."', 'boardmove', 'left=50, top=50, width=500, height=550, scrollbars=1');";
}

// 게시글 대피기능
if ($board['bo_move_bo_table'] && $write['mb_id'] == $member['mb_id'] && $is_amin != 'super' && $is_admin != 'group') {
    $move_href = "javascript:move('./move2_update.php?bo_table=$bo_table&wr_id=$wr_id&page=$page".$qstr."');";;
}

$scrap_href = "";
$good_href = "";
$nogood_href = "";
if ($member[mb_id]) {
    // 스크랩 링크
    $scrap_href = "./scrap_popin.php?bo_table=$bo_table&wr_id=$wr_id";

    // 추천 링크
  //  if ($board[bo_use_good])
  //      $good_href = "./good.php?bo_table=$bo_table&wr_id=$wr_id&good=good" . $mstr;

    // 비추천 링크
  //  if ($board[bo_use_nogood])
  //      $nogood_href = "./good.php?bo_table=$bo_table&wr_id=$wr_id&good=nogood" . $mstr;
}

// 추천 링크
    if ($board[bo_use_good])
        $good_href = "./good.php?bo_table=$bo_table&wr_id=$wr_id&good=good" . $mstr;

    // 비추천 링크
    if ($board[bo_use_nogood])
        $nogood_href = "./good.php?bo_table=$bo_table&wr_id=$wr_id&good=nogood" . $mstr;
        
$view = get_view($write, $board, $board_skin_path, 255);

//print_r($view);

// 게시글 잠금 가능하게 - 불당팩 : 배추님의 팁 (관리자 또는 게시글 작성자만 가능하게)
if ($is_admin || ($member["mb_id"] && $member["mb_id"] == $view["mb_id"])) { 
    if (strstr($view[wr_option], "secret")) { 
        // 잠금 해제 버튼
        $nosecret_href = "javascript:post_submit('proc/mw.btn.secret.php?page=$page$qstr','$bo_table','$wr_id', '', 'no', '게시글 잠금해제')";
    } else { 
        // 잠금 버튼
        $secret_href = "javascript:post_submit('proc/mw.btn.secret.php?page=$page$qstr','$bo_table','$wr_id', '', '', '게시글 잠금')";
    }
}

// 게시글 업데이트 날짜를 지금으로 - 불당팩 : 배추님의 팁 (관리자만 가능하게)
if ($is_admin) {
    $now_href = "javascript:post_submit('proc/mw.time.now.php?page=$page$qstr','$bo_table','$wr_id', '', '', '게시글 날짜 업데이트하기')";
}
  
// 신고 링크 - 코멘트 쓰기 권한이 있는 사람에게만 보이게
$singo_href = "";
if ($board[bo_singo] && $write_href && $member[mb_id] != $write[mb_id] && $member['mb_level'] >= $board['bo_comment_level'])
    $singo_href = "./singo_popin.php?bo_table=$bo_table&wr_id=$wr_id&wr_parent=$wr_id" . $mstr;

// 신고해지 링크
$unsingo_href = "";
if ($board[bo_singo] && $view[wr_singo] && $member[mb_id] != $write[mb_id] && $member['mb_level'] >= $board['bo_comment_level'])
    $unsingo_href = "./unsingo_popin.php?bo_table=$bo_table&wr_id=$wr_id&wr_parent=$wr_id" . $mstr;

if (strstr($sfl, "subject"))
    $view[subject] = search_font($stx, $view[subject]);

$html = 0;
if (strstr($view[wr_option], "html1"))
    $html = 1;
else if (strstr($view[wr_option], "html2"))
    $html = 2;

// 비밀글 - 남이 쓴 비밀글에 내 코멘트가 있을 때  
if ($is_unlock_secret && strstr($view[wr_option], "secret") && $view['mb_id'] !== $member['mb_id']) {
    // 내용이 보이지 않게
    $view[rich_content] = $view[content] = $view[content1] = "<font color=red><b>타인이 작성한 비밀글 입니다.</b></font>";
    // 첨부파일이 보이지 않게
    $view[file] = array();
    // 링크가 보이지 않게
    $view[link] = array();
} else {

$view[content] = conv_content($view[wr_content], $html);
if (strstr($sfl, "content"))
    $view[content] = search_font($stx, $view[content]);
$view[content] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' onclick='image_window(this)' class='pointer' \\2 \\3", $view[content]);

//$view[rich_content] = preg_replace("/{img\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view[content]);
$view[rich_content] = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view[content]);

$singo = "";
if ($write[wr_singo] and $board[bo_singo_action] > 0 and $write[wr_singo] >= $board[bo_singo_action])
{
    $singo .= "<div id='singo_title{$view[wr_id]}' class='singo_title'><font color=gray>신고가 접수된 게시물입니다. ";
    //$singo .= "<a href='javascript:;' onclick=\"document.getElementById('singo_contents{$view[wr_id]}').style.display=(document.getElementById('singo_contents{$view[wr_id]}').style.display=='none'?'':'none');\">";
    //$singo .= "<span class='singo_here'>여기</span></a>를 클릭하시면 내용을 볼 수 있습니다.</div>";
    $singo .= "<span class='singo_here' style='cursor:pointer;font-weight:bold;' onclick=\"document.getElementById('singo_contents{$view[wr_id]}').style.display=(document.getElementById('singo_contents{$view[wr_id]}').style.display=='none'?'':'none');\"><font color=red>여기</font></span>를 클릭하시면 내용을 볼 수 있습니다.</font></div>";

    // 신고이유의 출력 여부를 결정 (singo_popin.skin.php에서 출력여부를 판단하면 사용자가 선택후 값을 변경할 수 있기 때문임)
    // 표준 신고이유만 출력하는 것이 원칙. 그렇지 않은 경우 신고기능을 타인의 비방에 사용할 수 있기 때문입니다.
    $sql = " select distinct a.sg_reason from $g4[singo_table] a, $g4[singo_reason_table] b where a.bo_table = '$bo_table' and a.wr_id = '$wr_id' and a.sg_reason = b.sg_reason order by a.sg_id ";
    $sg_result = sql_query($sql);
        
    $sg_reason = "";
    for ($i=0; $sg_row = sql_fetch_array($sg_result); $i++) {
        $sg_reason .= $sg_row['sg_reason'] . "/" ;
    }
            
    if ($sg_reason)
        $singo .= "<font color=gray>신고이유는 \" $sg_reason \" 입니다</font>";

    $singo .= "<div id='singo_contents{$view[wr_id]}' style='display:none;'><p>";
    $singo .= $view[content];
    $singo .= "</div>";

    $view[content] = $singo;
}

} // 비밀글 - 남이 쓴 비밀글에 내 코멘트가 있을 때 

// 불당팩 : 게시글안에 추천기능 스크립트를 넣는거 방지 
$view[content] = preg_replace("/good\=good/i", "good=nogood", $view[content]); 

// 불당팩 : 과도한 이미지 size로 인한 출력제한 - 마지막에 둔다. 위에 프로세스는 일단 무조건 정상. 이거는 fortran이 아니니까.
if ($board[bo_image_max_size] && $view[wr_imagesize] > 0 && $view[wr_imagesize] > $board[bo_image_max_size]) {
    $msg = "<font color=red><b>첨부파일과 웹편집기로 올린 이미지의 합계가 " . number_format($board[bo_image_max_size]) . " kb를 초과한 " . number_format($view[wr_imagesize]) . " kb 이므로 출력할 수 없습니다.<br>이미지를 줄여주시기 바랍니다.<br></b></font>";
    if (($member[mb_id] && ($member[mb_id] == $view[mb_id]) || $is_admin))
        $view[content] = $msg . $view[content];
    else  {
        // count가 0이면 for loop가 수행된다.
        $view[file][count] = -1;
        // 신고 이미지정보도 안나오게 차단
        $view['wr_singo'] = false;
        // 내용에는 경고문만
        $view[content] = $msg;
    }
}


// 불당팩 - 게시글주소
$posting_url = "$g4[url]/$g4[bbs]/board.php?bo_table=$bo_table&wr_id=$wr_id";

$is_signature = false;
$signature = "";
if ($board[bo_use_signature] && $view[mb_id])
{
    $is_signature = true;
    if ($member[mb_id] && $member[mb_id] == $view[mb_id]) {
        $signature = $member[mb_signature];
    } else {
        $mb = get_member($view[mb_id], "mb_signature");
        $signature = $mb[mb_signature];
    }

    //$signature = bad_tag_convert($signature);
    // 081022 : CSRF 보안 결함으로 인한 코드 수정
    $signature = conv_content($signature, 1);
}

echo "<script type='text/javascript' src='{$g4['path']}/js/ajax.js'></script>";
include_once("$board_skin_path/view.skin.php");

if (file_exists("$board_skin_path/view.tail.skin.php"))
    @include_once("$board_skin_path/view.tail.skin.php");
?>
