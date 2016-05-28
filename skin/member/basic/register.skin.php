<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<form name="fregister" method="POST" onsubmit="return fregister_submit(this);" autocomplete="off">

<table width=600 cellspacing=0 align=center><tr><td align=center>

    <table width="100%" cellspacing="0" cellpadding="0">
    <tr> 
        <td align=center><img src="<?=$member_skin_path?>/img/join_title.gif" width="624" height="72"></td>
    </tr>
    </table>

    <? if ($g4['member_suggest_join']) { // 추천+가입인증으로만 가입가능하게 ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height=25></td>
        </tr>
        <tr>
            <td bgcolor="#cccccc" width=100%>
                <table cellspacing=1 cellpadding=0 width=100% border=0>
                <tr bgcolor="#ffffff"> 
                    <td width="140" height=30>&nbsp;&nbsp;&nbsp;<b>추천인아이디</b></td>
                    <td width="">&nbsp;&nbsp;&nbsp;<input name=mb_recommend itemname="추천인아이디" required class=ed></td>
                </tr>
                <tr bgcolor="#ffffff"> 
                    <td height=30>&nbsp;&nbsp;&nbsp;<b>가입인증번호</b></td>
                    <td>&nbsp;&nbsp;&nbsp;<input name=join_code itemname="가입인증번호" required maxlength=6 class=ed></td>
                </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height=25></td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" width=100%>
                <table cellspacing=1 width=100% border=0>
                <tr> 
                    <td>
                    <b><?=$config['cf_title']?>는 기존 회원의 추천을 통해서만 회원 가입이 가능</b>하며, <br>
                    추천인 아이디와 인증번호는 추천받은 분이 회원으로 가입후에는 사용할 수 없습니다 (1번의 추천=1번 가입). <br>
                    회원 가입문의는 <?=$config['cf_title']?> 회원분들께 하시기를 바랍니다.
                    </td>
                </tr>
                </table>
            </td>
        </tr>
    </table>
    <? } ?>

    <br>
    <table width="100%" cellpadding="4" cellspacing="0" bgcolor=#EEEEEE>
        <tr> 
            <td height=20>&nbsp; <b>회원약관</b></td>
        </tr>
        <tr> 
            <td align="center" valign="top"><textarea style="width: 98%" rows=5 readonly class=ed><?=get_text($config[cf_stipulation])?></textarea></td>
        </tr>
        <tr> 
            <td align="left" style="padding-left:190px;" height=20 valign=top><input type=checkbox value=1 name=agree id=agree>&nbsp;<label for=agree>동의합니다.</label>
            <input type=checkbox value=1 name=agree_no0 id=agree_no0 onClick="this.checked=false;history.go(-1);">&nbsp;<label for=agree_no0>동의하지 않습니다.</label>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="4" cellspacing="0" bgcolor=#EEEEEE>
        <tr> 
            <td colspan=3 height=20>&nbsp; <b>개인정보취급방침</b></td>
        </tr>
        <tr>
            <td align="center" valign="top" width="33%">
                <textarea style="width: 98%;" rows=5 readonly class=ed><?=get_text($config[cf_privacy_2])?></textarea>
            </td>
            <td align="center" valign="top" width="33%">
                <textarea style="width: 98%;" rows=5 readonly class=ed><?=get_text($config[cf_privacy_3])?></textarea>
            </td>
            <td align="center" valign="top"  width="33%">
                <textarea style="width: 98%;" rows=5 readonly class=ed><?=get_text($config[cf_privacy_1])?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan=3 align="left" style="padding-left:190px;" height=20 valign=top><input type=checkbox value=1 name=agree2 id=agree2>&nbsp;<label for=agree2>동의합니다.</label>
               <input type=checkbox value=1 name=agree_no2 id=agree_no2 onClick="this.checked=false;history.go(-1);">&nbsp;<label for=agree_no2>동의하지 않습니다.</label>
            </td>
        </tr>
    </table>
    


</td></tr></table>

<br>
<div align=center>
<input type=image src="<?=$member_skin_path?>/img/btn_agreement.gif" border=0>&nbsp;&nbsp;&nbsp;<img src="<?=$member_skin_path?>/img/btn_dont_agreement.gif" border=0 onClick="history.go(-1);" style="cursor:pointer;">
</div>

</form>


<script type="text/javascript">
function fregister_submit(f) 
{
    var agree1 = document.getElementsByName("agree");
    if (!agree1[0].checked) {
        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree1[0].focus();
        return false;
    }

    var agree2 = document.getElementsByName("agree2");
    if (!agree2[0].checked) {
        alert("개인정보취급방침의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree2[0].focus();
        return false;
    }

    f.action = './register_form.php';
    return true;
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>
