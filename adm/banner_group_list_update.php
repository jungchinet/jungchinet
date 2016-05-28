<?
$sub_menu = "300910";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    // 그룹을 사용하지 않음으로 하면 배너들도 모두 사용하지 않음으로
    $bg_id = $_POST[bg_id][$k];
    if ($_POST[bg_use][$k] == 0) {
        $sql = " update $g4[banner_table] set bn_use = '0' where bg_id = '$bg_id' ";
        sql_query($sql);
    }

    $sql = " update $g4[banner_group_table]
                set bg_subject    = '{$_POST[bg_subject][$k]}',
                    bg_admin      = '{$_POST[bg_admin][$k]}',
                    bg_use        = '{$_POST[bg_use][$k]}',
                    bg_width      = '{$_POST[bg_width][$k]}',
                    bg_height     = '{$_POST[bg_height][$k]}'
              where bg_id         = '{$_POST[bg_id][$k]}' ";
    if ($is_admin != "super")
        $sql .= " and bg_admin    = '{$_POST[bg_admin][$k]}' ";
    sql_query($sql);
}

goto_url("./banner_group_list.php?$qstr");
?>
