<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

include_once("$g4[path]/head.sub.php");

// 회원인지 검사하여 회원이 아닌 경우에는 로그인 페이지로 이동한다.
if (!$member[mb_id]) 
    alert_close("회원만 신고 할 수 있습니다.");

// CSRF를 막기 위해서
$sg_reason = strip_tags($_POST[sg_reason]);
$sg_reason='이유없음';

// 본인이 신고한 글인지 확인
$sql = " select sg_datetime from $g4[singo_table] 
          where bo_table = '$bo_table' and wr_id = '$wr_id' and wr_parent = '$wr_parent' and sg_mb_id = '$member[mb_id]' ";
$row = sql_fetch($sql);
if ($row[sg_datetime]) 
    alert("이미 신고한 글입니다. (신고일시 : $row[sg_datetime])");


$write_table = $g4['write_prefix'].$bo_table;
if ($bo_table == "@memo") {
    // 신고사유
    $sg_reason = "스팸쪽지 신고 입니다";
} else if ($bo_table == "@user") {
    // 신고사유
    $sg_reason = "사용자 신고 입니다";
} else if ($bo_table == "hidden_comment") {
    // 신고사유
    $sg_reason = "hidden comment 신고 입니다";
    $write = sql_fetch(" select bo_table, wr_id, mb_id, co_content as wr_subject from $g4[hidden_comment_table] where co_id = '$wr_id' ");
} else {
    $sql = " select count(*) as cnt from $write_table 
              where wr_id = '$wr_id' and wr_parent = '$wr_parent' ";
    $row = sql_fetch($sql);
    if (!$row[cnt])
        alert_close("신고할 게시물이 존재하지 않습니다.");
}

// 비회원의 글을 신고할 경우 $write[mb_id]에 값이 없는 문제를 해결하기 위해서...ㅠ..ㅠ...
if (!$write[mb_id])
    $write[mb_id] = "비회원";

// 신고 정보 등록
$sql = " insert into $g4[singo_table] 
            set mb_id = '$write[mb_id]',
                bo_table = '$bo_table',
                wr_id = '$wr_id',
                wr_parent = '$wr_parent',
                sg_mb_id = '$member[mb_id]',
                sg_reason = '$sg_reason',
                sg_datetime = '$g4[time_ymdhis]',
                sg_ip = '$remote_addr' ";
sql_query($sql);

// 게시글에 신고값 설정
if ($bo_table == "@memo" and $bo_table == "@user") // 쪽지 또는 사용자 신고의 경우
{
}
else if ($bo_table == "hidden_comment")
{
    $sql = " update $g4[hidden_comment_table] set wr_singo = wr_singo + 1 where co_id = '$wr_id' ";
    sql_query($sql, false);
} else 
{
    $sql = " update $write_table set wr_singo = wr_singo + 1 where wr_id = '$wr_id' ";
    sql_query($sql, false);
}

// 신고한 사람의 포인트를 차감
if ($config[cf_singo_point_send])
    insert_point($mb_id, -$config[cf_singo_point_send], "신고처리 포인트", '@member', $mb_id, '신고처리');

// 신고된 사람의 포인트를 차감
if ($config[cf_singo_point_recv])
    insert_point($mb_id, -$config[cf_singo_point_recv], "신고처리 포인트", '@member', $mb_id, '신고처리');

//------------------------------------------------------------------------------------
// 신고된 건수가 몇회이상이면 차단할지를 설정
// 회원의 권한을 1로 설정하고 차단일자를 저장하여 접근을 차단함
//------------------------------------------------------------------------------------
if (!isset($config[cf_singo_intercept_count]) || $config[cf_singo_intercept_count] == 0) $config[cf_singo_intercept_count] = 1000;
$sql = " select count(*) as cnt from $g4[singo_table] where mb_id = '$write[mb_id]' ";
$row = sql_fetch($sql);
if ($row[cnt] >= $config[cf_singo_intercept_count]) {
    // 관리자님 코드 - 접근 차단
    //$sql = " update $g4[member_table] set mb_level = '1', mb_intercept_date = '".date("Ymd",$g4[server_time])."' where mb_id = '$write[mb_id]' ";
    //sql_query($sql);
    // 불당 코드 - 사용자 레벨/포인트 초기화
    $sql = " update $g4[member_table] set mb_level = '$config[cf_register_level]', mb_point = '$config[cf_register_point]' where mb_id = '$write[mb_id]' ";
    sql_query($sql);    
    insert_point($mb_id, -$member[mb_point], "신고처리 포인트삭제", '@member', $mb_id, '신고처리');
    insert_point($mb_id, $config[cf_register_point], "신고처리 포인트초기화", '@member', $mb_id, '신고처리');
}
//$singo_count = $row['cnt']; // 전체 신고된 건수

