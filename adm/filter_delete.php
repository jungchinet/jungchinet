<?
$sub_menu = "200710";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

$act = strip_tags($_POST['act']);

if ($act == "delete") {
    for ($i=0; $i<count($chk); $i++) 
    {
        // 실제 번호를 넘김
        $k = $_POST[chk][$i];

        // 필터를 지우고
        $sql = " delete from $g4[filter_table] where pp_id = '$k' ";
        sql_query($sql);
        // 지워진 필터의 sum을 지우고
        $pp = sql_fetch(" select pp_word from $g4[filter_table] where pp_id = '$k' ");
        $sql = " update $g4[popular_sum_table] set pp_level=1 where pp_word = '$pp[pp_word]' ";
        sql_query($sql);
    }
} else if ($act == "insert") {
        // 새로운 필터를 삽입
        $pp_word = strip_tags($pp_word);
        $pp_level = (int) $pp_level;

        $sql = " insert into $g4[filter_table] set pp_word='$pp_word', pp_level='$pp_level', pp_datetime='$g4[time_ymdhis]' ";
        sql_query($sql);

        $sql = " update $g4[popular_sum_table] set pp_level='$pp_level' where pp_word='$pp_word' ";
        sql_query($sql);
}

goto_url("./filter_list.php?$qstr");
?>
