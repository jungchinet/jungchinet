<?
$sub_menu = "200100";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

if ($is_admin != "super")
    alert("게시판 삭제는 최고관리자만 가능합니다.");

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
		$k = $_POST[chk][$i];
    $j = $_POST[chk][$i]+1;

  	$groupName = "groupName_".$k;
    $sql = " update $g4[member_group_table]
                set gl_name = '$groupName_[$k]'
              where gl_id = '{$_POST[gl_id][$j]}' ";
    sql_query($sql);
}

goto_url("./memberGroup_list.php");
?>
