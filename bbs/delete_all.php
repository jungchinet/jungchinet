<?
include_once("./_common.php");

// 4.11
@include_once("$board_skin_path/delete_all.head.skin.php");

$count_write = 0;
$count_comment = 0;

// 불당팩 - 삭제되지 않는 메시지를 위해서
$tmp_array_undeleted = "";

$tmp_array = array();
if ($wr_id) // 건별삭제
    $tmp_array[0] = $wr_id;
else // 일괄삭제
    $tmp_array = $_POST[chk_wr_id];


// 사용자 코드 실행
@include_once("$board_skin_path/delete_all.skin.php");


// 거꾸로 읽는 이유는 답변글부터 삭제가 되어야 하기 때문임
for ($i=count($tmp_array)-1; $i>=0; $i--) 
{
    $write = sql_fetch(" select * from $write_table where wr_id = '{$tmp_array[$i]}' ");

    if ($is_admin == "super") // 최고관리자 통과
        ;
    else if ($is_admin == "group") // 그룹관리자
    {
        $mb = get_member($write[mb_id]);
        if ($member[mb_id] == $group[gr_admin]) // 자신이 관리하는 그룹인가?
        {
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
                ;
            else {
                $tmp_array_undeleted .= $tmp_array[$i] . " ";
                continue;
            }
        } 
        else
            continue;
    } 
    else if ($is_admin == "board") // 게시판관리자이면
    {
        $mb = get_member($write[mb_id]);
        if ($member[mb_id] == $board[bo_admin]) // 자신이 관리하는 게시판인가?
            if ($member[mb_level] >= $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
                ;
            else {
                $tmp_array_undeleted .= $tmp_array[$i] . " ";
                continue;
            }
        else
            continue;
    } 
    else if ($member[mb_id] && $member[mb_id] == $write[mb_id]) // 자신의 글이라면
    {
        ;
    } 
    else if ($wr_password && !$write[mb_id] && sql_password($wr_password) == $write[wr_password]) // 패스워드가 같다면
    {
        ;
    } 
    else
        continue;   // 나머지는 삭제 불가

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

            // 업로드된 파일이 있다면 파일삭제
            //$sql2 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            //$result2 = sql_query($sql2);
            //while ($row2 = sql_fetch_array($result2))
            //    @unlink("$g4[data_path]/file/$bo_table/$row2[bf_file]");
            
            // 파일테이블 행 삭제
            //sql_query(" delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ");

            // 업로드된 파일이 있다면
            $sql2 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            $result2 = sql_query($sql2);
            while ($row2 = sql_fetch_array($result2))
                // 파일삭제
                @unlink("$g4[data_path]/file/$bo_table/$row2[bf_file]");
                
            // 파일테이블 행 삭제
            sql_query(" delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ");

            // 불당팩 - cheditor 이미지 삭제
            $sql = " select * from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]'";
            $result3 = sql_query($sql);
            while ($row3=sql_fetch_array($result3)) {
                $file_path = $row3[bc_dir] . "/" . $row3[bc_file];
                @unlink($file_path);
                $sql_d = " delete from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' and bc_url='$row3[bc_url]' ";
                sql_query($sql_d);
            }

            // 불당팩 - whaton 삭제 (답글)
            $sql = " delete from $g4[whatson_table] where bo_table ='$bo_table' and wr_id = '$row[wr_id]' ";
            sql_query($sql);

            // 불당팩 - 전체 공지사항 삭제
            $sql = " delete from $g4[notice_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            sql_query($sql);

            // 베스트글 삭제
            sql_query(" delete from $g4[good_list_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ");
			
			$d_sql="update prem_info set del_date=now() where prem_board='$bo_table' and prem_wr_id='$row[wr_id]'";
			mysql_query($d_sql);

            $count_write++;
        } 
        else 
        {
            // 코멘트 포인트 삭제
            if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
                insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{$row[wr_id]} 코멘트삭제");

            // 불당팩 - whaton 삭제 (코멘트)
            $sql = " delete from $g4[whatson_table] where bo_table ='$bo_table' and wr_id = '$row[wr_id]' ";
            sql_query($sql);

            $count_comment++;
        }

        // 추천정보를 삭제
        $sql = " delete from $g4[board_good_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
        sql_query($sql);
    }

    // 게시글 삭제
    sql_query(" delete from $write_table where wr_parent = '$write[wr_id]' ");

    // 최근게시물 삭제
    sql_query(" delete from $g4[board_new_table] where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");

    // 스크랩 삭제
    sql_query(" delete from $g4[scrap_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]' ");

    // 신고내역 삭제
    sql_query(" delete from $g4[singo_table] where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");

    // 공지사항 삭제
    $notice_array = explode("\n", trim($board[bo_notice]));
    $bo_notice = "";
    for ($k=0; $k<count($notice_array); $k++)
        if ((int)$write[wr_id] != (int)$notice_array[$k])
            $bo_notice .= $notice_array[$k] . "\n";
    $bo_notice = trim($bo_notice);
    sql_query(" update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");
    $board[bo_notice] = $bo_notice;
    
    // 불당팩 - 전체 공지사항 삭제
    $sql = " delete from $g4[notice_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]' ";
    sql_query($sql);

    // 불당팩 - 왔숑~ 삭제
    $sql = " delete from $g4[whatson_table] where bo_table ='$bo_table' and wr_id = '$write[wr_id]' ";
    sql_query($sql);
}

// 글숫자 감소
if ($count_write > 0 || $count_comment > 0)
    sql_query(" update $g4[board_table] set bo_count_write = bo_count_write - '$count_write', bo_count_comment = bo_count_comment - '$count_comment' where bo_table = '$bo_table' ");

// 불당팩 - min_wr_num 업데이트
$result = sql_fetch(" select MIN(wr_num) as min_wr_num from $write_table ");
$sql = " update $g4[board_table] set min_wr_num = '$result[min_wr_num]' where bo_table = '$bo_table' ";
sql_query($sql);

// 4.11
@include_once("$board_skin_path/delete_all.tail.skin.php");

if ($tmp_array_undeleted)
    alert("게시글 id {$tmp_array_undeleted}은/는 게시자의 레벨이 같거나 크기 때문에 삭제할 수 없습니다.", "./board.php?bo_table=$bo_table&page=$page" . $qstr . "#board");
else
    goto_url("./board.php?bo_table=$bo_table&page=$page" . $qstr . "#board");
?>
