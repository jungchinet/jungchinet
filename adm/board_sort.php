<?
$sub_menu = "300100";
include_once("_common.php");

check_demo();

auth_check($auth[$sub_menu], "r");

$token = get_token();

$g4[title] = "게시판관리";
include_once("./admin.head.php");

echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br><br>";
echo "<span id='ct'></span>";

include_once("./admin.tail.php");

if (!$bo_table) die("bo_table 값이 없습니다.");

$write_table = $g4[write_prefix].$bo_table;

$data = array();

$sql = "select wr_id, wr_num from {$write_table} where wr_is_comment=0 and wr_reply='' order by wr_datetime";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry)) $data[] = $row;

sql_query("update {$write_table} set wr_num = wr_num * -1");

$wr_num = 0;
$cnt=0;

foreach ($data as $row)
{
    $wr_num--;
    $row[wr_num] *= -1;

    $sql = "update {$write_table} set wr_num = '{$wr_num}' where wr_num = '{$row[wr_num]}'";
    sql_query($sql);

    $msg = "{$row[wr_num]}을 $wr_num으로 재정렬 했습니다";
    echo "<script>document.getElementById('ct').innerHTML += '$msg<br/>';</script>\n";

    flush();

    $cnt++;
    if ($cnt%20==0)
        echo "<script>document.getElementById('ct').innerHTML = '';</script>\n";
}

echo "<script>document.getElementById('ct').innerHTML += '<br><br>게시판 재정렬 {$cnt}건 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";

$msg = "<a href=./board_list.php>게시판관리로 돌아가기</a>";
echo "<script>document.getElementById('ct').innerHTML += '<br><br>$msg';</script>\n";

//goto_url("board_list.php");
?>
