<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// wr_1 : 경매시작일시
// wr_2 : 경매종료일시
// wr_3 : 참여 포인트
// wr_4 : 입찰 최소 포인트
// wr_5 : 입찰 최고 포인트
// wr_6 : 하루 참여 횟수 
// wr_7 : 입찰수
// wr_8 : 경매상태 (0: 경매전, 1:진행중, 2:낙찰, 3:유찰)
// wr_9 : 낙찰 포인트
// wr_10 : 낙찰회원아이디

$tender_table = "{$write_table}_tender";

if (!$board[bo_1]) 
{
    $sql = " update $g4[board_table] set ";
    $sql.= "  bo_1_subj = '참여 포인트 기본값' ";
    $sql.= " ,bo_2_subj = '입찰 최소 포인트 기본값' ";
    $sql.= " ,bo_3_subj = '입찰 최대 포인트 기본값' ";
    $sql.= " ,bo_4_subj = '하루 참여 횟수 기본값' ";
    $sql.= " where bo_table = '$bo_table' ";
    sql_query($sql, false);

    $sql = " update $g4[board_table] set ";
    $sql.= "  bo_1 = '500' ";
    $sql.= " ,bo_2 = '1' ";
    $sql.= " ,bo_3 = '10000' ";
    $sql.= " ,bo_4 = '3' ";
    $sql.= " where bo_table = '$bo_table' ";
    sql_query($sql, false);
}

$sql = " create table $tender_table ( ";
$sql.= " `td_id` INT NOT NULL AUTO_INCREMENT ,";
$sql.= " `wr_id` INT NOT NULL ,";
$sql.= " `mb_id` VARCHAR( 30 ) NOT NULL ,";
$sql.= " `mb_name` VARCHAR( 255 ) NOT NULL ,";
$sql.= " `mb_nick` VARCHAR( 255 ) NOT NULL ,";
$sql.= " `mb_email` VARCHAR( 255 ) NOT NULL ,";
$sql.= " `mb_homepage` VARCHAR( 255 ) NOT NULL ,";
$sql.= " `td_inter_point` INT NOT NULL ,";
$sql.= " `td_tender_point` INT NOT NULL ,";
$sql.= " `td_status` CHAR( 1 ) NOT NULL ,";
$sql.= " `td_last` DATETIME NOT NULL ,";
$sql.= " `td_datetime` DATETIME NOT NULL ,";
$sql.= " PRIMARY KEY ( `td_id` ) ,";
$sql.= " INDEX ( `wr_id` ) ";
$sql.= " ); ";
sql_query($sql, false);

// 경매 상태 출력
function auction_status($status)
{
    switch ($status)
    {
        case "0": $status = "경매전"; break;
        case "1": $status = "진행중"; break;
        case "2": $status = "낙찰"; break;
        case "3": $status = "유찰"; break;
    }
    return $status;
}

// 경매정보(추가필드)를 가져온다.
function get_info_auction($wr_id, $row=null)
{
    global $write, $write_table;

    if (!$row && !$write) {
        $row = sql_fetch(" select wr_subject, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 from $write_table where wr_id = '$wr_id' ");
    } elseif ($write) {
        $row = $write;
    }

    $pd = explode("|", $row[wr_subject]);

    unset($res);
    $res[company] = trim($pd[0]);
    $res[product] = trim($pd[1]);
    $res[start_datetime] = $row[wr_1];
    $res[end_datetime] = $row[wr_2];
    $res[inter_point] = $row[wr_3];
    $res[tender_lower] = $row[wr_4];
    $res[tender_higher] = $row[wr_5];
    $res[day_limit] = $row[wr_6];
    $res[tender_count] = $row[wr_7];
    $res[status] = $row[wr_8];
    $res[td_id] = $row[wr_9];
    $res[mb_id] = $row[wr_10];

    return $res;
}

