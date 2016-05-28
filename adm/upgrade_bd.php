<?
$sub_menu = "100910";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
include_once("./admin.head.php");

// 쪽지4 관련 설정 읽어들이기
include_once("../memo.config.php");

// 1.0.45 - 1045 이전에는 db 버젼이 없으므로 한방에 고~???
if (!$config[cf_db_version])
    alert("db 버젼정보가 $g4[config_table] 테이블에 없습니다. 설치버젼 정보를 1092 (1.0.92)의 경우와 같이, g4_config 테이블의 cf_db_version 필드에 넣어주세요");

if ($config[cf_db_version] < 1045) {

echo $config[cf_db_version];
    // 게시판정보 업그레이드
    include_once("./b4_upgrade/upgrade_turning1.php");
    include_once("./b4_upgrade/upgrade_turning2.php");
    include_once("./b4_upgrade/upgrade_turning3.php");
    
    // 1.0.1 - 중복로그인 방지 (불당팁)
    $sql = " ALTER TABLE `$g4[session_table]` ADD `ip_addr` VARCHAR( 255 ) NOT NULL ";
    sql_query($sql, false);
    
    // 1.0.4 - 중복로그인 방지 (배추팁)
    $sql = " ALTER TABLE `$g4[session_table]` ADD `mb_id` VARCHAR( 20 ) NOT NULL AFTER `ss_data` ";
    sql_query($sql, false);
    $sql = " ALTER TABLE `$g4[session_table]` ADD INDEX `mb_id` ( `mb_id` , `ip_addr` ) ";
    sql_query($sql, false);
    $sql = " ALTER TABLE `$g4[session_table]` CHANGE `ip_addr` `ip_addr` VARCHAR( 20 ) ";
    sql_query($sql, false);
    
    // 1.0.4 - 핸드폰 인증된 회원만 글쓰기
    $sql = " ALTER TABLE `$g4[board_table]` ADD `bo_hhp` TINYINT( 4 ) NOT NULL ";
    sql_query($sql, false);
    
    // 1.0.4 - 인기 게시물 목록 (배추스킨)
    $sql = " ALTER TABLE `$g4[board_table]` ADD `bo_hot_list` TINYINT( 4 ) NOT NULL DEFAULT '0',
                                            ADD `bo_hot_list_basis` VARCHAR( 5 ) NOT NULL DEFAULT 'hit' ";
    sql_query($sql, false);
    
    // 1.0.6 - 쪽지4 출력설정
    $sql = " ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_print` TINYINT( 4 ) NOT NULL ";
    sql_query($sql, false);
    
    // 1.0.8 - meta 정보
    $sql = "
    ALTER TABLE `$g4[config_table]` ADD `cf_meta_author` VARCHAR( 255 ) NOT NULL ,
    ADD `cf_meta_keywords` VARCHAR( 255 ) NOT NULL ,
    ADD `cf_meta_description` VARCHAR( 255 ) NOT NULL ";
    sql_query($sql, false);
    
    // 1.0.8 - g4_login index 추가
    $sql = " ALTER TABLE `$g4[login_table]` ADD INDEX `lo_datetime` ( `lo_datetime` ) ";
    sql_query($sql, false);
    
    // 1.0.19 - 레벨업/레벨다운
    $sql = " 
    CREATE TABLE `$g4[member_level_table]` (
      `member_level` tinyint(4) NOT NULL,
      `use_levelup` tinyint(4) NOT NULL,
      `use_leveldown` int(11) NOT NULL,
      `up_days` int(11) NOT NULL,
      `up_point` int(11) NOT NULL,
      `up_post` int(11) NOT NULL,
      `up_post_all` int(11) NOT NULL,
      `up_audit_days` int(11) NOT NULL,
      `down_point` int(11) NOT NULL,
      `down_post` int(11) NOT NULL,
      `down_post_all` int(11) NOT NULL,
      `down_audit_days` int(11) NOT NULL,
      `good` int(11) NOT NULL,
      `nogood` int(11) NOT NULL,
      `singo` tinyint(4) NOT NULL,
      PRIMARY KEY  (`member_level`),
      KEY `level_up` (`use_levelup`),
      KEY `level_down` (`use_leveldown`)
    ) 
    ";
    sql_query($sql, false);
    
    $sql = " 
    CREATE TABLE `$g4[member_level_history_table]` (
      `id` int(11) NOT NULL auto_increment,
      `mb_id` varchar(255) NOT NULL,
      `from_level` tinyint(4) NOT NULL,
      `to_level` tinyint(4) NOT NULL,
      `level_datetime` datetime NOT NULL,
      PRIMARY KEY  (`id`),
      KEY `mb_id` (`mb_id`),
      KEY `level_datetime` (`level_datetime`)
    )
    ";
    sql_query($sql, false);
    
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='2' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='3' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='4' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='5' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='6' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='7' ";
    sql_query($sql, false);
    $sql = " INSERT INTO `$g4[member_level_table]` set `member_level`='8' ";
    sql_query($sql, false);
    
    $sql = " ALTER TABLE `$g4[member_table]` ADD `mb_level_datetime` DATETIME NOT NULL ";
    sql_query($sql, false);
    
    // 1.0.23 - 쪽지4 trash 테이블 설정 오류
    sql_query(" ALTER TABLE `$g4[memo_trash_table]` DROP `me_from_kind` ", FALSE);
    sql_query(" ALTER TABLE `$g4[memo_trash_table]` ADD `me_from_kind` VARCHAR( 255 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[memo_trash_table]` CHANGE `me_id` `me_id` INT( 11 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[memo_trash_table]` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `me_from_kind` ) ", FALSE);
    
    // 1.0.23 - 투표개요 기능 추가
    sql_query(" ALTER TABLE `$g4[poll_table]` ADD `po_summary` TEXT NOT NULL ", FALSE);
    
    // 1.0.23 - 쪽지4 첨부파일 삭제 기능 추가
    sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_del_file` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.25 - 실수로 잘못 들어간 필드 삭제 및 투표 필드 추가
    sql_query(" ALTER TABLE `$g4[poll_table]` DROP `pc_password` ", FALSE);
    sql_query(" ALTER TABLE `$g4[poll_etc_table]` ADD `pc_password` VARCHAR( 255 ) NOT NULL ", FALSE);
    
    // 1.0.26 - 쪽지4 설정추가 (실시간메모)
    sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_del_file` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.26 - 쪽지4 설정추가 (실명 사용)
    sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_mb_name` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.31 - 쪽지4 설정추가 (업로드 파일용량)
    sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_memo_file_size` VARCHAR( 20 ) NOT NULL ", FALSE);
    
    // 1.0.32 - 쪽지4 save 오류 수정
    sql_query(" ALTER TABLE `$g4[memo_save_table]` DROP PRIMARY KEY , ADD PRIMARY KEY ( `me_id` , `memo_type` ) ", FALSE);
    
    //1.0.36 - 가입경로 기록하기
    $sql = "
    CREATE TABLE `$g4[member_register_table]` ( 
      `mb_no` INT( 11 ) NOT NULL ,
      `mb_id` VARCHAR( 255 ) NOT NULL ,
      `ref_url` VARCHAR( 255 ) NOT NULL ,
      KEY `mb_no` (`mb_no`),
      KEY `mb_id` (`mb_id`),
      KEY `ref_url` (`ref_url`)
    )
    ";
    sql_query($sql, false);
    
    // 1.0.36 - 성별 게시판
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_sex` CHAR( 1 ) NOT NULL ", FALSE);
    
    // 1.0.37 - 쪽지4
    sql_query(" ALTER TABLE `$g4[memo_config_table]` CHANGE `cf_memo_file_size` `cf_memo_file_size` TINYINT( 4 ) NULL DEFAULT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[memo_config_table]` ADD `cf_max_memo_file_size` INT( 11 ) NOT NULL ", FALSE);
    
    // 1.0.38 - 홈페이지 인증
    sql_query(" ALTER TABLE `$g4[member_table]` ADD `mb_homepage_certify` DATETIME NOT NULL AFTER `mb_email_certify` ", FALSE);
    
    // 1.0.40 - 일별 글쓰기 제한
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_day_nowrite` VARCHAR( 255 ) NOT NULL ", FALSE);
    
    // 1.0.41 - 포인트 보기 index 수정
    sql_query(" ALTER TABLE `$g4[point_table]` ADD INDEX `mb_id` ( `mb_id` ) ", FALSE) ;
    sql_query(" ALTER TABLE `$g4[point_table]` ADD INDEX `po_rel_table` ( `po_rel_table` ) ", FALSE) ;
    sql_query(" ALTER TABLE `$g4[point_table]` ADD INDEX `po_rel` ( `po_rel_table` , `po_rel_id` ) ", FALSE) ;
    
    // 1.0.41 - 쪽지4 - 4.0.19
    sql_query(" ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply_datetime` DATETIME NOT NULL ", FALSE);
    
    // 1.0.45 - 딴지걸기
    sql_query(" ALTER TABLE `$g4[hidden_comment_table]` ADD `co_mb_id` VARCHAR( 255 ) NOT NULL ", FALSE);
    
    // 1.0.45 - 가입환영 쪽지
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_memo_mb_member` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.45 - n일후 글쓰기 제한
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_comment_nowrite` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.45 - 현재접속자수 튜닝
    sql_query(" ALTER TABLE `$g4[login_table]` ADD INDEX `mb_id` ( `mb_id` ) ", FALSE);
    
    // 1.0.45 - 갤러리 게시판 설정 / 튜닝
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_gallery` TINYINT( 4 ) NOT NULL ", FALSE);
    
    // 1.0.45 - 추천인 필수입력
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_req_recommend` TINYINT( 4 ) NOT NULL AFTER `cf_use_recommend` ", FALSE);
}

