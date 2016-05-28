<? 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($w == "") {

    // 포인트제약
    if ($bo_table == "2showup_ship") {
        $wr_point = 1000;
        $wr_days = 999999;
    } else {
        $wr_point = 5000;
        $wr_days = 30;
    }

    if (!$is_admin && $wr_point > $member[mb_point])
        alert("이 게시판은 $wr_point 포인트 이상의 회원만 글쓰기가 가능 합니다.\\n\\n");

    // 글쓰기 일수 제약
    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $sql = " select count(*) as cnt from $tmp_write_table where mb_id = '$member[mb_id]' and wr_datetime >= date_sub(now(), interval $wr_days day) ";
    $result = sql_fetch($sql);
    if (!$is_admin && $result[cnt] > 0)
        alert("이 게시판은 글작성 후 $wr_days 일이 경과한 후에 글쓰기가 가능 합니다.\\n\\n");
}
?>
