<?
include_once("./_common.php");

$g4[title] = "레벨업";
include_once("./_head.php");

// 레벨업 관련 정보를 읽어 옵니다.
$sql = " select * from $g4[member_level_table] where member_level >= 2 and use_levelup = 1 order by member_level asc";
$result = sql_query($sql);
?>

<style>
.line1 { background-color:#CCCCCC; height:2px; }
.line2 { background-color:#CCCCCC; height:1px; }
</style>

<form name=fmember_level method=post>
<table width=100% cellpadding=0 cellspacing=0>
    <colgroup width=100px>
    <colgroup width=''>
  	<tr><td colspan='2' class='line2'></td></tr>
    <th  colspan=2 align=left height=40px>회원 레벨업 모니터</th>
  	<tr><td colspan='2' class='line2'></td></tr>
    <tr><td colspan=2 height=30px>
        현재의 회원레벨 : <?=$member[mb_level]?>
    </td></tr>
  	<tr><td colspan='2' class='line2'></td></tr>
    <?
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $from_level = $row[member_level];
        $to_level = $row[member_level] + 1;
        echo "<tr height=30px align=center><td>";
        echo $from_level;
        echo "→";
        echo $to_level;
        echo "</td><td align=left>";
        if ($member[mb_level] > $row[member_level]) {
            $sql = " select * from $g4[member_level_history_table] where mb_id='$member[mb_id]' and from_level='$from_level' and to_level='$to_level'";
            $ml = sql_fetch($sql);
            if ($ml[level_datetime])
                echo $ml[level_datetime] . " 에 ";
            echo "레벨업 되었습니다.";
        }
        else {
            $sql = " select count(*) from $g4[board_new_table] where mb_id = '$member[mb_id]' and wr_id = wr_parent ";
            $wr_cnt = implode(sql_fetch($sql));
            $wr_diff = $row[up_post] - $wr_cnt;

            $sql = " select count(*) from $g4[board_new_table] where mb_id = '$member[mb_id]' ";
            $wr_total_cnt = implode(sql_fetch($sql));
            $wr_total_diff = $row[up_post_all] - $wr_total_cnt;

            $point_diff = $row[up_point] - $member[mb_point];
            if ($point_diff < 0)
                $point_diff = 0;

            $sql = " select TO_DAYS(now()) - TO_DAYS('$member[mb_level_datetime]') as days_diff";
            $days = implode(sql_fetch($sql));
            $days_diff = $row[up_days] - $days;
            
            echo " 아래의 조건이 모두 만족되면, 자동으로 레벨업 됩니다.";
            echo "<table align=left border=1px width=100%><tr align=center><td>";
            if ($row[up_days] > 0)
                echo "<tr><td width=130px>회원레벨 경과일수</td><td width=70px>$row[up_days] 일</td><td>레벨 경과일수 $days 일</td><td>$days_diff 일 남았습니다</td></tr>";
            if ($row[up_point] > 0)
                echo "<tr><td>레벨업 포인트</td><td>$row[up_point]</td><td>$member[mb_point] 포인트</td><td>$point_diff 포인트를 더 얻으면 됩니다</td></tr>";
            if ($row[up_post] > 0)
                echo "<tr><td>게시글수</td><td>$row[up_post]</td><td>$wr_cnt 의 게시글 작성</td><td>$wr_diff 개의 글을 더 작성해 주세요</td></tr>";
            if ($row[up_post_all] > 0)
                echo "<tr><td>전체글수(코멘트포함)</td><td>$row[up_post_all]</td><td>$wr_total_cnt 의 게시글 작성</td><td>$wr_total_diff 개의 글을 더 작성해주세요</td></tr>";
            echo "</table>";
        }
        echo "</td></tr>";
        echo "<tr><td colspan='2' class='line2'></td></tr>";
    }
    ?>
</table>
</form>

<?
include_once("./_tail.php");
?>
