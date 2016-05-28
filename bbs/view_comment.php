<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 불당팩 - 코멘트 읽기 권한
if ($board['bo_comment_read_level'] && $board['bo_comment_read_level'] > 1 && $member['mb_level'] && $member['mb_level'] < $board['bo_comment_read_level'])
{
    if ($cwin) // 코멘트 보기
       alert_close("코멘트 읽기 권한이 없는 게시판입니다.");
    else
       alert("코멘트 읽기 권한이 없는 게시판입니다.");
};

if (file_exists("$board_skin_path/view_comment.head.skin.php"))
    @include_once("$board_skin_path/view_comment.head.skin.php");

// 코멘트를 새창으로 여는 경우 세션값이 없으므로 생성한다.
if ($is_admin && !$token) 
{
    set_session("ss_delete_token", $token = uniqid(time()));
}

// 불당팩 - sideview 튜닝
$sideview = array();

$list = array();

$is_comment_write = false;
if ($member[mb_level] >= $board[bo_comment_level]) 
    $is_comment_write = true;

// DHTML 에디터 사용 선택 가능하게 수정 : 061021 - write.php에서 가져온 코드
if ($board[bo_use_dhtml_comment] && $member[mb_level] >= $board[bo_dhtml_editor_level_comment])
    $is_dhtml_editor = true;
else
    $is_dhtml_editor = false;

// 코멘트 출력
//$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment desc, wr_comment_reply ";
//$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
$select_sql = " wr_id, mb_id, wr_name, wr_parent, wr_option, wr_content, wr_datetime, wr_ip, wr_comment, wr_comment_reply, wr_singo,
                wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10, wr_password ";
if ($board[bo_use_sideview]) {
    $select_sql .= " ,wr_email , wr_homepage ";
}