// 경매 입찰 진행
function tender_send($wr_id, $point)
{
    global $g4, $board, $member, $tender_table, $write_table, $write, $bo_table;

    if (!$member[mb_id])
        alert_only("로그인 해주세요.");

    if ($board[bo_5] > 0 && (($g4[server_time] - strtotime($member[mb_datetime])) < ($board[bo_5]*86400)))
        alert_only("회원가입 후 $board[bo_5] 일이 지나야 참여 가능합니다.");

    $auction = get_info_auction($wr_id);

    if ($g4[time_ymdhis] < $auction[start_datetime])
        alert_only("경매 시작 전입니다.");

    if ($g4[time_ymdhis] > $auction[end_datetime]) 
        alert_only("경매가 종료되었습니다.");

    $row2 = sql_fetch(" select count(mb_id) as cnt from $tender_table where td_datetime like '$g4[time_ymd]%' and mb_id = '$member[mb_id]' and wr_id = '$wr_id' ");
    $tender_count = $row2[cnt];

    if ($tender_count >= $auction[day_limit])
        alert_only("하루에 $auction[day_limit] 번 참여 가능합니다.");

    if ($point < $auction[tender_lower] || $point > $auction[tender_higher])
        alert_only("입찰 포인트는 ".number_format($auction[tender_lower])."~".number_format($auction[tender_higher])." 사이로 설정해주세요.");

    $total_point = (int)$auction[inter_point] + (int)$point;

    if ($member[mb_point] - $total_point < 0)
        alert_only("가지고 계신 포인트(".number_format($member[mb_point]).") 가 참여 포인트+입찰 포인트(".number_format($total_point).") 보다 부족합니다.");

    $row = sql_fetch(" select * from $tender_table where wr_id = '$wr_id' and mb_id = '$member[mb_id]' and td_tender_point = '$point' ");
    if ($row)
        alert_only("이미 같은 포인트로 입찰 하셨습니다.");

    //////////////////////////////////////////////////////////////////////
    // 연속번호 불가 
    //////////////////////////////////////////////////////////////////////
    /*
    $series = 4;
    $half = floor($series/2);
    $msg = "연속된 번호로 ".($series-1)."번 이상 입찰하실 수 없습니다.";

    // 아래로 
    $row = sql_fetch(" select count(*) as cnt from {$tender_table} where wr_id = '$wr_id' and mb_id = '$member[mb_id]' and td_tender_point < {$point} and td_tender_point > {$point}-{$series} ");
    if ($row[cnt] >= $series-1)
        alert_only($msg);

    // 위로
    $row = sql_fetch(" select count(*) as cnt from {$tender_table} where wr_id = '$wr_id' and mb_id = '$member[mb_id]' and td_tender_point > {$point} and td_tender_point < {$point}+{$series} ");
    if ($row[cnt] >= $series-1)
        alert_only($msg);

    // 사이에
    $row = sql_fetch(" select count(*) as cnt from {$tender_table} where wr_id = '$wr_id' and mb_id = '$member[mb_id]' and td_tender_point >= {$point}-{$half} and td_tender_point <= {$point}+{$half} ");
    if ($row[cnt] >= $series+1)
        alert_only($msg);
    */

    //////////////////////////////////////////////////////////////////////
    // 범위 입찰 제한 
    //////////////////////////////////////////////////////////////////////
    $sec = 10; // 범위 10개
    $cnt = 5; // 허용갯수 5개

    if ($point % $sec)
        $tmp = $point;
    else
        $tmp = $point - 1;

    $min = floor($tmp/$sec) * $sec + 1;
    $max = ceil(($tmp/$sec)) * $sec;

    $row = sql_fetch(" select count(*) as cnt from {$tender_table} where wr_id = '$wr_id' and mb_id = '$member[mb_id]' and td_tender_point >= {$min} and td_tender_point <= {$max} ");
    if ($row[cnt] >= $cnt)
        alert_only("이미 $min 과 $max 사이에 $cnt 번 입찰하셨습니다.");
    //////////////////////////////////////////////////////////////////////

    $sql = "insert into {$tender_table} set ";
    $sql.= " wr_id = '$wr_id' ";
    $sql.= ",mb_id = '$member[mb_id]' ";
    $sql.= ",mb_name = '$member[mb_name]' ";
    $sql.= ",mb_nick = '$member[mb_nick]' ";
    $sql.= ",mb_email = '$member[mb_email]' ";
    $sql.= ",mb_homepage = '$member[mb_homepage]' ";
    $sql.= ",td_inter_point = '$auction[inter_point]' ";
    $sql.= ",td_tender_point = '$point' ";
    $sql.= ",td_status = '1' ";
    $sql.= ",td_last = '$g4[time_ymdhis]' ";
    $sql.= ",td_datetime = '$g4[time_ymdhis]' ";
    sql_query($sql);

    sql_query(" update $write_table set wr_7 = wr_7 + 1 where wr_id = '$wr_id' ");

    if ($auction[inter_point])
        insert_point($member[mb_id], $auction[inter_point]*-1, "$wr_id 경매 참여", $bo_table, $wr_id, "참여 : $g4[time_ymdhis]");

    if ($point)
        insert_point($member[mb_id], $point*-1, "$wr_id 경매 입찰", $bo_table, $wr_id, "입찰 : $g4[time_ymdhis]");
}

