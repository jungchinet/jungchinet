<?
$sub_menu = "200300";
include_once("./_common.php");

if ($w == 'u' || $w == 'd')
    check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

if ($w == "") 
{
    $sql = " insert $g4[mail_table]
                set ma_id      = '$_POST[ma_id]',
                    ma_subject = '$_POST[ma_subject]',
                    ma_content = '$_POST[ma_content]',
                    ma_time    = '$g4[time_ymdhis]',
                    ma_ip      = '$remote_addr' ";
    sql_query($sql);
} 
else if ($w == "u") 
{
    $sql = " update $g4[mail_table]
                set ma_subject = '$_POST[ma_subject]',
                    ma_content = '$_POST[ma_content]',
                    ma_time    = '$g4[time_ymdhis]',
                    ma_ip      = '$remote_addr'
              where ma_id      = '$_POST[ma_id]' ";
    sql_query($sql);
}
else if ($w == "d") 
{
	$sql = " delete from $g4[mail_table] where ma_id = '$_POST[ma_id]' ";
    sql_query($sql);
}

goto_url("./mail_list.php");
?>
