<?
$sub_menu = "300200";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    // 불당팩 - $gr_use_search에 값을 하위 게시판에 반영
    $gr_id = $_POST[gr_id][$k];
    $gr_old = sql_fetch(" select * from $g4[group_table] where gr_id = '$gr_id' ");
    if ($gr_old[gr_use_search] != $_POST[gr_use_search][$k]) {
        $sql = " update $g4[board_table] set bo_use_search = '{$_POST[gr_use_search][$k]}' where gr_id = '$gr_id' ";
        sql_query($sql);
    }
    
    $sql = " update $g4[group_table]
                set gr_subject    = '{$_POST[gr_subject][$k]}',
                    gr_admin      = '{$_POST[gr_admin][$k]}',
                    gr_use_access = '{$_POST[gr_use_access][$k]}',
                    gr_use_search = '{$_POST[gr_use_search][$k]}',
                    gr_order_search = '{$_POST[gr_order_search][$k]}'
              where gr_id         = '{$_POST[gr_id][$k]}' ";
    if ($is_admin != "super")
        $sql .= " and gr_admin    = '{$_POST[gr_admin][$k]}' ";
    sql_query($sql);
}

goto_url("./boardgroup_list.php?$qstr");
?>
