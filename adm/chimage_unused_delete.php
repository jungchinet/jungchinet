<?
$sub_menu = "300810";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "d");

check_token();

//print_r2($_POST);

for ($i=0; $i<count($chk); $i++) {
    // 실제 번호를 넘김
    $k = $_POST[chk][$i];

    $bc_now = $bc_id[$k];
    
    // 이미지 정보를 읽어 온다
    $bc = sql_fetch(" select * from $g4[board_cheditor_table] where bc_id = '$bc_now' ");

    // $img[src] 웹 상의 절대경로 이므로 이미지 파일의 상대경로를 구합니다.
    // 이렇게 잘라줘야 제대로 된 경로가 나온다.
    $fl = explode("/$g4[data]/",$bc[bc_dir]);
    $rel_path = "../" . $g4[data] . "/" . $fl[1];

    $img_link = $rel_path . "/" . $bc[bc_file];

    // 백업으로 넣어둘 디렉토리. 끝이 _delete로 끝난다.
    $img_bkup = $rel_path . "_delete";
    if (!file_exists("$img_bkup")) {
        @mkdir($img_bkup, 0707);
        @chmod($img_bkup, 0707);
    }
    $bkup_link = $img_bkup . "/" . $bc[bc_file];
    
    // 이미지를 백업 받는다
    rename("$img_link", "$bkup_link");

    // 이미지 정보를 지운다
    $sql = " delete from $g4[board_cheditor_table] where bc_id = '$bc_now' ";
    sql_query($sql);
}

goto_url("chimage_unused_list.php?$qstr");
?>
