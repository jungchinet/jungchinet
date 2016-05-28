<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

// 과잉 index를 제거 합니다.
sql_query(" ALTER TABLE `$g4[board_file_table]` DROP INDEX `bf_datetime`  ", FALSE);
sql_query(" ALTER TABLE `$g4[board_file_download_table]` DROP INDEX `dn_datetime`  ", FALSE);
sql_query(" ALTER TABLE `$g4[board_new_table]` DROP INDEX `my_datetime` ", FALSE);
sql_query(" ALTER TABLE `$g4[friend_table]` DROP INDEX `fr_datetime` ", FALSE);
sql_query(" ALTER TABLE `$g4[login_table]` DROP INDEX `lo_datetime` ", FALSE);
sql_query(" ALTER TABLE `$g4[member_table]` DROP INDEX `mb_today_login` ", FALSE);
sql_query(" ALTER TABLE `$g4[memo_recv_table]` DROP INDEX `datetime` , ADD INDEX `datetime` (`me_send_datetime`) ", FALSE);
sql_query(" ALTER TABLE `$g4[memo_send_table]` DROP INDEX `datetime` , ADD INDEX `datetime` (`me_send_datetime`) ", FALSE);
sql_query(" ALTER TABLE `$g4[memo_save_table]` DROP INDEX `datetime` , ADD INDEX `datetime` (`me_send_datetime`) ", FALSE);
sql_query(" ALTER TABLE `$g4[memo_trash_table]` DROP INDEX `datetime` , ADD INDEX `datetime` (`me_send_datetime`) ", FALSE);
sql_query(" ALTER TABLE `$g4[session_table]` DROP INDEX `sd_datetime` ", FALSE);

sql_query(" ALTER TABLE `$g4]my_board_table]` DROP INDEX `mb_id`, ADD INDEX `mb_id` (`mb_id`) ", FALSE);
sql_query(" ALTER TABLE `$g4[session_table]` DROP INDEX `se_datetime` ", FALSE);

// 게시판의 wr_hit, wr_datetime 인덱스를 제거. 건수가 많으면 보틀넥이 됩니다.
$sql = " select * from $g4[board_table] ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

    $tmp_write_table = $g4['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름

    $sql1 = " ALTER TABLE $tmp_write_table DROP INDEX `wr_hit` ";
    sql_query($sql1, FALSE);

    $sql2 = " ALTER TABLE $tmp_write_table DROP INDEX `wr_datetime` ";
    sql_query($sql2, FALSE);

    echo "<BR>" . $i . " : " . $row[bo_table] . "의 인덱스를 업데이트 했습니다 <br>";
}

echo "<br>인덱스 조정 UPGRADE 완료.";

if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
