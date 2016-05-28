<?
include_once("./_common.php");

@include_once("$board_skin_path/download.head.skin.php");

// 쿠키에 저장된 ID값과 넘어온 ID값을 비교하여 같지 않을 경우 오류 발생
// 다른곳에서 링크 거는것을 방지하기 위한 코드
if (!get_session("ss_view_{$bo_table}_{$wr_id}")) 
    alert("잘못된 접근입니다.");  

$sql = " select bf_source, bf_file, bf_datetime from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
$file = sql_fetch($sql);
if (!$file[bf_file]) {
    alert_close("파일 정보가 존재하지 않습니다.");
}

if ($member[mb_level] < $board[bo_download_level]) { 
    $alert_msg = "다운로드 권한이 없습니다.";
    if ($member[mb_id])
        alert($alert_msg);
    else
        alert($alert_msg . "\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?wr_id=$wr_id&$qstr&url=".urlencode("$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id"));
}

$filepath = "$g4[path]/data/file/$bo_table/$file[bf_file]";
$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath)) {

    // 파일정보를 삭제 합니다.
    //$sql = " delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
    //sql_query($sql);

    $tmp_write_table = $g4[write_prefix] . $bo_table;
    
    // 해당게시글의 파일정보를 감소시켜줍니다.
    //$sql = " update $tmp_write_table set wr_file_count=wr_file_count-1 where wr_id = '$wr_id' ";
    //sql_query($sql);

    // 글쓴이를 찾습니다.
    $sql = " select mb_id from $tmp_write_table where wr_id = '$wr_id' ";
    $tmp1 = sql_fetch($sql);
    if ($tmp1[mb_id])
        $mb = get_member($tmp1[mb_id]);

    // 글쓴이와 관리자에게 쪽지를 보냅니다.
    include_once("$g4[path]/memo.config.php");

    $me_subject = "[긴급] 게시글의 첨부파일 없어짐에 대해서";
    $msg = "올려주신 게시글의 첨부파일이 없어졌습니다.<br>
            게시글을 확인해 주시기 바랍니다.<br>
            <br>
            첨부파일 이  름 - $file[bf_source]<br>
            첨부파일 등록일 - $file[bf_datetime]<br>
            <br>
            <a href='$g4[url]/bbs/board.php?bo_table=$bo_table&wr_id=$wr_id' target=new>게시글바로가기</a>";
    $msg = addslashes($msg);
    $me_recv_mb_id = $mb[mb_id];
    $me_send_mb_id = $config[cf_admin];

    // function memo4_send($me_recv_mb_id, $me_send_mb_id, $me_memo, $me_subject, $me_option="html1", $mb_memo_call="1") 
    memo4_send($config[cf_admin], $me_send_mb_id, "aaa", $me_subject);
    if ($me_recv_mb_id)
        memo4_send($me_recv_mb_id, $me_send_mb_id, $msg, $me_subject);

    alert("파일이 존재하지 않습니다.");
}

// 사용자 코드 실행
@include_once("$board_skin_path/download.skin.php");

// 이미 다운로드 받은 파일인지를 검사한 후 게시물당 한번만 포인트를 차감하도록 수정
$ss_name = "ss_down_{$bo_table}_{$wr_id}_{$no}";

