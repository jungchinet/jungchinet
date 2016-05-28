<?php
/**
 * ix rolling xml parser
 * @author eyesonlyz@nate.com
 * 
 */
if(!function_exists('simplexml_load_string')){
	header("HTTP/1.1 500 Internal Server Error");
	header("X-message: simplexml not supported!");
	exit;
}
if(!function_exists('curl_init')){
	header("HTTP/1.1 500 Internal Server Error");
	header("X-message: curl not supported!");
	exit;
}
if(empty($_GET['xml'])){
	header("HTTP/1.1 400 Bad Request");
	header("X-message: simplexml not supported!");
	exit;
}

$url = $_GET['xml'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$f = curl_exec($ch);
curl_close($ch);
if(!empty($f)){
	
	$is_twitter = false;
	$is_facebook = false;
	$id = false;
	if(strpos($url,'http://twitter.com')!==false){
		$is_twitter = true;
	}
	if(strpos($url,'https://www.facebook.com')!==false){
		$is_facebook = true;
		if(preg_match('#id=(\d+)#',$url,$matches)){
			if(!empty($matches[1])){
				$id = $matches[1];
			}
		}
	}
	//echo '<pre>';
	//echo htmlspecialchars($f);
	$xml = @simplexml_load_string($f);
	if($xml){
		$ns = $xml->getDocNamespaces();
		$atom10 = false;
		$rss20 = false;
		if(in_array('http://www.w3.org/2005/Atom',$ns)){
			$atom10 = true;
		}else{
			$attrs = $xml->attributes();
			if($attrs['version']=='2.0'){
				$rss20 = true;
			}
		}
		$json = array();
		$data = array();
		if($rss20){
			$json['title'] = (string) $xml->channel->title;
			$json['link'] = (string) $xml->channel->link;
			$json['description'] = (string) $xml->channel->link;
			if($xml->channel->lastBuildDate){
				$json['last_update'] = strtotime((string) $xml->channel->lastBuildDate);
			}else{
				$json['last_update'] = null;
			}
			$json['data'] = array();
			if(!empty($xml->channel->item)){
				foreach($xml->channel->item as $item){
					$row = new StdClass;
					$row->title = (string) $item->title;
					$row->href = (string) $item->link;
					$description = (string) $item->description;
					if($description){
						$matches = array();
						if(preg_match('/<img[^>]*src*=*["\']?([^"\'\s>]*)/i',$description,$matches)){
							if(!empty($matches[1])){
								$row->profile_image_url = $matches[1];
							}
						}
					}
					$row->text = strip_tags((string) $item->description);
					if($item->pubDate){
						$created_at = strtotime((string) $item->pubDate);
						if($created_at){
							$row->created_at = date("r", $created_at);
						}
					}else{
						$created_at = strtotime((string) $item->children('http://purl.org/dc/elements/1.1/')->date);
						if($created_at){
							$row->created_at = date("r", $created_at);
						}
					}
					$row->id = $created_at;
					$row->from_user = (string) $item->author;
					if($id && empty($row->profile_image_url)){
						$row->profile_image_url = "http://graph.facebook.com/".$id."/picture";
					}
					$data[] = $row;
				}
			}
			$json['data'] = $data;
		}else if($atom10){
			$json['title'] = (string) $xml->title;
			$json['link'] = (string) $xml->link['href'];
			if($xml->updated){
				$json['last_update'] = strtotime((string) $xml->updated);
			}else{
				$json['last_update'] = null;
			}
			if($xml->logo){
				//$json['logo'] = (string) $xml->logo;
			}
			$json['data'] = array();
			if(!empty($xml->entry)){
				foreach($xml->entry as $item){
					$row = new StdClass;
					$row->title = (string) $item->title;
					$row->href = (string) $item->link['href'];
					if($item->content['type']=='xhtml'){
						$description = (string) $item->content->asXML();
					}else{
						$description = (string) $item->content;
					}
					if($description){
						$matches = array();
						if(preg_match('/< *img[^>]*src *= *["\']?([^"\'\s]*)/i',$description,$matches)){
							if(!empty($matches[1])){
								$row->profile_image_url = $matches[1];
							}
						}
					}
					$row->text = strip_tags($description);
					if($item->published){
						$created_at = strtotime((string) $item->published);
						if($created_at){
							$row->created_at = date("r", $created_at);
						}
					}else if($item->updated){
						$created_at = strtotime((string) $item->updated);
						if($created_at){
							$row->created_at = date("r", $created_at);
						}
					}
					$row->id = $created_at;
					$row->from_user = (string) $item->id;
					if($id && empty($row->profile_image_url)){
						$row->profile_image_url = "http://graph.facebook.com/".$id."/picture";
					}
					$data[] = $row;
				}
			}
			$json['data'] = $data;
		}
		echo json_encode($json);
	}
}