<?php
/**
 * ix rolling tf template data parser
 * @author eyesonlyz@nate.com
 */
header("Content-Type:application/json; charset=utf-8");
$keyword = (!empty($_GET['keyword']))? $_GET['keyword']: "yu-na kim";
$count = (!empty($_GET['count']) && $_GET['count'] > 10)? $_GET['count']: 10;
$time = (empty($_GET['time']) || $_GET['time'] < 120)? 120:$_GET['time'];
$file = dirname(__FILE__) . "/cache/tf-".md5($keyword).".json"; /// data 디렉토리는 수동생성하세요
$_GET['no_cache'] = null;
if(empty($_GET['no_cache']) && file_exists($file)) {
	$ftime = filemtime($file);
	if($ftime + $time > time()) {
		$data = file_get_contents($file);
		if($data != '[]') {
			echo $data;
			return;
		}
	}
}

$rows = array();
$total = $count;
$count = ceil($count / 3);

$facebook = "https://graph.facebook.com/search?q=" . urlencode($keyword) . "&date_format=U&type=post&limit=" . $count;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $facebook);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$f = curl_exec($ch);
curl_close($ch);

$f = json_decode($f);
function getKey($row, $time)
{
	global $rows;
	if($time > 0) {
		while(!empty($rows[$time])) {
			++$time;
		}
	}
	return $time;
}

if(!empty($f) && !empty($f->data)) {
	foreach($f->data as $row) {
		$id = getKey($row, $row->created_time);
		$_row = new StdClass();
		$_row->id = $row->id;
		$_row->stype = 'y';
		if(isset($row->message)) {
			$_row->text = $row->message;
		} else {
			$_row->text = "notext";
		}
		$_row->created_at = "" . $row->created_time . "000";
		$_row->stype = 'f';
		$_row->profile_image_url = "http://graph.facebook.com/{$row->from->id}/picture";
		$_row->profile_href = "http://www.facebook.com/profile.php?id={$row->from->id}";
		$_row->from_user = $row->from->name;
		$_row->href = "javascript:void(0);";
		$rows[$id] = $_row;
	}
}

$total_facebook = count($rows);
$add_count = $count - $total_facebook;
if($add_count < 0) {
	$add_count = 0;
}
$twitter = "http://search.twitter.com/search.json?q=" . urlencode($keyword) . '&result_type=recent&rpp=' . ($count + $add_count);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $twitter);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$t = curl_exec($ch);
curl_close($ch);

$t = json_decode($t);
if(!empty($t) && !empty($t->results)) {
	foreach($t->results as $row) {
		$id = getKey($row, strtotime($row->created_at));
		$_row = new StdClass();
		$_row->id = $row->id_str;
		$_row->text = $row->text;
		$_row->created_at = "" . strtotime($row->created_at) . "000";
		$_row->stype = 't';
		$_row->profile_image_url = $row->profile_image_url;
		$_row->profile_href = "http://twitter.com/{$row->from_user}/status/{$row->id_str}";
		$_row->href = "http://twitter.com/{$row->from_user}/status/{$row->id_str}";
		$_row->from_user = "";
		$rows[$id] = $_row;
	}
}
krsort($rows);
$total_twitter = count($rows) - $total_facebook;

$add_count = $total - $total_twitter;
if($add_count < 0) {
	$add_count = 0;
}

///Yozm
$url = "https://apis.daum.net/yozm/v1_0/search/timeline.json?q=" . urlencode($keyword) . "&count=" . ($count + $add_count);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$f = curl_exec($ch);
curl_close($ch);

$json = json_decode($f);

foreach($json->msg_list as $row) {
	$id = getKey($row, strtotime($row->pub_date));
	$_row = new StdClass();
	$_row->stype = 'y';
	$_row->id = $row->msg_id;
	$_row->text = $row->html_text;
	$_row->created_at = strtotime($row->pub_date) . "000";
	$_row->profile_image_url = $row->user->profile_img_url;
	$_row->profile_href = "";
	$_row->from_user = $row->user->nickname;
	$_row->href = $row->permanent_url;
	$rows[$id] = $_row;
}

$results = array_values($rows);
$json = new StdClass();
$json->keyword = $keyword;
$json->total_twitter = $total_twitter;
$json->total_facebook = $total_facebook;

$json->tw_max_id = '';
$json->results = $results;

$json = json_encode($json);
echo $json;
if(empty($_GET['no_cache'])){
	//if(is_writable(dirname($file))){
		@file_put_contents($file, utf8_encode($json));
	//}
}