// 1.0.45 이후부터는 필요한 것만 개별적으로 업데이트 ------------------------------------------------------------

// 1.0.52 - wr_hit, wr_datetime index 추가
if ($config[cf_db_version] < 1052) {
    include_once("$g4[admin_path]/b4_upgrade/upgrade_turning_wr_hit.php");
}

// 1.0.55 - 게시판 테이블의 최종 업데이트날짜 (게시글/코멘트가 등록된 날짜)
if ($config[cf_db_version] < 1055) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_modify_datetime` DATETIME NOT NULL ", FALSE);

    // 1.0.55 - db업데이트가 쉽게 config 테이블에 db 버젼정보를 추가 (코드 업글정보는 아니구요)
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_db_version` INT( 11 ) NOT NULL  ", FALSE);
}

// 1.0.56 - db 튜닝
if ($config[cf_db_version] < 1056) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD INDEX `gr_id` ( `gr_id` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD INDEX `bo_use_search` ( `bo_use_search` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD INDEX `bo_order_search` ( `bo_order_search` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_file_table]` ADD INDEX `bo_table` ( `bo_table` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_file_table]` ADD INDEX `wr_id` ( `wr_id` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_file_table]` ADD INDEX `bf_no` ( `bf_no` )  ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_file_table]` ADD INDEX `bf_datetime` ( `bf_datetime` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_new_table]` ADD INDEX `parent_mb_id` ( `parent_mb_id` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[group_table]` ADD INDEX `gr_use_access` ( `gr_use_access` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[member_table]` ADD INDEX `mb_open` ( `mb_open` )  ", FALSE);
}

// 1.0.64 - 휴지통기능
if ($config[cf_db_version] < 1064) {
    $sql = " ALTER TABLE `$g4[config_table]` ADD `cf_use_recycle` TINYINT( 4 ) NOT NULL , ADD `cf_recycle_table` VARCHAR( 255 ) NOT NULL ";
    sql_query($sql, false);
    
    $sql = " ALTER TABLE `$g4[config_table]` ADD `cf_recycle_days` INT( 11 ) NOT NULL ";
    sql_query($sql, false);
     
    $sql = " ALTER TABLE `$g4[board_table]` ADD `bo_use_recycle` TINYINT( 4 ) NOT NULL ";
    sql_query($sql, false);
    
    $sql = "
    CREATE TABLE `$g4[recycle_table]` (
      `rc_no` int(11) NOT NULL auto_increment,
      `rc_mb_id` varchar(255) NOT NULL,
      `rc_bo_table` varchar(255) NOT NULL,
      `rc_wr_id` int(11) NOT NULL,
      `rc_wr_parent` int(11) NOT NULL,
      `rc_parent_mb_id` varchar(255) NOT NULL,
      `rc_delete` tinyint(4) NOT NULL,
      `mb_id` varchar(255) NOT NULL,
      `bo_table` varchar(255) NOT NULL,
      `wr_id` int(11) NOT NULL,
      `wr_is_comment` tinyint(4) NOT NULL,
      `bn_id` int(11) NOT NULL,
      `rc_datetime` datetime NOT NULL,
      PRIMARY KEY  (`rc_no`),
      KEY `mb_id` (`mb_id`),
      KEY `bo_table` (`bo_table`),
      KEY `wr_id` (`wr_id`),
      KEY `bn_id` (`bn_id`),
      KEY `wr_is_comment` (`wr_is_comment`),
      KEY `rc_delete` (`rc_delete`),
      KEY `recycle_table` (`rc_bo_table`)
    )
    ";
    sql_query($sql, false);
}

// 1.0.66 - 신고기능 수정
if ($config[cf_db_version] < 1066) {
    sql_query(" ALTER TABLE `$g4[singo_table]` ADD `sg_notes` VARCHAR( 255 ) NOT NULL ", FALSE);
}

// 1.0.69 - 디비 튜닝
if ($config[cf_db_version] < 1069) {
    sql_query(" ALTER TABLE `$g4[board_good_table]` ADD INDEX `bg_flag` ( `bg_flag` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[my_menu_table]` ADD INDEX `mb_id2` ( `mb_id` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[scrap_table]` ADD INDEX `bo_table` ( `bo_table` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[singo_table]` ADD INDEX `mb_id` ( `mb_id` ) ", FALSE);
}

// 1.0.70 - 쪽지4 4.0.26 업글
if ($config[cf_db_version] < 1070) {
    sql_query(" ALTER TABLE `$g4[member_table]` ADD `mb_memo_unread` INT( 11 ) NOT NULL ", FALSE); 
}

// 1.0.73 - 코멘트 dhtml 편집기 사용
if ($config[cf_db_version] < 1073) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_use_dhtml_comment` TINYINT( 4 ) NOT NULL ", FALSE); 
    
    // 누락된 업글 script 보완. 이게 왜 빠졌을까요? ㅠ..ㅠ...
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_singo_point_send` INT( 11 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_singo_point_recv` INT( 11 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_double_login` TINYINT( 4 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_html_level_comment` TINYINT( 4 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_singo_nowrite`  VARCHAR( 255 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_print_level` TINYINT( 4 ) NOT NULL ", FALSE);
}

// 1.0.76 - 코멘트 dhtml 편집기 사용
if ($config[cf_db_version] < 1076) {

    // 누락된 업글 script 보완. 이게 왜 빠졌을까요? ㅠ..ㅠ...
    sql_query(" ALTER TABLE `$g4[member_table]` ADD `mb_hp_certify_datetime` DATETIME NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_sms4_member` TINYINT( 4 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_sms4_level` TINYINT( 4 ) NOT NULL ", FALSE);

    $sql = " CREATE TABLE IF NOT EXISTS `$g4[board_file_download_table]` (
              `dn_id` int(11) NOT NULL AUTO_INCREMENT,
              `bo_table` varchar(20) NOT NULL,
              `wr_id` int(11) NOT NULL,
              `bf_no` int(11) NOT NULL,
              `mb_id` varchar(255) NOT NULL,
              `download_point` int(11) NOT NULL,
              `dn_count` int(11) NOT NULL,
              `dn_datetime` datetime NOT NULL,
              `dn_ip` varchar(255) NOT NULL,
              `gr_id` varchar(20) NOT NULL,
              UNIQUE KEY `dn_id` (`dn_id`),
              KEY `index1` (`bo_table`,`wr_id`),
              KEY `mb_id` (`mb_id`),
              KEY `gr_id` (`gr_id`),
              KEY `dn_datetime` (`dn_datetime`)
            ) ";
    sql_query($sql, FALSE);
}


// 1.0.78
if ($config[cf_db_version] < 1078) {

    // 누락된 업글 script 보완. 이게 왜 빠졌을까요? ㅠ..ㅠ...
    $sql = " CREATE TABLE `$g4[user_group_table]` (
            `ug_id` varchar(10) NOT NULL default '',
            `ug_subject` varchar(255) NOT NULL default '',
            `ug_admin` varchar(255) NOT NULL default '',
            `ug_1_subj` varchar(255) NOT NULL default '',
            `ug_2_subj` varchar(255) NOT NULL default '',
            `ug_3_subj` varchar(255) NOT NULL default '',
            `ug_4_subj` varchar(255) NOT NULL default '',
            `ug_5_subj` varchar(255) NOT NULL default '',
            `ug_1` varchar(255) NOT NULL default '',
            `ug_2` varchar(255) NOT NULL default '',
            `ug_3` varchar(255) NOT NULL default '',
            `ug_4` varchar(255) NOT NULL default '',
            `ug_5` varchar(255) NOT NULL default '',
            PRIMARY KEY  (`ug_id`)
          ) ";
    sql_query($sql, FALSE);

    sql_query(" ALTER TABLE `$g4[member_table]` ADD `ug_id` VARCHAR( 10 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[group_table]` ADD `gr_use_search` TINYINT( 4 ) NOT NULL AFTER `gr_use_access` ", FALSE);

}

// 1.0.79
if ($config[cf_db_version] < 1079) {
    // 이미지 용량제한
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_image_info` TINYINT( 4 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_image_max_size` INT( 11 ) NOT NULL ", FALSE);
}

// 1.0.82 (db index를 재조정)
if ($config[cf_db_version] < 1082) {
    include_once("./b4_upgrade/index_change.php");
}

// 1.0.84 - cheditor 이미지 파일목록
if ($config[cf_db_version] < 1084) {

    $sql = " 
      CREATE TABLE IF NOT EXISTS `$g4[board_cheditor_table]` (
        `bo_table` varchar(255) DEFAULT NULL,
        `wr_id` int(11) DEFAULT NULL,
        `bc_url` varchar(255) NOT NULL,
        `bc_dir` varchar(255) NOT NULL,
        `bc_source` varchar(255) NOT NULL,
        `bc_file` varchar(255) NOT NULL,
        `bc_filesize` int(11) NOT NULL,
        `bc_width` int(11) NOT NULL,
        `bc_height` smallint(6) NOT NULL,
        `bc_type` tinyint(4) NOT NULL,
        `bc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        KEY `bo_table` (`bo_table`,`wr_id`)
      );
      ";
    sql_query($sql, FALSE);
}

// 1.0.88 - cheditor 이미지 파일목록 테이블 업그레이드
if ($config[cf_db_version] < 1088) {
    $sql = " 
        ALTER TABLE `$g4[board_cheditor_table]` ADD `bc_ip` VARCHAR( 255 ) NOT NULL ,
        ADD `mb_id` VARCHAR( 255 ) NOT NULL ;
      ";
    sql_query($sql, FALSE);
}

// 1.0.88 - 전체공지
if ($config[cf_db_version] < 1088) {
    $sql = " 
        CREATE TABLE IF NOT EXISTS `$g4[notice_table]` (
          `no_id` int(11) NOT NULL AUTO_INCREMENT,
          `bo_table` varchar(255) NOT NULL,
          `wr_id` mediumint(11) NOT NULL,
          `no_datetime` datetime NOT NULL,
          PRIMARY KEY (`no_id`)
        )
      ";
    sql_query($sql, FALSE);
}

// 1.0.89 - bo_dhtml_editor_level 추가
if ($config[cf_db_version] < 1089) {
    $sql = " 
        ALTER TABLE `$g4[board_table]` 
        ADD `bo_dhtml_editor_level` TINYINT( 4 ) NOT NULL AFTER `bo_html_level` ,
        ADD `bo_dhtml_editor_level_comment` TINYINT( 4 ) NOT NULL AFTER `bo_dhtml_editor_level` ;
      ";
    sql_query($sql, FALSE);
}

// 1.0.89 - 왔숑~
if ($config[cf_db_version] < 1089) {
    $sql = " 
        CREATE TABLE IF NOT EXISTS `$g4[whatson_table]` (
          `wo_id` int(11) NOT NULL AUTO_INCREMENT,
          `mb_id` varchar(255) NOT NULL,
          `wo_type` varchar(20) NOT NULL,
          `bo_table` varchar(20) NOT NULL,
          `wr_id` int(11) NOT NULL,
          `comment_id` int(11) NOT NULL,
          `wr_subject` varchar(255) NOT NULL,
          `wo_count` tinyint(4) NOT NULL,
          `wo_datetime` datetime NOT NULL,
          `wo_status` tinyint(4) NOT NULL,
          PRIMARY KEY (`wo_id`),
          KEY `mb_id` (`mb_id`),
          KEY `wo_datetime` (`wo_datetime`)
        );
      ";
    sql_query($sql, FALSE);
}

echo "1.0.89 업글 완료";

// 1.0.92 - 전체공지 게시판 설정
if ($config[cf_db_version] < 1092) {
    $sql = "
        ALTER TABLE `$g4[board_table]` ADD `bo_naver_notice` TINYINT( 4 ) NOT NULL DEFAULT '1';
      ";
    sql_query($sql, FALSE);
}

// 1.0.92 - 쪽지 5 업그레이드
if ($config[cf_db_version] < 1092) {
    $sql = "
        ALTER TABLE `$g4[member_table]` ADD `mb_memo_call_datetime` DATETIME NOT NULL AFTER `mb_memo_call` ;
      ";
    sql_query($sql, FALSE);
}

// 1.0.92 - geoip
if ($config[cf_db_version] < 1092) {
    $sql = " 
            CREATE TABLE IF NOT EXISTS `$g4[geoip_table]` (
              `ip_start` char(15) NOT NULL,
              `ip_end` char(15) NOT NULL,
              `ip32_start` int(10) unsigned NOT NULL,
              `ip32_end` int(10) unsigned NOT NULL,
              `country_code` char(2) NOT NULL,
              `country_full` varchar(50) NOT NULL,
              KEY `ip32` (`ip32_start`,`ip32_end`)
            );
      ";
    sql_query($sql, FALSE);
}

echo "1.0.92 업글 완료";

// 1.0.93 - 아이디/비번 찾기
if ($config[cf_db_version] < 1093) {
    $sql = " 
            ALTER TABLE `$g4[member_table]` ADD `mb_lost_certify` VARCHAR( 255 ) NOT NULL ;
            ";
    sql_query($sql, FALSE);
}

// 1.0.93 - 필터
if ($config[cf_db_version] < 1093) {
    $sql = " 
            CREATE TABLE IF NOT EXISTS `$g4[popular_sum_table]` (
              `pp_id` int(11) NOT NULL AUTO_INCREMENT,
              `pp_word` varchar(255) NOT NULL,
              `pp_date` date NOT NULL,
              `pp_count` int(11) NOT NULL,
              `pp_level` tinyint(4) NOT NULL,
              `bo_table` varchar(255) NOT NULL,
              PRIMARY KEY (`pp_id`),
              KEY `pp_index` (`pp_word`,`pp_date`),
              KEY `pp_level` (`pp_level`),
              KEY `bo_table` (`bo_table`)
            );
      ";
    sql_query($sql, FALSE);
}

if ($config[cf_db_version] < 1093) {
    $sql = " 
            CREATE TABLE IF NOT EXISTS `$g4[filter_table]` (
              `pp_id` int(11) NOT NULL AUTO_INCREMENT,
              `pp_word` varchar(255) NOT NULL,
              `pp_level` tinyint(4) NOT NULL DEFAULT '1',
              `pp_datetime` datetime NOT NULL,
              PRIMARY KEY (`pp_id`),
              KEY `pp_word` (`pp_word`)
            );
      ";
    sql_query($sql, FALSE);
}

// 1.0.94 - 신고헤제 테이블
if ($config[cf_db_version] < 1094) {
    $sql = " 
            CREATE TABLE IF NOT EXISTS `$g4[unsingo_table]` (
              `unsg_id` int(11) NOT NULL AUTO_INCREMENT,
              `mb_id` varchar(20) NOT NULL DEFAULT '',
              `bo_table` varchar(20) NOT NULL DEFAULT '',
              `wr_id` int(11) NOT NULL DEFAULT '0',
              `wr_parent` int(11) NOT NULL DEFAULT '0',
              `unsg_mb_id` varchar(20) NOT NULL DEFAULT '',
              `unsg_reason` varchar(255) NOT NULL DEFAULT '',
              `unsg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `unsg_ip` varchar(255) NOT NULL DEFAULT '',
              `unsg_notes` varchar(255) NOT NULL,
              PRIMARY KEY (`unsg_id`),
              KEY `fk1` (`bo_table`,`wr_id`),
              KEY `fk2` (`bo_table`,`wr_parent`),
              KEY `mb_id` (`mb_id`)
            )
      ";
    sql_query($sql, FALSE);
}

// 1.0.94 - chimage 옵션화
if ($config[cf_db_version] < 1094) {
    $sql = " 
            ALTER TABLE `$g4[board_table]` ADD `bo_chimage` TINYINT( 4 ) NOT NULL ;
      ";
    sql_query($sql, FALSE);
}

// 1.0.94 - chimage 테이블 수정
if ($config[cf_db_version] < 1094) {
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD INDEX `mb_id` (`mb_id`) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD `del` TINYINT( 4 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD `bc_id` INT( 11) NOT NULL AUTO_INCREMENT PRIMARY KEY ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD `wr_session` VARCHAR( 255 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD INDEX `wr_session` ( `wr_session` ) ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_cheditor_table]` ADD INDEX `bc_file` ( `bc_file` ) ", FALSE);
}

// 1.0.94 - 임시저장 테이블
if ($config[cf_db_version] < 1094) {
    $sql = " 
            CREATE TABLE IF NOT EXISTS `$g4[tempsave_table]` (
              `tmp_id` int(11) NOT NULL AUTO_INCREMENT,
              `mb_id` varchar(255) NOT NULL,
              `bo_table` varchar(255) NOT NULL,
              `wr_id` int(11) NOT NULL,
              `wr_subject` varchar(255) NOT NULL,
              `wr_content` text NOT NULL,
              `wr_datetime` datetime NOT NULL,
              `ip_addr` varchar(255) NOT NULL,
              `wr_session` varchar(255) NOT NULL,
              PRIMARY KEY (`tmp_id`),
              KEY `mb_id` (`mb_id`),
              KEY `wr_session` (`wr_session`),
              KEY `bo_table` (`bo_table`)
            );
      ";
    sql_query($sql, FALSE);
}

// 1.0.95 - visit log 테이블 업글
if ($config[cf_db_version] < 1096) {
    sql_query(" ALTER TABLE `$g4[login_table]` ADD `lo_referer` TEXT NOT NULL , ADD `lo_agent` VARCHAR( 255 ) NOT NULL  ", FALSE);
}

// 1.0.95 - chimage 확장
if ($config[cf_db_version] < 1096) {
    include_once("$g4[admin_path]/b4_upgrade/upgrade_wr_imagesize.php");
}

// 1.0.99 - 본인인증
if ($config[cf_db_version] < 1099) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_realcheck` TINYINT( 4 ) NOT NULL  ", FALSE);

    $sql = " 
            CREATE TABLE IF NOT EXISTS `g4_namecheck` (
              `cb_id` int(11) NOT NULL AUTO_INCREMENT,
              `mb_id` varchar(255) NOT NULL,
              `mb_jumin` varchar(255) NOT NULL,
              `mb_name` varchar(255) NOT NULL,
              `cb_ip` varchar(255) NOT NULL,
              `cb_datetime` datetime NOT NULL,
              `cb_returncode` tinyint(4) NOT NULL,
              PRIMARY KEY (`cb_id`),
              KEY `mb_id` (`mb_id`)
            );
      ";
    sql_query($sql, FALSE);

    $sql = " 
            CREATE TABLE IF NOT EXISTS `g4_realcheck` (
              `cb_id` int(11) NOT NULL AUTO_INCREMENT,
              `mb_id` varchar(255) NOT NULL,
              `cb_ip` varchar(255) NOT NULL,
              `cb_datetime` datetime NOT NULL,
              `cb_authtype` char(1) NOT NULL,
              `cb_errorcode` char(4) NOT NULL,
              PRIMARY KEY (`cb_id`),
              KEY `mb_id` (`mb_id`)
            );
      ";
    sql_query($sql, FALSE);
}

// 1.0.99 - 베스트글
if ($config[cf_db_version] < 1099) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_list_good` INT( 11 ) NOT NULL  ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_list_nogood` INT( 11 ) NOT NULL  ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_list_view` INT( 11 ) NOT NULL  ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_list_comment` INT( 11 ) NOT NULL  ", FALSE);

    $sql = " 
            CREATE TABLE IF NOT EXISTS `g4_good_list` (
              `gl_id` int(11) NOT NULL AUTO_INCREMENT,
              `gr_id` varchar(255) NOT NULL,
              `bo_table` varchar(255) NOT NULL,
              `wr_id` int(11) NOT NULL,
              `wr_datetime` datetime NOT NULL,
              `gl_datetime` datetime NOT NULL,
              `good` mediumint(11) NOT NULL,
              `nogood` int(11) NOT NULL,
              `hit` int(11) NOT NULL,
              `comment` int(11) NOT NULL,
              PRIMARY KEY (`gl_id`),
              KEY `bo_table` (`bo_table`),
              KEY `hit` (`hit`),
              KEY `comment` (`comment`),
              KEY `good` (`good`),
              KEY `wr_datetime` (`wr_datetime`),
              KEY `gr_id` (`gr_id`)
            );
      ";
    sql_query($sql, FALSE);
}

// 1.0.100 - 마이너스 포인트 글읽기 제한
if ($config[cf_db_version] < 1100) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_read_point_lock` TINYINT( 4) NOT NULL ", FALSE);
}


// 1.1.01 - 중복공지 금지
if ($config[cf_db_version] < 1101) {
    sql_query(" ALTER TABLE `$g4[board_table]` ADD `bo_notice_joongbok` TINYINT( 4 ) NOT NULL ", FALSE);
}

// 1.1.02 - 튜닝을 위한 인덱스 추가
if ($config[cf_db_version] < 1102) {
    sql_query(" ALTER TABLE `$g4[login_table]` ADD INDEX `lo_datetime` ( `lo_datetime` ) ", FALSE);
}

// 1.1.02 - 베스트글에 mb_id 정보 추가
if ($config[cf_db_version] < 1102) {
    sql_query(" ALTER TABLE `$g4[good_list_table]` ADD `mb_id` VARCHAR( 255 ) NOT NULL ", FALSE);
}

// 1.1.02 - 베스트글에 unique index 추가
if ($config[cf_db_version] < 1102) {
    sql_query(" ALTER TABLE `$g4[good_list_table]` ADD UNIQUE `unique` (`bo_table` ,`wr_id`) ", FALSE);
}

// 1.1.03 - 인기글에 개인정보 유출되지 않게 하기
if ($config[cf_db_version] < 1103) {
    sql_query(" ALTER TABLE `$g4[popular_sum_table]` ADD `mb_info` TINYINT( 4) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[popular_sum_table]` ADD INDEX `mb_info` (`mb_info`)  ", FALSE);
}

// 1.1.04 - db_cache
if ($config[cf_db_version] < 1104) {
    $sql = "
    CREATE TABLE IF NOT EXISTS `$g4[cache_table]` (
      `c_id` int(11) NOT NULL AUTO_INCREMENT,
      `c_name` varchar(255) NOT NULL,
      `c_text` text NOT NULL,
      `c_datetime` datetime NOT NULL,
      PRIMARY KEY (`c_id`),
      UNIQUE KEY `c_name` (`c_name`)
    )";
    sql_query($sql, FALSE);
}

// 1.1.05 - search
if ($config[cf_db_version] < 1105) {
    $sql = " ALTER TABLE $g4[board_table] ADD `bo_search_level` TINYINT( 4) NOT NULL ";
    sql_query($sql, FALSE);
}

// 1.1.07 - 추천, db 세션, 회원가입추천
if ($config[cf_db_version] < 1107) {

    $sql = " ALTER TABLE `$g4[member_table]` ADD `mb_good` INT( 11 ) NOT NULL , ADD `mb_nogood` INT( 11 ) NOT NULL ";
    sql_query($sql, FALSE);
 
    sql_query(" ALTER TABLE `$g4[session_table]` CHANGE `id` `ss_id` VARCHAR( 32) ", FALSE);
    sql_query(" ALTER TABLE `$g4[session_table]` CHANGE `ss_data` `ss_data` TEXT  ", FALSE);
    sql_query(" ALTER TABLE `$g4[session_table]` ADD INDEX `ss_datetime` (`ss_datetime`)  ", FALSE);
 
    sql_query(" ALTER TABLE `$g4[member_suggest_table]` ADD `join_email` VARCHAR( 255) NOT NULL AFTER `join_hp`  ", FALSE);
    sql_query(" ALTER TABLE `$g4[member_suggest_table]` ADD `mb_email` VARCHAR( 255) NOT NULL AFTER `mb_hp`  ", FALSE);
    sql_query(" ALTER TABLE `$g4[member_suggest_table]` ADD `email_certify` VARCHAR( 255) NOT NULL  ", FALSE);
    sql_query(" ALTER TABLE `$g4[member_suggest_table]` ADD INDEX `mb_id` (`mb_id`)  ", FALSE);
    sql_query(" ALTER TABLE `$g4[member_suggest_table]` ADD INDEX `email_certify` (`email_certify`)  ", FALSE);
}

if ($config[cf_db_version] < 1108) {

    // 1.1.08 - ca_name에 index 걸어주기
    $sql = " select * from $g4[board_table] ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql1 = " ALTER TABLE `$tmp_write_table` ADD INDEX `ca_name` ( `ca_name` ) ";
        sql_query($sql1, FALSE);
    }

    // wr_mb_id 필드 추가 - 추천된 글의 글쓴이
    sql_query(" ALTER TABLE `$g4[board_good_table]` ADD `wr_mb_id` VARCHAR( 255 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE `$g4[board_good_table]` ADD INDEX `wr_mb_id` ( `wr_mb_id` )", FALSE);

    // 사이트에 접근하는 keyword의 종류 및 접근 게시글
    $sql = " CREATE TABLE IF NOT EXISTS `$g4[seo_tag_table]` (
            `tag_id` int(11) NOT NULL AUTO_INCREMENT,
            `tag_name` varchar(255) NOT NULL,
            `tag_date` date NOT NULL,
            `bo_table` varchar(20) NOT NULL,
            `wr_id` int(11) NOT NULL,
            `count` int(11) NOT NULL,
            PRIMARY KEY (`tag_id`),
            UNIQUE KEY `unique_key` (`tag_name`,`bo_table`,`wr_id`)
          ) ";
    sql_query($sql, FALSE);

    // 사이트에 접속하는 agent의 빈도
    $sql = " CREATE TABLE IF NOT EXISTS `$g4[seo_server_table]` (
            `server_id` int(11) NOT NULL AUTO_INCREMENT,
            `server_name` varchar(255) NOT NULL,
            `server_date` date NOT NULL,
            `count` int(11) NOT NULL,
            PRIMARY KEY (`server_id`),
            UNIQUE KEY `server` (`server_name`,`server_date`)
          ) ";
    sql_query($sql, FALSE);

    // History
    $sql = " CREATE TABLE IF NOT EXISTS `$g4[seo_history_table]` (
            `seo_id` int(11) NOT NULL AUTO_INCREMENT,
            `seo_datetime` datetime NOT NULL,
            `server_name` varchar(255) NOT NULL,
            `tag_name` varchar(255) NOT NULL,
            `bo_table` varchar(255) NOT NULL,
            `wr_id` int(11) NOT NULL,
            PRIMARY KEY (`seo_id`),
            KEY `server_name` (`server_name`),
            KEY `bo_table` (`bo_table`),
            KEY `tag_name` (`tag_name`)
          ) ";
    sql_query($sql, FALSE);

    // 게시판별 추천, 비추천 포인트
    sql_query(" ALTER TABLE  `g4_board` ADD  `bo_good_point` INT( 11 ) NOT NULL ", FALSE);
    sql_query(" ALTER TABLE  `g4_board` ADD  `bo_nogood_point` INT( 11 ) NOT NULL ", FALSE);

    // 게시판별 추천, 비추천 포인트 업데이트
    $sql = " select * from $g4[board_good_table] ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $tmp_write_table = $g4[write_prefix] . $row[bo_table];
        $sql2 = " select mb_id from $tmp_write_table where wr_id = '$row[wr_id]' ";
        $result2 = sql_fetch($sql2);
        $sql3 = " update $g4[board_good_table] set wr_mb_id = '$result2[mb_id]' where bo_table = '$row[bo_table]' and wr_id = '$row[wr_id]' ";
        sql_query($sql3, FALSE);
    }

    // 개인정보 제3자 제공 항목 추가
    sql_query(" ALTER TABLE `g4_config_reg` ADD `cf_privacy_5` TEXT NOT NULL ", FALSE);

    // 개인정보 제3자 제공, 취급위탁 관련 동의 받기
    sql_query(" ALTER TABLE ADD `mb_agree_3rd_pty` TINYINT( 4) NOT NULL ", FALSE);

}


