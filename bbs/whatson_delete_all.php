<?
include_once("./_common.php");

$mb_id = $member[mb_id];

$head = (int) $_POST[head];
$check = (int) $_POST[check];
$rows = (int) $_POST[rows];

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];  

    $wo_id = $_POST['wo_id'][$k];

    $sql = " delete from $g4[whatson_table] where wo_id = '$wo_id' and mb_id = '$mb_id' ";
    sql_query($sql);
}

goto_url("./whatson.php?head=$head&check=$check&rows=$rows" . $qstr);
?>
