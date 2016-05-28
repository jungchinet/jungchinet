# 쪽지 5 설치 파일

# 메모2
DROP TABLE IF EXISTS `$g4[memo_group_table]`;
CREATE TABLE `$g4[memo_group_table]` (
  `gr_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL,
  `gr_name` varchar(255) NOT NULL,
  `gr_datetime` datetime NOT NULL,
  PRIMARY KEY (`gr_id`)
);

DROP TABLE IF EXISTS `$g4[memo_group_member_table]`;
CREATE TABLE `$g4[memo_group_member_table]` (
 `gr_mb_no` int(11) NOT NULL AUTO_INCREMENT,
  `gr_id` int(11) NOT NULL,
  `gr_mb_id` varchar(255) NOT NULL,
  `gr_mb_datetime` datetime NOT NULL,
  PRIMARY KEY (`gr_mb_no`)
);

# 쪽지2 - 공지테이블
DROP TABLE IF EXISTS `$g4[memo_notice_table]`;
CREATE TABLE `$g4[memo_notice_table]` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`)
);

# 쪽지2 - 수신테이블
DROP TABLE IF EXISTS `$g4[memo_recv_table]`;
CREATE TABLE `$g4[memo_recv_table]` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  PRIMARY KEY (`me_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `memo_owner` (`memo_owner`),
  KEY `me_file_local` (`me_file_local`)
);

# 쪽지2 - 저장테이블
DROP TABLE IF EXISTS `$g4[memo_save_table]`;
CREATE TABLE `$g4[memo_save_table]` (
  `me_id` int(11) NOT NULL,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  PRIMARY KEY (`me_id`,`memo_type`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `memo_owner` (`memo_owner`)
);

# 쪽지2 - 발신테이블
DROP TABLE IF EXISTS `$g4[memo_send_table]`;
CREATE TABLE `$g4[memo_send_table]` (
  `me_id` int(11) NOT NULL,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `memo_owner` (`memo_owner`),
  KEY `me_file_local` (`me_file_local`)
);

# 쪽지2 - 스팸테이블
DROP TABLE IF EXISTS `$g4[memo_spam_table]`;
CREATE TABLE `$g4[memo_spam_table]` (
  `me_id` int(11) NOT NULL,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `memo_owner` (`memo_owner`)
);

# 쪽지2 - 친구테이블
DROP TABLE IF EXISTS `$g4[friend_table]`;
CREATE TABLE `$g4[friend_table]` (
  `fr_no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `fr_id` varchar(20) NOT NULL,
  `fr_memo` varchar(255) DEFAULT NULL,
  `fr_type` varchar(20) NOT NULL,
  `fr_datetime` datetime NOT NULL,
  PRIMARY KEY (`fr_no`),
  UNIQUE KEY `mb_id` (`mb_id`,`fr_id`),
  KEY `fr_relation` (`fr_type`)
);

# 쪽지4 - 신규테이블 (휴지통)
DROP TABLE IF EXISTS `$g4[memo_trash_table]`;
CREATE TABLE `$g4[memo_trash_table]` (
  `me_id` int(11) NOT NULL,
  `me_recv_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(255) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` mediumtext NOT NULL,
  `me_file_local` varchar(255) NOT NULL,
  `me_file_server` varchar(255) NOT NULL,
  `me_subject` varchar(255) NOT NULL,
  `memo_type` varchar(255) NOT NULL,
  `memo_owner` varchar(255) NOT NULL,
  `me_option` set('html1','html2','secret','mail') NOT NULL,
  `me_from_kind` varchar(255) NOT NULL,
  PRIMARY KEY (`me_id`,`me_from_kind`),
  KEY `me_recv_mb_id_idx` (`me_recv_mb_id`),
  KEY `me_send_mb_id_idx` (`me_send_mb_id`),
  KEY `memo_owner` (`memo_owner`),
  KEY `me_file_local` (`me_file_local`)
);

# 쪽지4 - 신규 테이블 (설정)
DROP TABLE IF EXISTS `$g4[memo_config_table]`;
CREATE TABLE `$g4[memo_config_table]` (
  `cf_memo_page_rows` int(11) NOT NULL,
  `cf_memo_del_unread` int(11) NOT NULL DEFAULT '180',
  `cf_memo_del_trash` int(11) NOT NULL DEFAULT '7',
  `cf_memo_delete_datetime` datetime NOT NULL,
  `cf_memo_user_dhtml` tinyint(4) NOT NULL DEFAULT '1',
  `cf_memo_use_file` tinyint(4) NOT NULL DEFAULT '0',
  `cf_memo_file_size` tinyint(4) DEFAULT NULL,
  `cf_max_memo_file_size` int(11) DEFAULT NULL,
  `cf_friend_management` tinyint(4) NOT NULL DEFAULT '1',
  `cf_memo_no_reply` tinyint(4) NOT NULL DEFAULT '0',
  `cf_memo_notice_board` varchar(255) DEFAULT NULL,
  `cf_memo_notice_memo` mediumtext,
  `cf_memo_before_after` tinyint(4) NOT NULL,
  `cf_memo_print` tinyint(4) NOT NULL,
  `cf_memo_b4_resize` tinyint(4) NOT NULL,
  `cf_memo_realtime` tinyint(4) NOT NULL,
  `cf_memo_mb_name` tinyint(4) NOT NULL,
  `cf_memo_del_file` tinyint(4) NOT NULL
) ;

# 실시간 메모
ALTER TABLE `$g4[member_table]` ADD `mb_realmemo` TINYINT( 4 ) NOT NULL , ADD `mb_realmemo_sound` TINYINT( 4 ) NOT NULL ;

# 메모 call
ALTER TABLE `$g4[member_table]` CHANGE `mb_memo_call` `mb_memo_call` TEXT NOT NULL ;

# 쪽지4 자동응답기능
ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply` TINYINT( 4 ) NOT NULL ;
ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply_text` text NOT NULL ;

# 안읽은 쪽지갯수 추가
ALTER TABLE `$g4[member_table]` ADD `mb_memo_unread` INT( 11 ) NOT NULL ;

# 5.0.0 - 안읽은 쪽지날짜 추가
ALTER TABLE `$g4[member_table]` ADD `mb_memo_call_datetime` DATETIME NOT NULL ;