if ($config[cf_db_version] < 1108) {

    sql_query(" ALTER TABLE `$g4[config_table]` ADD `cf_delay_level` TINYINT( 4 ) NOT NULL , ADD `cf_delay_point` INT( 11 ) NOT NULL ", FALSE);

}

if ($config[cf_db_version] < 1111) {

    $sql = "
            CREATE TABLE IF NOT EXISTS `$g4[banner_group_table]` (
              `bg_id` varchar(20) NOT NULL,
              `bg_subject` varchar(255) NOT NULL,
              `bg_admin` varchar(255) NOT NULL,
              `bg_desc` varchar(255) NOT NULL,
              `bg_use` tinyint(4) NOT NULL,
              `bg_width` int(11) NOT NULL,
              `bg_height` int(11) NOT NULL,
              `bg_1_subj` varchar(255) NOT NULL,
              `bg_2_subj` varchar(255) NOT NULL,
              `bg_3_subj` varchar(255) NOT NULL,
              `bg_1` varchar(255) NOT NULL,
              `bg_2` varchar(255) NOT NULL,
              `bg_3` varchar(255) NOT NULL,
              PRIMARY KEY (`bg_id`)
            );
            ";
    sql_query($sql, FALSE);

    $sql = "
            CREATE TABLE IF NOT EXISTS `$g4[banner_table]` (
              `bn_id` varchar(20) NOT NULL,
              `bn_subject` varchar(255) NOT NULL,
              `bg_id` varchar(20) NOT NULL,
              `bn_url` varchar(255) NOT NULL,
              `bn_target` tinyint(4) NOT NULL,
              `bn_use` tinyint(4) NOT NULL,
              `bn_order` tinyint(4) NOT NULL,
              `bn_start_datetime` datetime NOT NULL,
              `bn_end_datetime` datetime NOT NULL,
              `bn_image` varchar(255) NOT NULL,
              `bn_filename` varchar(255) NOT NULL,
              `bn_text` text NOT NULL,
              `bn_datetime` datetime NOT NULL,
              `bn_click` int(11) NOT NULL,
              `bn_1_subj` varchar(255) NOT NULL,
              `bn_2_subj` varchar(255) NOT NULL,
              `bn_3_subj` varchar(255) NOT NULL,
              `bn_1` varchar(255) NOT NULL,
              `bn_2` varchar(255) NOT NULL,
              `bn_3` varchar(255) NOT NULL,
              PRIMARY KEY (`bn_id`),
              KEY `bg_id` (`bg_id`),
              KEY `bn_use` (`bn_use`),
              KEY `bn_order` (`bn_order`),
              KEY `bn_start_datetime` (`bn_start_datetime`),
              KEY `bn_end_datetime` (`bn_end_datetime`)
            );
            ";
    sql_query($sql, FALSE);
             
    $sql = "
            CREATE TABLE IF NOT EXISTS `$g4[banner_click_table]` (
              `bc_id` int(11) NOT NULL AUTO_INCREMENT,
              `bn_id` varchar(20) NOT NULL,
              `bg_id` varchar(20) NOT NULL,
              `bc_agent` varchar(255) NOT NULL,
              `bc_datetime` datetime NOT NULL,
              PRIMARY KEY (`bc_id`),
              KEY `bn_id` (`bn_id`),
              KEY `bg_id` (`bg_id`)
            );
            ";
    sql_query($sql, FALSE);
             
    $sql = "
            CREATE TABLE IF NOT EXISTS `$g4[banner_click_sum_table]` (
              `bc_date` date NOT NULL,
              `bc_count` int(11) NOT NULL,
              PRIMARY KEY (`bc_date`),
              KEY `bc_count` (`bc_count`)
            );
            ";
    sql_query($sql, FALSE);
}

if ($config[cf_db_version] < 1113) {

    sql_query(" ALTER TABLE  `$g4[good_list_table]` ADD  `gl_flag` TINYINT( 4 ) NOT NULL AFTER  `gl_id` ", FALSE);

}
            
// db 버젼을 업데이트 - major version + mid version - patch version
$max_version = "1113";
sql_query(" update $g4[config_table] set cf_db_version = '$max_version' ");

echo "불당팩 $max_version - UPGRADE 완료.";

include_once("./admin.tail.php");
?>
