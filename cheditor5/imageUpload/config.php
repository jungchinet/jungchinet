<?php
// ---------------------------------------------------------------------------
// 이미지가 저장될 디렉토리의 전체 경로를 설정합니다.
// 끝에 슬래쉬(/)는 붙이지 않습니다.
// 주의: 이 경로의 접근 권한은 쓰기, 읽기가 가능하도록 설정해 주십시오.

//define("SAVE_DIR", "/path/to/cheditor/attach");

// 위에서 설정한 'SAVE_DIR'의 URL을 설정합니다.
// 끝에 슬래쉬(/)는 붙이지 않습니다.

//define("SAVE_URL", "http://udomain.com/cheditor/attach");

// ---------------------------------------------------------------------------

//define("SAVE_DIR", "/main/data/cheditor4/1006");
//define("SAVE_URL", "http://digitalmind.co.kr/main/data/cheditor4/1006");

include_once("./_common.php");

// 월별로 나눠주지 않으면, 디렉토리가 펑~ 터진다.
$ym = date("ym", $g4[server_time]);

// 저장할 디렉토리를 지정한다
if ($g4[cheditor_save_dir] == "") {
    $g4[cheditor_save_dir] = dirname($g4[data_path] . "/nothing");
    $g4[cheditor_save_dir] = $g4[cheditor_save_dir] . "/" . $g4[cheditor4];
}

define("SAVE_DIR", "$g4[cheditor_save_dir]/$ym");
if (!file_exists("$g4[cheditor_save_dir]/$ym")) {
    @mkdir(SAVE_DIR, 0707);
    @chmod(SAVE_DIR, 0707);
}

// 저장 URL을 지정한다
if ($g4['cheditor_image_url'] == "") {
    $image_url = dirname($_SERVER[REQUEST_URI]);
    $g4['cheditor_image_url'] = "http://{$_SERVER[HTTP_HOST]}{$image_url}/{$g4[data_path]}/$g4[cheditor4]";
}
define('SAVE_URL', "$g4[cheditor_image_url]/$ym");
?>
