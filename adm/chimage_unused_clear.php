<?
$sub_menu = "300810";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if (!$ok)
    alert();

if ($is_admin != "super")
    alert("안쓰는 이미지 정리는 최고관리자만 가능합니다.");

$g4[title] = "안쓰는 이미지 정리";
include_once("./admin.head.php");

echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

echo "<script>document.getElementById('ct').innerHTML += '<p>안쓰는 이미지 정리중...';</script>\n";
flush();

// 현재부터 7일 이전의 이미지에 대해서만 clear 합니다.
$clear_days = 3;
$clear_datetime = date("Y-m-d H:i:s", $g4[server_time] - (86400 * $clear_days));

// 한번에 정리할 이미지의 숫자
$max_mb_num = 100;

// 정리할 이미지목록을 만들고 - 먼거부터
$sql = " SELECT *
           FROM $g4[board_cheditor_table] 
          WHERE bc_datetime < '{$clear_datetime}' and ( wr_id is null or del = '1' )
          ORDER BY bc_id asc ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // 정해진 숫자가 되면 break;
    if ($i >= $max_mb_num) 
        break;

    // $img[src] 웹 상의 절대경로 이므로 이미지 파일의 상대경로를 구합니다.
    // 이렇게 잘라줘야 제대로 된 경로가 나온다.
    $fl = explode("/$g4[data]/",$row[bc_dir]);
    $rel_path = "../" . $g4[data] . "/" . $fl[1];

    $img_link = $rel_path . "/" . $row[bc_file];

    // 백업으로 넣어둘 디렉토리. 끝이 _delete로 끝난다.
    $img_bkup = $rel_path . "_delete";
    if (!file_exists("$img_bkup")) {
        @mkdir($img_bkup, 0707);
        @chmod($img_bkup, 0707);
    }
    $bkup_link = $img_bkup . "/" . $row[bc_file];
    
    // 이미지를 백업 받는다
    rename($img_link, $bkup_link);

    // 이미지 정보를 지운다
    $sql = " delete from $g4[board_cheditor_table] where bc_id = '$row[bc_id]' ";
    sql_query($sql);

    $str = $row[bo_table]." 게시판에서 ".$row[bc_source]." 파일이 삭제 되었습니다<br>";
    echo "<script>document.getElementById('ct').innerHTML += '$str';</script>\n";
    flush();
}

echo "<script>document.getElementById('ct').innerHTML += '<p>총 ".$i."건의 안쓰는 이미지가 정리 되었습니다.';</script>\n";
echo "<script>document.getElementById('ct').innerHTML += '<a href=\'" . $g4[admin_path] . "/chimage_unused_list.php\'>안쓰는이미지관리로 이동하기</a>'</script>\n";
?>
