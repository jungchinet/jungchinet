<?
include_once("./_common.php");

$row = get_member($mb_id, "mb_id, mb_email, mb_datetime");
if (!$row[mb_id])
    alert("존재하는 회원이 아닙니다.", $g4[path]);

if ($mb_md5) 
{
    $tmp_md5 = md5($row[mb_id].$row[mb_email].$row[mb_datetime]);
    if ($mb_md5 == $tmp_md5) 
    {
        sql_query(" update $g4[member_table] set mb_email_certify = '$g4[time_ymdhis]' where mb_id = '$mb_id' ");

        alert("E-mail 인증 처리를 완료 하였습니다.", $g4[path]);
    }
}

alert("제대로 된 값이 넘어오지 않았습니다.", $g4[path]);
?>
