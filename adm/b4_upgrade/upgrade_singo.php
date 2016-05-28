<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

// 신고
$sql = "
CREATE TABLE IF NOT EXISTS `$g4[singo_table]` (
`sg_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`mb_id` varchar( 20 ) NOT NULL default '',
`bo_table` varchar( 20 ) NOT NULL default '',
`wr_id` int( 11 ) NOT NULL default '0',
`wr_parent` int( 11 ) NOT NULL default '0',
`sg_mb_id` varchar( 20 ) NOT NULL default '',
`sg_reason` varchar( 255 ) NOT NULL default '',
`sg_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
`sg_ip` varchar( 255 ) NOT NULL default '',
PRIMARY KEY ( `sg_id` ) ,
KEY `fk1` ( `bo_table` , `wr_id` ) ,
KEY `fk2` ( `bo_table` , `wr_parent` ) 
)
";
sql_query($sql, false);

// 신고 - 게시판에 신고 필드 추가
$sql = " select bo_table from $g4[board_table] ";
$res = sql_query($sql);
for($i=0;$row=sql_fetch_array($res);$i++) {
    sql_query(" ALTER TABLE `{$g4['write_prefix']}{$row[bo_table]}` ADD `wr_singo` TINYINT NOT NULL AFTER `wr_datetime` ", FALSE);
};

// 신고 - 게시판별 적용 설정하기
sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_singo` TINYINT NOT NULL ", FALSE);

// 신고처리 건수 설정하기
sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_singo_intercept_count` INT( 11 ) NOT NULL, ADD `cf_singo_point` INT( 11 ) NOT NULL , ADD `cf_singo_today_count` INT( 11 ) NOT NULL ", FALSE);

echo "<br>신고기능 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
