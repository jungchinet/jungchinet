<?
include_once("./_common.php");

//$wr = sql_fetch(" select * from $write_table where wr_id = '$wr_id' ");

@include_once("$board_skin_path/delete.head.skin.php");

if ($is_admin)
{
    if (!($token && get_session("ss_delete_token") == $token)) 
        alert("토큰 에러로 삭제 불가합니다.");
}

if ($is_admin == "super") // 최고관리자 통과
    ;
else if ($is_admin == "group") { // 그룹관리자
    $mb = get_member($write[mb_id]);
    if ($member[mb_id] != $group[gr_admin]) // 자신이 관리하는 그룹인가?
        alert("자신이 관리하는 그룹의 게시판이 아니므로 삭제할 수 없습니다.");
    else if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
        alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
} else if ($is_admin == "board") { // 게시판관리자이면
    $mb = get_member($write[mb_id]);
    if ($member[mb_id] != $board[bo_admin]) // 자신이 관리하는 게시판인가?
        alert("자신이 관리하는 게시판이 아니므로 삭제할 수 없습니다.");
    else if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
        alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
} else if ($member[mb_id]) {
    if ($member[mb_id] != $write[mb_id])
        alert("자신의 글이 아니므로 삭제할 수 없습니다.");
} else {
    if ($write[mb_id])
        alert("로그인 후 삭제하세요.", "./login.php?url=".urlencode("./board.php?bo_table=$bo_table&wr_id=$wr_id"));
    else if (sql_password($wr_password) != $write[wr_password])
        alert("패스워드가 틀리므로 삭제할 수 없습니다."); 
}

// 불당팩 - 휴지통으로 이동을 위해서 추가한 코드, /bbs/move_update.php의 하단부와 코드를 맞춰야 합니다
$recycle = "";
if ($config[cf_use_recycle] && $board[bo_use_recycle]) {

    // $config[cf_recycle_table]이 정의 되지 않으면 오류를 날려준다
    if ($config[cf_recycle_table] == "")
        alert("관리자오류 - 휴지통게시판이 지정되지 않았습니다. 관리자 기본환경설정에서 휴지통을 지정해주세요.");

    // 복사/이동에 대한 log를 남기지 않게 설정
    $config[cf_use_copy_log] = 0;

    // 대피할 게시판
    $board['bo_move_bo_table'] = $config[cf_recycle_table];

    // recycle action임을 지정
    $recycle = "recycle";
    
    // 게시글에 대한 정보에서 원글이 아니면, return
    if ($write[wr_id] !== $write[wr_parent])
        alert("원글에 대해서만 가능한 작업 입니다");

    // 이부분은 아래에서 차용한 것 입니다. 차용한 나머지 부분은 뒤에...
    // 원글의 포인트만 차감 합니다.
    $sql = " select wr_id, mb_id, wr_is_comment from $write_table where wr_parent = '$write[wr_id]' order by wr_id ";
    $result_del = sql_query($sql);

    include_once("./move2_update.php");

    // recycle action - 최신글을 지우고
    $bn = sql_fetch(" select * from $g4[board_new_table] where bo_table = '$move_bo_table' and wr_id = '$insert_id' ");
    sql_query(" delete from $g4[board_new_table] where bo_table = '$move_bo_table' and wr_id = '$insert_id' ");
    
    // 게시판에서 원글의 wr_id를 찾아야징
    $sql = " select wr_parent from $move_write_table where wr_id='$insert_id' ";
    $res2 = sql_fetch($sql);
    
    // recycle action - recycle 게시판에 글쓰고
    $sql = " insert into $g4[recycle_table]
                set 
                    rc_bo_table     = '$config[cf_recycle_table]',
                    rc_mb_id        = '$member[mb_id]',
                    rc_wr_id        = '$res2[wr_parent]',
                    rc_wr_parent    = '$res2[wr_parent]',
                    rc_parent_mb_id = '$bn[parent_mb_id]',
                    mb_id           = '$write[mb_id]',
                    bo_table        = '$board[bo_table]',
                    wr_id           = '$write[wr_id]',
                    wr_is_comment   = '$write[wr_is_comment]',
                    bn_id           = '$bn[bn_id]',
                    rc_datetime     = '$g4[time_ymdhis]' ";
    sql_query($sql);

    // 이부분은 아래에서 차용한 것 입니다. 차용한 나머지 부분은 위에...
    // 원글의 포인트만 차감 합니다.
    while ($row = sql_fetch_array($result_del)) 
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

            // 불당팩 - cheditor 이미지 삭제
            $sql = " select * from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]'";
            $result3 = sql_query($sql);
            while ($row3=sql_fetch_array($result3)) {
                $file_path = $row3[bc_dir] . "/" . $row3[bc_file];
                @unlink($file_path);
                $sql_d = " delete from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id = '$write[wr_id]' and bc_url='$row3[bc_url]' ";
                sql_query($sql_d);
            }

            // 불당팩 - whaton 삭제 (답글)
            $sql = " delete from $g4[whatson_table] where bo_table ='$bo_table' and wr_id = '$row[wr_id]' ";
            sql_query($sql);

            // 불당팩 - 전체 공지사항 삭제
            $sql = " delete from $g4[notice_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
            sql_query($sql);

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

    goto_url($opener_href . $qstr . "#board");
}

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
if ($row[cnt] && !$is_admin)
    alert("이 글과 관련된 답변글이 존재하므로 삭제 할 수 없습니다.\\n\\n우선 답변글부터 삭제하여 주십시오.");

