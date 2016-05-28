<?
include_once("./_common.php");

// SMS 설정값 배열변수
$sms4 = sql_fetch("select * from $g4[sms4_config_table] ");

$err = null;

if (!$sms4[cf_member])
    $err = "문자전송이 허용되지 않았습니다.\\n\\n사이트 관리자에게 문의하여 주십시오.";

if (!$err and !$is_member)
    $err = "로그인 해주세요.";

if (!$err and $member[mb_level] < $sms4[cf_level])
    $err = "회원 $sms4[cf_level] 레벨 이상만 문자전송이 가능합니다.";

// 오늘 문자를 보낸 총 건수
$row = sql_fetch(" select count(*) as cnt from $g4[sms4_member_history_table] where mb_id='$member[mb_id]' and date_format(mh_datetime, '%Y-%m-%d') = '$g4[time_ymd]' ");
$total = $row[cnt];

// 건수 제한
if (!$err and $sms4[cf_day_count] > 0 && $is_admin != 'super') {
    if ($total >= $sms4[cf_day_count]) {
        $err = "하루에 보낼수 있는 문자갯수(".number_format($sms4[cf_day_count])." 건)를 초과하였습니다.";
    }
}

// 포인트 검사
if (!$err and $sms4[cf_point] > 0 && $is_admin != 'super') {
    if ($sms4[cf_point] > $member[mb_point])
        $err = "보유하신 포인트(".number_format($member[mb_point])." 포인트)가 없거나 모자라서\\n\\n문자전송(".number_format($sms4[cf_point])." 포인트)이 불가합니다.\\n\\n포인트를 적립하신 후 다시 시도 해 주십시오.";
}

// 특정회원에게 문자 전송
if ($mb_id) {
    $mb = get_member($mb_id);
    if (!$mb[mb_sms] || !$mb[mb_open]) {
        alert("정보를 공개하지 않았습니다.");
    }
    $hp = $mb[mb_hp];
}

$g4[title] = "문자전송";

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

include_once("$g4[path]/head.sub.php");

$sms_skin_path = $g4[sms_path] . "/skin/basic";

include_once("$sms_skin_path/write.skin.php");
?>

<script language="JavaScript">
function sms_error(obj, err) {
    alert(err);
    obj.value = '';
}

function smssend_submit(f)
{
    <? if ($err) { ?>
    alert("<?=$err?>");
    return false;
    <? } ?>

    if (!f.mh_message.value)
    {
        alert('보내실 문자를 입력하십시오.');
        f.mh_message.focus();
        return false;
    }

    if (!f.mh_reply.value)
    {
        alert('발신 번호를 입력하십시오.\n\n발신 번호는 회원정보의 핸드폰번호입니다.');
        return false;
    }
    var flag = false;
    var tmp = '';
    for (i=0; i<f.numbers.length; i++) {
        if (f.numbers[i].value.length > 0) {
            flag = true;
            tmp += f.numbers[i].value + ',';
        }
    }
    if (!flag) {
        alert('수신 번호를 하나 이상 입력하십시오.');
        return false;
    }

    f.mh_hp.value = tmp;

    return true;
    //f.submit();    
    //win.focus();
}

function booking_show()
{
    if (document.getElementById('booking_flag').checked) {
        document.getElementById('mh_by').disabled   = false;
        document.getElementById('mh_bm').disabled   = false;
        document.getElementById('mh_bd').disabled   = false;
        document.getElementById('mh_bh').disabled   = false;
        document.getElementById('mh_bi').disabled   = false;
    } else {
        document.getElementById('mh_by').disabled   = true;
        document.getElementById('mh_bm').disabled   = true;
        document.getElementById('mh_bd').disabled   = true;
        document.getElementById('mh_bh').disabled   = true;
        document.getElementById('mh_bi').disabled   = true;
    }
}

function byte_check(mh_message, sms_bytes)
{
    var conts = document.getElementById(mh_message);
    var bytes = document.getElementById(sms_bytes);

    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';

    for (i=0; i<conts.value.length; i++) 
    {
        ch = conts.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    bytes.innerHTML = cnt;

    if (cnt > 80) 
    {
        exceed = cnt - 80;
        alert('메시지 내용은 80바이트를 넘을수 없습니다.\n\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\n\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = conts.value;
        for (i=0; i<tmp.length; i++) 
        {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > 80) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        conts.value = tmp;
        bytes.innerHTML = xcnt;
        return;
    }
}

byte_check('mh_message', 'sms_bytes');

<? 
if ($hp) { 
    echo "document.getElementsByName('numbers')[0].value = '$hp'";
} 
?>
</script>

<?
include_once("$g4[path]/tail.sub.php");
?>
