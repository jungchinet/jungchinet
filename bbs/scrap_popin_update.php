<?
include_once("./_common.php");

include_once("$g4[path]/head.sub.php");

if (!$member[mb_id]) 
{
    $href = "./login.php?$qstr&url=".urlencode("./board.php?bo_table=$bo_table&wr_id=$wr_id");
    echo "<script language='JavaScript'> alert('회원만 접근 가능합니다.'); top.location.href = '$href'; </script>";
    exit;
}

$sql = " select count(*) as cnt from $g4[scrap_table]
          where mb_id = '$member[mb_id]'
            and bo_table = '$bo_table'
            and wr_id = '$wr_id' ";
$row = sql_fetch($sql);
if ($row[cnt]) 
{
    echo "
    <script language='JavaScript'> 
    if (confirm('이미 스크랩하신 글 입니다.\\n\\n지금 스크랩을 확인하시겠습니까?'))
        document.location.href = './scrap.php';
    else
        window.close();
    </script>";
    exit;
}

// 덧글이 넘어오고 코멘트를 쓸 권한이 있다면
/*
if ($wr_content && ($member[mb_level] >= $board[bo_comment_level])) 
{
    $wr = get_write($write_table, $wr_id);
    // 원글이 존재한다면
    if ($wr[wr_id]) 
    {
        $mb_id = $member[mb_id];
        $wr_name = $member[mb_nick];
        $wr_password = $member[mb_password];
        $wr_email = $member[mb_email];
        $wr_homepage = $member[mb_homepage];

        $sql = " select max(wr_comment) as max_comment from $write_table 
                  where wr_parent = '$wr_id' and wr_is_comment = 1 ";
        $row = sql_fetch($sql);
        $row[max_comment] += 1;

        $sql = " insert into $write_table
                    set ca_name = '$wr[ca_name]',
                        wr_option = '',
                        wr_num = '$wr[wr_num]',
                        wr_reply = '',
                        wr_parent = '$wr_id',
                        wr_is_comment = '1',
                        wr_comment = '$row[max_comment]',
                        wr_content = '$wr_content',
                        mb_id = '$mb_id',
                        wr_password = '$wr_password',
                        wr_name = '$wr_name',
                        wr_email = '$wr_email',
                        wr_homepage = '$wr_homepage',
                        wr_datetime = '$g4[time_ymdhis]',
                        wr_ip = '$remote_addr' ";
        sql_query($sql);

        $comment_id = mysql_insert_id();

        // 원글에 코멘트수 증가
        sql_query(" update $write_table set wr_comment = wr_comment + 1 where wr_id = '$wr_id' ");

        // 새글 INSERT
        //sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime ) values ( '$bo_table', '$comment_id', '$wr_id', '$g4[time_ymdhis]' ) ");
        sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$comment_id', '$wr_id', '$g4[time_ymdhis]', '$member[mb_id]' ) ");

        // 코멘트 1 증가
        sql_query(" update $g4[board_table] set bo_count_comment = bo_count_comment + 1 where bo_table = '$bo_table' ");

        // 포인트 부여
        insert_point($member[mb_id], $board[bo_comment_point], "$board[bo_subject] {$wr_id}-{$comment_id} 코멘트쓰기", $bo_table, $comment_id, '코멘트');
    }
}

$sql = " insert into $g4[scrap_table] ( mb_id, bo_table, wr_id, ms_datetime )
         values ( '$member[mb_id]', '$bo_table', '$wr_id', '$g4[time_ymdhis]' ) ";
*/

$sql = " insert into $g4[scrap_table] ( mb_id, bo_table, wr_id, ms_datetime, ms_memo, wr_mb_id, wr_subject )
         values ( '$member[mb_id]', '$bo_table', '$wr_id', '$g4[time_ymdhis]', '$wr_content', '$wr_mb_id', '$wr_subject' ) ";
sql_query($sql);

echo <<<HEREDOC
<script language="JavaScript">
    if (confirm("이 글을 스크랩 하였습니다.\\n\\n지금 스크랩을 확인하시겠습니까?")) 
        document.location.href = "./scrap.php";
    else
        window.close();
</script>
HEREDOC;
?>
