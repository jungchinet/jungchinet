<?
$sub_menu = "200710";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];
    $pp_level = $_POST[pp_level][$i];

    // 필터를 업데이트 하고
    $sql = " update $g4[filter_table] set pp_level='$pp_level' where pp_id = '$k' ";
    sql_query($sql);

    // 필터 sum의 레벨도 업데이트 하고
    $pp = sql_fetch(" select pp_word from $g4[filter_table] where pp_id = '$k' ");
    $sql = " update $g4[popular_sum_table] set pp_level='$pp_level' where pp_word = '$pp[pp_word]' ";
    sql_query($sql);
}

goto_url("./filter_list.php?$qstr");
?>
