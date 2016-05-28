<?php
header("Content-Type: application/json");
$rows = array();
if(!empty($_GET['where_id']) && !empty($_GET['callback'])){
	$url = "https://www.facebook.com/feeds/page.php?format=json&id=".$_GET['where_id'].'&date_format=U';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	$json = curl_exec($ch);
	$json = json_decode($json);
	foreach($json->entries as &$entry){
		$entry->created_at = strtotime($entry->published);
		$entry->content = strip_tags($entry->content);
	}
	curl_close($ch);
	echo $_GET['callback'].'('.json_encode($json).');';
}
