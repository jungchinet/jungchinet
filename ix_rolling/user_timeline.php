<?php
/**
 * ix_rolling twitter cache
 */

/**
 * @param string $screen_name Twitter screen_name
 * @param int $count Item count
 */
function user_timeline_cache($screen_name, $count = 10)
{
	if (extension_loaded('curl')) {
		define("IX_TWITTER_CACHE_DIR", dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache');
		define('IX_TWITTER_CHECK_MIN', 300); //300초마다 체크
		if (!is_writable(IX_TWITTER_CACHE_DIR)) {
			return;
		}
		$file = IX_TWITTER_CACHE_DIR . DIRECTORY_SEPARATOR . md5($screen_name) . '.json';
		$updated = false;
		$request_skip = false;
		if (is_file($file)) {
			$modify_time = filemtime($file);
			if ($modify_time && time() - $modify_time < IX_TWITTER_CHECK_MIN) {
				$request_skip = true;
			}
		}
		if (!$request_skip) {
			$url = "http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name={$screen_name}&count={$count}";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			curl_close($ch);
			$matches = array();
			if (preg_match('@X-RateLimit-Remaining: (\d+)@', $header, $matches)) {
				if (!empty($matches[1])) {
					$remaining = (int)$matches[1];
					if ($remaining > 0) {
						if (json_decode($body)) {
							if (!json_last_error()) {
								file_put_contents($file, trim($body));
								$updated = true;
								echo $body;
							}
						}
					}
				}
			}
		}
		if ($updated === false && is_file($file)) {
			readfile($file);
		}
	}
}

if (!empty($_GET['screen_name'])) {
	header('Content-Type: application/json; charset=utf-8');
	$count = 10;
	if (!empty($_GET['count']) && $_GET['count'] > 0) {
		$count = (int)$_GET['count'];
	}
	user_timeline_cache($_GET['screen_name']);
}