<?php
// ---------------------------------------------------------------------------
//                              CHXImage
//
// 이 코드는 데모를 위해서 제공됩니다.
// 환경에 맞게 수정 또는 참고하여 사용해 주십시오.
//
// ---------------------------------------------------------------------------

require_once("config.php");

//----------------------------------------------------------------------------
//
//
$tempfile = $_FILES['file']['tmp_name'];
$filename = $_FILES['file']['name'];

//if (preg_match("/\.(php|htm|inc)/i", $filename)) die("-ERR: File Format");

// demo.html 파일에서 설정한 SESSID 값입니다.
//$sessid   = $_POST['sessid'];

// 저장 파일 이름
// $savefile = SAVE_DIR . '/' . $_FILES['file']['name'];

$pos = strrpos($filename, '.');
$ext = strtolower(substr($filename, $pos, strlen($filename)));

switch ($ext) {
case '.gif' :
case '.png' :
case '.jpg' :
case '.jpeg' :
	break;
default :
	die("-ERR: File Format!");
}

$ym = date("ym", time());
$ymd = date("ymd", time());
$pos = strrpos($filename, '.');
$ext = substr($filename, $pos, strlen($filename));
//$random_name = random_generator() . $ext;
$random_name = $ymd . "_" .  md5($_SERVER['REMOTE_ADDR']) . '_' . random_generator() . $ext;
$savefile = SAVE_DIR . '/' . $random_name;
move_uploaded_file($tempfile, $savefile);
$imgsize = getimagesize($savefile);
$filesize = filesize($savefile);

if (!$imgsize) {
	$filesize = 0;
	$random_name = '-ERR';
	unlink($savefile);
} else {
  // image type이 1보다 작거나 16 보다 크면 오류를
  if ($imgsize[2] < 1 || $imgsize[2] > 16)
  {
    die("-ERR: File Format!");
  }

  // 올라간 파일의 퍼미션을 변경합니다.
  chmod($savefile, 0606);
}

$rdata = sprintf( "{ fileUrl: '%s/%s', filePath: '%s/%s', origName: '%s', fileName: '%s', fileSize: '%d' }",
	SAVE_URL,
	$random_name,
	SAVE_DIR,
	$random_name,
	$filename,
	$random_name,
	$filesize );

echo $rdata;

// 불당팩 - 올라가는 모든 image 파일을 체크, 게시판에 올라가는거만 처리.
if ($bo_table !== "") {
    $bc_url = SAVE_URL . "/" . $random_name;
    $sql = " insert into $g4[board_cheditor_table]
            SET
                mb_id = '$member[mb_id]',
                bc_dir = '" . SAVE_DIR . "',
                bc_file = '$random_name',
                bc_url = '$bc_url',
                bc_filesize = '" . filesize2bytes($filesize)/1024 . "',
                bc_source = '" . mysql_real_escape_string($filename) . "',
                bc_ip = '$remote_addr',
                bc_datetime = '$g4[time_ymdhis]',
                bo_table = '$bo_table'
        ";
    sql_query($sql);
}

function random_generator ($min=8, $max=32, $special=NULL, $chararray=NULL) {
// ---------------------------------------------------------------------------
//
//
    $random_chars = array();
    
    if ($chararray == NULL) {
        $str = "abcdefghijklmnopqrstuvwxyz";
        $str .= strtoupper($str);
        $str .= "1234567890";

        if ($special) {
            $str .= "!@#$%";
        }
    }
    else {
        $str = $charray;
    }

    for ($i=0; $i<strlen($str)-1; $i++) {
        $random_chars[$i] = $str[$i];
    }

    srand((float)microtime()*1000000);
    shuffle($random_chars);

    $length = rand($min, $max);
    $rdata = '';
    
    for ($i=0; $i<$length; $i++) {
        $char = rand(0, count($random_chars) - 1);
        $rdata .= $random_chars[$char];
    }
    return $rdata;
}

?>
