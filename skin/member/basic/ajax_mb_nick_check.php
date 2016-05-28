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

if (strtolower($g4[charset]) == 'euc-kr') 
    $reg_mb_nick = convert_charset('UTF-8','CP949',$reg_mb_nick);

// 별명은 한글, 영문, 숫자만 가능
if (!check_string($reg_mb_nick, _G4_HANGUL_ + _G4_ALPHABETIC_ + _G4_NUMERIC_)) {
    echo "110"; // 별명은 공백없이 한글, 영문, 숫자만 입력 가능합니다.
} else if (strlen($reg_mb_nick) < 4) {
    echo "120"; // 4글자 이상 입력
} else if (preg_match("/[\,]?{$reg_mb_nick}/i", $config[cf_prohibit_id])) {
    echo "140"; // 예약어로 금지된 회원아이디
} else {
    // 회원 테이블에서 확인
    $row = sql_fetch(" select count(*) as cnt from $g4[member_table] where mb_nick = '$reg_mb_nick' ");
    $mb_count = $row[cnt];
    // 불당팩 - 회원 nick 테이블에서 확인 (내가 썼던 닉네임은 다시 쓸 수 있게)
    $row = sql_fetch(" select count(*) as cnt from $g4[mb_nick_table] where mb_nick = '$reg_mb_nick' and mb_id <> '$member[mb_id]' ");
    $mb_count_pack = $row[cnt];
    if ($mb_count or $mb_count_pack) {
        echo "130"; // 이미 존재하는 별명
    } else {
        // 신고된 회원의 닉네임 변경을 할 수 없게 제한
        $row1 = sql_fetch(" select count(*) as cnt from $g4[singo_table] where mb_id = '$member[mb_id]' ");
        if ($row1['cnt'] > 0)
            echo "150"; // 신고가 있어서 닉네임 변경을 할 수 없슴
        else
            echo "000"; // 정상
    }
}
?>
