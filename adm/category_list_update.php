<?
$sub_menu = "400250";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $chk[$i];

    $ca_id = $_POST[ca_id][$k];
    $ca_subject = $_POST[ca_subject][$k];
    $ca_use = $_POST[ca_use][$k];
    $ca_order = $_POST[ca_order][$k];

    $sql = " update $g4[category_table]
                set 
                    ca_subject          = '$ca_subject',
                    ca_use              = '$ca_use',
                    ca_order            = '$ca_order'
              where ca_id               = '$ca_id' ";
    sql_query($sql);
}

goto_url("./category_list.php?$qstr");
?>
