<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
include_once("./admin.head.php");

echo "UPGRADE 시작.";

// 일반적인 메모의 경우 (memo 테이블의 이름을 정확하게 지정...)
$sql = " select * from $g4[table_prefix]memo_backup ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $me_memo_text = nl2br($row[me_memo]);
    
    //$me_subject = $row[me_send_mb_id] . "님이 보내신 쪽지 입니다";
    $me_subject = addslashes(cut_str($me_memo_text,30));
    $me_id = $i+1;
    
    $sql = " insert into  $g4[memo_recv_table]
                     set 
                          me_id = '$me_id',
                          me_recv_mb_id = '$row[me_recv_mb_id]',
                          me_send_mb_id =  '$row[me_send_mb_id]',
                          me_send_datetime = '$row[me_send_datetime]',
                          me_read_datetime = '$row[me_read_datetime]',
                          me_memo = '" . addslashes($me_memo_text) . "',
                          me_file_local = '',
                          me_file_server = '',
                          me_subject = '$me_subject',
                          memo_type = 'recv',
                          memo_owner = '$row[me_recv_mb_id]',
                          me_option = ''
            ";
    sql_query($sql);

    $sql = " insert into $g4[memo_send_table] 
                     set 
                          me_id = '$me_id',
                          me_recv_mb_id = '$row[me_recv_mb_id]',
                          me_send_mb_id =  '$row[me_send_mb_id]',
                          me_send_datetime = '$row[me_send_datetime]',
                          me_read_datetime = '$row[me_read_datetime]',
                          me_memo = '" . addslashes($me_memo_text) . "',
                          me_file_local = '',
                          me_file_server = '',
                          me_subject = '$me_subject',
                          memo_type = 'send',
                          memo_owner = '$row[me_send_mb_id]',
                          me_option = ''
            ";
    sql_query($sql);

}

echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
