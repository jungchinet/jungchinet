<?php
/**
 * ix_rolling 그누보드 최근글 json
 * @charset utf8
 * @author eyesonlyz@nate.com
 */

$g4_path = "..";
// common.php 의 상대 경로
if(!(include_once ("$g4_path/common.php"))){
	header("HTTP/1.1 404 Not Found");
	header("X-message: Gnuboard4 not installed!");
	exit;
}
$charset = !empty($_GET['euckr']);
if(!empty($board) && is_array($board)) {
	if($member['mb_level'] < $board['bo_list_level']) {
		header("HTTP/1.1 404 Not Found");
		header("X-message: board permission denied!");
	} else {
		header("Content-Type: application/json;charset=utf-8");
		$sql = "SELECT wr_id, wr_subject AS text, wr_datetime AS created_at FROM " . $write_table;
		$sql .= " WHERE wr_is_comment=0 ";
		if($_GET['since_id'] > 0) {
			$sql .= " wr_id > " . mysql_real_escape_string($_GET['since_id']) . " ";
		}
		$sql .= " ORDER BY wr_num LIMIT 0,10";
		$result = mysql_query($sql);
		$rows = array("results" => array());
		while($row = mysql_fetch_object($result)) {
			$row->text = strip_tags($row->text);
			$row->profile_image_url = '';
			$row->href = $g4['url'] . "/bbs/board.php?bo_table=$bo_table&wr_id=$row->wr_id";
			$row->from_user = '';
			$row->id = $row->wr_id;
			$row->created_at = date("r", strtotime($row->created_at));
			if($charset) {
				$row->text = mb_convert_encoding($row->text, 'UTF-8', 'EUC-KR');
			}
			$rows["results"][] = $row;
		}
		echo json_encode($rows);
	}
} else {
	header("HTTP/1.1 404 Not Found");
	header("X-message: board not found!");//jquery 1.5.x???
}
