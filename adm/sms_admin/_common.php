<?
$g4_path = "../.."; // common.php 의 상대 경로
include_once ("$g4_path/common.php");
include_once ("$g4[admin_path]/admin.lib.php");
include_once ("$g4[path]/lib/sms.lib.php");

if (!strstr($PHP_SELF, 'install.php')) {
    if(!mysql_num_rows(mysql_query("show tables like '$g4[sms4_config_table]'"))) 
        goto_url('install.php');

    // SMS 설정값 배열변수
    $sms4 = sql_fetch("select * from $g4[sms4_config_table] ");
}

?>
