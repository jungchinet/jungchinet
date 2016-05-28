<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

include_once("$g4[path]/head.sub.php");

// 회원인지 검사하여 회원이 아닌 경우에는 로그인 페이지로 이동한다.
if (!$member[mb_id]) 
    alert("회원만 신고 할 수 있습니다.");

$bo_table = $_POST['bo_table'];
$sg_reason = $_POST['sg_reason'];
$singo_mb_id = $_POST['singo_mb_id'];

if ($bo_table != "@user") {
    alert("게시물/쪽지 등의 신고는 별도기능을 사용하세요.");
}
$write_table = $g4['write_prefix'].$bo_table;
    
// 신고 정보 등록
$sql = " insert into $g4[singo_table] 
            set mb_id = '$singo_mb_id',
                bo_table = '$bo_table',
                wr_id = '$singo_mb_id',
                wr_parent = '',
                sg_mb_id = '$member[mb_id]',
                sg_reason = '$sg_reason',
                sg_datetime = '$g4[time_ymdhis]',
                sg_ip = '$remote_addr' ";
sql_query($sql);

// 신고당사자, 게시판관리자/그룹관리자/사이트 관리자에게 쪽지를 발송 (불당의 쪽지2)
$memo_list = array();

$memo_list[] = $singo_mb_id;// 신고된 게시글의 글쓴이
$memo_list[] = $config['cf_admin']; // 사이트 관리자

foreach($memo_list as $memo_recv_mb_id) {
        $me_send_mb_id = $config['cf_admin']; // 사이트 관리자 명의로 쪽지를 발송
        $me_memo = "신고된 회원 - $singo_mb_id<br>신고이유 - $sg_reason<br><br>해당 신고내용에 이의가 있는 경우 운영자에게 문의하시기 바랍니다."; // 메모내용
        $me_subject = "$singo_mb_id 님이 신고되었습니다"; // 메모제목

        // 쪽지 INSERT (수신함) 
        $sql = " insert into $g4[memo_recv_table] 
                        ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server ) 
                values ('$memo_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$memo_recv_mb_id', '', '' ) "; 
        sql_query($sql); 
        $me_id = mysql_insert_id(); 

        // 실시간 쪽지 알림 기능 
        $sql = " update $g4[member_table] 
                    set mb_memo_call = '$me_send_mb_id' 
                  where mb_id = '$memo_recv_mb_id' "; 
        sql_query($sql); 
}

// 회원신고후에는 항상 첫 페이지로 이동
goto_url("$g4[path]");
?>
