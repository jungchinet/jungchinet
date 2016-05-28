<?php
$hxrw = $_SERVER['HTTP_X_REQUESTED_WITH'];
if(empty($hxrw) && strtolower($hxrw) == 'xmlhttprequest') exit('error');

include_once("./_common.php");

$q = $_GET['q'];
$max_id = $_GET['max_id'];

if( !trim($q) ) exit('error');

define('_CONSUMER_KEY_', 'BpatauE1Q0mHWNi8usKCdT3Rv');
define('_CONSUMER_SECRET_', 'OhsWhAHlMv9Zc2HkgT5bRSX7CpQdu864hHK3gHR59At4mbPIwK');
define('_ACCESS_TOKEN_', '2452601569-gRpTDQYMXrFXhQKPGHSdztVKH7vv07MKk3abBB7');
define('_ACCESS_TOKEN_SECRET_', 'QycCLmUZrLZsczwFvh1sK7u0KN4K6925o5rblkyjHQGej');

define('_LOAD_COUNT_', 50); // 최초 불러오는 갯수
define('_LOAD_COUNT_MORE_', 20); // 더보기로 불러오는 갯수

define('_RESULT_TYPE_', 'mixed'); // 최초 불러오는 방식
define('_RESULT_TYPE_MORE_', 'recent'); // 더보기로 불러오는 방식
/* mixed, recent, popular */


include $g4['path']."/twitter_search/twitteroauth/init.php";

$stx = $q;

if($max_id){
	$q.= '&max_id='.$max_id;
	$loadCount = _LOAD_COUNT_MORE_;
	$result_type = _RESULT_TYPE_MORE_;
}
else{
	$is_first = true;
	$loadCount = _LOAD_COUNT_;
	$result_type = _RESULT_TYPE_;
}

$loadCount = ($max_id)? _LOAD_COUNT_MORE : _LOAD_COUNT_;

$tweets = get_tweets($q, $loadCount, $result_type);

if(!$tweets['total_cnt']) {
	$result = json_encode(array('result'=>null));
	exit($result);
}

ob_start();

for($i=0; $i<$tweets['total_cnt']; $i++){
?>
<div class="twt_list_box" id="tweet_id_<?php echo $tweets['statuses'][$i]['id_str']?>">
	<div class="profile_pic">
		<span><a href="https://twitter.com/<?php echo $tweets['statuses'][$i]['user']['screen_name']?>" target="_blank"><img src="<?php echo $tweets['statuses'][$i]['user']['profile_image_url']?>"></a></span>
	</div>
	<div class="text_box">
		<div class="user">
			<span class="name"><a href="https://twitter.com/<?php echo $tweets['statuses'][$i]['user']['screen_name']?>" target="_blank"><?php echo $tweets['statuses'][$i]['user']['name']?></a></span>
			<?php if ($tweets['statuses'][$i]['user']['followers_count']>0){ ?>
			<span class="follower"><img src="<?php echo $g4['path']?>/twitter_search/img/icon_follower.png" alt="followers_count"> <?php echo number_format($tweets['statuses'][$i]['user']['followers_count'])?>명이 팔로우합니다.</span>
			<?php } ?>
		</div>
		<div class="text">
			<div class="content">
				<?php
				echo text_makeup($stx, $tweets['statuses'][$i]['text'], $tweets['statuses'][$i]['retweeted_status']);
				if($tweets['statuses'][$i]['entities']['media'][0]['type']=='photo'){
				?>
				<div class="photo lazyload-photo" data-src="<?php echo $tweets['statuses'][$i]['entities']['media'][0]['media_url']?>"></div>
				<?php }
				$expanded_url = $tweets['statuses'][$i]['entities']['urls'][0]['expanded_url'];
				if( (strstr($expanded_url, "youtu.be") || strstr($expanded_url, "youtube.com")) && !strstr($expanded_url, "channel") ){
				?>
				<p style="margin:5px 0; padding:0; font-weight:bold;"><i style="color:#e62117" class="fa fa-youtube-play fa-lg"></i> YouTube</p>
				<div class='lazyload-youtube' data-src="<?php echo $expanded_url?>"></div>
				<?php } ?>
			</div>
			<div class="info">
				<span class="src"><?php echo $tweets['statuses'][$i]['source']?></span>
				<span class="date"><?php echo chgdate($tweets['statuses'][$i]['created_at'])?></span>
				<span class="retweet"><i class="fa fa-retweet"></i> <?php echo $tweets['statuses'][$i]['retweet_count']?></span>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<?php
}
$result['result'] = 'success';
$result['first_id'] = $tweets['statuses'][0]['id_str'];
$result['body'] = ob_get_contents();
ob_end_clean();
$result['next_results'] = $tweets['search_metadata']['next_results'];
$tmp = parse_url($result['next_results']);
parse_str($tmp['query']);
$result['next_max_id'] = $max_id;
$response = json_encode($result);
echo $response;
