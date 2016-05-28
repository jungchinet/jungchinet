<?
// 그누 웹사이트 소스파일 백업
// 남규아빠, 아빠불당
// http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=20605

$sub_menu = "100200";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "소스파일 백업";
include_once("./admin.head.php");

$backup_dir = $g4[path] ."/data/backup";

if (!is_dir($backup_dir)) {
    @mkdir($backup_dir, 0707);
    @chmod($backup_dir, 0707);

    // 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
    $file = $backup_dir . "/index.php";
    $f = @fopen($file, "w");
    @fwrite($f, "");
    @fclose($f);
    @chmod($file, 0606);
}

$backup_file = $backup_dir . "/www_".$g4[time_ymd]. ".tar";
$backup_list = $backup_dir . "/www_".$g4[time_ymd]. ".txt";

$no_backup = " --exclude=". $g4[path] . "/data ";
$no_backup .= " --exclude=". $g4[path] . "/dbconfig.php ";

$fb = popen("tar -cvpf " . $backup_file . $no_backup . $g4[path] . " > " . $backup_list, "r");

if ($fb) {
    while ($file_line = fgets($fb, 1024)) {
        printf("%s<br>\n", $file_line);
    }
    pclose($fb);

    // 파일이름을 추정 불가능한 것으로 변경 합니다.
    if ($c_domain)
        $bk_domain = $c_domain . "_";
    else
        $bk_domain = "www_";
    
    // 웹경로 이외의 장소에 저장을 원하시면 이곳에서 디렉토리 이름을 절대경로로 지정해주면 됩니다.
    // (예) $backup_dir2 = "/home/user2/data/backup";
    $backup_dir2 = $backup_dir;
    $rand_tail = "_". time() . "_" . rand();
    
    $backup_file2 = $backup_dir2 . "/www_".$g4[time_ymd]. $rand_tail . ".tar";
    $backup_list2 = $backup_dir2 . "/www_".$g4[time_ymd]. $rand_tail . ".txt";
    
    @rename($backup_file, $backup_file2);
    @rename($backup_list, $backup_list2);

    echo         "그누 사이트의 소스파일 백업을 완료했습니다.";
    echo "<br><br>PC로 다운로드 하신후 백업파일을 삭제해 주세요.";
    echo "<br><br>다운로드 하시려면 <a href='$backup_file2'>[ 여 기 ]</a> 를 눌러주세요";

} 
else 
{
    echo         "그누 사이트의 소스파일 백업을 할 수 없습니다. 서버 운영자에게 문의하세요.";
}

include_once("./admin.tail.php");
?>
