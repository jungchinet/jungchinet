<?
$sub_menu = "300700";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

$msg = "";
for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];
    $rc_no = $_POST['rc_no'][$k];
    $sql = " update $g4[recycle_table] set rc_delete='1' where rc_no = '$rc_no' ";
    sql_query($sql);
}

goto_url("./recycle_list.php?$qstr");
?>