// 경매의 낙찰 여부 검사 및 업데이트
function auction_successful($wr_id)
{
    global $g4, $write_table, $tender_table, $auction, $write, $bo_table;

    if (!$auction)
        $auction = get_info_auction($wr_id);

    // 경매상태 조회 - 이미 종료되었으면 return
    if ($auction[status] > 1) return false;

    // 경매가 시작전이면 return
    if ($auction[start_datetime] > $g4[time_ymdhis]) return false;

    // 경매날짜를 비교하여 진행중일경우 return
    if ($auction[start_datetime] < $g4[time_ymdhis] && $auction[end_datetime] > $g4[time_ymdhis]) return false;

    // 최저로 입찰된 내역을 조회
    $row = sql_fetch(" select td_tender_point as point, count(td_tender_point) as cnt from $tender_table where wr_id = '$wr_id' group by td_tender_point order by cnt, td_tender_point limit 1 ");

    // 중복되었거나 입찰내역이 없을 경우 유찰
    if ($row[cnt] > 1 || !$row)
    {
        sql_query(" update $write_table set wr_8 = '3' where wr_id = '$wr_id' ");

        $qry = sql_query(" select * from $tender_table where wr_id = '$wr_id' ");
        while ($row = sql_fetch_array($qry))
        {
            insert_point($row[mb_id], $row[td_tender_point], "$wr_id 경매 유찰, 입찰 포인트 환급", $bo_table, $wr_id, "입찰 $row[td_tender_point] 포인트 환급");
        }

        $res = sql_fetch(" select wr_7, wr_8, wr_9, wr_10 from $write_table where wr_id = '$wr_id' ");
        return $res;
    }
    else
    {
        // 낙찰된 입찰정보 가져오기
        $row = sql_fetch(" select * from $tender_table where td_tender_point = '$row[point]' and wr_id = '$wr_id' ");
        sql_query(" update $write_table set wr_8 = '2', wr_9 = '$row[td_tender_point]', wr_10 = '$row[mb_id]' where wr_id = '$wr_id' ");

        $qry = sql_query(" select * from $tender_table where td_tender_point <> '$row[td_tender_point]' and wr_id = '$wr_id' ");
        while ($row = sql_fetch_array($qry))
        {
            insert_point($row[mb_id], $row[td_tender_point], "$wr_id 경매 낙찰안됨, 입찰 포인트 환급", $bo_table, $wr_id, "입찰 $row[td_tender_point] 포인트 환급");
        }

        $res = sql_fetch(" select wr_7, wr_8, wr_9, wr_10 from $write_table where wr_id = '$wr_id' ");
        return $res;
    }
}
?>
