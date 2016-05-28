<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 남성/여성이 bo_sex 필드에 M/F로 등록된 경우에만 게시판을 접근을 허용
check_bo_sex();

// 일별 글쓰기 제한 - a일동안 b회 이상 글쓰기를 금지합니다. a,b|c,d 와 같이 입력해주세요
$bo_day_nowrite = $board[bo_day_nowrite];

if ($w=="" && !$is_admin && $bo_day_nowrite) {

     // 게시판 테이블 전체이름
    $tmp_write_table = $g4['write_prefix'] . $bo_table;

    // 사용자 아이디
    $mb_id = $member[mb_id];

    // $bo_day_nowrite를 explode 합니다.
    $day_array = explode("|", trim($bo_day_nowrite));
    foreach ($day_array as $key => $val) {
        $res = explode(",", trim($val));
        if ($res) {
            $day2_days[$res[0]] = $res[0];
            $day2_count[$res[1]] = $res[1];
        }
    }

    // 배열을 정렬하기 (days 값 기준으로)
    array_multisort($day2_days, $day2_count);

    // 입력된 배열의 갯수
    $day_array_count = count($day2_count);

    // 최대날짜
    $max_days = $day2_days[$day_array_count-1];

    // sort되면서 흐트러진 key 값을 다시 지정해주기
    for ($i=0; $i < $day_array_count; $i++) {
        $day2_days2[$day2_days[$i]] = $day2_days[$i];
        $day2_count2[$day2_days[$i]] = $day2_count[$i];
    }

    // 글쓰기 제한에 걸리는지 확인해 봅니다.
    $sql = " SELECT to_days(now())-to_days(wr_datetime) AS t_diff, count( * ) AS cnt, date_format( wr_datetime, '%Y-%m-%d' ) 
               FROM `$tmp_write_table` 
              WHERE mb_id = '$mb_id' 
                AND wr_is_comment = '0'
                AND wr_reply = ''
                AND (to_days(now())-to_days(wr_datetime)-$max_days) < 0
              GROUP BY t_diff
          ";
    $result = sql_query($sql);

    if ($result && mysql_num_rows($result)) {
        // 결과값을 배열에 넣습니다
        for($i=0; $row = sql_fetch_array($result); $i++) {
            $day_result[$row[t_diff]] = $row[cnt];
        }
    
        // 조건을 충족하는지 check
        $sum = 0;
        for($i=0; $i <= $max_days; $i++) {
            $sum += $day_result[$i];
            if ($day2_days2[$i] && $day2_count2[$i] && $sum >= $day2_count2[$i]) {
                alert("{$i}일에 $day2_count2[$i]개 이상의 글을 작성할 수 없습니다. 운영자에게 문의 하시기 바랍니다.");
            }
        }
    }
}
?>
