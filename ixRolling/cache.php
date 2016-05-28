<?php
/**
 * ixr (ix rolling) cache module
 * @author eyesonlyz@nate.com
 * @require php 5.x http://php.net
 * @require curl http://php.net/curl
 * @version 1.2
 */

// 트위터 설정
define('OAUTH_CONSUMER_KEY', 'Z0pVJGySRKlZCDnp6BYhfAD9E'); ///< 수정하세요
define('OAUTH_CONSUMER_SECRET', 'XLa1uS3z8bv8rCbqNfoK3D31fGTtzb1y1JV4NA0FFs1VCxxPs8'); ///< 수정하세요
define('OAUTH_ACCESS_TOKEN', '75257164-vkwqUANcY4i0vQxVIedC52D2NY7Fa4rE7TfjEKakU'); ///< 수정하세요
define('OAUTH_ACCESS_TOKEN_SECRET', 'VUZXcIPGnbNjw7BkVaxtNq8oWYskMYkLgzBdwugyZXLev'); ///< 수정하세요


// 페이스북 설정
define('FACEBOOK_APP_ID', '647172948688562');
define('FACEBOOK_APP_SECRET', '26664ea4d7b11c31101eaa5497e0c69a');



define('IXR_CACHE_DIR', dirname(__FILE__) . '/cache'); //< 원하시는 캐쉬디렉토리 경로로 변경하실 수 있습니다

header("Content-Type: application/json; charset=utf-8");
define('IXR_MIN_SYNC_SECOND', 60);
if (!is_dir(IXR_CACHE_DIR)) {
	if (is_writable(dirname(IXR_CACHE_DIR))) {
		mkdir(IXR_CACHE_DIR);
	} else {
		header("HTTP/1.1 500 Internal Server Error");
		echo '{}';
		return;
	}
}
if (!is_writable(IXR_CACHE_DIR)) {
	header("HTTP/1.1 500 Internal Server Error");
	echo '{}';
	return;
}
if (!extension_loaded('curl') || !function_exists('json_encode')) {
	header("HTTP/1.1 501 Not Implemented");
	echo '{}';
	return;
}

if (!empty($_GET['provider']) && is_array($_GET['provider'])) {
	$cache = new IXR_Cache($_GET['provider']);
	$cache->render();
}


class IXR_Cache
{
	protected $provider;
	protected $key;

	/**
	 * 선언된 url 요청만 캐쉬할 수 있습니다.
	 * @var array
	 */
	protected $allow_url = array(
		'twitter' => array(
			'https://api.twitter.com/1.1/statuses/user_timeline.json?',
			'https://api.twitter.com/1.1/search/tweets.json?'
		),
		'youtube' => array(
			'https://gdata.youtube.com/',
			'http://gdata.youtube.com/'
		),
		'facebook' => array(
			'https://graph.facebook.com/search?',
			'http://graph.facebook.com/search?',
			'https://www.facebook.com/feeds/page.php?',
			'http://www.facebook.com/feeds/page.php?',
			'http://query.yahooapis.com/v1/public/yql?'
		),
		'yozm' => array('https://apis.daum.net/yozm/v1_0/search/timeline.json?'),
		'me2day' => array(
			'http://me2day.net/search.json?',
			'http://me2day.net/api/get_posts/'
		),
		'feed' => array('http://query.yahooapis.com/v1/public/yql?')
	);

	public function __construct($provider)
	{
		$this->provider = $provider;
		if (empty($this->provider['provider_name']) && !empty($this->provider['service'])) {
			$this->provider['provider_name'] = $this->provider['service'];
		}
		if (empty($this->provider['sync_second']) || $this->provider['sync_second'] < 300) {
			$this->provider['sync_second'] = 60 * 5;
		}

		if (empty($this->provider['key'])) {
			exit;
		}

		$this->key = md5($this->provider['provider_name'] . $this->provider['key']);
		$this->filename = IXR_CACHE_DIR . '/' . $this->key . '.json';
		$this->tmp_file = $this->filename . '.tmp';

		if ($this->provider['ajax']['dataType'] === 'jsonp') {
			$this->provider['url'] .= '&callback=jQuery' . $this->key . time();
		}
	}

