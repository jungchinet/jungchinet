<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

if ($_SESSION["sm_datetime"] >= ($g4['server_time'] - $config['memo_delay_sec']) && !$is_admin) 
    alert("너무 빠른 시간내에 쪽지를 연속해서 발신할 수 없습니다.");
set_session("sm_datetime", $g4['server_time']);

$me_send_mb_id = strip_tags($_POST['me_send_mb_id']);
$me_recv_mb_id = strip_tags($_POST['me_recv_mb_id']);

if (!$member['mb_id'])
    alert("회원만 이용하실 수 있습니다.");

$me_send_mb_id = trim($me_send_mb_id);
if ($me_send_mb_id == $member['mb_id']) {} else
    alert("memo_update - 바르지 못한 사용입니다.");

if ($me_subject == '')
    alert("쪽지 제목이 입력되지 않았습니다.");

// 쪽지의 내용을 변경
$me_memo = addslashes($me_memo);

$tmp_list = explode(",", $me_recv_mb_id);

// 쪽지 폭탄 제거를 위하여, 중복을 삭제
$tmp_list = array_unique($tmp_list);
$tmp_list = implode(",",$tmp_list);
$tmp_list = explode(",",$tmp_list);

$me_recv_mb_id_list = "";
$msg = "";
$comma1 = $comma2 = "";
$mb_list = array();
$mb_array = array();
for ($i=0; $i<count($tmp_list); $i++) {
    $row = get_member($tmp_list[$i]);
    // 친구관리가 적용되었을 때
    if ($row['mb_id']) { // 회원정보가 있는 경우 내가 블랙리스트에 포함되었는지 확인
        $sql2 = " select count(*) as cnt from $g4[friend_table] where fr_id = '$me_send_mb_id' and mb_id = '$row[mb_id]' and fr_type = 'black_id' ";
        $result2 = sql_fetch($sql2);
    }
    if (!$row['mb_id'] || $row['mb_leave_date'] || $row['mb_intercept_date'] || $result2['cnt']>0) {
        $msg .= "$comma1$tmp_list[$i]";
        $comma1 = ",";
    } else {
        if ($config['cf_memo_mb_name'])
            $me_recv_mb_id_list .= "$comma2$row[mb_name]";
        else
            $me_recv_mb_id_list .= "$comma2$row[mb_nick]";
        $mb_list[] = $tmp_list[$i];
        $mb_array[] = $row;
        $comma2 = ",";
    }
}

if (!$is_admin) {
    if (count($mb_list)) {
        $point = (int)$config['cf_memo_send_point'] * count($mb_list);
        if ($point) {
            if ($member['mb_point'] - $point < 0) {
                alert("보유하신 포인트(".number_format($member[mb_point])."점)가 모자라서 쪽지를 보낼 수 없습니다.");
            } 
        }
    }
}

if ($msg && count($mb_list)==0)
    alert("회원아이디 \'".$msg."\' 은(는) 존재하지 않거나(탈퇴, 접근차단) 수신을 거부하는 아이디 입니다.\\n\\n쪽지를 발송하지 않았습니다.");

// 파일명 초기화
$file_name0 = '';
$file_name3 = '';

// 서버에서 업로드 가능한 최대 파일 용량
//$upload_max_filesize = ini_get('upload_max_filesize');

// 쪽지2에서 업로드 가능한 최대 파일 용량
//$memo2_upload_size = intval(substr($config[cf_memo_file_size],0,-1)) * 1024 * 1024;
if ($config['cf_memo_file_size'])
    $memo2_upload_size = $config['cf_memo_file_size'] * 1024 * 1024;
else {
    $max_upload_size = intval(substr(ini_get("upload_max_filesize"), 0, -1));
    $memo2_upload_size = $max_upload_size * 1024 * 1024;
}

for ($i=0; $i<count($mb_list); $i++) {

    if (trim($mb_list[$i])) {

        // 첨부파일
        if ($i ==0 and $_FILES[memo_file][name]) { // 첫번째 loop에서 첨부파일의 아이디를 me_id와 동일하게 생성 - 편하게 관리하려고

              // 회원별로 디렉토리를 생성
              $dir_name = $g4['path'] . "/data/memo2/" . $member[mb_id];
              if(!is_dir($dir_name)){
                  @mkdir("$dir_name", 0707);
                  @chmod("$dir_name", 0707);
              }
    
              $file_name0 = $_FILES[memo_file][name];

              // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
              $tmp_file  = $_FILES[memo_file][tmp_name];
              $filesize  = $_FILES[memo_file][size];

              if (is_uploaded_file($tmp_file)) {
                  if ($filesize > $memo2_upload_size) {
                      $file_upload_msg .= "\'{$file_name0}\' 파일의 용량(".number_format($filesize)." 바이트)이 쪽지2에서 설정(".number_format($memo2_upload_size)." 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n";
                  }
              }

              // 서버에 설정된 값보다 큰파일을 업로드 한다면
              if ($file_name0) {
                  if ($_FILES[memo_file][error] == 1) {
                      $file_upload_msg .= "\'{$file_name0}\' 파일의 용량이 설정된 값{$config[cf_memo_file_size]}보다 크므로 업로드 할 수 없습니다.\\n";
                  } else if ($_FILES[memo_file][error] != 0) {
                      $file_upload_msg .= "\'{$file_name0}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n";
                  }
              }

              // 불당팩 : 이미지 확장자를 가진경우 이미지파일인지 확인
              if ($file_name0 && preg_match("/\.($config[cf_image_extension])/i", $file_name0))
              {
                  if (!getimagesize($tmp_file)) {
                      $file_upload_msg .= "\'{$file_name0}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n";
                  }
              }

              if ($file_upload_msg) {
                  alert($file_upload_msg);
              }
              
              // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함        
              // 파일명 오류 (NaviGator님)
              $file_name0= str_replace(' ', '_',$file_name0); 
              $file_name0= str_replace('\\\'', '_',$file_name0); 

              $file_name1 = intval($me_id) . "_" . preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $file_name0);
              $file_name2 = str_replace('%', '', urlencode($file_name1));

             	@move_uploaded_file($_FILES[memo_file][tmp_name], "$dir_name/$file_name2");
            	@chmod("$dir_name/$file_name2", 0606);

              $file_name3 = $member[mb_id] . "/" . $file_name2;
        }

        // 쪽지 보내기
        memo4_send($mb_list[$i], $member[mb_id], $me_memo, $me_subject, "$html,$secret,$mail", 1, $file_name0, $file_name3);

        // 포인트 기록 - history를 위해서
        $recv_mb_nick = get_text($mb_array[$i][mb_nick]);
        $recv_mb_id = $mb_array[$i][mb_id];
        insert_point($member[mb_id], (int)$config[cf_memo_send_point] * (-1), "{$recv_mb_nick}({$recv_mb_id})님께 쪽지 발송", "@memo", $recv_mb_id, $me_id);
    }

} // for - loop의 끝부분

if ($msg)
    alert("\'$msg\'님은 존재하지 않거나 수신을 거부하는 아이디 입니다. \'$me_recv_mb_id_list\' 님께 쪽지를 전달하였습니다.", "./memo.php?kind=send");
else 
    alert("\'$me_recv_mb_id_list\' 님께 쪽지를 전달하였습니다.", "./memo.php?kind=send");

?>
