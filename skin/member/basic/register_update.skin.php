<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 핸드폰 번호와 인증번호가 같이 넘어 왔다면 
$mb_hp_certify_datetime = "0000-00-00 00:00:00"; 
if ($mb_hp && $mb_hp_certify) { 
    // 인증번호가 같다면 
    if (get_session("ss_hp_certify_number") == $mb_hp_certify) { 
        $mb_hp_certify_datetime = $g4['time_ymdhis']; // 현재시간 
    } 
    sql_query(" update $g4[member_table] set mb_hp_certify_datetime = '$mb_hp_certify_datetime' where mb_id = '$mb_id' "); 
} else if ($mb_hp_old && $mb_hp != $mb_hp_old) { 
    sql_query(" update $g4[member_table] set mb_hp_certify_datetime = '$mb_hp_certify_datetime' where mb_id = '$mb_id' "); 
}

// 추천에 의한 회원 가입시 member_join_table 변경하기
if ($w == "" && $g4[member_suggest_join]) 
{
    $sql = "update $g4[member_suggest_table] 
              set join_mb_id = '$mb_id', join_datetime = '$g4[time_ymdhis]', join_code = password('$join_code') 
              where mb_id = '$mb_recommend' and join_code = '$join_code' ";
    sql_query ($sql);
    echo $sql;
}
?>
