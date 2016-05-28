<?
if (!defined('_GNUBOARD_')) exit;

// 방문자수 출력
function visit($skin_dir="basic")
{
    global $config, $g4;

    // visit 배열변수에 
    // $visit[1] = 오늘
    // $visit[2] = 어제
    // $visit[3] = 최대
    // $visit[4] = 전체
    // 숫자가 들어감
    preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);
    settype($visit[0], "integer");
    settype($visit[1], "integer");
    settype($visit[2], "integer");
    settype($visit[3], "integer");

    ob_start();
    $visit_skin_path = "$g4[path]/skin/visit/$skin_dir";
    include_once ("$visit_skin_path/visit.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// get_browser() 함수는 이미 있음
// http://kr.php.net/manual/en/function.get-browser.php
function get_brow($agent)
{
    $agent = strtolower($agent);

    //echo $agent; echo "<br/>";

    if (preg_match("/msie 5.0[0-9]*/", $agent))         { $s = "MSIE 5.0"; }
    else if(preg_match("/msie 5.5[0-9]*/", $agent))     { $s = "MSIE 5.5"; }
    else if(preg_match("/msie 6.0[0-9]*/", $agent))     { $s = "MSIE 6.0"; }
    else if(preg_match("/msie 7.0[0-9]*/", $agent))     { $s = "MSIE 7.0"; }
    else if(preg_match("/msie 8.0[0-9]*/", $agent))     { $s = "MSIE 8.0"; }
    else if(preg_match("/msie 9.0[0-9]*/", $agent))     { $s = "MSIE 9.0"; }
    else if(preg_match("/msie 4.[0-9]*/", $agent))      { $s = "MSIE 4.x"; }
    else if(preg_match("/firefox/", $agent))            { $s = "FireFox"; }
    else if(preg_match("/chrome/", $agent))             { $s = "Chrome"; }
    else if(preg_match("/x11/", $agent))                { $s = "Netscape"; }
    else if(preg_match("/opera/", $agent))              { $s = "Opera"; }
    else if(preg_match("/gec/", $agent))                { $s = "Gecko"; }
    else if(preg_match("/bot|slurp/", $agent))          { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))  { $s = "IE"; }
    else if(preg_match("/safari/", $agent))             { $s = "Safari"; }
    else if(preg_match("/mozilla/", $agent))            { $s = "Mozilla"; }
    else { $s = "기타"; }

    return $s;
}

function get_os($agent)
{
    $agent = strtolower($agent);

    //echo $agent; echo "<br/>";

    if (preg_match("/windows 98/", $agent))                 { $s = "98"; }
    else if(preg_match("/windows 95/", $agent))             { $s = "95"; }
    else if(preg_match("/windows nt 4\.[0-9]*/", $agent))   { $s = "NT"; }
    else if(preg_match("/windows nt 5\.0/", $agent))        { $s = "2000"; }
    else if(preg_match("/windows nt 5\.1/", $agent))        { $s = "XP"; }
    else if(preg_match("/windows nt 5\.2/", $agent))        { $s = "2003"; }
    else if(preg_match("/windows nt 6\.0/", $agent))        { $s = "Vista"; }
    else if(preg_match("/windows nt 6\.1/", $agent))        { $s = "Windows7"; }
    else if(preg_match("/windows 9x/", $agent))             { $s = "ME"; }
    else if(preg_match("/windows ce/", $agent))             { $s = "CE"; }
    else if(preg_match("/linux/", $agent))                  { $s = "Linux"; }
    else if(preg_match("/sunos/", $agent))                  { $s = "sunOS"; }
    else if(preg_match("/irix/", $agent))                   { $s = "IRIX"; }
    else if(preg_match("/phone/", $agent))                  { $s = "Phone"; }
    else if(preg_match("/bot|slurp/", $agent))              { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))      { $s = "IE"; }
    else if(preg_match("/mozilla/", $agent))                { $s = "Mozilla"; }
    else if(preg_match("/macintosh/", $agent))              { $s = "Mac"; }
    else if(preg_match("/iphone/", $agent))                 { $s = "iPhone"; }
    else if(preg_match("/iPod/", $agent))                   { $s = "iPod"; }
    else { $s = "기타"; }

    return $s;
}
?>
