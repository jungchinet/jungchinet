<?
$sub_menu = "900250";
include_once("./_common.php");
include_once("$g4[admin_path]/admin.head.php");

auth_check($auth[$sub_menu], "r");

// 베타 0.1.1 (07.11.22)
sql_query("ALTER TABLE `$g4[sms4_book_table]` ADD `bk_memo` TEXT NOT NULL ;", false);

// 베타 0.0.9 (07.09.21)
sql_query("ALTER TABLE `$g4[sms4_form_table]` ADD `fg_member` CHAR( 1 ) NOT NULL DEFAULT '0' AFTER `fg_no`", false);
$qry = sql_query("select * from $g4[sms4_form_group_table]");
while ($row = sql_fetch_array($qry))
{
    sql_query("update $g4[sms4_form_table] set fg_member = '$row[fg_member]' where fg_no = '$row[fg_no]'", false);
}

// 베타 0.0.4 (07.07.01)
sql_query("ALTER TABLE `$g4[sms4_form_group_table]` ADD `fg_member` TINYINT NOT NULL", false);

// 베타 0.0.2 (07.06.29)
sql_query("ALTER TABLE `$g4[sms4_config_table]` DROP `test` ", false);

// 베타 0.0.2 (07.06.20)
sql_query("ALTER TABLE `$g4[sms4_config_table]` ADD `cf_member` tinyint(4) DEFAULT '1' NOT NULL ;", false);
sql_query("ALTER TABLE `$g4[sms4_config_table]` ADD `cf_level` tinyint(4) DEFAULT '2' NOT NULL ;", false);
sql_query("ALTER TABLE `$g4[sms4_config_table]` ADD `cf_point` int(11) DEFAULT '0' NOT NULL ;", false);
sql_query("ALTER TABLE `$g4[sms4_config_table]` ADD `cf_day_count` int(11) DEFAULT '0' NOT NULL ;", false);
sql_query("CREATE TABLE `$g4[sms4_member_history_table]` (   `mh_no` int(11) NOT NULL auto_increment,   `mb_id` varchar(30) NOT NULL,   `mh_reply` varchar(30) NOT NULL,   `mh_hp` varchar(30) NOT NULL,   `mh_datetime` datetime NOT NULL,   `mh_booking` datetime NOT NULL,   `mh_log` varchar(255) NOT NULL,   `mh_ip` varchar(15) NOT NULL,   PRIMARY KEY  (`mh_no`),   KEY `mb_id` (`mb_id`,`mh_datetime`) );", false);

echo "업그레이드가 완료되었습니다.";

include_once("$g4[admin_path]/admin.tail.php");
?>
