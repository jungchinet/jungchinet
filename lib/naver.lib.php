<?php
if (!defined('_GNUBOARD_')) exit;

// 네이버 연관검색어
function naver_related($stx, $skin_dir="basic", $rows=10, $subject_len=16, $options="") {
    global $g4;

    if ($skin_dir)
        $popular_skin_path = "$g4[path]/skin/popular/$skin_dir";
    else
        $popular_skin_path = "$g4[path]/skin/popular/basic";

    $rows = (int) $rows;
    
    // 네이버는 10개만 나오니까
    if ($rows > 10 || $rows < 0) $rows = 10;

    $xmlurl = "http://openapi.naver.com/search?key=$g4[naver_api]&query=" . urlencode($stx) . "&target=recmd";
    $xml =simplexml_load_file($xmlurl);

    // 오류처리
    if ($xml->error_code) {
        ob_start();
        echo $xml->error_code . " : " . $xml->message;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    $list = array();
    for ($i=0; $i<$rows;$i++) {
        $k = $i + 1;
        $item = $xml->item->$i; 
        $item_i = iconv("UTF-8", $g4[charset], $item);
        $list[$i]['subject'] = cut_str($item_i, $subject_len);
        $list[$i]['href'] = "http://search.naver.com/search.naver?where=nexearch&query=" . urlencode($item_i) . "&sm=top_lve";
        //echo "<a href='" . $list[$i][href] . "' target=_blank'>" . $list[$i]['subject'] . "</a>";
    }

    $title = "$stx 연관검색어";

    ob_start();
    include "$popular_skin_path/latestbest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// 네이버 인기검색어
function naver_popular($skin_dir="basic", $rows=10, $title="네이버 인기검색어", $options="") {
    global $g4;

    if ($skin_dir)
        $popular_skin_path = "$g4[path]/skin/popular/$skin_dir";
    else
        $popular_skin_path = "$g4[path]/skin/popular/basic";

    $rows = (int) $rows;
    
    // 네이버는 10개만 나오니까
    if ($rows > 10 || $rows < 0) $rows = 10;

    $xml =simplexml_load_file("http://openapi.naver.com/search?key=$g4[naver_api]&query=nexearch&target=rank");

    $npop = array();
    for ($i=0; $i<$rows;$i++) {
        $k = $i + 1;
        $j = "R" . $k;
        $item = $xml->item->$j; 

        $k = $npop[$i]['K'] = iconv("UTF-8", $g4[charset], $item->K);
        $npop[$i]['S'] = iconv("UTF-8", $g4[charset], $item->S);
        $npop[$i]['V'] = (int) $item->V;
        $npop[$i]['LINK'] = "http://search.naver.com/search.naver?where=nexearch&query=" . urlencode($k) . "&sm=top_lve";
    }

    ob_start();
    include "$popular_skin_path/popular.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
?>