// 코멘트 달린 원글의 삭제 여부
$sql = " select count(*) as cnt from $write_table
          where wr_parent = '$wr_id'
            and mb_id <> '$member[mb_id]'
            and wr_is_comment = 1 ";
$row = sql_fetch($sql);
if ($row[cnt] >= $board[bo_count_delete] && !$is_admin)
    alert("이 글과 관련된 코멘트가 존재하므로 삭제 할 수 없습니다.\\n\\n코멘트가 {$board[bo_count_delete]}건 이상 달린 원글은 삭제할 수 없습니다.");


// 사용자 코드 실행
@include_once("$board_skin_path/delete.skin.php");


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
        $sql2 = " select * from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$row[wr_id]' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2))
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

// 불당팩 - 신고내역 업데이트
//sql_query(" delete from $g4[singo_table] where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");
$sg_notes = "$member[mb_nick]($member[mb_id]) - $g4[time_ymdhis] - 게시글삭제";
sql_query(" update $g4[singo_table] set sg_notes='$sg_notes' where bo_table = '$bo_table' and wr_parent = '$write[wr_id]' ");

// 공지사항 삭제
$notice_array = explode("\n", trim($board[bo_notice]));
$bo_notice = "";
for ($k=0; $k<count($notice_array); $k++)
    if ((int)$write[wr_id] != (int)$notice_array[$k])
        $bo_notice .= $notice_array[$k] . "\n";
$bo_notice = trim($bo_notice);
sql_query(" update $g4[board_table] set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");

// 글숫자 감소
if ($count_write > 0 || $count_comment > 0)
    sql_query(" update $g4[board_table] set bo_count_write = bo_count_write - '$count_write', bo_count_comment = bo_count_comment - '$count_comment' where bo_table = '$bo_table' ");

// 불당팩 - min_wr_num 업데이트
$result = sql_fetch(" select MIN(wr_num) as min_wr_num from $write_table ");
$sql = " update $g4[board_table] set min_wr_num = '$result[min_wr_num]' where bo_table = '$bo_table' ";
sql_query($sql);

@include_once("$board_skin_path/delete.tail.skin.php");

$d_sql="update prem_info set del_date=now() where prem_board='$bo_table' and prem_wr_id='$wr_id'";
mysql_query($d_sql);

goto_url("./board.php?bo_table={$bo_table}&page={$page}{$qstr}#board");
?>
