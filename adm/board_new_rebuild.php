<?
$sub_menu = "300120";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "최신글 다시 만들기";
include_once("./admin.head.php");

echo "'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br>";
echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

// 게시판을 모두 읽어 냅니다.
$sql = " select * from $g4[board_table] ";
$result = sql_query($sql);
while($board = sql_fetch_array($result)) {
    $tmp_write_table = $g4['write_prefix'] . $board[bo_table]; // 게시판 테이블 전체이름

    $sql2 = " select * from $tmp_write_table where (TO_DAYS('$g4[time_ymdhis]') - TO_DAYS(wr_datetime)) <= '$config[cf_new_del]' order by wr_datetime asc ";
    $result2 = sql_query($sql2);
    
    while ($write = sql_fetch_array($result2)) {
        // 최신글 테이블에 있는지 체크
        $res = sql_fetch(" select count(*) as cnt from $g4[board_new_table] where bo_table = '$board[bo_table]' and wr_id = '$write[wr_id]' ");
        if ($res[cnt] > 0)
          continue;
        
        // parent_mb_id를 구한다.
        if ($write[wr_is_comment]) {
            // 코멘트인 경우에는 원글의 mb_id를 넣어줍니다.
            $tmp_mb_id = sql_fetch(" select mb_id from $tmp_write_table where wr_id = '$write[wr_parent]' ");
            if ($tmp_mb_id[mb_id] !== "")
                $parent_mb_id = $tmp_mb_id[mb_id];
        } if ($write[wr_reply]) {
            // 불당팩 - 답글인 경우 원글의 mb_id를 입력
            // 원글만 구한다. + 현재글 작성자와는 달라야 한다
            $sql = " select mb_id from $tmp_write_table
                      where wr_reply = ''
                      and wr_id <> '$write[wr_id]'
                      and wr_num = '$write[wr_num]'
                      and mb_id <> '$write[mb_id]'
                      and wr_is_comment = 0 ";
            $tmp_mb_id = sql_fetch($sql);
            if ($tmp_mb_id[mb_id] !== "")
                $parent_mb_id = $tmp_mb_id[mb_id];
        } else {
            $parent_mb_id = "";
        }

        // 최신글 테이블에 값을 insert
        $sql = " insert into $g4[board_new_table]
                    set 
                    bo_table = '$board[bo_table]',
                    wr_id = '$write[wr_id]',
                    wr_parent = '$write[wr_parent]',
                    bn_datetime = '$write[wr_datetime]',
                    mb_id = '$write[mb_id]',
                    parent_mb_id = '$parent_mb_id',
                    wr_is_comment = '$write[wr_is_comment]',
                    gr_id = '$board[gr_id]',
                    wr_option = '$write[wr_option]',
                    my_datetime = '$write[wr_last]' ";
        sql_query($sql, FALSE);
    }
}


echo "<script>document.getElementById('ct').innerHTML += '<br><br>최신글테이블 리빌드 완료.<br><br>프로그램의 실행을 끝마치셔도 좋습니다.';</script>\n";

include_once("./admin.tail.php");
?>
