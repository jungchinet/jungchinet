<?
$sub_menu = "100600";
include_once("./_common.php");

check_demo();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", $g4[path]);

$g4[title] = "업그레이드";
if (!$g4[b4_upgrade]) include_once("./admin.head.php");

// 모든 게시판 그룹 정보를 가지고 옵니다.
$sql = " select * from $g4[group_table] where gr_use_access = '0' and gr_use_search = '1' ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {

    // 그룹에 속한 모든 게시판 정보를 가지고 옵니다
    $sql1 = " select * from $g4[board_table] where bo_use_search = '1' ";
    $result1 = sql_query($sql1);
    
    // 모든 게시글을 가지고 와서, 최신글을 만들어 줍니다 (날짜에 무관하게 무순으로 생성후 정렬을 합니다).
    for ($j=0; $row1=sql_fetch_array($result1); $j++) {
        $sql2 = " select * from $tmp_write_table ";
        $result2 = sql_query($sql2);
        // 최신글이 있는지를 확인
        $sql3 = " ";
        
        // 최신글이 없으면 넣어줍니다.
      
    }
}


if (!$g4[b4_upgrade]) include_once("./admin.tail.php");
?>
