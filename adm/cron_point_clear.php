#!/usr/local/php/bin/php
<?php
// 이 프로그램은 cron으로 포인트 정리를 하기 위한 샘플 프로그램 입니다.
// cron은 서버 관리자 또는 cron 작업이 허용된 사용자에게만 가능합니다.

// cron에서는 사용자의 프로그램 경로를 알 수 없기 때문에, $g4[path]를 반드시 절대 경로로 지정해줘야 합니다.
// 아래의 $g4[path]를 반드시 수정해서 사용하시기 바랍니다.
$g4[path] = "/home/opencode/public_html";

include_once("$g4[path]/lib/constant.php");
include_once("$g4[path]/config.php");
include_once("$g4[path]/lib/common.lib.php");

$dbconfig_file = "dbconfig.php";
include_once("$g4[path]/$dbconfig_file");
$connect_db = sql_connect($mysql_host, $mysql_user, $mysql_password);
$select_db = sql_select_db($mysql_db, $connect_db);
if (!$select_db)
    die("<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'><script language='JavaScript'> alert('DB 접속오류'); </script>");

// config 파일을 읽어줘야 합니다. common.php를 수행안하니까요
$config = " select * from $g4[config_file] ";

//-------------- 아랫부분은 point_clear.php에서 복사한 것 입니다 -----------------------

// 포인트가 n개 이상인 회원에 대해서만 point를 clear 합니다.
$max_count = 8;
// 현재부터 m일 이전의 포인트에 대해서만 point를 clear 합니다.
$clear_days = 30;
$clear_datetime = date("Y-m-d H:i:s", $g4[server_time] - (86400 * $clear_days));
// 한번에 정리할 회원의 숫자
$max_mb_num = 1000;

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
    //echo "<script>document.getElementById('ct').innerHTML += '$str';</script>\n";
    //flush();
    echo $str;
}

//---------------
?> 
