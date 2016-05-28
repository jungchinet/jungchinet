<?
/*******************************************************************************
** 공통 변수, 상수, 코드
*******************************************************************************/
error_reporting(E_ALL ^ E_NOTICE);

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

if (!isset($set_time_limit)) $set_time_limit = 0;
@set_time_limit($set_time_limit);

// 짧은 환경변수를 지원하지 않는다면
if (isset($HTTP_POST_VARS) && !isset($_POST)) {
	$_POST   = &$HTTP_POST_VARS;
	$_GET    = &$HTTP_GET_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_ENV    = &$HTTP_ENV_VARS;
	$_FILES  = &$HTTP_POST_FILES;

  if (!isset($_SESSION))
		$_SESSION = &$HTTP_SESSION_VARS;
}

//
// phpBB2 참고
// php.ini 의 magic_quotes_gpc 값이 FALSE 인 경우 addslashes() 적용
// SQL Injection 등으로 부터 보호
//
if( !get_magic_quotes_gpc() )
{
	if( is_array($_GET) )
	{
		while( list($k, $v) = each($_GET) )
		{
			if( is_array($_GET[$k]) )
			{
				while( list($k2, $v2) = each($_GET[$k]) )
				{
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			}
			else
			{
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}

	if( is_array($_POST) )
	{
		while( list($k, $v) = each($_POST) )
		{
			if( is_array($_POST[$k]) )
			{
				while( list($k2, $v2) = each($_POST[$k]) )
				{
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			}
			else
			{
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}

	if( is_array($_COOKIE) )
	{
		while( list($k, $v) = each($_COOKIE) )
		{
			if( is_array($_COOKIE[$k]) )
			{
				while( list($k2, $v2) = each($_COOKIE[$k]) )
				{
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			}
			else
			{
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}

if ($_GET['g4_path'] || $_POST['g4_path'] || $_COOKIE['g4_path']) {
    unset($_GET['g4_path']);
    unset($_POST['g4_path']);
    unset($_COOKIE['g4_path']);
    unset($g4_path);
}

// Proxy를 거쳐서 들어오는 경우, 실제 IP로 변경, http://virendrachandak.wordpress.com/2011/10/23/getting-real-client-ip-address-in-php-2/
function get_real_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))  //check ip from share internet
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  //to check ip is pass from proxy
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED']))
        $ip=$_SERVER['HTTP_X_FORWARDED'];
    else if (!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ip=$_SERVER['HTTP_FORWARDED_FOR'];
    else if (!empty($_SERVER['HTTP_FORWARDED']))
        $ip=$_SERVER['HTTP_FORWARDED'];
    else
        $ip=$_SERVER['REMOTE_ADDR'];
    return trim($ip);
}
$_SERVER["REMOTE_ADDR"] = get_real_ip();

// mobile device인지 체크 - http://detectmobilebrowsers.com/
$g4['g4_mobile_device'] = false;
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge|maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    $g4['g4_mobile_device'] = true;

//==========================================================================================================================
// XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단
//--------------------------------------------------------------------------------------------------------------------------
function xss_clean($data) 
{ 
    // If its empty there is no point cleaning it :\ 
    if(empty($data)) 
        return $data; 
         
    // Recursive loop for arrays 
    if(is_array($data)) 
    { 
        foreach($data as $key => $value) 
        { 
            $data[$key] = xss_clean($value); 
        } 
         
        return $data; 
    } 
     
    // http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php 
    // +----------------------------------------------------------------------+ 
    // | Copyright (c) 2001-2006 Bitflux GmbH                                 | 
    // +----------------------------------------------------------------------+ 
    // | Licensed under the Apache License, Version 2.0 (the "License");      | 
    // | you may not use this file except in compliance with the License.     | 
    // | You may obtain a copy of the License at                              | 
    // | http://www.apache.org/licenses/LICENSE-2.0                           | 
    // | Unless required by applicable law or agreed to in writing, software  | 
    // | distributed under the License is distributed on an "AS IS" BASIS,    | 
    // | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      | 
    // | implied. See the License for the specific language governing         | 
    // | permissions and limitations under the License.                       | 
    // +----------------------------------------------------------------------+ 
    // | Author: Christian Stocker <chregu@bitflux.ch>                        | 
    // +----------------------------------------------------------------------+ 
     
    // Fix &entity\n; 
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data); 
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/', '$1;', $data); 
    $data = preg_replace('/(&#x*[0-9A-F]+);*/i', '$1;', $data); 

    if (function_exists("html_entity_decode"))
    {
        $data = html_entity_decode($data); 
    }
    else
    {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $data = strtr($data, $trans_tbl);
    }

    // Remove any attribute starting with "on" or xmlns 
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#i', '$1>', $data); 

    // Remove javascript: and vbscript: protocols 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2nojavascript...', $data); 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2novbscript...', $data); 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#', '$1=$2nomozbinding...', $data); 

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span> 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#i', '$1>', $data); 

    // Remove namespaced elements (we do not need them) 
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data); 

    do 
    { 
        // Remove really unwanted tags 
        $old_data = $data; 
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data); 
    } 
    while ($old_data !== $data); 
     
    return $data; 
} 

$_GET = xss_clean($_GET);
//==========================================================================================================================


//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]])) unset($_GET[$ext_arr[$i]]);
}
//==========================================================================================================================

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);

// 완두콩님이 알려주신 보안관련 오류 수정
// $member 에 값을 직접 넘길 수 있음
$config = array();
$member = array();
$board  = array();
$group  = array();
$g4     = array();

// index.php 가 있는곳의 상대경로
// php 인젝션 ( 임의로 변수조작으로 인한 리모트공격) 취약점에 대비한 코드
// prosper 님께서 알려주셨습니다.
if (!$g4_path || preg_match("/:\/\//", $g4_path))
    die("<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'><script type='text/javascript'> alert('잘못된 방법으로 변수가 정의되었습니다.'); </script>");
//if (!$g4_path) $g4_path = ".";
$g4['path'] = $g4_path;

// 경로의 오류를 없애기 위해 $g4_path 변수는 해제
unset($g4_path);

include_once("$g4[path]/lib/constant.php");  // 상수 정의
include_once("$g4[path]/config.php");  // 설정 파일
include_once("$g4[path]/lib/common.lib.php"); // 공통 라이브러리

// config.php 가 있는곳의 웹경로
if (!$g4['url'])
{
    $g4['url'] = 'http://' . $_SERVER['HTTP_HOST'];
    $dir = dirname($_SERVER["PHP_SELF"]);
    if (!file_exists("config.php"))
        $dir = dirname($dir);
    $cnt = substr_count($g4['path'], "..");
    for ($i=2; $i<=$cnt; $i++)
        $dir = dirname($dir);
    $g4['url'] .= $dir;
}
// \ 를 / 롤 변경
$g4['url'] = strtr($g4['url'], "\\", "/");
// url 의 끝에 있는 / 를 삭제한다.
$g4['url'] = preg_replace("/\/$/", "", $g4['url']);

//==============================================================================
// 공통
//==============================================================================
$dirname = dirname(__FILE__).'/';
$dbconfig_file = "dbconfig.php";
/* - 설치된 이후에는 dbcofig.php 파일체크를 할 필요 없죠???
if (file_exists("$g4[path]/$dbconfig_file"))
{
    if (is_dir("$g4[path]/install")) die("<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'><script type='text/javascript'> alert('install 디렉토리를 삭제하여야 정상 실행됩니다.'); </script>");
*/
    @include_once("$g4[path]/$dbconfig_file");
    $connect_db = sql_connect($mysql_host, $mysql_user, $mysql_password);
    $select_db = sql_select_db($mysql_db, $connect_db);
    if (!$select_db)
        die("<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'><script type='text/javascript'> alert('DB 접속 오류'); </script>");
/*
}
else
{
    echo "<meta http-equiv='content-type' content='text/html; charset=$g4[charset]'>";
    echo <<<HEREDOC
    <script type="text/javascript">
    alert("DB 설정 파일이 존재하지 않습니다.\\n\\n프로그램 설치 후 실행하시기 바랍니다.");
    location.href = "./install/";
    </script>
HEREDOC;
    exit;
}
unset($my); // DB 설정값을 클리어 해줍니다.
*/
//print_r2($GLOBALS);

$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF']);

//-------------------------------------------
// SESSION 설정
//-------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)

// 사용할 session 형태를 지정 합니다. db. memcache. file - 3종 입니다
switch ($g4['session_type']) {
    case "db"       :
        include_once("$g4[path]/lib/dbsession.lib.php");
        $session = new g4_dbsession();
        session_set_save_handler(array($session, 'open'), 
                                 array($session, 'close'),
                                 array($session, 'read'),
                                 array($session, 'write'),
                                 array($session, 'destroy'),
                                 array($session, 'gc'));
        break;
    case "memcache" :
        ini_set('session.save_handler', 'memcache');
        ini_set('session.save_path', $g4['mpath']);
        break;
    case "redis" :
        ini_set('session.save_handler', 'redis');
        ini_set('session.save_path', $g4['rpath']);
        break;
    default :
        // 그누보드 기본 세션관리
        session_save_path("{$g4['data_path']}/session");
}

if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

//==============================================================================
// 공용 변수
//==============================================================================
// 기본환경설정
// 기본적으로 사용하는 필드만 얻은 후 상황에 따라 필드를 추가로 얻음
$config = sql_fetch(" select * from $g4[config_table] ");

// memcache와 redis는 세션관리가 정확하게 이루어지기 때문에, 시간을 길게 잡아줘야 합니다
if ($g4['session_type'] == "memcache" || $g4['session_type'] == "redis") {
    @ini_set("session.cache_expire", 7200); // 세션 캐쉬 보관시간 (분)
    @ini_set("session.gc_maxlifetime", 504000); // session data의 garbage collection 존재 기간을 지정 (초)
} else {
    @ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
    @ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
}
@ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
@ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

session_set_cookie_params(0, "/");
@ini_set("session.cookie_domain", $g4['cookie_domain']);

@session_start();

/*
// 081022 : CSRF 방지를 위해 코드를 작성했으나 효과가 없어 주석처리 함
if (strpos($_SERVER[PHP_SELF], $g4['admin']) === false)
    set_session("ss_admin", false);
*/

// 4.00.03 : [보안관련] PHPSESSID 가 틀리면 로그아웃한다.
if ($_REQUEST['PHPSESSID'] && $_REQUEST['PHPSESSID'] != session_id())
    goto_url("{$g4['bbs_path']}/logout.php");

// QUERY_STRING
$qstr = "";
/*
if (isset($bo_table))   $qstr .= 'bo_table=' . urlencode($bo_table);
if (isset($wr_id))      $qstr .= '&wr_id=' . urlencode($wr_id);
*/
if (isset($sca))  {
    $sca = mysql_real_escape_string($sca);
    $qstr .= '&sca=' . urlencode($sca);
}

if (isset($sfl))  {
    $sfl = mysql_real_escape_string($sfl);
    // 크롬에서만 실행되는 XSS 취약점 보완
    // 코드 $sfl 변수값에서 < > ' " % = ( ) 공백 문자를 없앤다.
    $sfl = preg_replace("/[\<\>\'\"\%\=\(\)\s]/", "", $sfl);
    //$sfl = preg_replace("/[^\w\,\|]+/", "", $sfl);
    $qstr .= '&sfl=' . urlencode($sfl); // search field (검색 필드)
}

if (isset($stx))  { // search text (검색어)
    $stx = mysql_real_escape_string($stx);
    $qstr .= '&stx=' . urlencode($stx);
}

if (isset($sst))  {
    $sst = mysql_real_escape_string($sst);
    $qstr .= '&sst=' . urlencode($sst); // search sort (검색 정렬 필드)
}

if (isset($sod))  { // search order (검색 오름, 내림차순)
    $sod = preg_match("/^(asc|desc)$/i", $sod) ? $sod : "";
    $qstr .= '&sod=' . urlencode($sod);
}

if (isset($sop))  { // search operator (검색 or, and 오퍼레이터)
    $sop = preg_match("/^(or|and)$/i", $sop) ? $sop : "";
    $qstr .= '&sop=' . urlencode($sop);
}

if (isset($spt))  { // search part (검색 파트[구간])
    $spt = (int)$spt;
    $qstr .= '&spt=' . urlencode($spt);
}

if (isset($page)) { // 리스트 페이지
    $page = (int)$page;
    $qstr .= '&page=' . urlencode($page);
}

if ($wr_id) {
    $wr_id = (int)$wr_id;
}

// URL ENCODING
if (isset($url)) {
    $urlencode = urlencode($url);
}
else {
    // 2008.01.25 Cross Site Scripting 때문에 수정
    //$urlencode = $_SERVER['REQUEST_URI'];
    $urlencode = urlencode($_SERVER[REQUEST_URI]);
}
if (isset($total_page)) { // 리스트 페이지
    $total_page = (int)$total_page;
}


if (isset($comment_id)) { // 리스트 페이지
    $comment_id = (int)$comment_id;
}

if (isset($mb_id)) {
    $mb_id = mysql_real_escape_string($mb_id);
}

if (isset($mb_email)) {
    $mb_email = mysql_real_escape_string($mb_email);
}

if (isset($po_id)) {
    $po_id = (int)$po_id;
}

if (isset($ug_id)) {
    $ug_id = mysql_real_escape_string($ug_id);
}

// 그누보드 4.34.09 보안패치 ($_SERVER의 SQL Injection 방어)
$remote_addr = mysql_real_escape_string($_SERVER['REMOTE_ADDR']); 
$referer    = mysql_real_escape_string($_SERVER['HTTP_REFERER']); 
$user_agent  = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']); 

//===================================


// 자동로그인 부분에서 첫로그인에 포인트 부여하던것을 로그인중일때로 변경하면서 코드도 대폭 수정하였습니다.
if ($_SESSION['ss_mb_id']) // 로그인중이라면
{
    $member = get_member($_SESSION['ss_mb_id']);

    // 오늘 처음 로그인 이라면
    if (substr($member['mb_today_login'], 0, 10) != $g4['time_ymd'])
    {
        // 첫 로그인 포인트 지급
        insert_point($member['mb_id'], $config['cf_login_point'], "{$g4['time_ymd']} 첫로그인", "@login", $member['mb_id'], $g4['time_ymd']);

        // 오늘의 로그인이 될 수도 있으며 마지막 로그인일 수도 있음
        // 해당 회원의 접근일시와 IP 를 저장
        $sql = " update {$g4['member_table']} set mb_today_login = '{$g4['time_ymdhis']}', mb_login_ip = '$remote_addr' where mb_id = '{$member['mb_id']}' ";
        sql_query($sql);
    } else {
        // 오늘의 마지막 login_ip와 현재의 로그인 ip가 다르면, 현재의 로그인 ip로 업데이트 한다
        if ($member['mb_login_ip'] !== $_SERVER['REMOTE_ADDR']) {
            $sql = " update {$g4['member_table']} set mb_login_ip = '$remote_addr' where mb_id = '{$member['mb_id']}' ";
            sql_query($sql);
        }
    }
}
else
{
    // 자동로그인 ---------------------------------------
    // 회원아이디가 쿠키에 저장되어 있다면 (3.27)
    if ($tmp_mb_id = get_cookie("ck_mb_id"))
    {
        // 불당팩 - 암호화된 쿠키를 디코드
        $tmp_mb_id = decrypt( $tmp_mb_id, $g4[encrypt_key]); 

        $tmp_mb_id = substr(preg_replace("/[^a-zA-Z0-9_]*/", "", $tmp_mb_id), 0, 20);
        // 최고관리자는 자동로그인 금지
        if ($tmp_mb_id != $config['cf_admin'])
        {
            $row = get_member("$tmp_mb_id", "mb_password, mb_intercept_date, mb_leave_date, mb_email_certify");
            if ($g4['load_balance']) {
                if ($g4['g4_mobile_device'])
                    $key = md5($g4['load_balance'] . $_SERVER['HTTP_USER_AGENT'] . $row['mb_password']);
                else
                    $key = md5($g4['load_balance'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $row['mb_password']);
            } else {
                if ($g4['g4_mobile_device'])
                    $key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $row['mb_password']);
                else
                    $key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $row['mb_password']);
            }
            // 쿠키에 저장된 키와 같다면
            $tmp_key = get_cookie("ck_auto");
            if ($tmp_key == $key && $tmp_key)
            {
                // 차단, 탈퇴가 아니고 메일인증이 사용이면서 인증을 받았다면
                if ($row['mb_intercept_date'] == "" &&
                    $row['mb_leave_date'] == "" &&
                    (!$config['cf_use_email_certify'] || preg_match('/[1-9]/', $row['mb_email_certify'])) )
                {
                    // 세션에 회원아이디를 저장하여 로그인으로 간주
                    set_session("ss_mb_id", $tmp_mb_id);

                    // 페이지를 재실행
                    echo "<script type='text/javascript'> window.location.reload(); </script>";
                    exit;
                }
            }
            // $row 배열변수 해제
            unset($row);
        }
    }
    // 자동로그인 end ---------------------------------------
}

// 첫방문 쿠키
// 1년간 저장
if (!get_cookie("ck_first_call"))     set_cookie("ck_first_call", $g4[server_time], 86400 * 365);
if (!get_cookie("ck_first_referer"))  set_cookie("ck_first_referer", $_SERVER[HTTP_REFERER], 86400 * 365);

// 회원이 아니라면 권한을 방문객 권한으로 함
if (!($member['mb_id']))
    $member['mb_level'] = 1;
else
    $member['mb_dir'] = substr($member['mb_id'],0,2);

$write_table = "";
if (isset($bo_table)) {
    $bo_table = preg_match("/^[a-zA-Z0-9_]+$/", $bo_table) ? $bo_table : "";
    $board = sql_fetch(" select * from {$g4['board_table']} where bo_table = '$bo_table' ");
    if ($board['bo_table']) {
        $gr_id = $board['gr_id'];
        $write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        if ($wr_id)
            $write = sql_fetch(" select * from $write_table where wr_id = '$wr_id' ");
    }
}

// adm/board_list.php에서 gr_id를 배열로 쓰기 때문에, is_array를 체크해야 합니다. =..=...
if (isset($gr_id) && !is_array($gr_id)) {
    $gr_id = preg_match("/^[a-zA-Z0-9_]+$/", $gr_id) ? $gr_id : "";
    $group = sql_fetch(" select * from {$g4['group_table']} where gr_id = '$gr_id' ");
}

// 회원, 비회원 구분
$is_member = $is_guest = false;
if ($member['mb_id'])
    $is_member = true;
else
    $is_guest = true;


$is_admin = is_admin($member['mb_id']);
if ($is_admin != "super") {
    // 접근가능 IP
    $cf_possible_ip = trim($config['cf_possible_ip']);
    if ($cf_possible_ip) {
        $is_possible_ip = false;
        $pattern = explode("\n", $cf_possible_ip);
        for ($i=0; $i<count($pattern); $i++) {
            $pattern[$i] = trim($pattern[$i]);
            if (empty($pattern[$i]))
                continue;

            $pattern[$i] = str_replace(".", "\.", $pattern[$i]);
            $pat = "/^{$pattern[$i]}/";
            $is_possible_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
            if ($is_possible_ip)
                break;
        }
        if (!$is_possible_ip)
            die ("접근이 가능하지 않습니다.");
    }

    // 접근차단 IP
    $is_intercept_ip = false;
    $pattern = explode("\n", trim($config['cf_intercept_ip']));
    for ($i=0; $i<count($pattern); $i++) {
        $pattern[$i] = trim($pattern[$i]);
        if (empty($pattern[$i]))
            continue;

        $pattern[$i] = str_replace(".", "\.", $pattern[$i]);
        $pat = "/^{$pattern[$i]}/";
        $is_intercept_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
        if ($is_intercept_ip) header("Location: http://iisweb.co.kr/servicestop.html");
    
    }
}

// 스킨경로
$board_skin_path = '';
if (isset($board['bo_skin']))
    $board_skin_path = "{$g4['path']}/skin/board/{$board['bo_skin']}"; // 게시판 스킨 경로

// 방문자수의 접속을 남김
include_once("{$g4['bbs_path']}/visit_insert.inc.php");

// common.php 파일을 수정할 필요가 없도록 확장합니다.
$tmp = dir("$g4[path]/extend");
while ($entry = $tmp->read()) {
    // php 파일만 include 함
    if (preg_match("/(\.php)$/i", $entry))
      if ($entry != "index.php")
        include_once("$g4[path]/extend/$entry");
}

// 유니크로 쿠키를 구워줍니다.
if ($g4[unicro_url]) {
    $unicro_cookie_id = $member["mb_id"] . "^" . $member["mb_no"];
    if (isset($_COOKIE[unicro_id]) && $_COOKIE[unicro_id] == "$unicro_cookie_id") { } else {
        setcookie("unicro_id", "$unicro_cookie_id", $g4[server_time] + 3600, '/', $g4[cookie_domain]) ;
    }
}

// 곱슬최씨 - 게시판별 카운터
if ($gr_id && $bo_table) 
{
    $board_visit = "$g4[time_ymd].$gr_id.$bo_table.$_SERVER[REMOTE_ADDR]";

    $sql = " select count(*) as cnt from $mw[board_visit_log_table] where log = '$board_visit' ";
    $result = sql_fetch($sql);

    // $result[cnt] == 0 : 오늘 처음 방문하는 경우.
    if ($result[cnt] == 0) {
        $qry = sql_query("insert into $mw[board_visit_log_table] set log = '$board_visit'", false);
        if ($qry) {
            $sql = " update $mw[board_visit_table] set bv_count = bv_count + 1 where bv_date = '$g4[time_ymd]' and gr_id = '$gr_id' and bo_table = '$bo_table' ";
            $qry = sql_query($sql, false);

            // 수정된 row가 하나도 없다면(업데이트가 안되는 오류) 새로운 날짜별 행을 생성하도록 insert를 실행
            if ( mysql_affected_rows() == 0 ) {
                $sql = " insert $mw[board_visit_table] set bv_date = '$g4[time_ymd]', gr_id = '$gr_id', bo_table = '$bo_table', bv_count = 1 ";
                $qry = sql_query($sql);
            }
        }
        unset($board_visit);
    }
}

// geoip 체크, 한국이면 KR이 리턴 됩니다.
if ($g4['use_geo_ip'])
    $geoip = ipaddress_to_country_code($_SERVER['REMOTE_ADDR']);

// 글쓰기제한
$is_delay = false;
if ($member['mb_level'] > 1) {
    if ($member['mb_level'] >= $config['cf_delay_level'] || $member['mb_point'] >= $config['cf_delay_point'] || $is_admin)
        $is_delay = true;
}

// 불당팩 - 추가적인 개별 변수설정을 위해
include_once("$g4[path]/config.2.php");  // 설정 파일
?>