if (!get_session($ss_name)) 
{
    // 자신의 글이라면 통과
    // 관리자인 경우 통과
    if (($write[mb_id] && $write[mb_id] == $member[mb_id]) || $is_admin)
        ;
    else if ($board[bo_download_level] > 1) // 회원이상 다운로드가 가능하다면
    {
        // 다운로드 포인트가 음수이고 회원의 포인트가 0 이거나 작다면
        if ($member[mb_point] + $board[bo_download_point] < 0)
            alert("보유하신 포인트(".number_format($member[mb_point]).")가 없거나 모자라서 다운로드(".number_format($board[bo_download_point]).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 다운로드 해 주십시오.");

        // 게시물의 첨부문서별로 한번만 차감하도록 수정
        //insert_point($member[mb_id], $board[bo_download_point], "$board[bo_subject] $wr_id 파일 다운로드", $bo_table, $wr_id, "{$no}_다운로드");
        // 게시물당 한번만 차감하도록 수정
        insert_point($member[mb_id], $board[bo_download_point], "$board[bo_subject] $wr_id 파일 다운로드", $bo_table, $wr_id, "다운로드");
    }

    // 불당팩 - 다운로드 내역
    if ($member[mb_id]) {

        // 불당팩 - db에서 다운로드 여부를 확인
        $sql = " select count(*) as cnt from $g4[board_file_download_table] 
                  where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '$member[mb_id]' ";
        $result = sql_fetch($sql);

        if ($result[cnt] == 0) {
            $gr_id = sql_fetch(" select gr_id from $g4[board_table] where bo_table= '$bo_table' ");
            $sql = " insert into $g4[board_file_download_table]
                        set bo_table = '$bo_table',
                            wr_id = '$wr_id',
                            bf_no = '$no',
                            mb_id = '$member[mb_id]',
                            download_point = '$board[bo_download_point]',
                            dn_count = '1',
                            dn_datetime = '$g4[time_ymdhis]',
                            dn_ip = '$remote_addr',
                            gr_id = '$gr_id[gr_id]'
                             ";
            sql_query($sql);
        } else {
            // 불당팩 - 다운로드 내역 (이미 다운한 경우에는 해당 다운로드의 실제 count만 하나씩 증가)
            $sql = " update $g4[board_file_download_table] set dn_count = dn_count + 1 where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
            sql_query($sql);
        }

    }
    
    // 다운로드 카운트 증가
    $sql = " update $g4[board_file_table] set bf_download = bf_download + 1 where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
    sql_query($sql);

    set_session($ss_name, TRUE);
}

$g4[title] = "$group[gr_subject] > $board[bo_subject] > " . conv_subject($write[wr_subject], 255) . " > 다운로드";

$filepath = "$g4[data_path]/file/$bo_table/$file[bf_file]";
$filepath = addslashes($filepath);
// utf-8 파일 이름 깨어지는 오류
//if (preg_match("/^utf/i", $g4[charset]))
//    $original = urlencode($file[bf_source]);
//else
    $original = $file[bf_source];

@include_once("$board_skin_path/download.tail.skin.php");

if (file_exists($filepath)) {
    if(preg_match("/msie/i", $_SERVER[HTTP_USER_AGENT]) && preg_match("/5\.5/", $_SERVER[HTTP_USER_AGENT])) {
        header("content-type: doesn/matter");
        header("content-length: ".filesize("$filepath"));
        header("content-disposition: attachment; filename=\"$original\"");
        header("content-transfer-encoding: binary");
    } else {
        header("content-type: file/unknown");
        header("content-length: ".filesize("$filepath"));
        header("content-disposition: attachment; filename=\"$original\"");
        header("content-description: php generated data");
    }

    header("pragma: no-cache");
    header("expires: 0");
    flush();

    if (is_file("$filepath")) {
        $fp = fopen("$filepath", "rb");

        // 4.00 대체
        // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
        //if (!fpassthru($fp)) {
        //    fclose($fp);
        //}

        // 1초 정도만 다운로드 되고, 다운로드가 안되는 경우 또는 다운로드 속도의 조정이 필요한 경우
        // 다운로드 rate = fread 문장의 100*1024(100k) * 1초 sleep(1) = 초당 100k
        $download_rate = 100;
        $download_rate = round($download_rate * 1024);
        while(!feof($fp)) { 
            echo fread($fp, $download_rate); 
            flush();
            //sleep(1);
        }
        fclose ($fp); 
        flush();
    } else {
        alert("해당 파일이나 경로가 존재하지 않습니다.");
    }

} else {
    alert("파일을 찾을 수 없습니다.");
}
?>
