<?
include_once("_common.php");

if (trim($reg_mb_email)=='') {
    echo "110"; // 입력이 없습니다.
} else if (!preg_match("/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/", $reg_mb_email)) {
    echo "120"; // E-mail 주소 형식에 맞지 않음
} else {
    $sql = " select count(*) as cnt from $g4[member_table] where mb_id <> '$reg_mb_id' and mb_email = '$reg_mb_email' ";
    $row = sql_fetch($sql);
    if ($row[cnt]) {
        echo "130"; // 이미 존재하는 이메일
    } else {
        //if (preg_match("/[\,]?{$reg_mb_email}\,/i", $config[cf_prohibit_id].","))
        if (preg_match("/[\,]?{$reg_mb_email}/i", $config[cf_prohibit_id]))
            echo "140"; // 예약어로 금지된 회원아이디
        else {
            // 금지 메일 도메인 검사 (register_form skin.php의 java script를 수정)
            $prohibit_email = explode(",", trim(strtolower(preg_replace("/(\r\n|\r|\n)/", ",", $config[cf_prohibit_email]))));
            $email_domain_arr = explode("@", strtolower($reg_mb_email));
            $email_domain = $email_domain_arr[1];
            if (in_array($email_domain, $prohibit_email))
                echo "150"; // 사용이 금지된 도메인
            else 
                echo "000"; // 정상
        }
    }
}
?>
