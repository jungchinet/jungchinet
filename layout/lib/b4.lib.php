<?
// 프로그램 : 그누보드 불당팩 라이브러리 
// 개 발 자 : 아빠불당 (echo4me@gmail.com)
//
// 저 작 권 : GPL2

// 당일인 경우 시간 등으로 이쁘게 표시함 (이거 수정하면 common.lib.php의 get_list의 날짜 표현도 수정해야 함)
function get_datetime($datetime)
{
    global $g4;
    
    // 오늘이면 시간으로 표시
    if (substr($datetime,0,10) == $g4['time_ymd'])
        return substr($datetime,11,5);
    // 같은 년도이면 월-일로표시
    else if (substr($datetime,0,4) == substr($g4['time_ymd'],0,4))
        return substr($datetime,5,5);
    // 연도는 다르더라도 60일 이내이면, 헷갈리지 않게 월-일로 표시
    else if (days_diff($datetime) <= 60)
        return substr($datetime,5,5);
    // 이제는 연-월로 표시
    else
        return substr($datetime,0,7);
}

// 날짜로 표시함
function get_date($datetime)
{
    global $g4;
    
    return substr($datetime,5,5);
}

// mysql 명령을 수행후 변경된 라인수를 return (update의 경우 matched가 있으면 그것을 return)
// http://kr.php.net/manual/kr/function.mysql-info.php
function mysql_modified_rows() {
    $info_str = mysql_info();
    $a_rows = mysql_affected_rows();
    preg_match("/Rows matched: ([0-9]*)/i", $info_str, $r_matched);
    return ($a_rows < 1)?($r_matched[1]?$r_matched[1]:0):$a_rows;
}

// 불당팩 : 설정값을 읽어오기
function get_config($config_type='', $fields='*') 
{ 
    global $g4, $config, $board; 

    $config_type = trim($config_type);
    if ($config_type) {
        $config_extend = sql_fetch(" select $fields from $g4[config_table]_{$config_type} ");
        if ($config_extend)
            $config = array_merge($config, $config_extend);
    } else {
        $config = sql_fetch(" select $fields from $g4[config_table] ");
    }

    return $config;
}


