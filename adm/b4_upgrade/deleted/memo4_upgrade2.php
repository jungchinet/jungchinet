<?
$sub_menu = "100600";
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "쪽지4 - 업그레이드(2)";
include_once("./admin.head.php");

// memo2 첨부파일 디렉토리를 생성
$dir_name = $g4[path] . "/data/memo2";
if(!is_dir($dir_name)){
    @mkdir("$dir_name", 0707);
    @chmod("$dir_name", 0707);
}

// 일반적인 메모의 경우
$sql = " select * from $g4[memo_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $me_subject = $row[me_send_mb_id] . "님이 보내신 쪽지 입니다";
    $me_memo_text = nl2br($row[me_memo]);

    $html = "";
    
    $sql = " insert into $g4[memo_recv_table] (me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_read_datetime, me_memo, me_file_local, me_file_server, me_subject, memo_type, memo_owner, me_option) 
                                       values ($i+1, '$row[me_recv_mb_id]', '$row[me_send_mb_id]', '$row[me_send_datetime]', '$row[me_read_datetime]', '" . addslashes($me_memo_text) . "', '$bmemos', '$memofile', '" . addslashes(cut_str($me_memo_text,30)) . "', 'recv', '$row[me_recv_mb_id]', '$html,$secret,$mail' )";
    sql_query($sql);

    $sql = " insert into $g4[memo_send_table] (me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_read_datetime, me_memo, me_file_local, me_file_server, me_subject, memo_type, memo_owner, me_option) 
                                       values ($i+1, '$row[me_recv_mb_id]', '$row[me_send_mb_id]', '$row[me_send_datetime]', '$row[me_read_datetime]', '" . addslashes($me_memo_text) . "', '$bmemos', '$memofile', '" . addslashes(cut_str($me_memo_text,30)) . "', 'send', '$row[me_send_mb_id]', '$html,$secret,$mail' )";
    sql_query($sql);
    
    echo "i: " . $i;
}

echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
