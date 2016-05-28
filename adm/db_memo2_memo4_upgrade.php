<?
$sub_menu = "100600";
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
include_once("./admin.head.php");


// 쪽지4 - 신규 테이블 (설정)
$sql = "
CREATE TABLE `$g4[memo_config_table]` (
  `cf_memo_page_rows` int(11) NOT NULL,
  `cf_memo_del_unread` int(11) NOT NULL default '180',
  `cf_memo_del_trash` int(11) NOT NULL default '7',
  `cf_memo_delete_datetime` datetime NOT NULL,
  `cf_memo_user_dhtml` tinyint(4) NOT NULL default '1',
  `cf_memo_use_file` tinyint(4) NOT NULL default '0',
  `cf_friend_management` tinyint(4) NOT NULL default '1',
  `cf_memo_notice_board` varchar(255) default NULL,
  `cf_memo_before_after` tinyint(4) NOT NULL,
  `cf_memo_notice_memo` text NOT NULL
) ";
sql_query($sql, FALSE);

//쪽지4- 신규 테이블 (임시저장)
$sql = "
CREATE TABLE `$g4[memo_temp_table]` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_recv_mb_id` varchar(255) NOT NULL default '',
  `me_send_mb_id` varchar(255) NOT NULL default '',
  `me_send_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  PRIMARY KEY  (`me_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `datetime` (`me_send_datetime`,`me_read_datetime`),
  KEY `memo_owner` (`memo_owner`),
  KEY `me_file_local` (`me_file_local`)
) ";
sql_query($sql, FALSE);

// 쪽지4 - 신규테이블 (휴지통)
$sql = "
CREATE TABLE `$g4[memo_trash_table]` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_recv_mb_id` varchar(255) NOT NULL default '',
  `me_send_mb_id` varchar(255) NOT NULL default '',
  `me_send_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  PRIMARY KEY  (`me_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `datetime` (`me_send_datetime`,`me_read_datetime`),
  KEY `memo_owner` (`memo_owner`),
  KEY `me_file_local` (`me_file_local`)
)";
sql_query($sql, FALSE);

// 쪽지4 - 옵션필드 추가
sql_query(" ALTER TABLE `$g4[memo_recv_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE);
sql_query(" ALTER TABLE `$g4[memo_send_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_save_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_temp_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_notice_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_spam_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_trash_table]` ADD `me_option` SET( 'html1', 'html2', 'secret', 'mail' ) NOT NULL", FALSE) ;

// 1.0.24 - 쪽지4 temp, trash 테이블 key 추가
sql_query(" ALTER TABLE `$g4[memo_temp_table]` ADD `me_from_kind` VARCHAR( 255 ) NOT NULL", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_trash_table]` ADD `me_from_kind` VARCHAR( 255 ) NOT NULL", FALSE) ;

sql_query(" ALTER TABLE `$g4[memo_temp_table]` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `me_from_kind` )", FALSE) ;
sql_query(" ALTER TABLE `$g4[memo_trash_table]` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `me_from_kind` )", FALSE) ;

// 1.0.26 - 쪽지4 설정추가 (실시간메모)
sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_realtime` TINYINT( 4 ) NOT NULL", FALSE)  ;

// 1.0.26 - 쪽지4 설정추가 (실명 사용)
sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_mb_name` TINYINT( 4 ) NOT NULL", FALSE)  ;

// 1.0.31 - 쪽지4 설정추가 (업로드 파일용량)
sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_file_size` VARCHAR( 20 ) NOT NULL ", FALSE) ;

// 1.0.32 - 쪽지4 save 오류 수정
sql_query(" ALTER TABLE `$g4[memo_save_table]` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `memo_type` ) ", FALSE) ;

// 설정값 옮기기
$sql = "
UPDATE `$g4[memo_config_table]` 
    set cf_memo_del_unread      = '$config[cf_memo_del_unread]',
        cf_memo_delete_datetime = '$config[cf_memo_delete_datetime]',
        cf_memo_del_unread      = '$config[cf_memo_del_unread]',
        cf_memo_user_dhtml      = '$config[cf_memo_user_dhtml]',
        cf_memo_use_file        = '$config[cf_memo_use_file]',
        cf_memo_page_rows       = '15',
        cf_memo_del_trash       = '90'
";        
sql_query($sql, FALSE);

// html code 설정하기
if ($config[cf_memo_user_dhtml]) {
    $html = "html1";
    sql_query(" UPDATE $g4[memo_recv_table] set me_option = '$html.$secret,$mail' ", FALSE);
    sql_query(" UPDATE $g4[memo_send_table] set me_option = '$html.$secret,$mail' ", FALSE);
    sql_query(" UPDATE $g4[memo_save_table] set me_option = '$html.$secret,$mail' ", FALSE);
    sql_query(" UPDATE $g4[memo_spam_table] set me_option = '$html.$secret,$mail' ", FALSE);
}

// config 테이블의 memo2 설정을 삭제 합니다.
$sql = "
ALTER TABLE `$g4[config_table]` DROP `cf_memo_delete_datetime` ,
                                DROP `cf_memo_del_unread` ,
                                DROP `cf_memo_use_file` ,
                                DROP `cf_memo_user_dhtml` ";
sql_query($sql, FALSE);



echo "UPGRADE 완료.";

include_once("./admin.tail.php");
?>
