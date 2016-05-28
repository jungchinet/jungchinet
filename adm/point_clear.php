<?
$sub_menu = "200200";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if (!$ok)
    alert();

if ($is_admin != "super")
    alert("포인트 정리는 최고관리자만 가능합니다.");

$g4[title] = "포인트 정리";
include_once("./admin.head.php");

echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

echo "<script>document.getElementById('ct').innerHTML += '<p>포인트 정리중...';</script>\n";
flush();

// 포인트가 30개 이상인 회원에 대해서만 point를 clear 합니다.
$max_count = 30;
// 현재부터 30일 이전의 포인트에 대해서만 point를 clear 합니다.
$clear_days = 30;
$clear_datetime = date("Y-m-d H:i:s", $g4[server_time] - (86400 * $clear_days));
// 한번에 정리할 회원의 숫자
$max_mb_num = 1000;

// 백업테이블을 만들고
$sql = "
CREATE TABLE `$g4[point_table]_backup` (
  `po_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL default '',
  `po_point` int(11) NOT NULL default '0',
  `po_rel_table` varchar(20) NOT NULL default '',
  `po_rel_id` varchar(20) NOT NULL default '',
  `po_rel_action` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`)
) ";
sql_query($sql, false);

// 30일 이전의 포인트까지만 정리하기 때문에 lock을 걸지 않아도 됩니다.
// 테이블 락을 걸고 
//$sql = " LOCK TABLES $g4[member_table] WRITE, $g4[point_table] WRITE ";
//sql_query($sql);

// 정리할 회원목록을 만들고 (정리할 껀수가 많은 회원부터 정리를 하도록 정렬)
$sql = " SELECT mb_id, count(po_point) as cnt, sum(po_point) as po_sum
           FROM $g4[point_table] 
          WHERE po_datetime < '{$clear_datetime}'
          GROUP BY mb_id
         HAVING cnt > {$max_count}+1
          ORDER BY cnt desc ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // 천명이 되면 break;
    if ($i >= $max_mb_num) 
        break;

    // 처리할 건수는 기준일자 이후의 모든 건수에서 $max-count를 뺀 것
    $count = $row['cnt'] - $max_count;

    // 합계는 전체건수에 대한 것이므로 $max_count에 대한 합계는 별도로 빼야 합니다.
    // select sum(po_point) ... limit 1, 30의 의미는 
    // select 된 결과 값의 return이지 select 자체의 limit가 아니기 때문이죠(어렵나요? ㅋㅋ)
    $total = $row['po_sum'];
    
    $sql2 = " select po_id, po_point
                from $g4[point_table] 
               where mb_id = '$row[mb_id]' and po_datetime < '{$clear_datetime}'
               order by po_id desc 
               limit 1, $max_count ";
    $result2 = sql_query($sql2);
    $max_sum = 0;
    for ($k=0; $row2=sql_fetch_array($result2); $k++)
    {
        $max_sum += $row2['po_point'];
    }
    $total = $total - $max_sum;
    
    $sql3 = " INSERT INTO $g4[point_table]_backup 
              SELECT * FROM $g4[point_table] WHERE mb_id = '$row[mb_id]' and po_datetime < '{$clear_datetime}'
               order by po_id desc 
               limit $max_count, $row[cnt] ";
    $result3 = sql_query($sql3, false);
    
    $sql4 = " DELETE FROM $g4[point_table] 
               WHERE mb_id = '$row[mb_id]' and po_datetime < '{$clear_datetime}'
               order by po_id asc 
               limit $count";
    $result4 = sql_query($sql4);
    
    insert_point($row[mb_id], $total, "{$clear_datetime} 시점까지의 포인트 {$count}건 정리", "@clear", $row[mb_id], $g4[time_ymd]."-".uniqid(""));

    $str = $row[mb_id]."님 포인트 내역 ".number_format($count)."건 ".number_format($total)."점 정리<br>";
    echo "<script>document.getElementById('ct').innerHTML += '$str';</script>\n";
    flush();
}

// 테이블 락을 풀고
//$sql = " UNLOCK TABLES ";
//sql_query($sql);

echo "<script>document.getElementById('ct').innerHTML += '<p>총 ".$i."건의 회원포인트 내역이 정리 되었습니다.';</script>\n";
echo "<script>document.getElementById('ct').innerHTML += '<a href=\'" . $g4[admin_path] . "/point_list.php\'>포인트관리로 이동하기</a>'</script>\n";
?>
