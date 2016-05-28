<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

// 사용자 설정을 저장하기
$mb_realmemo             = $_POST['mb_realmemo'];
$mb_realmemo_sound       = $_POST['mb_realmemo_sound'];
$mb_memo_no_reply        = $_POST['mb_memo_no_reply'];
$mb_memo_no_reply_text   = addslashes($_POST['mb_memo_no_reply_text']);
$mb_memo_no_reply_org    = $_POST['mb_memo_no_reply_org'];
if ($mb_memo_no_reply_org != $mb_memo_no_reply)
    $mb_memo_no_reply_datetime = $g4['time_ymdhis'];
else
    $mb_memo_no_reply_datetime = $member['mb_memo_no_reply_datetime'];

$sql = " update $g4[member_table] 
            set mb_realmemo = '$mb_realmemo',
                mb_realmemo_sound = '$mb_realmemo_sound',
                mb_memo_no_reply = '$mb_memo_no_reply',
                mb_memo_no_reply_text = '$mb_memo_no_reply_text',
                mb_memo_no_reply_datetime = '$mb_memo_no_reply_datetime'
          where mb_id = '$member[mb_id]' ";
$res = sql_query($sql, false);

if (!$res) {
    sql_query( " ALTER TABLE `$g4[member_table]` ADD `mb_realmemo` tinyint(4) NOT NULL ", false);
    sql_query( " ALTER TABLE `$g4[member_table]` ADD `mb_realmemo_sound` tinyint(4) NOT NULL ", false);
    sql_query( " ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply` tinyint(4) NOT NULL ", false);
    sql_query( " ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply_text` varchar(255) NOT NULL ", false);
    sql_query( " ALTER TABLE `$g4[member_table]` ADD `mb_memo_no_reply_datetime` datetime NOT NULL ", false);
        
    // update를 수행
    sql_query($sql);
}

// config_table
$cf_memo_send_point   = (int) $_POST['cf_memo_send_point'];
$cf_memo_del          = (int) $_POST['cf_memo_del'];

// memo_config_table
$cf_memo_page_rows    = (int) $_POST['cf_memo_page_rows'];
$cf_memo_del_unread   = (int) $_POST['cf_memo_del_unread'];
$cf_memo_del_trash    = (int) $_POST['cf_memo_del_trash'];
$cf_memo_user_dhtml   = $_POST['cf_memo_user_dhtml'];
$cf_memo_use_file     = $_POST['cf_memo_use_file'];
$cf_friend_management = $_POST['cf_friend_management'];
$cf_memo_no_reply     = $_POST['cf_memo_no_reply'];
$cf_memo_notice_board = $_POST['cf_memo_notice_board'];
$cf_memo_notice_memo  = $_POST['cf_memo_notice_memo'];
$cf_memo_before_after = $_POST['cf_memo_before_after'];
$cf_memo_print        = $_POST['cf_memo_print'];
$cf_memo_b4_resize    = $_POST['cf_memo_b4_resize'];
$cf_memo_realtime     = $_POST['cf_memo_realtime'];
$cf_memo_mb_name      = $_POST['cf_memo_mb_name'];
$cf_memo_file_size    = (int) $_POST['cf_memo_file_size'];
$cf_max_memo_file_size    = (int) $_POST['cf_max_memo_file_size'];

