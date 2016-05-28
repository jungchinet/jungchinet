<?
$sub_menu = "300830";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

//print_r2($_POST);

for ($i=0; $i<count($chk); $i++) {
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    // 임시저장 자료를 삭제
    $sql = " delete from $g4[tempsave_table] where tmp_id = '$tmp_id[$k]' ";
    sql_query($sql);

}

goto_url("tempsave_list.php?$qstr");
?>