// 불당팩 -- tmp 테이블을 이용해서 데이터 추출과 정렬을 별도로 구분한다
$sql = " select $select_sql from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $list[$i] = $row;

    //$list[$i][name] = get_sideview($row[mb_id], cut_str($row[wr_name], 20, ''), $row[wr_email], $row[wr_homepage]);

    // html 편집기로 작성된 코멘트인데, 지금은 html 편집기를 안쓴다면???
    if (!$is_dhtml_editor && strstr($row[wr_option], "html")) {
      
          // euc-kr은 인식을 하지 못하네요. 따라서, CP866으로 해야 합니다.
          if (strtoupper($g4[charset]) == "UTF-8")
              $list[$i][wr_content0] = html_entity_decode($row[wr_content],ENT_QUOTES,"UTF-8");
          else 
              $list[$i][wr_content0] = html_entity_decode($row[wr_content],ENT_QUOTES,"CP866");
          $list[$i][wr_content0] = br2nl($list[$i][wr_content0]);
         
    }

    $tmp_name = get_text(cut_str($row[wr_name], $config[cf_cut_name])); // 설정된 자리수 만큼만 이름 출력
    if ($board[bo_use_sideview])
    {
        // 회원일때는 저장된 sideview가 있으면 저장된 sideview를 사용
        if ($row[mb_id]) {

            if ($sideview[$row[mb_id]])
                $list[$i][name] = $sideview[$row[mb_id]];
            else {
                // 글쓴이의 개인정보가 바뀐 시점 이후에 쓰여진 글이라면 개인정보를 다시 가져올 필요가 없지만
                // 언제 글쓴이의 정보가 바뀌었는지, 데이터를 가지고 오려면 SQL Query를 해야지 해서 그냥 엎어 써 버립니다.
                $mb = get_member($row['mb_id'], "mb_email, mb_homepage");
                $row[wr_email] = $mb[mb_email];
                $row[wr_homepage] = $mb[mb_homepage];
                $list[$i][name] = get_sideview($row[mb_id], $tmp_name, $row[wr_email], $row[wr_homepage]);
                $sideview[$row[mb_id]] = $list[$i][name];
            }
            
        } else {
            $list[$i][name] = get_sideview($row[mb_id], $tmp_name, $row[wr_email], $row[wr_homepage]);
        }
    }
    else
        $list[$i][name] = "<span class='".($row[mb_id]?'member':'guest')."'>$tmp_name</span>";

    // 공백없이 연속 입력한 문자 자르기 (way 보드 참고. way.co.kr)
    //$list[$i][content] = eregi_replace("[^ \n<>]{130}", "\\0\n", $row[wr_content]);

    $singo = "";
    $singo .= "<div id='singo_title{$list[$i][wr_id]}' class='singo_title'><font color=gray>신고가 접수된 게시물입니다. ";
    $singo .= "<span class='singo_here' style='cursor:pointer;font-weight:bold;' onclick=\"document.getElementById('singo_contents{$list[$i][wr_id]}').style.display=(document.getElementById('singo_contents{$list[$i][wr_id]}').style.display=='none'?'':'none');\"><font color=red>여기</font></span>를 클릭하시면 내용을 볼 수 있습니다.</font></div>";
    $singo .= "<div id='singo_contents{$list[$i][wr_id]}' style='display:none;'><p>";

    // 코멘트의 경우에는 신고이유를 출력하지 않음 (코드가 이상하게 꼬여서요)
    if (!strstr($row[wr_option], "secret")) {

        $list[$i][content1] = $row[wr_content];
        if (!strstr($row[wr_option], "html"))
            $list[$i][content] = conv_content($row[wr_content], 0, 'wr_content');
        else
            $list[$i][content] = $list[$i][content1];
        $list[$i][content] = search_font($stx, $list[$i][content]);

        // 신고된 코멘트 출력하기
        if ($row[wr_singo] and $board[bo_singo_action] > 0 and $row[wr_singo] >= $board[bo_singo_action] )
        {
            $singo .= $list[$i][content];
            $singo .= "</div>";

            $list[$i][content] = $singo;
        }

    } else if ($is_admin || 
        ($member[mb_id] && $write[mb_id]==$member[mb_id]) || 
        ($member[mb_id] && $row[mb_id]==$member[mb_id])) {

        $list[$i][content1] .= $row[wr_content];
        if (!strstr($row[wr_option], "html"))
            $list[$i][content] = conv_content($row[wr_content], 0, 'wr_content');
        else
            $list[$i][content] = $list[$i][content1];
        $list[$i][content] = search_font($stx, $list[$i][content]);
        
        // 신고된 코멘트 출력하기
        if ($row[wr_singo] and $board[bo_singo_action] > 0 and $row[wr_singo] >= $board[bo_singo_action])
        {
            $singo .= $list[$i][content];
            $singo .= "</div>";

            $list[$i][content] = $singo;
        }

    } else if ($member[mb_id]) {

        // 계층의 코멘트 비밀글 처리
        $comment_depth = strlen($list[$i][wr_comment_reply]);

        // 바로 윗레벨 댓글에 대해서만 권한 체크를 합니다.
        $parent_wr_comment_reply = substr($list[$i][wr_comment_reply], 0, $comment_depth-1);
        $parent_wr_comment = $list[$i][wr_comment];
        $parent_wr_parent = $list[$i][wr_parent];

        // sql query caching이 가능하게, mb_id는 where에 넣지 않는다
        $sql5 = " select mb_id from $write_table where wr_parent = '$parent_wr_parent' and wr_is_comment=1 and wr_comment = '$parent_wr_comment' and wr_comment_reply='$parent_wr_comment_reply' ";
        $result5 = sql_fetch($sql5);

        // 바로위 댓글의 주인이 글 읽는 사람이면, 비밀글이더라도 보여준다
        if ($result5) {
            if ($result5[mb_id] == $member[mb_id]) {

                $list[$i][content1] = $row[wr_content];
                if (!strstr($row[wr_option], "html"))
                    $list[$i][content] = conv_content($row[wr_content], 0, 'wr_content');
                else
                    $list[$i][content] = $list[$i][content1];
                $list[$i][content] = search_font($stx, $list[$i][content]);
            } else {
              
                $list[$i][content] = $list[$i][content0] = $list[$i][content1] = $list[$i][wr_content0] = "";
            }
        } else {
            $list[$i][content] = $list[$i][content0] = $list[$i][content1] = $list[$i][wr_content0] = "";
        }

        // 신고된 코멘트 출력하기
        if ($row[wr_singo] and $board[bo_singo_action] > 0 and $row[wr_singo] >= $board[bo_singo_action])
        {
            $singo .= $list[$i][content];
            $singo .= "</div>";

            $list[$i][content] = $singo;
        }

    } else {

        $list[$i][content] = $list[$i][content0] = $list[$i][content1] = $list[$i][wr_content0] = "";

    }

    // 불당팩 : image Resize를 위해서
    $list[$i][content] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' \\2 \\3", $list[$i][content]);

    $list[$i][datetime] = substr($row[wr_datetime],2,14);

    // 불당팩 - $board[bo_new] 시간내에 새로운 코멘트가 있으면 icon_new.gif를 뒤에
    if ($row['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($board['bo_new'] * 3600))) 
        $list[$i][datetime] .= "<img src='$board_skin_path/img/icon_new.gif' align='absmiddle'>";

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i][ip] = $row[wr_ip];
    if (!$is_admin)
        $list[$i][ip] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $row[wr_ip]);

    // 신고 링크
    if ($board[bo_singo] && $is_comment_write && $member[mb_id] != $row[mb_id])
        $list[$i][singo_href] = "./singo_popin.php?bo_table=$bo_table&wr_id=$row[wr_id]&wr_parent=$row[wr_parent]";

    $list[$i][is_reply] = false;
    $list[$i][is_edit] = false;
    $list[$i][is_del]  = false;
    if ($is_comment_write || $is_admin) 
    {
        if ($member[mb_id]) 
        {
            if ($row[mb_id] == $member[mb_id] || $is_admin) 
            {
                $list[$i][del_link]  = "./delete_comment.php?bo_table=$bo_table&comment_id=$row[wr_id]&token=$token&cwin=$cwin&page=$page".$qstr;
                $list[$i][is_edit]   = true;
                $list[$i][is_del]    = true;
            }
        } 
        else 
        {
            if (!$row[mb_id]) {
                $list[$i][del_link] = "./password.php?w=x&bo_table=$bo_table&comment_id=$row[wr_id]&cwin=$cwin&page=$page".$qstr;
                $list[$i][is_del]   = true;
            }
        }

        if (strlen($row[wr_comment_reply]) < 5)
            $list[$i][is_reply] = true;
    }

    // 05.05.22
    // 답변있는 코멘트는 수정, 삭제 불가
    if ($i > 0 && !$is_admin)
    {
        if ($row[wr_comment_reply]) 
        {
            $tmp_comment_reply = substr($row[wr_comment_reply], 0, strlen($row[wr_comment_reply]) - 1);
            if ($tmp_comment_reply == $list[$i-1][wr_comment_reply])
            {
                $list[$i-1][is_edit] = false;
                $list[$i-1][is_del] = false;
            }
        }
    }
    
    // 게시글 잠금 가능하게 - 불당팩 : 배추님의 팁 (관리자 또는 게시글 작성자만 가능하게)
    if ($is_admin || ($member['mb_id'] && $member['mb_id'] == $list[$i][mb_id])) { 
        if (strstr($list[$i][wr_option], "secret")) { 
            // 잠금 해제 버튼
            $list[$i][nosecret_href] = "javascript:post_submit('proc/mw.btn.secret.php','$bo_table','$wr_id', '{$list[$i][wr_id]}', 'no', '게시글 잠금해제')";
        } else { 
            // 잠금 버튼
            $list[$i][secret_href] = "javascript:post_submit('proc/mw.btn.secret.php','$bo_table','$wr_id', '{$list[$i][wr_id]}', '', '게시글 잠금')";
        }
    }
}

//  코멘트수 제한 설정값
if ($is_admin)
{
    $comment_min = $comment_max = 0;
}
else
{
    $comment_min = (int)$board[bo_comment_min];
    $comment_max = (int)$board[bo_comment_max];
}

include_once("$board_skin_path/view_comment.skin.php");

// 필터
if (!file_exists("$g4[bbs_path]/ajax.filter.php")) {
echo "<script type='text/javascript'> var g4_cf_filter = '$config[cf_filter]'; </script>\n";
echo "<script type='text/javascript' src='$g4[path]/js/filter.js'></script>\n";
}

if (file_exists("$board_skin_path/view_comment.tail.skin.php"))
    @include_once("$board_skin_path/view_comment.tail.skin.php");
?>