// 관리자 설정을 저장하기
if ($is_admin) {
    $sql = " update $g4[config_table]
                set
                    cf_memo_send_point  = '$cf_memo_send_point',
                    cf_memo_del         = '$cf_memo_del'
          ";
    sql_query($sql);
    $sql = " update $g4[memo_config_table] 
                set 
                    cf_memo_page_rows   = '$cf_memo_page_rows',
                    cf_memo_del_unread  = '$cf_memo_del_unread',
                    cf_memo_del_trash   = '$cf_memo_del_trash',
                    cf_memo_user_dhtml  = '$cf_memo_user_dhtml',
                    cf_memo_use_file    = '$cf_memo_use_file',
                    cf_memo_file_size   = '$cf_memo_file_size',
                    cf_max_memo_file_size = '$cf_max_memo_file_size',
                    cf_friend_management= '$cf_friend_management',
                    cf_memo_no_reply    = '$cf_memo_no_reply',
                    cf_memo_notice_board= '$cf_memo_notice_board',
                    cf_memo_notice_memo = '$cf_memo_notice_memo',
                    cf_memo_before_after= '$cf_memo_before_after',
                    cf_memo_print       = '$cf_memo_print',
                    cf_memo_b4_resize   = '$cf_memo_b4_resize',
                    cf_memo_realtime    = '$cf_memo_realtime',
                    cf_memo_mb_name     = '$cf_memo_mb_name'
            ";
    $res = sql_query($sql, false);

    if (!$res) {
        $cml = " DROP TABLE IF EXISTS `$g4[memo_config_table]` ";
        sql_query($cml);
        $cml = "
                CREATE TABLE `$g4[memo_config_table]` (
                  `cf_memo_page_rows` int(11) NOT NULL,
                  `cf_memo_del_unread` int(11) NOT NULL default '180',
                  `cf_memo_del_trash` int(11) NOT NULL default '7',
                  `cf_memo_delete_datetime` datetime NOT NULL,
                  `cf_memo_user_dhtml` tinyint(4) NOT NULL default '1',
                  `cf_memo_use_file` tinyint(4) NOT NULL default '0',
                  `cf_memo_file_size` tinyint(4) default NULL,
                  `cf_max_memo_file_size` int(11) default NULL,
                  `cf_friend_management` tinyint(4) NOT NULL default '1',
                  `cf_memo_no_reply` tinyint(4) NOT NULL default '0',
                  `cf_memo_notice_board` varchar(255) default NULL,
                  `cf_memo_notice_memo` text default NULL,
                  `cf_memo_before_after` tinyint(4) NOT NULL,
                  `cf_memo_print` tinyint(4) NOT NULL,
                  `cf_memo_b4_resize` tinyint(4) NOT NULL,
                  `cf_memo_realtime` tinyint(4) NOT NULL,
                  `cf_memo_mb_name` tinyint(4) NOT NULL
                ) 
        ";
        sql_query($cml);
        
        if (!$cf_memo_page_rows)        $cf_memo_page_rows = 20;
        if (!$cf_memo_del_unread)       $cf_memo_del_unread = 180;
        if (!$cf_memo_del_trash)        $cf_memo_del_trash = 7;
        if (!$cf_memo_delete_datetime)  $cf_memo_delete_datetime = '0000-00-00 00:00:00';
        if (!$cf_memo_user_dhtml)       $cf_memo_user_dhtml = 1;
        if (!$cf_memo_use_file)         $cf_memo_use_file = 0;
        if (!$cf_memo_file_size)        $cf_memo_file_size = "4";
        if (!$cf_max_memo_file_size)    $cf_max_memo_file_size = "0";
        if (!$cf_friend_management)     $cf_friend_management = 0;
        if (!$cf_memo_notice_board)     $cf_memo_notice_board = 0;
        if (!$cf_memo_before_after)     $cf_memo_before_after = 0;
        if (!$cf_memo_print)            $cf_memo_print = 1;
        if (!$cf_memo_b4_resize)        $cf_memo_b4_resize = 1;
        if (!$cf_memo_realtime)         $cf_memo_realtime = 1;
        if (!$cf_memo_mb_name)          $cf_memo_realtime = 0;

        $sql2 = "
                 INSERT INTO `$g4[memo_config_table]` 
                   set  `cf_memo_page_rows` = '$cf_memo_page_rows', 
                        `cf_memo_del_unread` = '$cf_memo_del_unread', 
                        `cf_memo_del_trash` = '$cf_memo_del_trash', 
                        `cf_memo_delete_datetime` = '$cf_memo_delete_datetime', 
                        `cf_memo_user_dhtml` = '$cf_memo_user_dhtml', 
                        `cf_memo_use_file` = '$cf_memo_use_file', 
                        `cf_memo_file_size` = '$cf_memo_file_size', 
                        `cf_max_memo_file_size` = '$cf_max_memo_file_size', 
                        `cf_friend_management` = '$cf_friend_management', 
                        `cf_memo_notice_board` = '$cf_memo_notice_board', 
                        `cf_memo_before_after` = '$cf_memo_before_after', 
                        `cf_memo_print` = '$cf_memo_print', 
                        `cf_memo_realtime` = '$cf_memo_realtime', 
                        `cf_memo_mb_name` = '$cf_memo_mb_name'
                  ";
        sql_query($sql2);
        
        // update 명령을 한번 더 수행
        sql_query($sql);
    }
}

alert("쪽지 설정을 저장 하였습니다.", "./memo.php?kind=memo_config");
?>
