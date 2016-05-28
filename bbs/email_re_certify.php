<?
include_once("./_common.php");

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$g4[title] = "이메일 인증";
include_once("$g4[path]/_head.php");

if ($is_member) {
    $mb_id = $member[mb_id];
} else {
    $mb_id = $_SESSION['email_mb_id'];
    // 로그인후에 이동한 것이면
    if ($mb_id) {
        ;
    } else {
        set_session('email_mb_id', "");
        alert("이메일 인증을 위해 로그인 하시기 바랍니다.", "./login.php?$qstr&url=".urlencode("$_SERVER[PHP_SELF]"));
    }
}
$member = get_member($mb_id);

// 관리자는 이메일 재인증을 못하게 합니다.
if ($is_admin)
    die;

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
?>

<style type="text/css">
/* http://html.nhndesign.com/uio_factory/ui_pattern/box/1 */
.section1{position:relative;border:1px solid #e9e9e9;background:#fff;font-size:12px;line-height:normal;*zoom:1}
.section1 .hx{margin:0;padding:10px 0 7px 9px;border:1px solid #fff;background:#f7f7f7 url(img/br_section_title.gif) repeat-x left bottom;font-size:12px;line-height:normal;color:#333}
.section1 .tx{padding:10px;border-top:1px solid #e9e9e9;color:#666}
.section1 .section_more{position:absolute;top:9px;right:10px;font:11px Dotum, 돋움, Tahoma;color:#656565;text-decoration:none !important}
.section1 .section_more span{font:14px/1 Tahoma;color:#6e89aa}

/* http://html.nhndesign.com/uio_factory/ui_pattern/table/3 */
.tbl_type3,.tbl_type3 th,.tbl_type3 td{border:0}
.tbl_type3{width:100%;border-bottom:2px solid #dcdcdc;font-family:Tahoma;font-size:11px;text-align:center}
.tbl_type3 caption{display:none}
.tbl_type3 th{padding:7px 0 4px;border-top:2px solid #dcdcdc;background-color:#f5f7f9;color:#666;font-family:'돋움',dotum;font-size:12px;font-weight:bold}
.tbl_type3 td{padding:6px 0 4px;border-top:1px solid #e5e5e5;color:#4c4c4c}
</style>

<script type="text/javascript">
var member_skin_path = "<?=$member_skin_path?>";
</script>

<script type="text/javascript" src="<?="$g4[path]/js/jquery.js"?>"></script>
<script type="text/javascript" src="<?=$member_skin_path?>/jquery.ajax_register_form.js"></script>

<div class="section1">
  	<h2 class="hx">이메일 인증</h2>
	  <div class="tx">
  	인증받을 이메일주소를 입력하십시오.
  	<? if ($g4['email_certify_point']) { ?><br>이메일을 인증하면 <?=$g4['email_certify_point']?>포인트를 적립해 드립니다 (1회만 적립 됩니다).<? }?>
    <? 
    // 이메일인증을 사용하는 경우에는 추가 메시지를 출력해 줍니다.
    if ($config['cf_use_email_certify']) { ?>
    발송된 인증메일을 반드시 확인해야 로그인이 가능합니다.
    <? } ?>
	  </div>
</div>

<br>
<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=token value='<?=$token?>'>
<input type=hidden name=mb_id id='mb_id' value='<?=$member[mb_id]?>'>
<input type=hidden name=mb_email_enabled id="mb_email_enabled" value="" >

<table class="tbl_type3" border="1" cellspacing="0" summary="이메일인증">
<caption>이메일인증</caption>
<colgroup>
<col width="120px">
<col>
</colgroup>
<tbody>
<tr>
    <td class="ranking" scope="row">등록된 이메일</td>
    <td align=left>
    <?=$member['mb_email']?>
    <? if (!preg_match("/[1-9]/", $member[mb_email_certify])) echo "(인증되지 않음)"; else echo "(인증일자: " . cut_str($member[mb_email_certify],10,"") . ")"; ?>
    </td>
</tr>
    <tr>
    <td class="ranking" scope="row">변경할 이메일</td>
    <td align=left>
    <input class=m_text type=text id='mb_email' name='mb_email' required style="ime-mode:disabled" size=38 maxlength=100 value='<?=$member[mb_email]?>' onkeyup='reg_mb_email_check()'>
    &nbsp;<span id='msg_mb_email'></span>
    </td>
</tr>
</tbody>
</table>

<div style="margin-left:120px; margin-top:10px;"> 
    <input type=image id="btn_submit" src="<?=$g4[bbs_path]?>/img/btn_mail_send.gif" border=0 accesskey='s' title="메일발송에 몇초가 걸리므로 기다려 주세요." alt="submit">
    <!-- 이메일 인증을 하게 했고, 회원가입했으나 미인증된 경우 탈퇴 기능을 제공 합니다 -->
    <?// if ($config[cf_use_email_certify] && !preg_match("/[1-9]/", $member[mb_email_certify])) { ?>
        &nbsp;&nbsp;&nbsp;<a href="javascript:member_leave();"><img src="<?=$member_skin_path?>/img/leave_btn.gif" border=0 title="이메일이 인증되지 않아도 회원탈퇴를 할 수 있습니다." alt="회원탈퇴"></a> 
    <?// } ?>
</div>

</form>

<script type="text/javascript">
function fwrite_submit(f) {

    // E-mail 검사
    reg_mb_email_check();

    if (f.mb_email_enabled.value != '000') {
        alert('E-mail을 입력하지 않았거나 입력에 오류가 있습니다.');
        f.mb_email.focus();
        return false;
    }

    f.action = './email_re_certify_update.php';

    return true;
}

function member_leave() 
{ 
   if (confirm("정말 회원에서 탈퇴 하시겠습니까?")) 
            location.href = "<?=$g4[bbs_path]?>/mb_leave.php"; 
}
</script>

<?
include_once("$g4[path]/_tail.php");
?>