// 신고당사자, 게시판관리자/그룹관리자/사이트 관리자에게 쪽지를 발송 (불당의 쪽지2)
$memo_list = array();

$memo_list[] = $write[mb_id];// 신고된 게시글의 글쓴이
$memo_list[] = $config['cf_admin']; // 사이트 관리자
if ($group['gr_admin'] && !in_array($group['gr_admin'], $memo_list)) // 그룹관리자
    $memo_list[] = $group['gr_admin'];
if ($board['bo_admin'] && !in_array($board['bo_admin'], $memo_list)) // 게시판관리자
    $memo_list[] = $board['bo_admin'];

// 코멘트를 신고할 경우
if ($wr_id != $wr_parent) {
    // $write[wr_subject] 값을 본글의 제목으로 넣어줍니다
    $result = sql_fetch(" select wr_subject from $write_table where wr_id = '$wr_parent' ");
    $write['wr_subject'] = $result['wr_subject'];
    // wr_id를 코멘트로 설정
    $wr_id = $wr_id . "#c_" . $wr_parent;
    // 코멘트의 옵션으로 html 사용설정
}

foreach($memo_list as $memo_recv_mb_id) {

    $me_send_mb_id = $config['cf_admin']; // 사이트 관리자 명의로 쪽지를 발송

    // 신고된 url
    if ($bo_table == 'hidden_comment') {
        $sg_url = "$g4[bbs_path]/board.php?bo_table=$write[bo_table]&wr_id=$write[wr_id]&h_id=$wr_id";
    } else {
        $sg_url = "$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id";
    }

    // 신고내용
    $me_memo = "신고된 게시글 - <a href=\'$sg_url\' target=new>$write[wr_subject]</a><br>게시글의 신고이유 - {$sg_reason}<br><br>해당 게시글의 신고내용에 이의가 있는 경우 운영자에게 문의하시기 바랍니다."; // 메모내용

    // 신고글 제목
    $me_subject = "$write[mb_id] 님의 게시글이 신고되었습니다"; // 메모제목
    if ($row[cnt] >= $config[cf_singo_intercept_count]) {
        $me_subject .= "<br><br>$write[mb_id]님은 신고횟수가 $config[cf_singo_intercept_count]회를 초과하여, 사용자레벨 및 포인트가 초기화 되었습니다";
    }

    // 신고글의 보기를 html로
    $html = "html1";

    // 쪽지 INSERT (수신함) 
    $sql = " insert into $g4[memo_recv_table] 
                    ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option ) 
             values ('$memo_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$memo_recv_mb_id', '', '', '$html,$secret,$mail' ) 
          "; 
    sql_query($sql); 
    $me_id = mysql_insert_id(); 

    // 안읽은 쪽지 갯수, 쪽지 수신 날짜를 업데이트
    $sql = " update $g4[member_table]
                set mb_memo_unread=mb_memo_unread+1, mb_memo_call_datetime='$g4[time_ymdhis]' 
              where mb_id = '$me_recv_mb_id' ";
    sql_query($sql);

    // 쪽지 수신 알림 기능
    if ($mb_memo_call)
    {
        $sql = " update $g4[member_table]
                    set mb_memo_call = concat(mb_memo_call, concat(' ', '$me_send_mb_id'))
                  where mb_id = '$me_recv_mb_id' ";
        sql_query($sql);
    }
}

//------------------------------------------------------------------------------------
?>

<?
if ($bo_table == "@memo" or $bo_table == "@user") { // 쪽지.사용자 신고가 아닌 경우에만 확인
} 
else if ($bo_table == "hidden_comment") 
{


?>
<SCRIPT LANGUAGE="JavaScript">
alert("게시물을 신고하였습니다.\n\n담당자 확인 후 해당 게시물에 대해서 관련조치를 하겠습니다.\n\n감사합니다.");
document.location.href = "<?="board.php?bo_table=$write[bo_table]&wr_id=$write[wr_id]"?>";
window.close();
</SCRIPT>
<?
} 
else
{
?>
<SCRIPT LANGUAGE="JavaScript">
alert("게시물을 신고하였습니다.\n\n담당자 확인 후 해당 게시물에 대해서 관련조치를 하겠습니다.\n\n감사합니다.");
document.location.href = "<?="board.php?bo_table=$bo_table&wr_id=$wr_id#board"?>";
window.close();
</SCRIPT>
<? } ?>
