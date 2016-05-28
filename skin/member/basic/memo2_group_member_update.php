<?
include_once("./_common.php");
include_once("$g4[path]/memo.config.php");

$gr_mb_id   = $_POST[gr_mb_id];
$gr_id      = $_POST[gr_id];

$row = get_member($gr_mb_id);

if ((!$row[mb_id] || $row[mb_leave_date] || $row[mb_intercept_date]) && !$is_admin) {
    alert("회원아이디 \'".$gr_mb_id."\' 은(는) 존재(또는 정보공개)하지 않는 회원아이디 이거나 탈퇴, 접근차단된 회원아이디 입니다.\\n\\n그룹에 추가할 수 없습니다.");
}
  
$sql = " select count(*) as cnt from $g4[memo_group_member_table] where gr_id = '$gr_id' and gr_mb_id = '$gr_mb_id' ";
$result = sql_fetch($sql);
if ($result[cnt] > 0)
  alert("$gr_mb_id는 이미 등록된 아이디 입니다.");

$sql = " select count(*) as cnt from $g4[member_table] where mb_id = '$gr_mb_id' ";
$result = sql_fetch($sql);
if ($result[cnt] == 0)
  alert("$gr_mb_id는 등록되지 않은 회원 아이디 입니다.");

$sql = " insert $g4[memo_group_member_table] set gr_id = '$gr_id', gr_mb_id = '$gr_mb_id', gr_mb_datetime = now() ";
sql_query($sql, $error);

goto_url("$g4[bbs_path]/memo.php?kind=memo_group&gr_id=$gr_id");
?>