	function get_data($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$t = @curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
			$t = false;
		}
		if (curl_errno($ch) !== 0) {
			$t = false;
		}
		curl_close($ch);
		return $t;
	}

	function _default_provider($provider)
	{
		if ($provider['provider_name'] === 'twitter') {
			$urls = parse_url($provider['url']);
			$method = 'GET';
			$query = array();
			parse_str($urls['query'], $query);
			if (isset($query['callback'])) {
				unset($query['callback']);
			}
			$oauth = array(
				'oauth_consumer_key' => OAUTH_CONSUMER_KEY,
				'oauth_token' => OAUTH_ACCESS_TOKEN,
				'oauth_nonce' => md5(microtime() . rand()),
				'oauth_timestamp' => time(),
				'oauth_signature_method' => 'HMAC-SHA1',
				'oauth_version' => '1.0'
			);

			$oauth = array_map("rawurlencode", $oauth);
			$query = array_map("rawurlencode", $query);

			$arr = array_merge($oauth, $query);
			asort($arr);
			ksort($arr);
			$querystring = http_build_query($arr, '', '&');

			$url = $urls['scheme'] . '://' . $urls['host'] . $urls['path'];
			$base_string = $method . "&" . rawurlencode($url) . "&" . rawurlencode($querystring);
			$key = rawurlencode(OAUTH_CONSUMER_SECRET) . "&" . rawurlencode(OAUTH_ACCESS_TOKEN_SECRET);
			$signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));
			$url .= "?" . http_build_query($query);

			$oauth['oauth_signature'] = $signature;
			ksort($oauth);
			foreach ($oauth as $k => $v) {
				$oauth[$k] = '"' . $v . '"';
			}
			$headers = array();
			$headers[] = "Authorization: OAuth " . urldecode(http_build_query($oauth, '', ', '));
			$options = array(
				CURLOPT_TIMEOUT => 3,
				CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
				CURLOPT_HEADER => false,
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
			);

			if ($urls['scheme'] === 'https') {
				$options[CURLOPT_SSL_VERIFYPEER] = 0;
				$options[CURLOPT_SSL_VERIFYHOST] = 0;
			}
			$options[CURLOPT_HTTPHEADER] = $headers;
			$ch = curl_init();
			curl_setopt_array($ch, $options);
			$data = curl_exec($ch);
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
				$data = false;
			}
			curl_close($ch);
		} else if($provider['provider_name'] === 'facebook'){
			$_url = "https://graph.facebook.com/oauth/access_token?client_id=".FACEBOOK_APP_ID."&client_secret=".FACEBOOK_APP_SECRET."&grant_type=client_credentials";
			$_token = $this->get_data($_url);
			$_vars = array();
			parse_str($_token,$_vars);
			if(!empty($_vars['access_token'])){
				$data = $this->get_data($provider['url'].'&access_token='.$_vars['access_token']);
			}else{
				$data = '{}';
			}
		} else {
			$data = $this->get_data($provider['url']);
		}
		if ($data) {
			if ($data[0] !== '[' && $data[0] !== '{') {
				$spos = strpos($data, '(') + 1;
				$epos = strrpos($data, ')') - $spos;
				$json_data = substr($data, $spos, $epos);
			} else {
				$json_data = $data;
			}
			$json = json_decode($json_data);
			if (!empty($json)) {
				$json = json_encode($json);
				@file_put_contents($this->filename, $json);
				return $json;
			}
		}

		return '{}';
	}

	function provider_twitter($provider)
	{
		return $this->_default_provider($provider);
	}

	function provider_facebook($provider)
	{
		return $this->_default_provider($provider);
	}

	function provider_yozm($provider)
	{
		return $this->_default_provider($provider);
	}

	function provider_youtube($provider)
	{
		return $this->_default_provider($provider);
	}

	function provider_me2day($provider)
	{
		return $this->_default_provider($provider);
	}

	function provider_feed($provider)
	{
		return $this->_default_provider($provider);
	}

	function render()
	{
		if (is_array($this->provider)) {
			if (!empty($this->provider['provider_name'])) {
				$method = 'provider_' . $this->provider['provider_name'];
				if (method_exists($this, $method)) {
					if (!empty($this->provider['url']) && !empty($this->allow_url[$this->provider['provider_name']])) {
						$valid = false;
						foreach ($this->allow_url[$this->provider['provider_name']] as $url) {
							if (strpos($this->provider['url'], $url) === 0) {
								$valid = true;
								break;
							}
						}
						if ($valid) {
							if (is_file($this->filename)) {
								$sync_second = (int)$this->provider['sync_second'];
								if ($sync_second < IXR_MIN_SYNC_SECOND) {
									$sync_second = IXR_MIN_SYNC_SECOND;
								}
								$ftime = filemtime($this->filename);
								if ($ftime + $sync_second > time() || file_exists($this->tmp_file)) {
									header('X-IXR-CACHE: ' . ($ftime + $sync_second - time()) . ' SEC');
									readfile($this->filename);
									return;
								}
							}
							file_put_contents($this->tmp_file, 'tmp');
							echo $this->$method($this->provider);
							unlink($this->tmp_file);
						}
					}
				}
			}
		}
	}
}
