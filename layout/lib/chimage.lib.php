<?
if (!defined('_GNUBOARD_')) exit;

// cheditor로 업로드한 이미지 가져오기
function chimage($skin_dir="", $bo_table, $wr_id=0, $rows=10)
{
    global $config, $g4;

    if ($wr_id == 0) {
        // 게시판의 chimage는 $rows 만큼 보여준다. 왜? 너무 많으니까.
        $sql = " select * from $g4[board_cheditor_table] where bo_table = '$bo_table' and and del = 0 and bc_type > 0 limit 0, $rows ";
    } else {
        // 게시글의 chimage는 다 보여주는게 원칙. 너무 많으면 가져가서 고민할 것.
        $sql = " select * from $g4[board_cheditor_table] where bo_table = '$bo_table' and wr_id='$wr_id' and del = 0 and bc_type > 0 ";
    }

    if ($skin_dir)
        $chimage_skin_path = "$g4[path]/chimage/connect/$skin_dir";
    else
        $chimage_skin_path = "$g4[path]/skin/chimage/basic";

    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
        $list[$i] = $row;

        // $img[src] 웹 상의 절대경로 이므로 이미지 파일의 상대경로를 구합니다.
        // 이렇게 잘라줘야 제대로 된 경로가 나온다.
        $fl = explode("/$g4[data]/",$row[bc_dir]);
        $rel_path = "../" . $g4[data] . "/" . $fl[1];

        $list[$i]['image_path'] = $rel_path . "/" . $row['bc_file'];
    }

    ob_start();
    include_once ("$chimage_skin_path/chimage.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
