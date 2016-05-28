<?
$sub_menu = "300200";
include_once("./_common.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $gr_id))
    alert("그룹 ID는 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)");

if (!$gr_subject) alert("그룹 제목을 입력하세요.");

check_token();

$gr_subject      = $_POST[gr_subject];
$gr_admin        = $_POST[gr_admin];  
$gr_use_access   = $_POST[gr_use_access];
$gr_use_search   = $_POST[gr_use_search];
$gr_order_search = $_POST[gr_order_search];
$gr_1_subj       = $_POST[gr_1_subj];
$gr_2_subj       = $_POST[gr_2_subj];
$gr_3_subj       = $_POST[gr_3_subj];
$gr_4_subj       = $_POST[gr_4_subj];
$gr_5_subj       = $_POST[gr_5_subj];
$gr_6_subj       = $_POST[gr_6_subj];
$gr_7_subj       = $_POST[gr_7_subj];
$gr_8_subj       = $_POST[gr_8_subj];
$gr_9_subj       = $_POST[gr_9_subj];
$gr_10_subj      = $_POST[gr_10_subj];
$gr_1            = $_POST[gr_1];
$gr_2            = $_POST[gr_2];
$gr_3            = $_POST[gr_3];
$gr_4            = $_POST[gr_4];
$gr_5            = $_POST[gr_5];
$gr_6            = $_POST[gr_6];
$gr_7            = $_POST[gr_7];
$gr_8            = $_POST[gr_8];
$gr_9            = $_POST[gr_9];
$gr_10           = $_POST[gr_10];
                
$sql_common = " gr_subject      = '$gr_subject',
                gr_admin        = '$gr_admin',  
                gr_use_access   = '$gr_use_access',
                gr_use_search   = '$gr_use_search',
                gr_order_search = '$gr_order_search',
                gr_1_subj       = '$gr_1_subj',
                gr_2_subj       = '$gr_2_subj',
                gr_3_subj       = '$gr_3_subj',
                gr_4_subj       = '$gr_4_subj',
                gr_5_subj       = '$gr_5_subj',
                gr_6_subj       = '$gr_6_subj',
                gr_7_subj       = '$gr_7_subj',
                gr_8_subj       = '$gr_8_subj',
                gr_9_subj       = '$gr_9_subj',
                gr_10_subj      = '$gr_10_subj',
                gr_1            = '$gr_1',
                gr_2            = '$gr_2',
                gr_3            = '$gr_3',
                gr_4            = '$gr_4',
                gr_5            = '$gr_5',
                gr_6            = '$gr_6',
                gr_7            = '$gr_7',
                gr_8            = '$gr_8',
                gr_9            = '$gr_9',
                gr_10           = '$gr_10'
                ";

if ($w == "") 
{
    $sql = " select count(*) as cnt from $g4[group_table] where gr_id = '$gr_id' ";
    $row = sql_fetch($sql);
    if ($row[cnt]) 
        alert("이미 존재하는 그룹 ID 입니다.");

    $sql = " insert into $g4[group_table]
                set gr_id = '$gr_id',
                    $sql_common ";
    sql_query($sql);
} 
else if ($w == "u") 
{
    // 불당팩 - $gr_use_search에 값을 하위 게시판에 반영
    $gr_old = sql_fetch(" select * from $g4[group_table] where gr_id = '$gr_id' ");
    if ($gr_old[gr_use_search] != $gr_use_search) {
        $sql = " update $g4[board_table] set bo_use_search = '$gr_use_search' where gr_id = '$gr_id' ";
        sql_query($sql);
    }

    $sql = " update $g4[group_table]
                set $sql_common
              where gr_id = '$gr_id' ";
    sql_query($sql);
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

goto_url("./boardgroup_form.php?w=u&gr_id=$gr_id&$qstr");
?>
