<?
$sub_menu = "300500";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

$g4[board_file_download_table] = $g4[board_file_table] . "_download";

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    // 다운로드 내역 테이블에서 삭제
    $sql = " delete from $g4[board_file_download_table] where dn_id = '{$_POST['dn_id'][$k]}' ";
    sql_query($sql);

    // 다운로드 테이블에서 다운로드 횟수를 하나 차감
    $sql= " update $g4[board_file_table] set bf_download = bf_download - 1 where bo_table = '{$_POST['bo_table_list'][$k]}' and wr_id = '{$_POST['wr_id'][$k]}'";
    sql_query($sql, false);
}

goto_url("./download_list.php?$qstr");
?>
