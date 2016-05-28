<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if (!$kind or !$me_id)
    alert("다운로드에 필요한 정보가 없습니다.");

switch ($kind) {
  case 'send'   : $sql = " select * from $g4[memo_send_table] where me_id = $me_id "; break;
  case 'recv'   : $sql = " select * from $g4[memo_recv_table] where me_id = $me_id "; break;
  case 'spam'   : $sql = " select * from $g4[memo_spam_table] where me_id = $me_id "; break;
  case 'save'   : $sql = " select * from $g4[memo_save_table] where me_id = $me_id "; break;
  case 'notice' : $sql = " select * from $g4[memo_notice_table] where me_id = $me_id "; break;
  default     : alert("잘못된 kind 값 입니다");
}
$result = sql_fetch($sql);

if ($member['mb_id'] != $result['memo_owner'])
    alert("다른 사람의 메모에서 첨부파일을 다운로드 할 수 없습니다");

$file_server = $result['me_file_server'];
$file_local = $result['me_file_local'];

$filepath="$g4[path]/data/memo2/$file_server";

//$original="$file_local"; -- UTF-8 파일명, NaviGator님
if (preg_match("/^utf/i", $g4['charset'])) 
    $original = urlencode($file_local); 
else 
    $original = $file_local; 

if (file_exists($filepath)) {
    if(eregi("msie", $_SERVER[HTTP_USER_AGENT]) && eregi("5\.5", $_SERVER[HTTP_USER_AGENT])) {
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

        while(!feof($fp)) { 
            echo fread($fp, 100*1024); 
            flush(); 
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
