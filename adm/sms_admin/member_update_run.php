<?
$sub_menu = "900200";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$count      = 0;
$hp_yes     = 0;
$hp_no      = 0;
$hp_empty   = 0;
$leave      = 0;
$receipt    = 0;

// 회원 데이터 마이그레이션
$qry = sql_query("select mb_id, mb_name, mb_hp, mb_sms, mb_leave_date from $g4[member_table] order by mb_datetime");
while ($res = sql_fetch_array($qry)) 
{
    if ($res[mb_leave_date] != '') 
        $leave++;
    else if ($res[mb_hp] == '')
        $hp_empty++;
    else if (is_hp($res[mb_hp])) 
        $hp_yes++ ;
    else 
        $hp_no++;

    $hp = get_hp($res[mb_hp]);

    if ($hp == '') $bk_receipt = 0; else $bk_receipt = $res[mb_sms];

    $field = "mb_id='$res[mb_id]', bk_name='$res[mb_name]', bk_hp='$hp', bk_receipt='$bk_receipt', bk_datetime='$g4[time_ymdhis]'";

    $res2 = sql_fetch("select * from $g4[sms4_book_table] where mb_id='$res[mb_id]'");
    if ($res2) // 기존에 등록되어 있을 경우 업데이트
    {
        $res3 = sql_fetch("select count(*) as cnt from $g4[sms4_book_table] where mb_id='$res2[mb_id]'");
        $mb_count = $res3[cnt];

        // 회원이 삭제되었다면 핸드폰번호 DB 에서도 삭제한다.
        if ($res[mb_leave_date]) 
        {
            sql_query("delete from $g4[sms4_book_table] where mb_id='$res2[mb_id]'");

            $sql = "update $g4[sms4_book_group_table] set bg_count = bg_count - $mb_count, bg_member = bg_member - $mb_count";
            if ($res2[bk_receipt] == 1)
                $sql .= ", bg_receipt = bg_receipt - $mb_count";
            else
                $sql .= ", bg_reject = bg_reject - $mb_count";
            $sql .= " where bg_no='$res2[bg_no]'";

            sql_query($sql);
        }
        else
        {
            if ($bk_receipt != $res2[bk_receipt]) {
                if ($bk_receipt == 1)
                    $sql_sms = "bg_receipt = bg_receipt + $mb_count, bg_reject = bg_reject - $mb_count";
                else 
                    $sql_sms = "bg_receipt = bg_receipt - $mb_count, bg_reject = bg_reject + $mb_count";

                sql_query("update $g4[sms4_book_group_table] set $sql_sms where bg_no='$res2[bg_no]'");
            }
            
            if ($bk_receipt) $receipt++;

            sql_query("update $g4[sms4_book_table] set $field where mb_id='$res[mb_id]'");
        }
    }
    else if ($res[mb_leave_date] == '') // 기존에 등록되어 있지 않을 경우 추가 (삭제된 회원이 아닐 경우)
    {
        if ($bk_receipt == 1) {
            $sql_sms = "bg_receipt = bg_receipt + 1";
            $receipt++;
        } else {
            $sql_sms = "bg_reject = bg_reject + 1";
        }

        sql_query("insert into $g4[sms4_book_table] set $field, bg_no=1");
        sql_query("update $g4[sms4_book_group_table] set bg_count = bg_count + 1, bg_member = bg_member + 1, $sql_sms where bg_no=1");
    }

    $count++;
}

sql_query("update $g4[sms4_config_table] set cf_datetime='$g4[time_ymdhis]'");

?>
<script language=javascript>
var msg = "";
msg += "회원정보를 핸드폰번호 DB로 업데이트 하였습니다.";
msg += "<br>총 회원 수 : <?=number_format($count)?> 명";
msg += "<br>삭제된 회원 : <?=number_format($leave)?> 명";
msg += "<br>핸드폰번호 없음 : <?=number_format($hp_empty)?> 명";
msg += "<br><span style='color:blue;'>핸드폰번호 정상 : <?=number_format($hp_yes)?> 명</span>";
msg += "<br><span style='color:red;'>핸드폰번호 오류 : <?=number_format($hp_no)?> 명</span>";
msg += "<br><span style='color:blue;'>수신허용 : <?=number_format($receipt)?> 명</span>";
msg += "<br><span style='color:red;'>수신거부 : <?=number_format($hp_yes-$receipt)?> 명</span>";
msg += "<br>프로그램의 실행을 끝마치셔도 좋습니다.";

parent.document.getElementById('datetime').innerHTML = "<?=$g4[time_ymdhis]?>";
parent.document.getElementById('res').innerHTML = msg;
</script>
