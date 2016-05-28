<?
$sub_menu = "200900";
include_once("./_common.php");

$w = $_POST['w'];
if ($w == 'u' || $w == 'd')
    check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

$po_subject = $_POST[po_subject];
$po_poll1   = $_POST[po_poll1];
$po_poll2   = $_POST[po_poll2];
$po_poll3   = $_POST[po_poll3];
$po_poll4   = $_POST[po_poll4];
$po_poll5   = $_POST[po_poll5];
$po_poll6   = $_POST[po_poll6];
$po_poll7   = $_POST[po_poll7];
$po_poll8   = $_POST[po_poll8];
$po_poll9   = $_POST[po_poll9];
$po_cnt1    = $_POST[po_cnt1];
$po_cnt2    = $_POST[po_cnt2];
$po_cnt3    = $_POST[po_cnt3];
$po_cnt4    = $_POST[po_cnt4];
$po_cnt5    = $_POST[po_cnt5];
$po_cnt6    = $_POST[po_cnt6];
$po_cnt7    = $_POST[po_cnt7];
$po_cnt8    = $_POST[po_cnt8];
$po_cnt9    = $_POST[po_cnt9];
$po_etc     = $_POST[po_etc]; 
$po_level   = $_POST[po_level];
$po_point   = $_POST[po_point];
$po_date    = $_POST[po_date];
$po_id      = $_POST[po_id];
$po_use_access = $_POST[po_use_access];
$po_summary = $_POST[po_summary];
$r1 = $_POST[r1];
$r2 = $_POST[r2];


if ($w == "") 
{
    $sql = " insert $g4[poll_table]
                    ( po_subject, po_poll1, po_poll2, po_poll3, po_poll4, po_poll5, po_poll6, po_poll7, po_poll8, po_poll9, po_cnt1, po_cnt2, po_cnt3, po_cnt4, po_cnt5, po_cnt6, po_cnt7, po_cnt8, po_cnt9, po_etc, po_level, po_etc_level, po_point, po_date, po_skin, po_end_date, po_use_access, po_summary, po_r1, po_r2 )
             values ( '$po_subject', '$po_poll1', '$po_poll2', '$po_poll3', '$po_poll4', '$po_poll5', '$po_poll6', '$po_poll7', '$po_poll8', '$po_poll9', '$po_cnt1', '$po_cnt2', '$po_cnt3', '$po_cnt4', '$po_cnt5', '$po_cnt6', '$po_cnt7', '$po_cnt8', '$po_cnt9', '$po_etc', '$po_level', '$po_etc_level', '$po_point', '$g4[time_ymdhis]', '$po_skin', '$po_end_date', 'po_use_access', '$po_summary', '$r1', '$r2' ) ";
    sql_query($sql);

    $po_id = mysql_insert_id();
} 
else if ($w == "u") 
{
    $sql = " update $g4[poll_table]
                set po_subject = '$po_subject',
                    po_poll1 = '$po_poll1',
                    po_poll2 = '$po_poll2',
                    po_poll3 = '$po_poll3',
                    po_poll4 = '$po_poll4',
                    po_poll5 = '$po_poll5',
                    po_poll6 = '$po_poll6',
                    po_poll7 = '$po_poll7',
                    po_poll8 = '$po_poll8',
                    po_poll9 = '$po_poll9',
                    po_cnt1 = '$po_cnt1',
                    po_cnt2 = '$po_cnt2',
                    po_cnt3 = '$po_cnt3',
                    po_cnt4 = '$po_cnt4',
                    po_cnt5 = '$po_cnt5',
                    po_cnt6 = '$po_cnt6',
                    po_cnt7 = '$po_cnt7',
                    po_cnt8 = '$po_cnt8',
                    po_cnt9 = '$po_cnt9',
                    po_etc  = '$po_etc',
                    po_skin = '$po_skin', 
                    po_end_date = '$po_end_date', 
                    po_level = '$po_level',
                    po_etc_level = '$po_etc_level',
                    po_point = '$po_point',
                    po_date = '$po_date',
                    po_use_access = '$po_use_access',
                    po_summary = '$po_summary',
                    po_r1 = '$r1',
                    po_r2 = '$r2'
              where po_id = '$po_id' ";
    $res = sql_query($sql, false);
    
    // 그누보드에 투표기능강화를 위한 필드 추가
    if (!$res) {
        $sql_db = " ALTER TABLE `$g4[poll_etc_table]` ADD `pc_password` VARCHAR( 255 ) NOT NULL ";
        $res = sql_query($sql_db, false);
        $sql_db = " ALTER TABLE `$g4[poll_table]` ADD `po_skin` VARCHAR( 255 ) NOT NULL ";
        $res = sql_query($sql_db, false);
        $sql_db = " ALTER TABLE `$g4[poll_table]` ADD `po_end_date` DATE NOT NULL ";
        $res = sql_query($sql_db, false);
        $sql_db = " ALTER TABLE `$g4[poll_table]` ADD `po_etc_level` TINYINT( 4 ) NOT NULL ";
        $res = sql_query($sql_db, false);
        $sql_db = " ALTER TABLE `$g4[poll_table]` ADD `po_use_access` TINYINT( 4 ) NOT NULL ; ";
        $res = sql_query($sql_db, false);
        $sql_db = " ALTER TABLE `$g4[poll_table]` ADD `po_summary` TEXT NOT NULL ; ";
        $res = sql_query($sql_db, false);     
        sql_query($sql);
    }
} 
else if ($w == "d") 
{
    $sql = " delete from $g4[poll_table] where po_id = '$po_id' ";
    sql_query($sql);

    $sql = " delete from $g4[poll_etc_table] where po_id = '$po_id' ";
    sql_query($sql);
}

// 가장 큰 투표번호를 기본환경설정에 저장하여 
// 투표번호를 넘겨주지 않았을 경우 
// 가장 큰 투표번호를 구해야 하는 쿼리를 대체한다
$row = sql_fetch(" select max(po_id) as max_po_id from $g4[poll_table] where po_use_access = 0 ");
sql_query(" update $g4[config_table] set cf_max_po_id = '$row[max_po_id]' ");

if ($w == "d")
    goto_url("./poll_list.php?$qstr");
else
    goto_url("./poll_form.php?w=u&po_id=$po_id&$qstr");
?>
