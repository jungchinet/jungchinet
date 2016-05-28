<?
include_once("./_common.php");

$g4[title] = "비승인 게시글 게시물 일괄 삭제" . $act;
include_once("$g4[path]/head.sub.php");

// 참조 : /bbs/delete_all.php (해당 코드가 변경되면 이 코드도 반드시 수정해야 함)

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($sw != "d")
    alert("바르지 못한 사용입니다.");

// $_POST[chk_wr_id] : $list[$i][wr_id]}|{$list[$i][bo_table]}

$count_write = 0;
$count_comment = 0;

$tmp_array = array();
if ($wr_id) // 건별삭제
    $tmp_array[0] = $wr_id;
else // 일괄삭제
    $tmp_array = $_POST[chk_wr_id];

// 거꾸로 읽는 이유는 답변글부터 삭제가 되어야 하기 때문임
for ($i=count($tmp_array)-1; $i>=0; $i--) {
    // 삭제할 게시글 정보를 가져오기
    $wr_array=explode("|",$tmp_array[$i]);
    $wr_id = $wr_array[0];
    $bo_table = $wr_array[1];
    $write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

    $sql = " select * from $write_table where wr_id = '{$wr_id}' ";
    $write = sql_fetch($sql);

if ($write[wr_is_comment]) { // 코멘트인 경우

    // 코멘트 포인트 삭제
    if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
       insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{wr_id} 코멘트삭제");

    // 코멘트 삭제
    sql_query(" delete from $write_table where wr_id = '$wr_id' ");
    
    $sql = " delete from $write_table where wr_id = '$wr_id' ";

    // 최근게시물 삭제
    sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_id = '$wr_id' ");

    // 게시글의 코멘트 숫자 감소
    sql_query(" update $write_table set wr_comment = wr_comment - 1 where wr_id = '$write[wr_parent]' ");    
    
    // 글 숫자 감소
    sql_query(" update $g4[board_table] set bo_count_comment = bo_count_comment - 1 where bo_table = '$bo_table' ");    

} else { // 코멘트가 아닌경우

    // 이부분 부터는 delete_all.php에서 그래도 복사 (원글삭제)
    $len = strlen($write[wr_reply]);
    if ($len < 0) $len = 0; 
    $reply = substr($write[wr_reply], 0, $len);

    // 원글만 구한다.
    $sql = " select count(*) as cnt from $write_table
              where wr_reply like '$reply%'
                and wr_id <> '$write[wr_id]'
                and wr_num = '$write[wr_num]'
                and wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    if ($row[cnt])
            continue;

    // 나라오름님 수정 : 원글과 코멘트수가 정상적으로 업데이트 되지 않는 오류를 잡아 주셨습니다.
    //$sql = " select wr_id, mb_id, wr_comment from $write_table where wr_parent = '$write[wr_id]' order by wr_id ";
    $sql = " select wr_id, mb_id, wr_is_comment from $write_table where wr_parent = '$write[wr_id]' order by wr_id ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) 
    {
        // 원글이라면
        if (!$row[wr_is_comment]) 
        {
            // 원글 포인트 삭제
            if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '쓰기'))
                insert_point($row[mb_id], $board[bo_write_point] * (-1), "$board[bo_subject] $row[wr_id] 글삭제");

            // 업로드된 파일이 있다면
            $sql2 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            $result2 = sql_query($sql2);
            while ($row2 = sql_fetch_array($result2))
                // 파일삭제
                @unlink("$g4[data_path]/file/$bo_table/$row2[bf_file]");
                
            // 파일테이블 행 삭제
            sql_query(" delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ");

            $count_write++;
        } 
        else 
        {
            // 코멘트 포인트 삭제
            if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
                insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{$row[wr_id]} 코멘트삭제");

            $count_comment++;
        }
    }

    // 게시글 삭제
    sql_query(" delete from $write_table where wr_parent = '$write[wr_id]' ");

    // 최근게시물 삭제
    sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");

    // 스크랩 삭제
    sql_query(" delete from $g4[scrap_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]' ");

    // 공지사항 삭제
    $notice_array = explode("\n", trim($board[bo_notice]));
    $bo_notice = "";
    for ($k=0; $k<count($notice_array); $k++)
        if ((int)$write[wr_id] != (int)$notice_array[$k])
            $bo_notice .= $notice_array[$k] . "\n";
    $bo_notice = trim($bo_notice);
    sql_query(" update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");
    $board[bo_notice] = $bo_notice;

    // 글숫자 감소
    if ($count_write > 0 || $count_comment > 0)
        sql_query(" update $g4[board_table] set bo_count_write = bo_count_write - '$count_write', bo_count_comment = bo_count_comment - '$count_comment' where bo_table = '$bo_table' ");

    // 글숫자 감소 카운터 초기화 (왜? 게시판이 모두 다르니까)
    $count_write = 0;
    $count_comment = 0;

} // if의 끝
} // for loop의 끝

goto_url("$g4[bbs_path]/new.php?gr_id=$gr_id&view=$view&mb_id=$mb_id" . $qstr);
?>
