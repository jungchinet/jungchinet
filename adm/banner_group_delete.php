<?
$sub_menu = "300910";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("게시판그룹 삭제는 최고관리자만 가능합니다.");

auth_check($auth[$sub_menu], "d");

check_token();

$bg_id = mysql_real_escape_string(trim($_POST['bg_id']));
$row = sql_fetch(" select count(*) as cnt from $g4[banner_table] where bg_id = '$bg_id' ");
if ($row[cnt])
    alert("이 그룹에 속한 배너가 존재하여 배너 그룹을 삭제할 수 없습니다.\\n\\n이 그룹에 속한 배너를 먼저 삭제하여 주십시오.", "./banner_list.php?sfl=bg_id&stx=$bg_id");


// 그룹 삭제
sql_query(" delete from $g4[banner_group_table] where bg_id = '$bg_id' ");

goto_url("banner_group_list.php?$qstr");
?>
