<?
$sub_menu = "100910";
include_once("_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

if (!($mb_password && sql_password($mb_password)==$member[mb_password]))
    alert("최고관리자 패스워드가 틀립니다.");

// 테이블 생성 ------------------------------------
$file = implode("", file("memo4.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysql_query($f[$i]) or die(mysql_error());
}
// 테이블 생성 ------------------------------------
$sql = " INSERT INTO `$g4[memo_config_table]` 
            set `cf_memo_page_rows` = 20, 
                `cf_memo_del_unread` = 180, 
                `cf_memo_del_trash` = 7, 
                `cf_memo_delete_datetime` = '0000-00-00 00:00:00', 
                `cf_memo_user_dhtml` = 1, 
                `cf_memo_use_file` = 0, 
                `cf_friend_management` = 0, 
                `cf_memo_notice_board` = '', 
                `cf_memo_before_after` = 0 ";
sql_query($sql, true);

// 디렉토리 생성
$dir_arr = array ("../data/memo2", "../data/memo2_deleted");
for ($i=0; $i<count($dir_arr); $i++) 
{
    @mkdir($dir_arr[$i], 0707);
    @chmod($dir_arr[$i], 0707);

    // 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
    $file = $dir_arr[$i] . "/index.php";
    $f = @fopen($file, "w");
    @fwrite($f, "");
    @fclose($f);
    @chmod($file, 0606);
}

alert("설치를 정상적으로 완료 하였습니다.", "memo4_install.php");
?>
