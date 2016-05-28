<?
$sub_menu = "900200";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "회원정보 업데이트";

include_once("$g4[admin_path]/admin.head.php");
?>

<script language="javascript">
function run()
{
    document.getElementById('res').innerHTML = '업데이트 중입니다. 잠시만 기다려 주십시오...';
    hiddenframe.document.location.href = 'member_update_run.php';
}
</script>

<?=subtitle($g4[title])?>

<div style="line-height:30px; margin-bottom:10px;">
새로운 회원정보로 업데이트 합니다.<br>
실행 후 '완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br>
마지막 업데이트 일시 : <span id='datetime'><?=$sms4[cf_datetime]?></span> <br>
</div>
<div id=res style="line-height:30px;">
<input type=button value='실     행' onclick=run() class='btn1'>
</div>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>
