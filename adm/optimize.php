<?
$sub_menu = "100710";
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "테이블 최적화";
include_once("./admin.head.php");
echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br>";
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

$sql = "SHOW TABLE STATUS FROM ".$mysql_db;
$result = sql_query($sql);
while($row = sql_fetch_array($result))
{
    $str = '';

    $tbl = $row['Name'];

    if($row['Data_free'] == 0) continue;

    // 테이블 최적화
    $sql3 = " OPTIMIZE TABLE `$tbl` ";
    sql_query($sql3);
    $str .= $sql3 . "<br/>";

    echo "<script>document.getElementById('ct').innerHTML += '$str';</script>\n";

    flush();
    /*
    for($i = 0; $i < 40 - strlen($tbl); $i ++) echo " ";
        echo "\t";
    for($i = 0; $i < 9 - strlen($row['Data_free']); $i ++) echo " ";
        echo $row['Data_free']." OPTIMIZED\n";
    */
}
echo "<script>document.getElementById('ct').innerHTML += '<br><br>테이블 복구 및 최적화 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";
?>
