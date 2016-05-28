<?
include_once("_common.php");

if (!function_exists('convert_charset')) {
    /*
    -----------------------------------------------------------
        Charset 을 변환하는 함수
    -----------------------------------------------------------
    iconv 함수가 있으면 iconv 로 변환하고
    없으면 mb_convert_encoding 함수를 사용한다.
    둘다 없으면 사용할 수 없다.
    */
    function convert_charset($from_charset, $to_charset, $str) {

        if( function_exists('iconv') )
            return iconv($from_charset, $to_charset, $str);
        elseif( function_exists('mb_convert_encoding') )
            return mb_convert_encoding($str, $to_charset, $from_charset);
        else {
            include_once("$g4[bbs_path]/iconv.php");
            return iconv($from_charset, $to_charset, $str);
            //die("Not found 'iconv' or 'mbstring' library in server.");
        }
    }
}

$mb_name = convert_charset('UTF-8','CP949',$mb_name);

// 별명은 한글, 영문, 숫자만 가능
if (!check_string($mb_name, _G4_HANGUL_ + _G4_ALPHABETIC_)) {
    echo "110"; // 이름은 공백없이 한글, 영문만 입력 가능합니다.
} else if (strlen($mb_name) < 2) {
    echo "120"; // 2글자 이상 입력
} else if (preg_match("/[\,]?{$mb_name}/i", $config[cf_prohibit_id])) {
    echo "140"; // 예약어로 금지된 회원아이디
} else {
    echo "000"; // 정상
}
?>
