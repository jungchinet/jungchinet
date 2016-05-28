<?
include_once("./_common.php");

$mb_md5 = mysql_real_escape_string($mb_md5);
if ($mb_md5) 
{
    $sql = " select mb_id, count(*) as cnt from $g4[member_suggest_table] where email_certify = '$mb_md5' and join_mb_id='' ";
    $result = sql_fetch($sql);
    if ($result['cnt'] == 1) {
        // $mb_md5를 저장해 둡니다.
        sql_query(" update $g4[member_suggest_table] set join_code = '$certify_number' where join_code = '$mb_md5' ");
        
        echo "회원가입에 필요한 추천인 아이디는 $result[mb_id], 인증번호는 $certify_number 입니다.<br>";
        echo "이메일의 인증번호 확인 링크를 클릭할 때마다 인증번호는 변경 됩니다.<br><br>";
        echo "회원가입 추천코드의 유효기간은 추천일부터 $g4[member_suggest_join_days]일 입니다.<br>";
        echo "회원가입 추천코드의 유효기간이 경과하는 경우 추천인에게 추천일갱신을 요청 하셔야 합니다.<br>";
        exit;
    }
}

alert("제대로 된 값이 넘어오지 않았습니다.", $g4[path]);
?>
