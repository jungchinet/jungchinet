<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

include_once("$g4[path]/head.sub.php");

// 사용자에의한 신고해제는 게시판의 글에만 해당 합니다.
// 쪽지, 기타 신고에는 해당 사항이 없습니다.

// 회원인지 검사하여 회원이 아닌 경우에는 로그인 페이지로 이동한다.
if (!$member['mb_id']) 
    alert_close("회원만 신고해제 할 수 있습니다.");

// CSRF를 막기 위해서
$unsg_reason = strip_tags($_POST['unsg_reason']);

// 게시글 정보를 가져온다
$write_table = $g4['write_prefix'].$bo_table;
$sql = " select mb_id from $write_table where wr_id = '$wr_id' ";
$write_tmp = sql_fetch($sql);

// 본인이 신고한 글인지 확인
$sql = " select count(*) as cnt from $g4[singo_table] 
          where bo_table = '$bo_table' and wr_id = '$wr_id' and wr_parent = '$wr_parent' and sg_mb_id = '$member[mb_id]' ";
$row = sql_fetch($sql);
// 본인의 글은 절대로 못 풀어줌
if ($row['cnt'] > 0) {
    if ($write_tmp['mb_id'] == $member['mb_id'])
        alert_close("자신의 글은 신고해제 할 수 없습니다.");
} else {
    alert_close("다른 회원이 신고한 글은 신고해제 할 수 없습니다.");
}

// 비회원의 글을 신고할 경우 $write[mb_id]에 값이 없는 문제를 해결하기 위해서...ㅠ..ㅠ...
if (!$write['mb_id'])
    alert_close("비회원의 글은 신고해제 할 수 없습니다.");

if(!$unsg_reason){
	$unsg_reason='신고해제';	
}

// 신고해제 정보 등록
$sql = " insert into $g4[unsingo_table] 
            set mb_id = '$write[mb_id]',
                bo_table = '$bo_table',
                wr_id = '$wr_id',
                wr_parent = '$wr_parent',
                unsg_mb_id = '$member[mb_id]',
                unsg_reason = '$unsg_reason',
                unsg_datetime = '$g4[time_ymdhis]',
                unsg_ip = '$remote_addr' ";
sql_query($sql);

// 게시글에 신고값 설정
$sql = " update $write_table set wr_singo = wr_singo - 1 where wr_id = '$wr_id' ";
sql_query($sql, false);

// 신고해제한 사람의 포인트를 차감
if ($config['cf_singo_point_send'])
    insert_point($mb_id, -$config['cf_singo_point_send'], "신고해제 포인트", '@member', $mb_id, '신고해제');

// 신고당사자, 게시판관리자/그룹관리자/사이트 관리자에게 쪽지를 발송 (불당의 쪽지2)
$memo_list = array();

$memo_list[] = $write['mb_id'];// 신고된 게시글의 글쓴이
$memo_list[] = $config['cf_admin']; // 사이트 관리자
if ($group['gr_admin'] && !in_array($group['gr_admin'], $memo_list)) // 그룹관리자
    $memo_list[] = $group['gr_admin'];
if ($board['bo_admin'] && !in_array($board['bo_admin'], $memo_list)) // 게시판관리자
    $memo_list[] = $board['bo_admin'];

foreach($memo_list as $memo_recv_mb_id) {

    $me_send_mb_id = $config['cf_admin']; // 사이트 관리자 명의로 쪽지를 발송

    // 신고해제된 url
    $unsg_url = "$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id";

    // 신고해제내용
    $me_memo = "신고해제된 게시글 - <a href=\'$unsg_url\' target=new>$write[wr_subject]</a><br>게시글의 신고해제이유 - {$unsg_reason}<br><br>해당 게시글의 신고해제 내용에 이의가 있는 경우 운영자에게 문의하시기 바랍니다."; // 메모내용

    // 신고글 제목
    $me_subject = "$write[mb_id] 님의 게시글이 신고해제 되었습니다"; // 메모제목

    // 쪽지 INSERT (수신함) 
    $sql = " insert into $g4[memo_recv_table] 
                    ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option ) 
             values ('$memo_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$memo_recv_mb_id', '', '', '$html,$secret,$mail' ) 
          "; 
    sql_query($sql); 
    $me_id = mysql_insert_id(); 

    // 실시간 쪽지 알림 기능
    $sql = " update $g4[member_table]
                set mb_memo_call = concat(mb_memo_call, concat(' ', '$me_send_mb_id'))
              where mb_id = '$memo_recv_mb_id' ";
    sql_query($sql);
}
?>
<script type="text/javascript">
alert("게시물을 신고해제 하였습니다.\n\n담당자 확인 후 해당 게시물에 대해서 관련조치를 하겠습니다.\n\n감사합니다.");
document.location.href = "<?="board.php?bo_table=$bo_table&wr_id=$wr_id#board"?>";
window.close();
</script>
