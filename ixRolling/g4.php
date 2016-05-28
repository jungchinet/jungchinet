<?php
/**
 * ix_rolling 그누보드 최근글 json
 * @charset utf8
 * @author eyesonlyz@nate.com
 * @version 1.0.1
 */

$g4_path = "../../g4"; //g4 경로
$g4_http_path = "/g4"; //http 절대경로로 설정한다
define('MAX_COUNT', 50); // 요청 최대 카운트수제한

// param 으로 설정
if (!empty($_GET['www']) && strpos($_GET['www'], '..') === false) {
    $_g4_path = $_SERVER['DOCUMENT_ROOT'] . $_GET['www'];
    if (is_dir($_g4_path) && is_file($_g4_path . '/common.php')) {
        $g4_path = $_g4_path;
        $g4_http_path = $_GET['www'];
    }
}

if (!(include_once("$g4_path/common.php"))) {
    header("HTTP/1.1 404 Not Found");
    header("X-message: Gnuboard4 not installed!");
    exit;
}
$charset = 'UTF-8';
if (!empty($_GET['charset'])) {
    $charset = strtoupper($_GET['charset']); /// UTF-8 || EUC-KR
}

if(empty($bo_table)){//@todo
	$new_table = $g4['write_prefix'].'board_new';
}
if (!empty($board) && is_array($board)) {
    if ($member['mb_level'] < $board['bo_list_level']) {
        header("HTTP/1.1 404 Not Found");
        header("X-message: board permission denied!");
    } else {
        header("Content-Type: application/json;charset=utf-8");
        $sql = "SELECT wr_id, wr_subject AS title, wr_content AS description, wr_datetime AS created_at,wr_name,mb_id FROM " . $write_table;
        $sql .= " WHERE wr_is_comment=0 ";
        if ($_GET['since_id'] > 0) {
            $sql .= " wr_id > " . mysql_real_escape_string($_GET['since_id']) . " ";
        }
        $count = 10;
        if (!empty($_GET['count']) && $_GET['count'] > 0) {
            $count = $_GET['count'];
        }
        if ($count > MAX_COUNT) {
            $count = MAX_COUNT;
        }
        $sql .= " ORDER BY wr_num LIMIT 0,$count";
        $result = mysql_query($sql);
        $rows = array("results" => array());
        while ($row = mysql_fetch_object($result)) {
            $row->title = strip_tags($row->title);
            $row->description = strip_tags($row->description);

            if ($charset && $charset !== 'UTF-8') {
                $row->title = mb_convert_encoding($row->title, 'UTF-8', $charset);
            }

            $row->date = date("r", strtotime($row->created_at));
            $row->author = array('name' => $row->wr_name);
            $row->img_url = $g4_http_path . '/data/member/' . substr(
                $row->mb_id,
                0,
                2
            ) . '/' . $row->mb_id . '.gif';
            $row->link = $g4['url'] . $g4_http_path . "/bbs/board.php?bo_table=$bo_table&wr_id=$row->wr_id";
            $row->timestamp = strtotime($row->created_at);
            if ($charset && $charset !== 'UTF-8') {
                $row->description = mb_convert_encoding($row->description, 'UTF-8', $charset);
            }
            $row->others = array('wr_id' => $row->wr_id);
            $rows["results"][] = $row;
        }
        echo json_encode($rows);
    }
} else {
    header("HTTP/1.1 404 Not Found");
    header("X-message: board not found!"); //jquery 1.5.x???
}
