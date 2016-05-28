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

// 쪽지2를 사용하는 경우
$html = "html1";

$sql = " update $g4[memo_recv_table] set me_option = '$html,$secret,$mail' ";
sql_query($sql, false);

$sql = " update $g4[memo_send_table] set me_option = '$html,$secret,$mail' ";
sql_query($sql, false);

$sql = " update $g4[memo_save_table] set me_option = '$html,$secret,$mail' ";
sql_query($sql, false);

echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