// 불당팩 : 이미지 resize (청춘불안정 : http://www.sir.co.kr/bbs/board.php?bo_table=cm_free&wr_id=306629)
function resize($string)
{ 
    global $g4, $board;

    //print_r($board);

    // 전역변수를 받아들이기 때문에 설정값이 없으면, 기본으로 게시판의 폭을 지정. 게시판 폭도 없으면 기본으로 500
    $max_img_width = (int) $board['resize_img_width'];
    if ($max_img_width <= 0) {
        if ((int)$board['bo_image_width'] > 0)
            $max_img_width = $board['bo_image_width'];
        else
            $max_img_width = 500;
    }
    
    // max_img_height에 값이 있는 경우는 crop을 허용 합니다.
    $max_img_height = (int) $board['resize_img_height'];
    $is_crop = false;
    if ($max_img_height > 0)
        $is_crop = true;

    // 실행할 때마다 image를 create할지 설정 (무조건 false)
    $is_create = false;
    
    // 이미지의 quality 값을 설정 (없으면, thumb의 기본값으로 90이 적용됨)
    $quality = (int) $board['resize_img_quality'];
    if ($quality <= 0)
        $quality = 90;

    // $water_mark 변수를 전달 받습니다
    $water_mark = $board['water_mark'];

    // $board[thumb_create]에 값이 있으면 무조건 썸네일을 생성 합니다.
    if ($board[thumb_create])
        $thumb_create = 1;

    // 이미지 필터 - 기본으로 UnSharpMask
    if ($board[image_filter]) {
        $filter[type] = $board[image_filter][type];
        $filter[arg1] = $board[image_filter][arg1];
        $filter[arg2] = $board[image_filter][arg2];
        $filter[arg3] = $board[image_filter][arg3];
        $filter[arg4] = $board[image_filter][arg4];
    } else {
        $filter[type] = 99;
        $filter[arg1] = 10;
        $filter[arg2] = 1;
        $filter[arg3] = 2;
    }

    // 변수를 setting
    $return = $string['0']; 
    preg_match_all('@(?P<attribute>[^\s\'\"]+)\s*=\s*(\'|\")?(?P<value>[^\s\'\"]+)(\'|\")?@i', $return, $match);
    if (function_exists('array_combine')) {
        $img = array_change_key_case(array_combine($match['attribute'], $match['value']));
    }
    else {
        $img = array_change_key_case(array_combine4($match['attribute'], $match['value']));
    }

    // 실제 디렉토리 이름을 구하고 절대경로에서 잘라낼 글자수를 계산
    $real_dir = dirname($_SERVER['DOCUMENT_ROOT'] . "/nothing");
    $cut_len = strlen($real_dir);

    // 가끔씩 img의 파일이름이 깨어지는 경우가 있어서 decoding 해줍니다 (예: &#111;&#110; = on)
    $img['src'] = html_entity_decode($img[src]); 

    // 이미지 파일의 경로를 설정 (외부? 내부? 내부인경우 절대경로? 상대경로?)
    if (preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $img['src'])) {
        // 내 서버에 있는 이미지?
        $img_src = @getimagesize($img['src']);
        if (preg_match("/" . $_SERVER[HTTP_HOST] . "/", $img[src], $matches)) {
            $url = parse_url($img[src]);
            $img[src] = $url[path];
            $thumb_path = "1";
        } else {
            return $return;
        }
    } else {
        $thumb_path="1";
    }

    if ($thumb_path) {
        $dir = dirname(file_path($img['src']));
        $file = basename($img['src']);
        $img_path = $dir . "/" . $file;
        // 첨부파일의 이름은 urlencode로 들어가게 됩니다. 따라서, decode해줘야 합니다. (/bbs/write_update.php 참조)
        $img_path = urldecode($img_path);
        $img_src = @getimagesize($img_path);
        // 잊어버리지말고 여기도 urldecode 해줘야죠?
        $thumb_path = urldecode($img['src']);
    }

    // 이미지파일의 정보를 얻지 못했을 때
    if (!$img_src) {
        return $return;
    }

    // 이미지생성의 최소 넓이가 있으면, 이미지가 그 크기 이상일때만, 썸을 만들어야징.
    // 이거는 작은 아이콘 같은 것의 썸을 만들지 않게 하려고 하는거임
    if ($board[image_min] && $img_src[0] < $board[image_min])
        return $return;

    // 이미지 파일의 크기를 구해서
    $fsize = filesize2bytes(filesize($img_path));

    // 이미지 파일의 전체 크기와 갯수 저장
    if ($board['bo_image_info']) {
        $g4['resize']['image_size'] = $g4['resize']['image_size'] + $fsize/1000;
        $g4['resize']['image_count'] = $g4['resize']['image_count'] + 1;
        $g4['resize']['image_file'][] = $img_path;
    }

    // 이미지생성의 최소 파일용량이 있으면, 이미지가 그 파일크기 이상일때만, 썸을 만들어야징.
    // 이거는 작은 아이콘 같은 것이나 효율적으로 줄어든 이미지의 썸을 만들지 않게 하려고 하는거임
    if ($board[image_min_kb]) {
        // 용량은 kb에서 byte로 바꿔서
        $min_kb = $board[image_min_kb]*1024;
        if ($fsize < $min_kb) {
            return $return;
        }
    }

    if(isset($img['width']) == false) {
        $img_width = $img_src[0];
        $img_height = $img_src[1];
    } else {
        $img_width = $img['width'];
        $img_height = $img['height'];
    }

    if((int)$img_width > $max_img_width) 
    {
        // width를 조정
        if (isset($img['width']) == true)
            $return = preg_replace('/width\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'width="' . $max_img_width . '"', $return); 
        else
            $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 width='" . $max_img_width . "' \\2 \\3", $return);

        // height를 삭제
        $return = preg_replace('/height\=(\'|\")?[^\s\'\"]+(\'|\")?/i', null, $return); 

        // 이름도 그누의 javascript resize할 수 있게 수정
        if (isset($img[name]) == true)
            $return = preg_replace('/name\=(\'|\")?[^\s\'\"]+(\'|\")?/i', ' name="target_resize_image[]" ', $return);
        else
            $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' \\2 \\3", $return);

        // thumbnail을 생성
        if ($thumb_path) {
            include_once("$g4[path]/lib/thumb.lib.php");
            $thumb_path=thumbnail($thumb_path, $max_img_width,$max_img_height,$is_create,$is_crop,$quality, "", $water_mark, $filter);
            $return = preg_replace('/src\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'src="' . $thumb_path . '"', $return); 
        }

        // onclick을 했을 때, 원래의 이미지 크기로 popup이 되도록 변경
        if ($board[image_window]) {
            if (isset($img[onclick]) == true)
                $return = preg_replace('/onclick\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'onClick="image_window3(\'' . $img['src'] . '\',' . (int)$img_width . ',' . (int)$img_height . ')" ', $return);
            else
                $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 onClick='image_window3(\"" . $img['src'] . "\"," . (int)$img_width . "," . (int)$img_height . ")' \\2 \\3", $return);
        } else {
            if (isset($img[onclick]) == true)
                $return = preg_replace('/onclick\=(\'|\")?[^\s\'\"]+(\'|\")?/i', '', $return);
            else
                $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 onclick='' \\2 \\3", $return);
        }
    }
    else
    { 
        // width를 조정
        if (isset($img['width']) == true)
            $return = preg_replace('/width\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'width="' . $img_width . '"', $return); 
        else
            $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 width='" . $img_width . "' \\2 \\3", $return);

        // height를 삭제
        $return = preg_replace('/height\=(\'|\")?[^\s\'\"]+(\'|\")?/i', null, $return); 

        // 이름도 그누의 javascript resize할 수 있게 수정
        if (isset($img[name]) == true)
            $return = preg_replace('/name\=(\'|\")?[^\s\'\"]+(\'|\")?/i', ' name="target_resize_image[]" ', $return);
        else
            $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 name='target_resize_image[]' \\2 \\3", $return);

        // $thumb_create가 true이면, 이미지 크기가 $max_img_width보다 작지만, 그래도 thumb를 생성

        if ($thumb_create && $thumb_path) {
            include_once("$g4[path]/lib/thumb.lib.php");
            $thumb_path=thumbnail($thumb_path, $max_img_width,$max_img_height,$is_create,$is_crop,$quality, "", $water_mark, $filter);
            $return = preg_replace('/src\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'src="' . $thumb_path . '"', $return); 
        }

        // onclick을 했을 때, 원래의 이미지 크기로 popup이 되도록 변경
        if ($board[image_window]) {
            if (isset($img[onclick]) == true)
                $return = preg_replace('/onClick\=(\'|\")?[^\s\'\"]+(\'|\")?/i', 'onClick="image_window3(\'' . $img['src'] . '\',' . (int)$img_width . ',' . (int)$img_height . ')" ', $return);
            else
                $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 onClick='image_window3(\"" . $img['src'] . "\"," . (int)$img_width . "," . (int)$img_height . ")' \\2 \\3", $return);
        } else {
            if (isset($img[onclick]) == true)
                $return = preg_replace('/onClick\=(\'|\")?[^\s\'\"]+(\'|\")?/i', '', $return);
            else
                $return = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 onClick='' \\2 \\3", $return);
        }
    }

    return $return; 
}

// $content                                   : resize할 img 태그가 있는 html
// $width         = $board[resize_img_width]  : 최대 이미지의 폭 (값이 없으면 $board[bo_img_width] 값을 씁니다
// $height        = $board[resize_img_height] : 최대 이미지의 높이 (이것이 지정되면 $is_crop = true가 됩니다) 값이 없으면, 비율대로 줄이고 crop 하지 않습니다.
// $quality       = $board[resize_img_quality]: 썸네일 이미지의 quality (없으면 기본값, 70%를 사용)
// $thumb_create  = $board[thumb_create]      : 이미지의 폭이 지정보다 작은경우에도 썸네일을 생성할지를 지정
// $image_window  = $board[image_window]      : 이미지를 누를때 팝업창을 띄울 것인지를 선택 (1: 팝업)
// $water_mark    = $board[water_mark]        : 워터마크
// $image_filter  = $board[image_filter]      : 이미지필터
// $image_min     = $board[image_min]         : 값이 있으면, $thumb_create=1이더라도 image_min 이상의 폭의 이미지에 대해서만, 썸을 만든다
// $image_min_kb  = $board[image_min_kb]      : 값이 있으면, $thumb_create=1이더라도 image_kb 이상의 이미지 용량에 대해서만, 썸을 만든다
function resize_content($content, $width=0, $height=0, $quality=0, $thumb_create=0, $image_window=1, $water_mark='', $image_filter='', $image_min=0, $image_min_kb=0)
{
    global $board;

    if ($width > 0)
        $board['resize_img_width'] = (int)$width;
    else
        $board['resize_img_width'] = 0;

    if ($height > 0)
        $board['resize_img_height'] = (int)$height;
    else
        $board['resize_img_height'] = 0;

    if ($quality > 0)
        $board['resize_img_quality'] = (int)$quality;
    else
        $board['resize_img_quality'] = 70;

    if ($thumb_create)
        $board['thumb_create'] = 1;
    else
        $board['thumb_create'] = 0;

    if ($image_window)
        $board['image_window'] = 1;
    else
        $board['image_window'] = 0;

    if ($image_min)
        $board['image_min'] = $image_min;

    if ($image_min_kb)
        $board['image_min_kb'] = $image_min_kb;

    if ($water_mark)
        $board['water_mark'] = $water_mark;

    if ($image_filter)
        $board['image_filter'] = $image_filter;
    
    return preg_replace_callback('/\<img[^\<\>]*\>/i', 'resize', $content);
}

// $content                                   : resize할 img 태그가 있는 html
// $image_min     = $board[image_min]         : 값이 있으면, $thumb_create=1이더라도 image_min 이상의 폭의 이미지에 대해서만, 썸을 만든다
// $image_min_kb  = $board[image_min_kb]      : 값이 있으면, $thumb_create=1이더라도 image_kb 이상의 이미지 용량에 대해서만, 썸을 만든다
// $quality       = $board[resize_img_quality]: 썸네일 이미지의 quality (없으면 기본값, 70%를 사용)
// $image_window  = $board[image_window]      : 이미지를 누를때 팝업창을 띄울 것인지를 선택 (1: 팝업)
function resize_dica($content, $image_min=0, $image_min_kb=0, $quality=90, $image_window=1)
{
    global $board;

    $board['image_min'] = (int)$image_min;

    $board['image_min_kb'] = (int)$image_min_kb;

    $board['resize_img_quality'] = (int)$quality;

    $board[image_window] = $image_window;

    return preg_replace_callback('/\<img[^\<\>]*\>/i', 'resize', $content);
}

// php4를 위한 array_combine 함수정의, http://kr2.php.net/manual/kr/function.array-combine.php
function array_combine4($arr1, $arr2) {
    $out = array();
    
    $arr1 = array_values($arr1);
    $arr2 = array_values($arr2);
    
    foreach($arr1 as $key1 => $value1) {
        $out[(string)$value1] = $arr2[$key1];
    }
    
    return $out;
}

// 회원권한 이미지 보여주기
function role_img () {
    global $bo_table, $board, $member, $board_skin_path;
    
    if (!$bo_table)
        return;

    $role_img = "";
    
    if ($member['mb_level'] >= $board['bo_read_level'])
        $role_img .= "<img src='$board_skin_path/img/read_ok.gif' align=absmiddle title='read ok'>";
    else
        $role_img .= "<img src='$board_skin_path/img/read_no.gif' align=absmiddle title='read no'>";

    if ($member['mb_level'] >= $board['bo_write_level'])
        $role_img .= "<img src='$board_skin_path/img/write_ok.gif' align=absmiddle title='write ok'>";
    else
        $role_img .= "<img src='$board_skin_path/img/write_no.gif' align=absmiddle title='write no'>";

    if ($member['mb_level'] >= $board['bo_reply_level'])
        $role_img .= "<img src='$board_skin_path/img/reply_ok.gif' align=absmiddle title='reply ok'>";
    else
        $role_img .= "<img src='$board_skin_path/img/reply_no.gif' align=absmiddle title='reply no'>";

    if ($member['mb_level'] >= $board['bo_comment_level'])
        $role_img .= "<img src='$board_skin_path/img/comment_ok.gif' align=absmiddle title='comment ok'>";
    else
        $role_img .= "<img src='$board_skin_path/img/comment_no.gif' align=absmiddle title='comment no'>";

    $role_img .= "<img src='$board_skin_path/img/point_info.gif' align=absmiddle title='read:{$board[bo_read_point]}, write:{$board[bo_write_point]}, comment:{$board[bo_comment_point]}', download:{$board[bo_download_point]}>";
    return $role_img;
}


// http://kr2.php.net/manual/kr/function.realpath.php
// 서브디렉토리에서 get_absolute_path를 호출할 때, 해당 서브디렉토리까지의 경로는 누락됩니다
function get_absolute_path($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }

    return implode(DIRECTORY_SEPARATOR, $absolutes);
}


// http://kr2.php.net/manual/kr/function.realpath.php + http://kr2.php.net/dirname
function get_absolute_path_my($path) {
    // 원본 path 데이터는 저장
    $path_org = $path;
    
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }

    if (substr($path_org,0,1) == "/") {
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    } else {
        $my = my_dir();
        if ($my)
            if (substr($path_org,0,2) == "../")
                return $my . "/" . implode(DIRECTORY_SEPARATOR, $absolutes);
            else
                return implode(DIRECTORY_SEPARATOR, $absolutes);
        else
            return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}


// http://kr2.php.net/dirname
function my_dir(){
    return end(explode('/', dirname(!empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : !empty($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : str_replace('\\','/',__FILE__))));
}


// 파일의 경로를 가지고 옵니다 (불당팩, /lib/common.lib.php에 정의된 함수)
if(!function_exists('file_path')){
function file_path($path) {

    $dir = dirname($path);
    $file = basename($path);
    
    if (substr($dir,0,1) == "/") {
        $real_dir = dirname($_SERVER['DOCUMENT_ROOT'] . "/nothing");
        $dir = $real_dir . $dir;
    }
    
    return $dir . "/" . $file;
}
}


// 실제 존재하는 사이트의 경우에만 url을 지정해줍니다
// http://scriptplayground.com/tutorials/php/Simple-Way-to-Validate-Links/
function set_http2($url, $mb_id="") {

    global $g4, $member;

    if (!$url)
        return "";
    else
        $url = set_http($url);

    $u2 = @parse_url($url);
    if (!$u2)
        return "";
    $uhost = $u2['host'];

    $fp = @fsockopen($uhost, 80, $errno, $errstr, 1);

    if ($fp) {
        // 회원 id가 있는 경우 회원정보의 관련 필드들을 인증 한다
        if ($mb_id) {
            $sql = " update $g4[member_table] set mb_homepage_certify='$g4[time_ymdhis]' where mb_id = '$mb_id' ";
            sql_query($sql);
        }
    }
    else 
    {
        // 회원 id가 있는 경우 회원정보의 관련 필드들을 clear 한다
        if ($mb_id) {
            $sql = " update $g4[member_table] set mb_homepage='', mb_homepage_certify='0000-00-00 00:00:00' where mb_id = '$mb_id' ";
            sql_query($sql);
        }
        $url = "";
    }
    
    return $url;
}


// 디렉토리의 용량 (KB)
// http://kr.php.net/manual/kr/function.filesize.php   
function get_dir_size($path)                           
{                       
    $result=explode("\t", @exec("du -k -s ".$path),2);
    return ($result[1]==$path ? $result[0] : "error"); 
}


// ip의 특정부분을 감춰버립니다
function str_rev_ip($str, $pos=2, $mask='♡') 
{ 
    global $is_admin;

    $ar=explode(".",$str); 
    $ar[4 - $pos] = $mask;
    return "$ar[3].$ar[2].$ar[1].$ar[0]"; 
}


// memo4_send - 불당표 쪽지4 보내기
function memo4_send($me_recv_mb_id, $me_send_mb_id, $me_memo, $me_subject, $me_option="", $mb_memo_call="1", $file_name0="", $file_name3="") 
{ 
        global $g4, $config;
        
        // 쪽지 INSERT (수신함)
        $sql = " insert into $g4[memo_recv_table]
                        ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                 values ('$me_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$me_recv_mb_id', '', '', '$me_option' ) ";
        sql_query($sql);
        $me_id = mysql_insert_id();

        // 쪽지 INSERT (발신함 - me_id는 발신함의 me_id와 동일하게 유지)
        $sql = " insert into $g4[memo_send_table]
                        ( me_id,  me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                 values ( $me_id,  '$me_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'send', '$me_send_mb_id', '', '', '$me_option' ) ";
        $result = @sql_query($sql);

        // 중복 오류가나오면? - index를 +10 시켜준다. 그정도면 충분.
        if ( !$result ) {
            $sql = " update $g4[memo_recv_table] set me_id = me_id + 10 where me_id = '$me_id' ";
            sql_query($sql);

            // 쪽지 INSERT (발신함 - me_id는 발신함의 me_id와 동일하게 유지)
            $sql = " insert into $g4[memo_send_table]
                            ( me_id,  me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                     values ( $me_id,  '$me_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'send', '$me_send_mb_id', '', '', '$me_option' ) ";
            $result = @sql_query($sql);
        }

        // 첨부파일 정보 업데이트
        $sql = " update $g4[memo_recv_table]
                      set me_file_local = '$file_name0', me_file_server = '$file_name3' 
                      where me_id = $me_id ";
        sql_query($sql);
        // 첨부파일 정보 업데이트
        $sql = " update $g4[memo_send_table]
                      set me_file_local = '$file_name0', me_file_server = '$file_name3' 
                      where me_id = $me_id ";
        sql_query($sql);

        // 안읽은 쪽지 갯수, 쪽지 수신 날짜를 업데이트
        $sql = " update $g4[member_table]
                    set mb_memo_unread=mb_memo_unread+1, mb_memo_call_datetime='$g4[time_ymdhis]' 
                  where mb_id = '$me_recv_mb_id' ";
        sql_query($sql);

        // 쪽지 수신 알림 기능
        if ($mb_memo_call)
        {
            $sql = " update $g4[member_table]
                        set mb_memo_call = concat(mb_memo_call, concat(' ', '$me_send_mb_id'))
                      where mb_id = '$me_recv_mb_id' ";
            sql_query($sql);
        }

        // 자동응답 기능
        $mb = get_member($me_recv_mb_id, "mb_nick, mb_memo_no_reply, mb_memo_no_reply_text");
        if ($config[cf_memo_no_reply] && $mb[mb_memo_no_reply]) {
            $me_subject = "$mb[mb_nick]님의 [자동응답] 메시지 입니다.";
            $me_memo = "당분간 쪽지를 수신할 수 없습니다. 확인후 연락드리겠습니다.<BR><BR>$mb[mb_memo_no_reply_text]";

            // 쪽지 INSERT (수신함)
            $sql = " insert into $g4[memo_recv_table]
                            ( me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                     values ('$me_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'recv', '$me_recv_mb_id', '', '', '$me_option' ) ";
            sql_query($sql);
            $me_id = mysql_insert_id();
                
            // 쪽지 INSERT (발신함 - me_id는 발신함의 me_id와 동일하게 유지)
            $sql = " insert into $g4[memo_send_table]
                            ( me_id,  me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo, me_subject, memo_type, memo_owner, me_file_local, me_file_server, me_option )
                     values ( $me_id,  '$me_recv_mb_id', '$me_send_mb_id', '$g4[time_ymdhis]', '$me_memo', '$me_subject', 'send', '$me_send_mb_id', '', '', '$me_option' ) ";
            sql_query($sql);
              
        }
}

// 쪽지5 - cancel / delete
function memo4_cancel($me_id) {

    global $g4, $member;

    // $g4['memo_delete'] == 1, 무조건 지운다.
    $memo_delete = "";
    if ($g4['memo_delete']) {
        $memo_delete = " and memo_owner='$member[mb_id]' ";
    }

    // 발신 테이블에서, 정보를 가져 옵니다.
    $sql = " select * from $g4[memo_send_table] where me_id = '$me_id' ";
    $result = sql_fetch($sql);

    // 발신자와 삭제하려는 사람이 다르면 안되겠죠?
    if ($result[me_send_mb_id] !== $member[mb_id]) 
        alert("바르지 못한 사용입니다");

    // trash에 쪽지를 넣어두기 - 그냥 지워버리기 위해서.
    //$sql = "insert into $g4[memo_trash_table] select *, 'send' from $g4[memo_send_table] where me_id = '$me_id' and me_send_mb_id='$member[mb_id]' $memo_delete ";
    $me = sql_fetch("select * from $g4[memo_send_table] where me_id = '$me_id' and me_send_mb_id='$member[mb_id]' $memo_delete ");
    $sql = " insert into $g4[memo_trash_table]
                set me_id = '$me[me_id]',
                    me_recv_mb_id = '$me[me_recv_mb_id]',
                    me_send_mb_id = '$me[me_send_mb_id]',
                    me_send_datetime = '$me[me_send_datetime]',
                    me_read_datetime = '$me[me_read_datetime]',
                    me_memo = '$me[me_memo]',
                    me_file_local = '$me[me_file_local]',
                    me_file_server = '$me[me_file_server]',
                    me_subject = '$me[me_subject]',
                    memo_type = '$me[memo_type]',
                    memo_owner = '$member[mb_id]',
                    me_option = '$me[me_option]',
                    me_from_kind = 'send' ";
    sql_query($sql, FALSE);

    // 발신함을 삭제 합니다.
    $sql = " delete from $g4[memo_send_table] where me_id = '$me_id' and me_send_mb_id = '$member[mb_id]' $memo_delete ";
    sql_query($sql);

    // 수신함의 쪽지를 읽지 않은 경우에는 삭제해버립니다 - 회수의 개념 입니다. 좀 황당은 하지만.
    if ($result[me_read_datetime] == '0000-00-00 00:00:00') {
        $sql = " delete from $g4[memo_recv_table] where me_id = '$me_id' and me_send_mb_id = '$member[mb_id]' ";
        sql_query($sql);

        // 쪽지 수신자의 쪽지함에서 읽지 않은 쪽지 갯수를 업데이트
        sql_query(" update $g4[member_table] set mb_memo_unread = mb_memo_unread - 1 where mb_id = '$result[me_recv_mb_id]' ");

        // 쪽지 알림에서 하나를 차감
        $mb = get_member($result[me_recv_mb_id], "mb_memo_call"); 

        $memo_call = preg_replace("/$member[mb_nick]/" , '', $mb[mb_memo_call], 1);
        sql_query(" update $g4[member_table] set mb_memo_call = '$memo_call' where mb_id = '$result[me_recv_mb_id]' ");
    }
}


// 이메일 암호화 - http://davidwalsh.name/php-email-encode-prevent-spam
function encode_email($e)
{
    for ($i = 0; $i < strlen($e); $i++) { $output .= '&#'.ord($e[$i]).';'; }
  	return $output;
}


// 날짜비교
function days_diff($date2)
{
    global $g4;

    if ($date2 == "")
        return;

    $_date1 = explode("-", $g4['time_ymd']);
    $_date2 = explode("-",$date2);

    $tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]); 
    $tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]); 

    return (int) ($tm1 - $tm2) / 86400; 
}


// 시간비교
function hours_diff($date2)
{
    global $g4;

    // 현재시간
    $_date1 = $g4[server_time];

    // 비교할 시간
    $_date2 = strtotime($date2);

    return (int) ($_date1 - $_date2) / 3600; 
}


// ip 함호화 - http://sir.co.kr/bbs/board.php?bo_table=g4_tiptech&wr_id=20523
function encode_ip($ip)
{
    return crc32($ip);
}


// 게시판 설정 테이블에서 하나의 행을 읽음
function get_board($bo_table, $fields='*')
{
    global $g4;

    return sql_fetch(" select $fields from $g4[board_table] where bo_table = '$bo_table' ");
}

// 게시의 게시글 하나를 읽음
function get_write2($bo_table, $wr_id, $fields='*')
{
    global $g4;

    $tmp_write_table = $g4[write_prefix] . $bo_table;

    return sql_fetch(" select $fields from $tmp_write_table where wr_id = '$wr_id' ");
}


// email 주소 일부 암호화 (가영아빠님)
function encode_mail_form($email, $encode_count=2, $fields='*')
{
    $mail=explode("@",$email); 
    $email=substr($mail[0],0,$encode_count).str_repeat($fields,strlen($mail[0]))."@".$mail[1]; 

    return $email;
}


// 지정된 tag를 삭제
// http://kr.php.net/manual/kr/function.strip-tags.php
function strip_only($str, $tags) {
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
    return $str;
}


// 최신글 함수를 찾아서 그 값을 replace (최신글이 들어가는 템플릿 프로세싱)
function latest_replace($matches) {
    global $g4;

    $latest_match = $matches[1];
    list($skin, $bo_table, $rows, $subj_len, $gallery_view, $options)=explode(",",$latest_match); 

    //function latest($skin_dir="", $bo_table, $rows=10, $subject_len=40, $gallery_view=0, $options="")
    $latest_data = latest($skin, $bo_table, $rows, $subj_length, $gallery_view, $options);

    return $latest_data;
}


// 한줄의 공지글 - 공지사항이 있으면 공지사항을 출력, 없으면 게시글을 random하게 출력
function one_line_notice($bo_table, $title_len= "60", $class="") {
    global $g4;

    $tmp_board = sql_fetch(" select bo_notice from {$g4['board_table']} where bo_table = '$bo_table' ");
    $notice_list = trim($tmp_board[bo_notice]);
    if ($notice_list) {
        $notice_array = explode("\n", $notice_list);
        $notice_id = array_rand($notice_array);
        $tmp_wr_id = $notice_array[$notice_id];
        $sql = " select wr_id, wr_subject, wr_datetime from {$g4[write_prefix]}{$bo_table} where wr_id = '$tmp_wr_id' ";
    } else {
        $sql = " select wr_id, wr_subject, wr_datetime from {$g4[write_prefix]}{$bo_table} where wr_is_comment = '0' order by rand() limit 1 ";
    }
    $notice = sql_fetch($sql);
    if ($notice[wr_id]) {
        $result = $notice;
        if ($class)
            $class = " class='$class' ";
        $result['link'] = "<a href='$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$notice[wr_id]' $class>" . conv_subject($notice['wr_subject'],$title_len) . "</a>";
    } else {
        $result[link] = "";
    }
    
    return $result;
}


/** 
 * Converts human readable file size (e.g. 10 MB, 200.20 GB) into bytes. 
 * 
 * @param string $str 
 * @return int the result is in bytes 
 * @author Svetoslav Marinov 
 * @author http://slavi.biz 
 */ 
if(!function_exists('filesize2bytes')){
function filesize2bytes($str) { 
    $bytes = 0; 

    $bytes_array = array( 
        'B' => 1, 
        'KB' => 1024, 
        'MB' => 1024 * 1024, 
        'GB' => 1024 * 1024 * 1024, 
        'TB' => 1024 * 1024 * 1024 * 1024, 
        'PB' => 1024 * 1024 * 1024 * 1024 * 1024, 
    ); 

    $bytes = floatval($str); 

    if (preg_match('#([KMGTP]?B)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) { 
        $bytes *= $bytes_array[$matches[1]]; 
    } 

    $bytes = intval(round($bytes, 2)); 

    return $bytes; 
} 
}


// 파일캐쉬를 DB로 대신하는 것, $c_code = "latest(simple, gnu4_pack)"
function db_cache($c_name, $seconds=300, $c_code) {

    global $g4;

    $result = sql_fetch(" select c_name, c_text, c_datetime from $g4[cache_table] where c_name = '$c_name' ");
    if (!$result) {
        // 시간을 offset 해서 입력 (-1을 해줘야 처음 call에 캐쉬를 만듭니다)
        $new_time = date("Y-m-d H:i:s", $g4['server_time'] - $seconds - 1);
        $result['c_datetime'] = $new_time;
        sql_query(" insert into $g4[cache_table] set c_name='$c_name', c_datetime='$new_time' ");
    }

    $sec_diff = $g4['server_time'] - strtotime($result['c_datetime']);
    if ($sec_diff > $seconds) {

        // $c_code () 안에 내용만 살림 
        $pattern = "/[()]/";
        $tmp_c_code = preg_split($pattern, $c_code);
        
        // 수행할 함수의 이름
        $func_name = $tmp_c_code[0];

        // 수행할 함수의 인자
        $tmp_array = explode(",", $tmp_c_code[1]);
        
        if ($func_name == "include_once" || $func_name == "include") {

            ob_start();
            include($tmp_array[0]);
            $c_text = ob_get_contents();
            ob_end_clean();

        } else {
        
        // 수행할 함수의 인자를 담아둘 변수
        $func_args = array();

        for($i=0;$i < count($tmp_array); $i++) {
            // 기본 trim은 여백 등을 없앤다. $charlist = " \t\n\r\0\x0B"
            $tmp_args = trim($tmp_array[$i]);
            // 추가 trim으로 인자를 넘길 때 쓰는 '를 없앤다
            $tmp_args = trim($tmp_args, "'");
            // 추가 trim으로 인자를 넘길 때 쓰는 "를 없앤다
            $func_args[$i] = trim($tmp_args, '"');
        }
        // 새로운 캐쉬값을 만들고
        $c_text = call_user_func_array($func_name, $func_args);
        }

        // 값이 없으면 그냥 return
        if (trim($c_text) == "")
            return;

        // db에 넣기전에 slashes들을 앞에 싹 붙여 주시고
        $c_text1 = addslashes($c_text);
        
        // 새로운 캐쉬값을 업데이트 하고
        sql_query(" update $g4[cache_table] set c_text = '$c_text1', c_datetime='$g4[time_ymdhis]' where c_name = '$c_name' ");

        // 새로운 캐쉬값을 return (slashes가 없는거를 return 해야합니다)
        return $c_text;

    } else {

        // 캐쉬한 데이터를 그대로 return
        return $result['c_text'];

    }
}


function br2nl($string, $line_break=PHP_EOL) {
    $patterns = array(    
                        "/(<br>|<br \/>|<br\/>)\s*/i",
                        "/(\r\n|\r|\n)/"
    );
    $replacements = array(    
                            PHP_EOL,
                            $line_break
    );
    $string = preg_replace($patterns, $replacements, $string);
    return $string;
}

//  <BR>을 nl로 변환 - http://us.php.net/manual/en/function.nl2br.php
/*
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
} 

function br2nl($string){ 
  $return=preg_replace('/<BR[[:space:]]*\/?/i'. 
    '[[:space:]]*>',chr(13).chr(10),$string);
  return $return; 
} 
*/


// http://kr.php.net/implode]
if(!function_exists('implode_wrapped')){
function implode_wrapped($before, $after, $glue, $array){
    $output = '';
    foreach($array as $item){
        $output .= $before . $item . $after . $glue;
    }
    return substr($output, 0, -strlen($glue));
}
}


// http://blog.naver.com/xitem?Redirect=Log&logNo=140113457912
// PHP암호화 함수
function encrypt($data,$k) { 
  $encrypt_these_chars = "1234567890ABCDEFGHIJKLMNOPQRTSUVWXYZabcdefghijklmnopqrstuvwxyz.,/?!$@^*()_+-=:;~{}";
  $t = $data;
  $result2;
  $ki;
  $ti;
  $keylength = strlen($k);
  $textlength = strlen($t);
  $modulo = strlen($encrypt_these_chars);
  $dbg_key;
  $dbg_inp;
  $dbg_sum;
  for ($result2 = "", $ki = $ti = 0; $ti < $textlength; $ti++, $ki++) {
    if ($ki >= $keylength) {
      $ki = 0;
    }
    $dbg_inp += "["+$ti+"]="+strpos($encrypt_these_chars, substr($t, $ti,1))+" ";  
    $dbg_key += "["+$ki+"]="+strpos($encrypt_these_chars, substr($k, $ki,1))+" ";  
    $dbg_sum += "["+$ti+"]="+strpos($encrypt_these_chars, substr($k, $ki,1))+ strpos($encrypt_these_chars, substr($t, $ti,1)) % $modulo +" ";
    $c = strpos($encrypt_these_chars, substr($t, $ti,1));
    $d;
    $e;
    if ($c >= 0) {
      $c = ($c + strpos($encrypt_these_chars, substr($k, $ki,1))) % $modulo;
      $d = substr($encrypt_these_chars, $c,1);
      $e .= $d;
    } else {
      $e += $t.substr($ti,1);
    }
  }
  $key2 = $result2;
  $debug = "Key  : "+$k+"\n"+"Input: "+$t+"\n"+"Key  : "+$dbg_key+"\n"+"Input: "+$dbg_inp+"\n"+"Enc  : "+$dbg_sum;
  return $e . "";
}


function decrypt($key2,$secret) {
  $encrypt_these_chars = "1234567890ABCDEFGHIJKLMNOPQRTSUVWXYZabcdefghijklmnopqrstuvwxyz.,/?!$@^*()_+-=:;~{}";
  $input = $key2;
  $output = "";
  $debug = "";
  $k = $secret;
  $t = $input;
  $result;
  $ki;
  $ti;
  $keylength = strlen($k);
  $textlength = strlen($t);
  $modulo = strlen($encrypt_these_chars);
  $dbg_key;
  $dbg_inp;
  $dbg_sum;
  for ($result = "", $ki = $ti = 0; $ti < $textlength; $ti++, $ki++) {
    if ($ki >= $keylength){
      $ki = 0;
    }
    $c = strpos($encrypt_these_chars, substr($t, $ti,1));
    if ($c >= 0) {
      $c = ($c - strpos($encrypt_these_chars , substr($k, $ki,1)) + $modulo) % $modulo;
      $result .= substr($encrypt_these_chars , $c, 1);
    } else {
      $result += substr($t, $ti,1);
    }
  }
  return $result;
}


// 불당팩 - 제목에서 특수문자를 싹~ 날려버릴꺼야~!
// 한번에 날리니까 잘 안날라가서 한개씩 날립니다.
function remove_special_chars($subject) {

    global $g4;

    // 없애고 싶은 문자열은 config.php에서 정의 합니다.
    $change = $g4['special_chars_change'];

    // euc-kr 일 경우 utf-8로 변환한다.
    if (strtolower($g4[charset]) == 'euc-kr') {
        $subject = iconv('EUC-KR','UTF-8',$subject);

        $change = iconv("EUC-KR", "UTF-8", $change);
    }

    // 문자열을 치환 합니다.
    $subject = preg_replace("/[$change]/u", "_", $subject);

    // euc-kr 일 경우 utf-8을 다시 euc-kr 변환한다.
    if (strtolower($g4[charset]) == 'euc-kr') {
        $subject = iconv('UTF-8','EUC-KR',$subject);
    }

    return $subject;
}


// ip 주소를 unit 32 숫자로
// http://www.zedwood.com/article/144/php-mysql-geoip-lookup
function ipaddress_to_uint32($ip) {
    list($v4,$v3,$v2,$v1) = explode(".", $ip);
    return ($v4*256 *256*256) + ($v3*256*256) + ($v2*256) + ($v1);
}


// ip의 국가명을 return
// http://www.zedwood.com/article/144/php-mysql-geoip-lookup
function ipaddress_to_country_code($ip) {
    global $g4;

    $i = ipaddress_to_uint32($ip);

    $query   = "select * from $g4[geoip_table] where ip32_start<= $i and $i <=ip32_end;";
    $result  = sql_fetch($query);
    
    return $result['country_code'];
}


// 특정 테이블의 컬럼 이름을 얻기 - http://www.codediesel.com/mysql/selecting-all-except-some-columns-in-mysql/
function get_column_names($table_name) {
    global $g4;

    $query = "SHOW COLUMNS FROM {$table_name}";

    if(($result=sql_query($query, $conn))) {
 
        $column_names = array();
        while ($row = sql_fetch_array($result)) {
            $column_names[] = $row['Field'];
        }

        return $column_names;
    }
    else
        return 0;
}


// 특정 테이블의 컬럼 이름이 빠진 SQL select 목록 얻기 - http://www.codediesel.com/mysql/selecting-all-except-some-columns-in-mysql/
function except_sql_statement($table_name, $exclude) {
    global $g4;

    $column_names = get_column_names($table_name);
    $statement = "";

    foreach($column_names as $name) {
        if(!in_array($name, $exclude)) {
            if($statement == "")
                $statement = $name;
            else
                $statement .= "," . $name;
        }
    }
 
    return $statement;
}


// 포인트 경매 auction.lib.php 에서 가져옴
function alert_only($msg='')
{
	global $g4;

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
	echo "<script language='javascript'>alert('$msg');</script>";
    exit;
}


// 유니크로 로그 기록하기
function insert_unicro_log($mb_id, $log_message='', $log_url='')
{
    global $config;
    global $g4;
    global $is_admin;

    // 유니크로 로그를 기록
    $sql = " insert into $g4[unicro_log_table]
                set mb_id = '$mb_id',
                    log_datetime = '$g4[time_ymdhis]',
                    log_message = '".addslashes($log_message)."',
                    log_ip = '$_SERVER[REMOTE_ADDR]',
                    log_url = '$log_url' ";
    sql_query($sql);
}


// 게시판별 인기글 키워드 확인
function popular_list($pop_cnt=7, $date_cnt=7, $bo_table='') 
{
    global $config, $g4;

    if ($bo_table) $bo_sql = " and bo_table = '$bo_table' ";

    $date_gap = date("Y-m-d", $g4[server_time] - ($date_cnt * 86400));
    $sql = " select pp_word, sum(pp_count) as cnt from $g4[popular_sum_table]
              where pp_date between '$date_gap' and '$g4[time_ymd]' and pp_word != '' 
              $bo_sql
              group by pp_word
              order by cnt desc, pp_word
              limit 0, $pop_cnt ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        // 스크립트등의 실행금지
        $list[$i][pp_word] = get_text($row[pp_word]);
        $list[$i][cnt] = $row[cnt];
        $list[$i][sfl] = $row[sfl];
    }
    
    return $list;
}

// 신고 - 게시판 쓰기 제한
function check_singo_nowrite($bo_singo_nowrite, $bo_table='')
{
    global $g4, $board, $member;

    // $bo_singo_nowrite를 explode 합니다.
    $singo_array = explode("|", trim($bo_singo_nowrite));
    foreach ($singo_array as $key => $val) {
        $res = explode(",", trim($val));
        if ($res) {
            $singo2_days[$res[0]] = $res[0];
            $singo2_count[$res[1]] = $res[1];
        }
    }
    // 입력된 배열의 갯수
    $singo_array_count = count($singo2_count);
    // 배열을 정렬하기 (days 값 기준으로)
    array_multisort($singo2_days, $singo2_count);
    // 최대 신고 확인일
    $max_singo_days = $singo2_days[$singo_array_count-1];

    // sort되면서 흐트러진 key 값을 다시 지정해주기
    for ($i=0; $i < count($singo2_days); $i++) {
        $singo2_days2[$singo2_days[$i]-1] = $singo2_days[$i];
        //$singo2_count2[$singo2_days[$i]-1] = $singo2_count[$i];

        // 본인인증 회원의 경우, 신고 카운터에서 1개를 빼줍니다.
        if ($member[mb_realcheck] == "0000-00-00 00:00:00")
            $singo2_count2[$singo2_days[$i]-1] = $singo2_count[$i];
        else
            $singo2_count2[$singo2_days[$i]-1] = $singo2_count[$i] - 1;
    }

    // 사용자 아이디
    $mb_id = $member[mb_id];
    
    // $bo_table이 있는 경우에는 해당 게시판에 대해서만
    if ($bo_table)
        $sql_bo_table = " AND bo_table = '$bo_table' ";
    else
        $sql_bo_table = "";

    // 대부분의 사용자는 신고건수가 없기 때문에, 신고건수가 있는 사람만 cost가 많이 들어가는 sql을 수행하게 합니다.
    $sql = " SELECT count(*) as cnt from $g4[singo_table] 
              WHERE mb_id = '$mb_id' $sql_bo_table
                AND sg_datetime > '" . date("Y-m-d H:i:s", $g4[server_time] - $max_singo_days * 86400) ."' ";
    $result = sql_fetch($sql);
    if ($result[cnt] == 0)
        return false;

    // 신고제한에 걸리는지 확인해 봅니다.
    $sql = " SELECT to_days(now())-to_days(sg_datetime) AS t_diff, count( * ) AS cnt, date_format( sg_datetime, '%Y-%m-%d' ) 
               FROM `$g4[singo_table]` 
              WHERE mb_id = '$mb_id' $sql_bo_table
                AND (to_days(now())-to_days(sg_datetime)-$max_singo_days) < 0
              GROUP BY t_diff
          ";
    $result = sql_query($sql);

    // 결과값을 배열에 넣습니다
    for($i=0; $row = sql_fetch_array($result); $i++) {
        $singo_result[$row[t_diff]] = $row[cnt];
    }
    
    $sum = 0;
    for($i=0; $i < $max_singo_days; $i++) {
        $sum += $singo_result[$i];
        if ($singo2_days2[$i] && $singo2_count2[$i] && $singo2_days2[$i] == ($i+1) && $sum >= $singo2_count2[$i]) {
            echo "$singo2_days2[$i]일 동안 신고된 건수가 $singo2_count2[$i]건을 초과하였습니다.";
            return true;
        }
    }

    return false;
}


// 회원 레벨(권한)명 얻기
function get_gl_name($mb_level)
{
    global $g4;

    $sql = "select gl_name from $g4[member_group_table] where gl_id = '$mb_level'";
    $row = sql_fetch($sql, FALSE);

    if (!$row)
        $gl_name = $mb_level;
    else
        $gl_name = $row['gl_name'];

    return $gl_name;
}

// 이미지 정보를 읽어서 DB에 저장
// 이미지 정보를 읽어서 db에 넣어 줍니다.
function get_chimage($string)
{ 
    global $g4, $board, $member, $_SESSION;

    // 변수를 setting
    $return = $string['0']; 
    preg_match_all('@(?P<attribute>[^\s\'\"]+)\s*=\s*(\'|\")?(?P<value>[^\s\'\"]+)(\'|\")?@i', $return, $match);
    if (function_exists('array_combine')) {
        $img = array_change_key_case(array_combine($match['attribute'], $match['value']));
    }
    else {
        $img = array_change_key_case(array_combine4($match['attribute'], $match['value']));
    }

    // 가끔씩 img의 파일이름이 깨어지는 경우가 있어서 decoding 해줍니다 (예: &#111;&#110; = on)
    $img['src'] = html_entity_decode($img[src]); 

    // 이미지 파일의 경로를 설정 (외부? 내부? 내부인경우 절대경로? 상대경로?)
    if (preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $img['src'])) {
        // 내 서버에 있는 이미지?
        $img_src = @getimagesize($img['src']);
        if (preg_match("/" . $_SERVER[HTTP_HOST] . "/", $img[src], $matches)) {
            $url = parse_url($img[src]);
            $img[src] = $url[path];
        } else {
            return "";
        }
    }

    // update 모드일 때, 업로드 정보를 DB에 저장 합니다.
    if ($g4[w] == "u") {
        $sql = " select bc_id from $g4[board_cheditor_table] where bo_table='$g4[bo_table]' and wr_id='$g4[wr_id]' and bc_url like '%" . $img[src] . "' and del = '1' ";
        $result = sql_fetch($sql);

        // 이미 올라간 파일이면 사용중이라고 del field를 업데이트 하고 return
        if ($result[bc_id]) {
            $sql = "update $g4[board_cheditor_table] set del = '0' where bc_id = '$result[bc_id]' ";
            sql_query($sql);

            return $return; 
        }
    }

    // $img[src] 웹 상의 절대경로 이므로 이미지 파일의 상대경로를 구합니다.
    // 이렇게 잘라줘야 제대로 된 경로가 나온다.
    $fl = explode("/$g4[data]/",$img[src]);
    $rel_path = "../" . $g4[data] . "/" . $fl[1];
    $path = pathinfo($rel_path);
    $bc_dir = $path['dirname'];
    $bc_file = $path['basename'];

    // 이미지 정보를 구합니다
    $im = getimagesize($rel_path);
    
    // filesize는 KB 단위로 저장
    $fs = filesize2bytes(filesize($rel_path))/1000;

    // sub 디렉토리에 설치된 경우...으... 머리아퍼
    $bc_path = $g4[data] . "/" . $fl[1];

    // source file 이름을 가져 온다
    $sql = " select * from $g4[board_cheditor_table] where bo_table='$g4[bo_table]' and wr_id is null and bc_file = '$bc_file' and bc_url like '%$bc_path' ";
    $sc = sql_fetch($sql);

    if ($sc[bc_id]) {
        // 있으면 업데이트 해준다
        $sql = " UPDATE $g4[board_cheditor_table]
                SET 
                    bc_url = '".$img[src]."',
                    bc_dir = '".$bc_dir."',
                    bc_file = '".$bc_file."',
                    bc_width = '". $im[0] ."',
                    bc_height = '". $im[1] ."',
                    bc_type = '". $im[2] ."',
                    bc_filesize = '". $fs ."',
                    bc_ip = '".$g4[ip_addr]."',
                    mb_id = '".$member['mb_id']."',
                    bo_table = '". $g4[bo_table] ."',
                    wr_id = '".$g4[wr_id]."',
                    bc_datetime = '".$g4[time_ymdhis]."'
              where bc_id = '$sc[bc_id]'
                     ";
        sql_query($sql);
    } else {
        // 없으면 새로 넣어준다
        $sql = " INSERT INTO $g4[board_cheditor_table]
                SET 
                    bc_url = '".$img[src]."',
                    bc_dir = '".$bc_dir."',
                    bc_file = '".$bc_file."',
                    bc_width = '". $im[0] ."',
                    bc_height = '". $im[1] ."',
                    bc_type = '". $im[2] ."',
                    bc_filesize = '". $fs ."',
                    bc_ip = '".$g4[ip_addr]."',
                    mb_id = '".$member['mb_id']."',
                    bo_table = '". $g4[bo_table] ."',
                    wr_id = '".$g4[wr_id]."',
                    bc_datetime = '".$g4[time_ymdhis]."'
                     ";
        sql_query($sql);
    }

    return $return; 
}


// 지정된 날짜 이전의 글은 볼 수 없게 하기
function check_bo_from_date()
{
    global $is_admin, $view, $board;

    if (!$view)
        return false;

    $date1 = date("Y-m-d");
    $date2 = cut_str($view[wr_datetime], 10, "");
   
    $_date1 = explode("-",$date1); 
    $_date2 = explode("-",$date2); 

    $tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]); 
    $tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]); 

    $date_diff = ($tm1 - $tm2) / 86400; 
    if ($board[bo_from_date] and  $date_diff > $board[bo_from_date] and !$is_admin) 
    {
        alert("시스템에서 조회를 허용하지 않는 오래된 글 입니다. 관리자에게 문의하시기 바랍니다.");
    }
    
    return true;
}

// 남성/여성이 bo_sex 필드에 M/F로 등록된 경우에만 게시판을 접근을 허용 
function check_bo_sex()
{
    global $board, $member, $is_admin;
    
    if($board[bo_sex]) {
        if ($member[mb_sex]) { 
          if (($board[bo_sex] == $member[mb_sex]) || $is_admin)
              {;} 
          else 
          { 
              alert("엄마/이모는 엄마방에만, 아빠/삼촌은 아빠방에만 접근할 수 있습니다"); 
          } 
        } else {
            alert("성별을 등록한 회원만 엄마/이모, 아빠/삼촌 게시판을 이용할 수 있습니다. 개인정보를 수정해주세요.",  "$g4[bbs_path]/member_confirm.php?url=register_form.php");
        }
    }
    
    return true;
}

// http://www.creativecommons.or.kr/xe/?mid=licenses
function mw_get_ccl_info($ccl)
{
    $info = array();

    switch ($ccl)
    {
        case "by":
            $info[by] = "by";
            $info[nc] = "";
            $info[nd] = "";
            $info[kr] = "저작자표시";
            break;
        case "by-nc":
            $info[by] = "by";
            $info[nc] = "nc";
            $info[nd] = "";
            $info[kr] = "저작자표시-비영리";
            break;
        case "by-sa":
            $info[by] = "by";
            $info[nc] = "";
            $info[nd] = "sa";
            $info[kr] = "저작자표시-동일조건변경허락";
            break;
        case "by-nd":
            $info[by] = "by";
            $info[nc] = "";
            $info[nd] = "nd";
            $info[kr] = "저작자표시-변경금지";
            break;
        case "by-nc-sa":
            $info[by] = "by";
            $info[nc] = "nc";
            $info[nd] = "sa";
            $info[kr] = "저작자표시-비영리-동일조건변경허락";
            break;
        case "by-nc-nd":
        default :
            $info[by] = "by";
            $info[nc] = "nc";
            $info[nd] = "nd";
            $info[kr] = "저작자표시-비영리-변경금지";
            break;
    }
    $info[ccl] = $ccl;
    $info[msg] = "크리에이티브 커먼즈 코리아 $info[kr] 2.0 대한민국 라이센스에 따라 이용하실 수 있습니다.";
    //$info[link] = "http://creativecommons.org/licenses/{$ccl}/2.0/kr/";
    $info[link] = "http://www.creativecommons.or.kr/xe/?mid=licenses";
    
    return $info;
}

// 관련글 얻기.. 080429, curlychoi
function mw_related($related, $count, $field="wr_id, wr_subject, wr_content")
{
    global $bo_table, $write_table, $g4, $view;

    if (!trim($related)) return;

    $view[wr_related] = "";
    
    $sql_wr_id = " and wr_id != '$view[wr_id]' ";

    $sql_where = "";
    $related = explode(",", $related);
    foreach ($related as $rel) {
        $rel = trim($rel);
        if ($rel) {
            $rel = addslashes($rel);
            if ($sql_where) {
                $sql_where .= " or ";
            }
            $sql_where .= " (instr(wr_subject, '$rel')>0 or instr(wr_content, '$rel')>0) ";
        }
    }

    if ($g4['old_stype_search']) {
        $sql = "select $field from $write_table where wr_is_comment = 0 and FIND_IN_SET('secret',wr_option) = 0 {$sql_wr_id} and ($sql_where) order by wr_num limit 0, $count ";
        $result = sql_query($sql);
    } else {
        // tmp 테이블을 만들고, 그곳에서 order by와 limit를 한다.
        $sql = "select $field, wr_num from $write_table where wr_is_comment = 0 and FIND_IN_SET('secret',wr_option) = 0 {$sql_wr_id} and ($sql_where) ";
        $sql_tmp = " create TEMPORARY table related_tmp_table as $sql ";
        $sql_ord = " select * from related_tmp_table order by wr_num limit 0, $count ";

        @mysql_query($sql_tmp) or die("<p>$sql_tmp<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
        $result = @mysql_query($sql_ord) or die("<p>$sql_ord<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    }

    $list = array();
    $i = 0;
    while ($row = sql_fetch_array($result)) {
        $row[href] = "$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$row[wr_id]";
        $row[comment] = $row[wr_comment] ? "<span class='comment'>($row[wr_comment])</span>" : "";
        $row[subject] = get_text($row[wr_subject]);
        $list[] = $row;
        if (++$i >= $count) {
            break;
        }
    }

    return $list;
}


// 디렉토리의 끝에 슬래쉬 한개를 붙인다
function rslash($dpath)
{
    return rtrim($dpath, "/") . "/";
}


// 회원 레벨을 업/다운 합니다.
function member_level_up($mb_id)
{
    global $g4;

    $mb = get_member($mb_id);

    $up_check = 0;
    $down_check = 0;

    $sql = " select *, 
                    (up_days+up_point+up_post+up_post_all+good) as sum_up,
                    (down_point+down_post+down_post_all+nogood+singo) as sum_down
                from $g4[member_level_table] 
               where member_level = '$mb[mb_level]' and (use_levelup = 1 or use_leveldown = 1)";
    $result = sql_fetch($sql);

    // 레벨업
    if ($result && $result['use_levelup'] && $result['sum_up'] > 0) {

        // 가입일을 확인해서 체류기간이 안되었으면 pass. 체류기간은 levelup 할 때만 확인
        $wtime = date("Y-m-d", $g4[server_time] - ($result[up_days] * 86400)); 
        if ($mb[mb_level_datetime] != "0000-00-00 00:00:00")
            $jtime = substr($mb[mb_level_datetime],0,10);
        else
            $jtime = substr($mb[mb_datetime],0,10);

        // time format으로 변경
        $wtime = strtotime($wtime ." 00:00:00");
        $jtime = strtotime($jtime ." 00:00:00");

        if ($wtime >= $jtime) {
            // 포인트
            if ($result['up_point'] && $mb['mb_point'] >= $result['up_point']) 
                $up_check = $up_check + 1;
            else
                $up_check = -1000;

            //검증일수가 있으면 해당 일수 만큼만 최신글을 확인
            if ($result['up_audit_days'])
                $sql_audit = " and bn_datetime > '".date("Y-m-d H:i:s", $g4[server_time] - (86400 * $result[up_audit_days]))."' ";
            else
                $sql_audit = "";

            // 게시글 수 (게시글 확인은 전체 최근글 구간에 대해서 실시)
            if ($result['up_post']) {
                $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$mb[mb_id]' and wr_id = wr_parent $sql_audit ";
                $chk = sql_fetch($sql);
                if ($chk['cnt'] >= $result['up_post'])
                    $up_check = $up_check + 1;
                else
                    $up_check = -1000;
            }

            // 전체 게시글 수 (코멘트 포함)
            if ($result['up_post_all']) {
                $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$mb[mb_id]' $sql_audit ";
                $chk = sql_fetch($sql);
                if ($chk['cnt'] >= $result['up_post_all'])
                    $up_check = $up_check + 1;
                else
                    $up_check = -1000;
            }

            //검증일수가 있으면 추천수를 해당 날짜만큼만 확인
            if ($result['up_audit_days'])
                $sql_audit = " and bg_datetime > '".date("Y-m-d H:i:s", $g4[server_time] - (86400 * $result[up_audit_days]))."' ";
            else
                $sql_audit = "";
                
            // 추천수 (비추천수를 차감)
            if ($result['good']) {
                $sql = " select count(*) as cnt from $g4[board_good_table] where mb_id = '$mb[mb_id]' and bg_flag = 'good' $sql_audit ";
                $chk = sql_fetch($sql);
                if ($chk['cnt'] >= $result['good']) {
                    $sql2 = " select count(*) as cnt from $g4[board_good_table] where mb_id = '$mb[mb_id]' and bg_flag = 'nogood' $sql_audit ";
                    $chk2 = sql_fetch($sql2);
                    if (($chk['cnt']-$chk2['cnt']) >= $result['good'])
                        $up_check = $up_check + 1;
                    else
                        $up_check = -1000;

                }
            }

            if ($up_check > 0) {
                // 회원정보 db를 업데이트
                $sql = " update $g4[member_table] set mb_level = mb_level+1, mb_level_datetime = '$g4[time_ymdhis]' where mb_id = '$mb[mb_id]' ";
                sql_query($sql);
                // 회원레벨 history에 insert
                $sql = " insert 
                           into $g4[member_level_history_table] 
                            set mb_id           = '$mb[mb_id]',
                                from_level      = '$mb[mb_level]',
                                to_level        = '" . (int)($mb[mb_level]+1) . "',
                                level_datetime  = '$g4[time_ymdhis]' ";
                sql_query($sql);
                
                $rstr = "$mb[mb_id] 회원이 레벨업 되었습니다";
            }
            
            // 레벨업이 이루어진 경우에는 레벨다운을 수행하지 않게 코드를 패쓰~!
            $result['sum_down'] = "";
        }
    } 
    else 
    if ($mb['mb_level'] >= 2 && $up_check != 0 && $result && $result['use_leveldown'] && $result['sum_down'] > 0) {  // 레벨다운

        // 포인트
        if ($result['down_point'] > 0 && $result['down_point'] < $mb['mb_point']) 
            $down_check = $down_check + 1;
        else
            $down_check = -1000;

        // 게시글 수 (게시글 확인은 전체 최근글 구간에 대해서 실시)
        if ($result['down_post'] > 0) {
            $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$mb[mb_id]' and wr_id = wr_parent ";
            $chk = sql_fetch($sql);
            if ($chk['cnt'] < $result['down_post'])
                $down_check = $down_check + 1;
            else
                $down_check = -1000;
        }
        // 전체 게시글 수 (코멘트 포함)
        if ($result['down_post_all'] > 0) {
            $sql = " select count(*) as cnt from $g4[board_new_table] where mb_id = '$mb[mb_id]' ";
            $chk = sql_fetch($sql);
            if ($chk['cnt'] < $result['down_post_all'])
                $down_check = $down_check + 1;
            else
                $down_check = -1000;
        }

        //검증일수가 있으면 추천수를 해당 날짜만큼만 확인
        if ($result['down_audit_days'])
            $sql_audit = " and bg_datetime > '".date("Y-m-d H:i:s", $g4[server_time] - (86400 * $result[down_audit_days]))."' ";
        else
            $sql_audit = "";

        // 비추천수 (추천수를 차감하지 않음)
        if ($result['nogood'] > 0) {
            $sql = " select count(*) as cnt from $g4[board_good_table] where mb_id = '$mb[mb_id]' and bg_flag = 'nogood' $sql_audit ";
            $chk = sql_fetch($sql);
            if ($chk['cnt'] >= $result['nogood'])
                $down_check = $down_check + 1;
            else
                $down_check = -1000;
        }

        // 신고
        if ($result['singo'] > 0) {
            $sql = " select count(*) as cnt from $g4[singo_table] where mb_id = '$mb[mb_id]' $sql_audit ";
            $chk = sql_fetch($sql);
            if ($chk['cnt'] >= $result['nogood'])
                $down_check = $down_check + 1;
            else
                $down_check = -1000;
        }
        
        if ($down_check > 0) {
            // 회원정보 db를 업데이트
            $sql = " update $g4[member_table] set mb_level = mb_level-1, mb_level_datetime = '$g4[time_ymdhis]' where mb_id = '$mb[mb_id]' ";
            sql_query($sql);
            // 회원레벨 history에 insert
            $sql = " insert 
                       into $g4[member_level_history_table] 
                        set mb_id           = '$mb[mb_id]',
                            from_level      = '$mb[mb_level]',
                            to_level        = '" . (int)($mb[mb_level]-1) . "',
                            level_datetime  = '$g4[time_ymdhis]' ";
            sql_query($sql);

            $rstr = "$mb[mb_id] 회원이 레벨다운 되었습니다";
        }
    }

    return $rstr;
}

// sideview를 출력
function print_sideview($mb_id, $board) {
    global $config, $g4;

    $subject_mb = get_member($mb_id, "mb_id, mb_nick, mb_name, mb_email, mb_email_certify, mb_homepage, mb_homepage_certify");

    // 게시판에 출력할 글쓴이의 이름/닉네임이 바뀌었을 때 어떻게 될까요? 몰래 닉네임 바꾸고 장난치면 어찌 될까요?
    if ($board[bo_use_name])
        $tmp_name = $subject_mb[mb_name];
    else
        $tmp_name = $subject_mb[mb_nick];

    $tmp_name = get_text(cut_str($tmp_name, $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    $subject_sideview = get_sideview($subject_mb['mb_id'], $tmp_name, $subject_mb['wr_email'], $subject_mb['wr_homepage']);

    return $subject_sideview;
}

// 게시판에 게시글을 신규로 insert 합니다.
function board_write($bo_table, $mb_id)
{
    global $g4;
    global $ca_name, $html, $secret, $mail, $wr_subject, $wr_content, $wr_link1, $wr_link2, $wr_related, $wr_good, $wr_nogood;
    global $bf_file, $bf_source, $bf_type, $bf_width, $bf_height;
    global $wr_1, $wr_2, $wr_3, $wr_4, $wr_5, $wr_6, $wr_7, $wr_8, $wr_9, $wr_10;

    // 게시판 정보
    $board = get_board($bo_table);

    // 회원 정보
    $member = get_member($mb_id);

    // 게시판 정보를 얻습니다 - 신규 insert 기준
    $g4_id = $board[gr_id];
    $write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $wr_num = get_next_num($write_table);
    $wr_reply = "";
    $wr_name = $board[bo_use_name] ? $member[mb_name] : $member[mb_nick];
    $wr_password = $member[mb_password];
    $wr_email = $member[mb_email];
    $wr_homepage = $member[mb_homepage];
        
    $sql = " insert into $write_table
                set wr_num = '$wr_num',
                    wr_reply = '$wr_reply',
                    wr_comment = 0,
                    ca_name = '$ca_name',
                    wr_option = '$html,$secret,$mail',
                    wr_subject = '$wr_subject',
                    wr_content = '$wr_content',
                    wr_link1 = '$wr_link1',
                    wr_link2 = '$wr_link2',
                    wr_link1_hit = 0,
                    wr_link2_hit = 0,
                    wr_hit = 0,
                    wr_good = '$wr_good',
                    wr_nogood = '$wr_nogood',
                    mb_id = '$member[mb_id]',
                    wr_password = '$wr_password',
                    wr_name = '$wr_name',
                    wr_email = '$wr_email',
                    wr_homepage = '$wr_homepage',
                    wr_datetime = '$g4[time_ymdhis]',
                    wr_last = '$g4[time_ymdhis]',
                    wr_ip = '$_SERVER[REMOTE_ADDR]',
                    wr_related = '$wr_related',
                    wr_1 = '$wr_1',
                    wr_2 = '$wr_2',
                    wr_3 = '$wr_3',
                    wr_4 = '$wr_4',
                    wr_5 = '$wr_5',
                    wr_6 = '$wr_6',
                    wr_7 = '$wr_7',
                    wr_8 = '$wr_8',
                    wr_9 = '$wr_9',
                    wr_10 = '$wr_10' ";

    sql_query($sql);
    $wr_id = mysql_insert_id();

    // 부모 아이디에 UPDATE
    sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

    // 새글 INSERT
    sql_query(" insert into $g4[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id, wr_is_comment, gr_id, wr_option, parent_mb_id) 
                values ( '$bo_table', '$wr_id', '$wr_id', '$g4[time_ymdhis]', '$member[mb_id]', '0', '$gr_id', '$secret', '$parent_mb_id[mb_id]') "); 
    
    // 게시글 1 증가
    sql_query("update $g4[board_table] set bo_count_write = bo_count_write + 1, bo_modify_datetime = '$g4[time_ymdhis]' where bo_table = '$bo_table'");

    // 불당팩 - min_wr_num 업데이트
    $result = sql_fetch(" select MIN(wr_num) as min_wr_num from $write_table ");
    $sql = " update $g4[board_table] set min_wr_num = '$result[min_wr_num]' where bo_table = '$bo_table' ";
    sql_query($sql);

    // 첨부파일 insert
    if ($bf_file) {
        $sql = " insert into $g4[board_file_table]
                    set bo_table = '$bo_table',
                        wr_id = '$wr_id',
                        bf_no = '0',
                        bf_source = '$bf_source',
                        bf_file = '$bf_file',
                        bf_content = '$wr_subject',
                        bf_download = 0,
                        bf_filesize = '',
                        bf_width = '$bf_width',
                        bf_height = '$bf_height',
                        bf_type = '$bf_type',
                        bf_datetime = '$g4[time_ymdhis]' ";
        sql_query($sql);
    }

    // 불당팩 - 첨부파일의 갯수 파악
    $sql = " select count(*) as cnt from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_source <> '' ";
    $result = sql_fetch($sql);

    // 불당팩 - 첨부파일 갯수 업데이트
    $sql = " update $write_table set wr_file_count = '$result[cnt]' where wr_id = '$wr_id' ";
    sql_query($sql);

    // 불당팩 - CCL 정보 업데이트
    if ($board[bo_ccl]) {
        $wr_ccl = "";
        if ($wr_ccl_by == "by") { $wr_ccl .= "by"; }
        if ($wr_ccl_nc == "nc") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "nc"; }
        if ($wr_ccl_nd == "nd") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "nd"; }
        if ($wr_ccl_nd == "sa") { $wr_ccl .= $wr_ccl ? "-": ""; $wr_ccl .= "sa"; }

        sql_query("update $write_table set wr_ccl = '$wr_ccl' where wr_id = '$wr_id'");
    }
}

// 줄바꿈 없애기, http://huddak.net/bbs/board.php?bo_table=cm_free&wr_id=3629
function remove_nr($str) {
    $reg_e = array('/\n/', '/\r/', '/\"/', "/<\/script>/i"); 
    $reg_p = array(' ', ' ', '\\"', "<\/SCRIPT>"); 

    return preg_replace($reg_e, $reg_p, $str);
}

// 개인정보지킴이 - http://opencode.co.kr/bbs/board.php?bo_table=gnu4_tips&wr_id=913
function save_me($content) {

    // 주민번호
    $content1 = preg_replace_callback("/(?<![\d+_%])\d{2}[0-1]\d[0-3]\d[-\s]?[1-8]\d{6}/", 'save_jumin', $content);

    // 핸드폰번호
    $content2 = preg_replace_callback("/(?<![\d+_%])(010|011|016|017|018|019)[-\s]\d{3,4}[-\s]\d{4}/", 'save_mobile', $content1);

    // 전화번호
    $content3 = preg_replace_callback("/(?<![\d+_%])(070|02|031|032|033|041|042|043|051|052|053|054|055|061|062|063|064)[-\s]\d{3,4}[-\s]\d{4}/", 'save_phone', $content2);

    // 이메일
    $content4 = preg_replace_callback("/(?<![\d+_%])[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/", 'save_email', $content3);

    return $content4;
}

// 이메일을 mask
function save_email($string)
{
    // @를 기준으로 문자열을 자른 후
    $str = explode("@", $string[0]);

    // 앞부분은 모두 mask
    $mask1 = strlen($str[0]);
    $str1 = substr_replace($str[0], str_repeat("*", $mask1), 0, $mask1);

    // 뒷부분은 첫번째를 모두 mask
    $tmp = explode(".", $str[1]);
    $mask2 = strlen($tmp[0]);
    $tmp[0] = substr_replace($tmp[0], str_repeat("*", $mask2), 0, $mask2);
    $str2 = implode(".", $tmp);

    $return = $str1 . "@" . $str2;

    return $return; 
}

// 주민번호를 mask, 주민번호를 몇개의 key만 살리고 모두 mix + str_shuffle
function save_jumin($string)
{ 
    // "-" 또는 SPACE로 explode
    $str = preg_split("/-|\s/", $string[0]);
    
    // 3자리를 *로 바꾸고 str_shuffle. *로 바꾸는 시작 위치는 추정을 막기 위해서 랜덤
    if (count($str) == 2) {
        $str1 = str_shuffle(substr_replace($str[0], "***", rand(0,2), 3));
        $str2 = str_shuffle(substr_replace($str[1], "***", rand(0,3), 3));
        $return = $str1 . "-" . $str2;
    } else {
        // 공백이 없이 숫자가 붙어 있는 경우
        $str1 = str_shuffle(substr_replace($str[0], "******", rand(0,2), 6));
        $return = $str1;
    }

    return $return;
}

// 핸드폰 번호를 mask, 01* - *** - ****, 폰의 자릿수만 그대로 나온다.
function save_mobile($string)
{ 
    // "-" 또는 SPACE로 explode
    $str = preg_split("/-|\s/", $string[0]);
    $return = substr_replace($str[0], "*", 2) . "-" . str_repeat("*", strlen($str[1])) . "-" . str_repeat("*", strlen($str[2]));

    return $return;
}

// 전화번호를 mask, 국번 추정을 못하게 국번은 무조건 3개로 mask
function save_phone($string)
{ 
    // "-" 또는 SPACE로 explode
    $str = preg_split("/-|\s/", $string[0]);
    $return = substr_replace($str[0], "**", 1, 2) . "-" . str_repeat("*", strlen($str[1])) . "-" . str_repeat("*", strlen($str[2]));

    return $return;
}

// 정해진 자릿수의 알파뉴메릭 순서를 생성
// http://stackoverflow.com/questions/12000979/alphanumeric-increment-a-string-in-php-to-a-certain-length
function getNextAlphaNumeric($code, $digit=4) {
    $base_ten = base_convert($code,36,10);
    $result = base_convert($base_ten+1,10,36);
    $result = str_pad($result, $digit, '0', STR_PAD_LEFT);
    $result = strtoupper($result);
    return $result;
}

// 바이트를 보기 좋은 형식으로 출력
// http://stackoverflow.com/questions/2510434/php-format-bytes-to-kilobytes-megabytes-gigabytes
function formatBytes($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');  
    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}


function redis_cache($c_name, $seconds=300, $c_code) {

    global $g4;
  
    $redis = new Redis();
    $redis->connect($g4["rhost"], $g4["rport"]);
    $redis->select(0);
    if ($redis->ttl($c_name) > 0)
        return $redis->get($c_name);
    else {

        // $c_code () 안에 내용만 살림 
        $pattern = "/[()]/";
        $tmp_c_code = preg_split($pattern, $c_code);
        
        // 수행할 함수의 이름
        $func_name = $tmp_c_code[0];

        // 수행할 함수의 인자
        $tmp_array = explode(",", $tmp_c_code[1]);
        
        if ($func_name == "include_once" || $func_name == "include") {

            ob_start();
            include($tmp_array[0]);
            $c_text = ob_get_contents();
            ob_end_clean();

        } else {
        
        // 수행할 함수의 인자를 담아둘 변수
        $func_args = array();

        for($i=0;$i < count($tmp_array); $i++) {
            // 기본 trim은 여백 등을 없앤다. $charlist = " \t\n\r\0\x0B"
            $tmp_args = trim($tmp_array[$i]);
            // 추가 trim으로 인자를 넘길 때 쓰는 '를 없앤다
            $tmp_args = trim($tmp_args, "'");
            // 추가 trim으로 인자를 넘길 때 쓰는 "를 없앤다
            $func_args[$i] = trim($tmp_args, '"');
        }
        // 새로운 캐쉬값을 만들고
        $c_text = call_user_func_array($func_name, $func_args);
        }

        // 값이 없으면 그냥 return
        if (trim($c_text) == "")
            return;

        // redis의 cache 값을 업데이트
        $redis->setex($c_name, $seconds, $c_text);

        // 새로운 캐쉬값을 return (slashes가 없는거를 return 해야합니다)
        return $c_text;
    }
}
?>