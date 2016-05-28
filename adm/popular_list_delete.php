<?
$sub_menu = "200700";

include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    // 검색어 정보를 가져온다
    $pp = sql_fetch(" select * from $g4[popular_table] where pp_id = '{$_POST['pp_id'][$k]}' ");

    // 검색어 내역 테이블에서 삭제
    $sql = " delete from $g4[popular_table] where pp_id = '{$_POST['pp_id'][$k]}' ";
    sql_query($sql);
    
    // 검색어 sum 테이블에서 삭제
    $sql = " select pp_id, pp_count from $g4[popular_sum_table] where pp_word='$pp[pp_word]' and pp_date='$pp[pp_date]' and bo_table='$pp[bo_table]' ";
    $pp_sum = sql_fetch($sql);
    if ($pp_sum[pp_count] == 1)
        sql_query(" delete from $g4[popular_sum_table] where pp_id = '$pp_sum[pp_id]' ");
    else
        sql_query(" update $g4[popular_sum_table] set pp_count=pp_count-1 where pp_id = '$pp_sum[pp_id]'  ");
}

goto_url("./popular_list.php?$qstr");
?>
