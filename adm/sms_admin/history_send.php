<?
$sub_menu = "900400";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$g4[title] = "문자전송중";

$list = array();

$write = sql_fetch("select * from $g4[sms4_write_table] where wr_no='$wr_no' and wr_renum=0");

$res = sql_fetch("select max(wr_renum) as wr_renum from $g4[sms4_write_table] where wr_no='$wr_no'");
$new_wr_renum = $res[wr_renum] + 1;

if ($w == 'f')
    $sql_flag = " and hs_flag=0 ";
else
    $sql_flag = "";

if ($wr_renum)
    $sql_renum = " and wr_renum='$wr_renum' ";
else
    $sql_renum = " and wr_renum=0 ";

$res = sql_fetch("select count(*) as cnt from $g4[sms4_history_table] where wr_no='$wr_no' $sql_renum $sql_flag");
if (!$res[cnt]) {
?>
    <script language=javascript>
    act = window.open('sms_ing.php', 'act', 'width=300, height=200');
    act.close();
    alert('재전송할 내역이 없습니다.');
    history.back();
    </script>
    <?
    exit;
}

$sql = sql_query("select * from $g4[sms4_history_table] where wr_no='$wr_no' $sql_renum $sql_flag");
while ($res = sql_fetch_array($sql))
{
    $res[bk_hp] = get_hp($res[bk_hp], 0);

    if ($g4[sms4_demo])
        $res[bk_hp] = '0100000000';

    array_push($list, $res);
}

$wr_total = count($list);

include_once("$g4[admin_path]/admin.head.php");

$SMS = new SMS4;
$SMS->SMS_con($sms4[cf_ip], $sms4[cf_id], $sms4[cf_pw], $sms4[cf_port]);

$reply = str_replace('-', '', trim($write[wr_reply]));

$result = $SMS->Add($list, $reply, '', '', $write[wr_message], '', $wr_total);

if ($result)
{
    $result = $SMS->Send();

    if ($result) //SMS 서버에 접속했습니다.
    {
        sql_query("insert into $g4[sms4_write_table] set wr_no='$wr_no', wr_renum='$new_wr_renum', wr_reply='$write[wr_reply]', wr_message='$write[wr_message]', wr_total='$wr_total', wr_datetime='$g4[time_ymdhis]'");

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
            sql_query("insert into $g4[sms4_history_table] set wr_no='$wr_no', wr_renum='$new_wr_renum', bg_no='$row[bg_no]', mb_id='$row[mb_id]', bk_no='$row[bk_no]', hs_name='$row[hs_name]', hs_hp='$row[hs_hp]', hs_datetime='$g4[time_ymdhis]', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='$hs_memo', hs_log='$log'");
        }
        $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

        sql_query("update $g4[sms4_write_table] set wr_success='$wr_success', wr_failure='$wr_failure' where wr_no='$wr_no' and wr_renum='$new_wr_renum'");
        sql_query("update $g4[sms4_write_table] set wr_re_total=wr_re_total+1 where wr_no='$wr_no' and wr_renum=0");
    }
    else alert("에러: SMS 서버와 통신이 불안정합니다.");
}
else alert("에러: SMS 데이터 입력도중 에러가 발생하였습니다.");

?>
<script language=javascript>
act = window.open('sms_ing.php', 'act', 'width=300, height=200');
act.close();
location.href = 'history_view.php?wr_no=<?=$wr_no?>&wr_renum=<?=$new_wr_renum?>';
</script>
<?
include_once("$g4[admin_path]/admin.tail.php");
?>
