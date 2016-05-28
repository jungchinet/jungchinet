<?php
include "twitteroauth.php";

function get_tweets($q, $rows=30, $result_type='mixed'){
    $twitter = new TwitterOAuth(_CONSUMER_KEY_, _CONSUMER_SECRET_, _ACCESS_TOKEN_, _ACCESS_TOKEN_SECRET_);
    $get_url = 'https://api.twitter.com/1.1/search/tweets.json?q='.$q.'&result_type='.$result_type.'&count='.$rows;
    $tweets = $twitter->get($get_url);
    $data = json_decode(json_encode($tweets),1);
    $data['total_cnt'] = count($data['statuses']);
    return $data;
}

function autolink($text){
    return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.-]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $text);
}

function chgdate($d){
    $y = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
    $tmp = explode(" ", $d);
    foreach($y as $k=>$v) if(strtolower($v) == strtolower($tmp[1])) $tmp[1] = "$k";
    $tmp_date = $tmp[5] . "-" .$tmp[1] . "-" . $tmp[2] . " " . $tmp[3];
    $d = date("Y.m.d H:i:s", strtotime($tmp_date)+(60*60*9));
    return $d;
}

function text_makeup($stx, $str, $rt_status=''){
    $src = array("/", "|");
    $dst = array("\/", "\|");
    if (!trim($stx)) return $str;
    $s = explode(" ", $stx);
    $pattern = "";
    $bar = "";
    for ($m=0; $m<count($s); $m++) {
        if (trim($s[$m]) == "") continue;
        $tmp_str = quotemeta($s[$m]);
        $tmp_str = str_replace($src, $dst, $tmp_str);
        $pattern .= $bar . $tmp_str . "(?![^<]*>)";
        $bar = "|";
    }
    $str = autolink($str);
    $str = preg_replace("/($pattern)/i", "<span style='font-weight:bold; color:#000;'>\\1</span>", $str);
    if($rt_status){
        $tmp = reset(explode(':', $str));
        $str = str_replace($tmp, '<a href="https://twitter.com/'.$rt_status['user']['screen_name'].'/status/'.$rt_status['id'].'" target="_blank">'.$tmp.'</a>', $str);
    }

    return $str;
}

// 배열을 print_r
function ptr($v){
    if($v=='p' && $v!=1) $var = $_POST; else
    if($v=='g' && $v!=1) $var = $_GET; else $var = $v;
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function get_youtube($url, $q=''){
    $v = '';
    $l = '';

    if (strstr($url, "youtube.com/feeds")) return;

    if (preg_match("/^https?:\/\/youtu.be\/([a-zA-Z0-9_-]+)?/i", $url, $mat)) {
        $v = $mat[1];
    }
    elseif (preg_match("/^https?:\/\/www\.youtube\.com\/watch\?v=([^&]+)&.*&list=([^&]+)&$/i", $url.'&', $mat)) {
        $v = $mat[1];
        $l = $mat[2];
    }
    //elseif (preg_match("/^http[s]{0,1}:\/\/www\.youtube\.com\/watch\?v=([^&]+)&/i", $url.'&', $mat)) {
    elseif (preg_match("/\/\/.*youtube\.com\/.*v[=\/]([a-zA-Z0-9_-]+)?/i", $url, $mat)) {
        $v = $mat[1];
    }
    elseif (preg_match("/\/\/.*youtube\.com\/embed\/([a-zA-Z0-9_-]+)?/i", $url, $mat)) {
        $v = $mat[1];
    }

    if (!$v) return;

    $t = null;
    preg_match("/t=([0-9ms]+)?/i", $url, $mat);
    if ($mat[1]) {
        $t = $mat[1];

        preg_match("/([0-9]+)m/", $t, $mat);
        $m = $mat[1];

        preg_match("/([0-9]+)s/", $t, $mat);
        $s = $mat[1];

        $t = $m*60+$s;
    }

    $v = trim($v);

    // $src = "https://www.youtube.com/embed/{$v}?fs=1&hd=1";
    $src = "https://www.youtube.com/embed/{$v}";

    if ($t)
        $src .= "&start=".$t;
    if ($l)
        $src .= "&list=".$l;

    if (!$cf_youtube_size)
        $cf_youtube_size = 360;

    $cf_player_size = trim($board['bo_1']);

    if ($q && $q!='thumb') {
        $cf_youtube_size = $q;
        $cf_player_size = null;
    }
    else if($q=='thumb'){
        return "http://img.youtube.com/vi/{$v}/mqdefault.jpg";
    }

    switch ($cf_youtube_size) {
        case "144": $width = 320; $height = 180; break;
        case "240": $width = 560; $height = 315; break;
        case "360": $width = 640; $height = 394; break;
        case "480": $width = 854; $height = 516; break;
        case "720": $width = 1280; $height = 759; break;
        case "1080": $width = 1920; $height = 1123; break;
        default:
            $width = 640; $height = 394; break;
    }

    if ($cf_player_size) {
        $size = explode("x", $cf_player_size);
        $width = $size[0];
        $height = $size[1];
    }

    // if ($width > $board['bo_image_width']) {
    //     $height = floor($board['bo_image_width']/$width*$height);
    //     $width = $board['bo_image_width'];
    // }

    $you = "<div class='videoWrapper'><iframe src='{$src}?wmode=transparent' frameborder='0' ";
    $you.= "webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>";

    return $you;
}