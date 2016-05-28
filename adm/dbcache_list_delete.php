<?
$sub_menu = "300150";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    $sql = " delete from $g4[cache_table] where c_id = '{$_POST['c_id'][$k]}' ";
    sql_query($sql);
}

goto_url("./dbcache_list.php?$qstr");
?>
