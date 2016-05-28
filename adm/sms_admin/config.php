<?
$sub_menu = "900100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "SMS 기본설정";

$sms4[cf_ip] = '115.68.47.4';

if ($sms4[cf_id] && $sms4[cf_pw])
{
    $res = get_sock("http://www.smshub.co.kr/web_module/point_check.html?sms_id=$sms4[cf_id]&sms_pw=$sms4[cf_pw]");
    $res = explode(';', $res);
    $userinfo = array(
        'code'      => $res[0], // 결과코드
        'coin'      => $res[1], // 고객 잔액 (충전제만 해당)
        'gpay'      => $res[2], // 고객의 건수 별 차감액 표시 (충전제만 해당)
        'payment'   => 'A'  // 요금제 표시, A:충전제, 고정값
    );
}

include_once("../admin.head.php");

?>

<form name=fconfig method=post action='./config_update.php'  enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=cf_ip value='<?=$sms4[cf_ip]?>'>

<table cellpadding=0 cellspacing=0 width=100% border=0>
<colgroup width=20%></colgroup>
<colgroup width=80% bgcolor=#FFFFFF></colgroup>
<tr class='ht'>
    <td colspan=2 align=left><?=subtitle($g4[title])?></td>
</tr>
<tr><td colspan=2 height=2 bgcolor=#CCCCCC></td></tr>
<tr class=ht>
	<td>SMSHUB 서비스 신청</td>
	<td><a href='http://www.smshub.co.kr/rankup_module/rankup_member/member_article_r.html' target=_blank>http://www.smshub.co.kr/rankup_module/rankup_member/member_article_r.html</a></td>
</tr>
<tr class=ht>
	<td>SMSHUB 회원아이디</td>
	<td>
		<input type=text name=cf_id value='<?=$sms4[cf_id]?>' size=20 class=ed required itemname='SMSHUB 회원아이디'>
		<?=help("SMSHUB에서 사용하시는 회원아이디를 입력합니다.");?>	</td>
</tr>
<tr class=ht>
	<td>SMSHUB 패스워드</td>
	<td>
		<input type=password name=cf_pw class=ed value='<?=$sms4[cf_pw]?>' required itemname='SMSHUB 패스워드'>
		<?=help("SMSHUB에서 사용하시는 패스워드를 입력합니다.")?>
        <? if (!$sms4[cf_pw]) { ?>  &nbsp; 현재 패스워드가 입력되어 있지 않습니다.	<?}?> </td>
</tr>
<tr class=ht>
	<td>캐쉬 잔액</td>
	<td>
		<?=number_format($userinfo[coin])?> 캐쉬.
        <input type=button class=btn1 value='캐쉬충전' onclick="window.open('http://www.smshub.co.kr/rankup_module/rankup_member/login_r.html','smshub_payment','')">
    </td>
</tr>
<tr class=ht>
	<td>건수별 금액</td>
	<td>
		<?=number_format($userinfo[gpay])?> 캐쉬.
    </td>
</tr>
<tr class=ht>
	<td>회신번호</td>
	<td>
		<input type=text name=cf_phone value='<?=$sms4[cf_phone]?>' size=20 class=ed required telnumber itemname='회신번호'>
		<?=help("관리자 또는 보내시는분의 핸드폰번호를 입력하세요.<br><br>예) 010-123-4567");?>	</td>
	</td>
</tr>
<tr class=ht>
	<td>MYSQL USER</td>
	<td><?=$mysql_user?></td>
</tr>
<tr class=ht>
	<td>MYSQL DB</td>
	<td><?=$mysql_db?></td>
</tr>
<tr class=ht>
	<td>서버 IP</td>
	<td><?=$_SERVER[SERVER_ADDR]?></td>
</tr>

<tr class=ht>
	<td>회원간 문자전송</td>
	<td>
        <input type="checkbox" name=cf_member <?if ($sms4[cf_member]) echo 'checked'?>> 허용
		<?=help("허용에 체크하면 회원간에 문자전송이 가능합니다.");?>
	</td>
</tr>
<tr class=ht>
	<td>문자전송가능 레벨</td>
	<td>
        <select name=cf_level>
        <? for ($i=1; $i<=10; $i++) { ?>
        <option value='<?=$i?>' <?if ($sms4[cf_level] == $i) echo 'selected';?> > <?=$i?> </option>
        <? } ?>
        </select>
        레벨 이상
		<?=help("문자전송이 가능한 회원레벨을 선택해주세요.");?>
	</td>
</tr>
<tr class=ht>
	<td>문자전송 차감 포인트</td>
	<td>
		<input type=text name=cf_point value='<?=$sms4[cf_point]?>' size=10 class=ed required itemname="회원 문자전송 포인트"> 포인트
		<?=help("회원이 문자를 전송할시에 차감할 포인트를 입력해주세요. 0이면 포인트를 차감하지 않습니다.");?>
	</td>
</tr>

<tr class=ht>
	<td>문자전송 하루제한 갯수 </td>
	<td>
		<input type=text name=cf_day_count value='<?=$sms4[cf_day_count]?>' size=10 class=ed required itemname="회원 전송 하루제한 갯수"> 건
		<?=help("회원이 하루에 보낼수 있는 문자 갯수를 입력해주세요. 0이면 제한하지 않습니다.");?>
	</td>
</tr>

<tr><td colspan=2 height=1 bgcolor=#CCCCCC></td></tr>
</table>

<p align=center>
	<input type=submit class=btn1 accesskey='s' value='  확  인  '>
</p>

</form>


<?
include_once("../admin.tail.php");
?>
