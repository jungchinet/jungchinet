<?
include_once("./_common.php");

$html_title = "$group[gr_subject] > $board[bo_subject] > " . conv_subject($write[wr_subject], 255) . " > 링크";

// common.php에서 $bo_table을 안전하게 하는 코드
$bn_id = preg_match("/^[a-zA-Z0-9_]+$/", $bn_id) ? $bn_id : "";
if (!$bn_id)
    alert_close("링크값이 제대로 넘어오지 않았습니다.");

// SQL Injection 예방
$bn = sql_fetch(" select * from $g4[banner_table] where bn_id = '$bn_id' ");
if (!$bn['bn_id'] || !$bn['bn_url'])
    alert_close("존재하는 배너가 아닙니다.");

$ss_name = "ss_banner_click_{$bn_id}_{$bn[bg_id]}";
if (empty($_SESSION[$ss_name])) 
{
    $sql = " update $g4[banner_table] set bn_click = bn_click + 1 where bn_id = '$bn_id' ";
    sql_query($sql);

    $sql = "insert into $g4[banner_click_table] 
                    set bn_id = '$bn[bn_id]',
                        bg_id = '$bn[bg_id]',
                        bc_agent = '$useragent',
                        bc_datetime = '$g4[time_ymdhis]'
            ";
    $result = sql_query($sql);

    // 정상으로 INSERT 되었다면 배너클릭 합계에 반영
    if ($result) {
      
        // UPDATE를 먼저하고 오류가 발생시 insert를 실행 (엑스엠엘님)
        $sql = " update $g4[banner_click_sum_table] set bc_count = bc_count + 1 where bc_date = '$g4[time_ymd]' ";
        $result = sql_query($sql);

        if ( mysql_affected_rows() == 0 ) {
            $sql = " insert $g4[banner_click_sum_table] ( bc_count, bc_date) values ( 1, '$g4[time_ymd]' ) ";
            $result = sql_query($sql);
        }
    }
    set_session($ss_name, true);
}

if ($bn['target'])
    goto_url(set_http($bn['bn_url']));
else
    goto_url($bn['bn_url']);
?>
