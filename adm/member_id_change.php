<?
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

// 변경할 id
$mb_id = "test3";
// 변경될 id (중복 id가 없는지는 관리자가 먼저 확인해야 합니다)
$to_id = "test30";  

// 주의 점
//
// 1. 확장 필드에 mb_id가 저장된 경우에는 phpMyAdmin에서 변경해야 합니다
// 2. 투표테이블의 mb_id는 업데이트 안합니다 (귀챦아서 프로그램 안했어요)
// 3. 로그인 테이블도 업데이트 안합니다. 어차피 지워질 정보니까요.
// 4. 변경할 아이디, 변경될 아이디 정보는 잘~~~ 입력하세요.

//
echo "회원 아이디 $mb_id를 $to_id로 변경합니다<BR>";

// 불당팩
if (file_exists("$g4[path]/memo.config.php"))
    include_once("$g4[path]/memo.config.php");

$sql = " select count(*) as cnt from $g4[member_table] where mb_id = '$mb_id' ";
$result = sql_fetch($sql);

if (!$result[cnt])
    alert ("변경할 아이디 $mb_id가 없습니다. 확인후 다시 수행해 주세요");

$sql = " select count(*) as cnt from $g4[member_table] where mb_id = '$to_id' ";
$result = sql_fetch($sql);

if ($result[cnt]) 
    alert ("변경된 아이디 $to_id는 이미 존재합니다. 확인후 다시 수행해 주세요");

// 그누보드 db 정보 변경 ---------------------------------------------------------------

// auth 테이블
$sql = " update $g4[auth_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 게시판 테이블 - bo_admin에 여러개의 아이디를 쓰는 경우에는 사용할 수 없습니다.
$sql = " update $g4[board_table] set bo_admin = '$to_id' where bo_admin = '$mb_id' ";
sql_query($sql, FALSE);

// 첨부파일 다운로드 테이블
$sql = " update $g4[board_file_table]_download set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 게시판 추천 테이블
$sql = " update $g4[board_good_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 최근글 테이블
$sql = " update $g4[board_new_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 최근글 테이블
$sql = " update $g4[board_new_table] set parent_mb_id = '$to_id' where parent_mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 친구 테이블
if ($g4[friend_table]) {
$sql = " update $g4[friend_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 그룹테이블 - gr_admin에 여러개의 아이디를 쓰는 경우에는 사용할 수 없습니다.
$sql = " update $g4[group_table] set gr_admin = '$to_id' where gr_admin = '$mb_id' ";
sql_query($sql, FALSE);

// 그룹회원 테이블
$sql = " update $g4[group_member_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - hidden_comment
if ($g4[hidden_comment_table]) {
$sql = " update $g4[hidden_comment_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 로그인 오류정보 테이블
if ($g4[login_fail_log_table]) {
$sql = " update $g4[login_fail_log_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 회원닉 테이블
if ($g4[mb_nick_table]) {
$sql = " update $g4[mb_nick_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 회원정보 테이블
$sql = " update $g4[member_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 회원레벨업 정보 테이블
if ($g4[member_level_history_table]) {
$sql = " update $g4[member_level_history_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 쪽지4 그룹
if ($g4[memo_group_table]) {
$sql = " update $g4[memo_group_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 쪽지4 그룹회원 테이블
if ($g4[memo_group_member_table]) {
$sql = " update $g4[memo_group_member_table] set gr_mb_id = '$to_id' where gr_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 쪽지4 테이블
if ($g4[memo_recv_table]) {

$sql = " update $g4[memo_notice_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_notice_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_notice_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_recv_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_recv_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_recv_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_send_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_send_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_send_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_save_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_save_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_save_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_temp_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_temp_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_temp_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_spam_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_spam_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_spam_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

$sql = " update $g4[memo_trash_table] set recv_mb_id = '$to_id' where recv_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_trash_table] set send_mb_id = '$to_id' where send_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[memo_trash_table] set memo_owner = '$to_id' where memo_owner = '$mb_id' ";
sql_query($sql, FALSE);

//쪽지4 - 첨부파일 디렉토리 이름변경
// 회원 아이콘 정보 변경
$mb_memo = "$g4[data_path]/memo2/$mb_id/";
$to_memo = "$g4[data_path]/memo2/$to_id/";
if (file_exists($mb_memo)) {
    rename($mb_icon, $to_memo);
}
}

// 불당팩 - 내가 방문한 테이블
if ($g4[my_board_table]) {
$sql = " update $g4[my_board_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 마이메뉴 테이블
if ($g4[my_menu_table]) {
$sql = " update $g4[my_menu_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 포인트 테이블
$sql = " update $g4[point_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 투표테이블의 mb_ids 필드는 복잡해서 ㅠ..ㅠ...

// 투표 - 기타의견 테이블
$sql = " update $g4[poll_etc_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 인기검색어 테이블 확장
$sql = " update $g4[popular_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 스크랩 테이블
$sql = " update $g4[scrap_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 스크랩 테이블 확장
$sql = " update $g4[scrap_table] set wr_mb_id = '$to_id' where wr_mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 불당팩 - 신고테이블
if ($g4[singo_table]) {
$sql = " update $g4[singo_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);
$sql = " update $g4[singo_table] set sg_mb_id = '$to_id' where sg_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 불당팩 - 사용자그룹 테이블 - ug_admin에 여러개의 아이디를 쓰는 경우에는 사용할 수 없습니다.
if ($g4[user_group_table]) {
$sql = " update $g4[user_group_table] set ug_mb_id = '$to_id' where ug_mb_id = '$mb_id' ";
sql_query($sql, FALSE);
}

// 게시판 테이블
$sql = " select bo_table from $g4[board_table] ";
$result = sql_query($sql);

while ($row=sql_fetch_array($result)) {
    $sql = " update $g4[write_prefix]$row[bo_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
    sql_query($sql, FALSE);
}

// 포인트경매 테이블 변경
$g4[point_tender_table] = $g4[table_prefix] . "auction_tender";     // 포인트경매
$sql = " update $g4[point_tender_table] set mb_id = '$to_id' where mb_id = '$mb_id' ";
sql_query($sql, FALSE);

// 회원 아이콘 정보 변경
$mb_icon = "$g4[data_path]/member/" . substr($mb_id ,0,2) . "/" . $mb_id;
$to_icon = "$g4[data_path]/member/" . substr($to_id ,0,2) . "/" . $to_id;
if (file_exists($mb_icon)) {
    rename($mb_icon, $to_icon);
}

echo "회원 아이디 변경이 완료 되었습니다<BR>";
?>
