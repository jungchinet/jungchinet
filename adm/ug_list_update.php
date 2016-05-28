<?
$sub_menu = "200500";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    $gr_subject = $_POST[gr_subject][$k];
    $gr_admin = $_POST[gr_admin][$k];
    $gr_id = $_POST[gr_id][$k];
    $sql = " update $g4[user_group_table]
                set ug_subject = '$gr_subject',
                    ug_admin = '$gr_admin'
              where ug_id = '$gr_id' ";
    if ($is_admin != "super")
        $sql .= " and gr_admin = '$gr_admin' ";
    sql_query($sql);
}

goto_url("./ug_list.php?$qstr");
?>
