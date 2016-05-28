<?
$sub_menu = "900300";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$g4[title] = "문자전송중";

if (!trim($wr_reply))
    win_close_alert('회신 번호를 입력해주세요.');

if (!trim($wr_message))
    win_close_alert('메세지를 입력해주세요.');

if (!trim($send_list))
    win_close_alert('문자 메세지를 받을 핸드폰번호를 입력해주세요.');

$list = $hps = array();

$send_list = explode('/', $send_list);

while ($row = array_shift($send_list))
{
    $item = explode(',', $row);

    for ($i=1, $max = count($item); $i<$max; $i++)
    {
        if (!trim($item[$i])) continue;

        switch ($item[0])
        {
            case 'g': // 그룹전송
                $qry = sql_query("select * from $g4[sms4_book_table] where bg_no='$item[1]' and bk_receipt=1");
                while ($row = sql_fetch_array($qry))
                {
                    $row[bk_hp] = get_hp($row[bk_hp], 0);

                    if ($wr_overlap && array_overlap($hps, $row[bk_hp])) {
                        $overlap++;
                        continue;
                    }

                    array_push($list, $row);
                    array_push($hps, $row[bk_hp]);
                }
                break;

            case 'l':
                $mb_level = $item[$i];

                $qry = sql_query("select mb_id, mb_name, mb_nick, mb_hp from $g4[member_table] where mb_level='$mb_level' and mb_sms=1 and not (mb_hp='')");
                while ($row = sql_fetch_array($qry))
                {
                    $name = $row[mb_nick];
                    $hp = get_hp($row[mb_hp], 0);
                    $mb_id = $row[mb_id];

                    if ($wr_overlap && array_overlap($hps, $hp)) {
                        $overlap++;
                        continue;
                    }

                    $row = sql_fetch("select bg_no, bk_no from $g4[sms4_book_table] where mb_id='$row[mb_id]'");
                    $bg_no = $row[bg_no];
                    $bk_no = $row[bk_no];

                    array_push($list, array('bk_hp' => $hp, 'bk_name' => $name, 'mb_id' => $mb_id, 'bg_no' => $bg_no, 'bk_no' => $bk_no));
                    array_push($hps, $hp);
                }
                break;

            case 'h': // 권한(mb_leve) 선택

                $item[$i] = explode(':', $item[$i]);
                $hp = get_hp($item[$i][1], 0);
                $name = $item[$i][0];

                if ($wr_overlap && array_overlap($hps, $hp)) {
                    $overlap++;
                    continue;
                }

                array_push($list, array('bk_hp' => $hp, 'bk_name' => $name));
                array_push($hps, $hp);
                break;

            case 'p': // 개인 선택

                $row = sql_fetch("select * from $g4[sms4_book_table] where bk_no='$item[$i]'");
                $row[bk_hp] = get_hp($row[bk_hp], 0);

                if ($wr_overlap && array_overlap($hps, $row[bk_hp])) {
                    $overlap++;
                    continue;
                }
                array_push($list, $row);
                array_push($hps, $row[bk_hp]);
                break;
        }
    }
}

$wr_total = count($list);

// 예약전송
if ($wr_by && $wr_bm && $wr_bd && $wr_bh && $wr_bi) {
    $wr_booking = "$wr_by-$wr_bm-$wr_bd $wr_bh:$wr_bi";
    $booking = $wr_by.$wr_bm.$wr_bd.$wr_bh.$wr_bi;
} else {
    $wr_booking = '';
    $booking = '';
}

include_once("$g4[admin_path]/admin.head.php");

$SMS = new SMS4;
$SMS->SMS_con($sms4[cf_ip], $sms4[cf_id], $sms4[cf_pw], $sms4[cf_port]);

$reply = str_replace('-', '', trim($wr_reply));

$result = $SMS->Add($list, $reply, '', '', $wr_message, $booking, $wr_total);

if ($result)
{
    $result = $SMS->Send();

    if ($result) //SMS 서버에 접속했습니다.
    {
        $row = sql_fetch("select max(wr_no) as wr_no from $g4[sms4_write_table]");
        if ($row)
            $wr_no = $row[wr_no] + 1;
        else
            $wr_no = 1;

        sql_query("insert into $g4[sms4_write_table] set wr_no='$wr_no', wr_renum=0, wr_reply='$wr_reply', wr_message='$wr_message', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='$g4[time_ymdhis]'");

        $wr_success = 0;
        $wr_failure = 0;
        $count      = 0;

        foreach ($SMS->Result as $result)
        {
            list($phone, $code) = explode(":", $result);

            if (substr($code,0,5) == "Error")
            {
                $hs_code = substr($code,6,2);

                switch ($hs_code) {
                    case '02':	 // "02:형식오류"
                        $hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
                        break;
                    case '16':	 // "16:발송서버 IP 오류"
                        $hs_memo = "발송서버 IP가 잘못되어 전송이 실패하였습니다.";
                        break;
                    case '23':	 // "23:인증실패,데이터오류,전송날짜오류"
                        $hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
                        break;
                    case '97':	 // "97:잔여코인부족"
                        $hs_memo = "잔여코인이 부족합니다.";
                        break;
                    case '98':	 // "98:사용기간만료"
                        $hs_memo = "사용기간이 만료되었습니다.";
                        break;
                    case '99':	 // "99:인증실패"
                        $hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
                        break;
                    default:	 // "미 확인 오류"
                        $hs_memo = "알 수 없는 오류로 전송이 실패하었습니다.";
                        break;
                }
                $wr_failure++;
                $hs_flag = 0;
            }
            else
            {
                $hs_code = $code;
                $hs_memo = get_hp($phone, 1)."로 전송했습니다.";
                $wr_success++;
                $hs_flag = 1;
            }

            $row = array_shift($list);
            $row[bk_hp] = get_hp($row[bk_hp], 1);

            $log = array_shift($SMS->Log);
            sql_query("insert into $g4[sms4_history_table] set wr_no='$wr_no', wr_renum=0, bg_no='$row[bg_no]', mb_id='$row[mb_id]', bk_no='$row[bk_no]', hs_name='$row[bk_name]', hs_hp='$row[bk_hp]', hs_datetime='$g4[time_ymdhis]', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='$hs_memo', hs_log='$log'");
        }
        $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

        sql_query("update $g4[sms4_write_table] set wr_success='$wr_success', wr_failure='$wr_failure' where wr_no='$wr_no' and wr_renum=0");
    }
    else win_close_alert("에러: SMS 서버와 통신이 불안정합니다.");
}
else win_close_alert("에러: SMS 데이터 입력도중 에러가 발생하였습니다.");

function win_close_alert($msg) {

    $html = "<script language=javascript>
    act = window.open('sms_ing.php', 'act', 'width=300, height=200');
    act.close();
    alert('$msg');
    history.back();</script>";

    echo $html;
    exit;
}

?>
<script language=javascript>
act = window.open('sms_ing.php', 'act', 'width=300, height=200');
act.close();
location.href = 'history_view.php?wr_no=<?=$wr_no?>';
</script>
<?
include_once("$g4[admin_path]/admin.tail.php");
?>
