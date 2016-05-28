<?php
if (!defined('_GNUBOARD_')) exit;

// 다음 소셜픽
function daum_social($skin_dir="basic", $rows=10, $subject_len=16, $category="e", $options="") {
    global $g4;

    if ($skin_dir)
        $popular_skin_path = "$g4[path]/skin/popular/$skin_dir";
    else
        $popular_skin_path = "$g4[path]/skin/popular/basic";

    $rows = (int) $rows;

    // c: 시사, s: 스포츠, e: 연예
    $xmlurl = "http://apis.daum.net/socialpick/search?category=$category&n=$rows";
    $xml =simplexml_load_file($xmlurl);

    // 오류처리
    /*
    if ($xml->dmessage) {
        ob_start();
        echo $xml->code . " : " . $xml->message;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    */

    $list = array();
    for ($i=0; $i<$rows;$i++) {
        $k = $i + 1;
        $item = $xml->item->$i; 

        $list[$i]['subject'] = cut_str(iconv("UTF-8", $g4[charset], $item->keyword), $subject_len);
        $list[$i]['href'] = $item->link;
    }

    $title = "다음 소셜픽";

    ob_start();
    include "$popular_skin_path/popular.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
