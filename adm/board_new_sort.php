<?
$sub_menu = "300100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "최신글정렬";
include_once("./admin.head.php");

echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br>";
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

// 복사 테이블을 정의 합니다.
$g4[board_new_copy_table ] = $g4[board_new_table] . "_copy";

// 테이블을 하나 복사 합니다. 매사는 불여튼튼
$sql = " DROP TABLE  IF EXISTS $g4[board_new_copy_table] ";
sql_query($sql);
$sql = " CREATE TABLE $g4[board_new_copy_table] select * from $g4[board_new_table] ";
sql_query($sql);

// 복사된 게시판의 bn_datetime을 wr_datetime으로 업데이트 합니다. 이거는 한땀 한땀 해야 합니다.
$sql = " select * from $g4[board_new_copy_table] ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
    $write = sql_fetch(" select wr_datetime from $tmp_write_table where wr_id = '$row[wr_id]' ");
    
    $sql = " update $g4[board_new_copy_table] set bn_datetime='$write[wr_datetime]' where bn_id='$row[bn_id]' ";
    sql_query($sql);
}
echo "<script>document.getElementById('ct').innerHTML += '<br><br>bn_datetime 업데이트 완료';</script>\n";

// 원본 게시판의 모든 최신글 레코드를 싹 지워버립니다.
sql_query(" delete from $g4[board_new_table] ");

echo "<script>document.getElementById('ct').innerHTML += '<br><br>max_id 계산 완료';</script>\n";

// 지웠으니, 이제 넣어야죠. 어떻게? 잘~. ㅋㅋ... 
// 한방에 다 넣을 수는 있지만, 그럴려면 작업할 동안 누가 글쓰면 안되거든요. 그래서 한땀씩 넣어버립니다.
$sql = " select * from $g4[board_new_copy_table] order by bn_datetime asc ";
$result = sql_query($sql);
$bn_id = 1;
while ($row = sql_fetch_array($result)) {
    $sql = " insert into $g4[board_new_table]
                set 
                    bn_id = '$bn_id',
                    bo_table = '$row[bo_table]',
                    wr_id = '$row[wr_id]',
                    wr_parent = '$row[wr_parent]',
                    bn_datetime = '$row[bn_datetime]',
                    mb_id = '$row[mb_id]',
                    parent_mb_id = '$row[parent_mb_id]',
                    wr_is_comment = '$row[wr_is_comment]',
                    gr_id = '$row[gr_id]',
                    wr_option = '$row[wr_option]',
                    my_datetime = '$row[my_datetime]' ";
    sql_query($sql);
    $bn_id++;
}

echo "<script>document.getElementById('ct').innerHTML += '<br><br>최신글테이블 정렬 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";

include_once("./admin.tail.php");
?>
