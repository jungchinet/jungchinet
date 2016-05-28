<?
$sub_menu = "200500";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

check_token();

if ($is_admin != "super")
    alert("회원 레벨관리는 최고관리자만 가능합니다.");
    
$g4[title] = "회원레벨관리";
include_once("./admin.head.php");

echo "<span id='ct'></span>";
include_once("./admin.tail.php");
flush();

// 레벨업할 목록을 준비 (최고 관리자 빼고는 모두 대상)
$sql = " select mb_id from $g4[member_table] where mb_id <> '$config[cf_admin]' ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    // 게시판 관리자를 레벨 대상에서 제외한다
    $bo = sql_fetch(" select count(*) as cnt from $g4[board_table] where bo_admin = '$row[mb_id]' ");
    // 그룹 관리자를 레벨 대상에서 제외한다
    $gr = sql_fetch(" select count(*) as cnt from $g4[group_table] where gr_admin = '$row[mb_id]' ");
    if ($bo[cnt] > 0 || $gr[cnt] > 0)
        ;
    else {
        member_level_up($row[mb_id]);
    }
}

echo "<script>document.getElementById('ct').innerHTML += '<a href=\'" . $g4[admin_path] . "/member_level_list.php\'>회원레벨관리로 이동하기</a>'</script>\n";
?>
