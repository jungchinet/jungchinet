<?
if (!defined('_GNUBOARD_')) exit;

// 인기검색어 출력
// $skin_dir : 스킨 디렉토리
// $pop_cnt : 검색어 몇개
// $date_cnt : 몇일 동안
// $bo_table : 어느게시판
function popular($skin_dir='basic', $pop_cnt=7, $date_cnt=3, $bo_table='')
{
    global $config, $g4, $member;

    if (!$skin_dir) $skin_dir = 'basic';

    if ($bo_table) $bo_sql = " and bo_table = '$bo_table' ";

    // 불당팩 - 인기검색어 보는 레벨을 지정
    if (!$member)
        $pp_level = 1;
    else
        $pp_level = $member[mb_level];

    $date_gap = date("Y-m-d", $g4[server_time] - ($date_cnt * 86400));
    $sql = " select pp_word, sum(pp_count) as cnt from $g4[popular_sum_table]
              where pp_date between '$date_gap' and '$g4[time_ymd]' and pp_level <= '$pp_level'
              $bo_sql and mb_info = '0'
              group by pp_word
              order by cnt desc, pp_word
              limit 0, $pop_cnt ";
    $result = sql_query($sql);

    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        $list[$i] = $row;
        // 스크립트등의 실행금지
        $list[$i][pp_word] = get_text($list[$i][pp_word]);
    }

    ob_start();
    $popular_skin_path = "$g4[path]/skin/popular/$skin_dir";
    include ("$popular_skin_path/popular.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 인기게시판 추출
function board_popular($skin_dir="", $gr_id="", $days=7, $rows=10, $subject_len=40, $options="")
{
    global $g4, $mw;

    if ($skin_dir)
        $popular_skin_path = "$g4[path]/skin/popular/$skin_dir";
    else
        $popular_skin_path = "$g4[path]/skin/popular/basic";

    $list = array();

    if ($gr_id)
        $gr_id = " and gr_id='$gr_id' ";
    else
        $gr_id = "";

    $sql = " select sum(bv_count) as bv_sum, bo_table, gr_id 
                from $mw[board_visit_table] 
                where bv_date >= DATE_SUB('$g4[time_ymd]', INTERVAL $days day) $sql_gr 
                group by bo_table order by bv_sum desc limit 0, $rows ";
    $result = sql_query($sql);

    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $list[$i] = $row;

        $bo = get_board($row[bo_table], "bo_subject, bo_count_write, bo_count_comment");
        $gr = get_group($row[gr_id], "gr_subject");

        $list[$i][bo_subject] = $bo[bo_subject];
        $list[$i][subject] = cut_str($bo[bo_subject], $subject_len);
        $list[$i][bo_count_write] = $bo[bo_count_write];
        $list[$i][bo_count_comment] = $bo[bo_count_comment];
        $list[$i][gr_subject] = $gr[gr_subject];
    }

    ob_start();
    include "$popular_skin_path/popular.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
