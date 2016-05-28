<?
$sub_menu = "200500";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

if ($is_admin != "super")
    alert("사용자그룹 삭제는 최고관리자만 가능합니다.");
    
check_token();

// 사용자 그룹 삭제
sql_query(" delete from $g4[user_group_table] where ug_id = '$gr_id' ");

// 사용자 그룹 회원 정보 초기화 
sql_query(" update $g4[member_table] set ug_id = '' where ug_id = '$gr_id' ");

goto_url("ug_list.php?$qstr");
?>
