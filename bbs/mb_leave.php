<?
include_once("./_common.php");

$g4[title] = "회원탈퇴";
include_once ("./_head.php");

// 비회원의 접근을 제한 합니다
if (!$member[mb_id]) {
    $msg = "비회원은 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.";
    alert($msg, "./login.php?url=".urlencode("./mb_leave.php"));
}
?>
        
<style type="text/css">
<!--
.col1 { color:#616161; }
.col2 { color:#868686; }
.pad1 { padding:5px 10px 5px 10px; }
.pad2 { padding:5px 0px 5px 0px; }
.bold { font-weight:bold; }
.center { text-align:center; }
.right { text-align:right; }
.ht { height:30px; }
-->
</style>

<div style="width:620px">
<p class='col1 pad1 bold'>회원탈퇴</p>
</div>

<div style="width:620px" class='pad1'>
<p>1. 해당 아이디로 재가입 불가능</P>
<p>회원탈퇴를 신청하시면 해당 아이디는 즉시 탈퇴처리되며 이후 해당 아이디는 영구적으로 사용이 중지되므로 해당 아이디로는 재가입이 불가능합니다. </P>

<p>2. 회원정보 및 회원제 서비스의 정보 삭제 </P>
<p>회원탈퇴시 해당 아이디로는 더이상 로그인 등을 할 수 없으며, 저장된 회원정보는 <?=$config[cf_leave_day]?>일 후에 삭제 됩니다. </P>

<p>3. 불량이용 및 이용제한에 관한 기록 1년 동안 보관 </P>
<p>개인정보취급방침에 따라 불량이용 및 이용제한에 관한 기록은 1년 동안 삭제되지 않고 보관됩니다.</P>
</div>

<BR>

<form name='fconfigform' method='post' onsubmit="return fconfigform_submit(this);">
<input type=hidden name=token value='<?=$token?>'>

<table width=620 cellpadding=0 cellspacing=0 border=0>
<colgroup width=120 class='col1 pad1 bold right'>
<colgroup class='col2 pad2'>
<tr class='ht'>
<td>아 이 디</td>
<td><input type=text class=ed name='mb_id' size='25' readonly value='<?=$member[mb_id]?>'></td>
</tr>
<tr class='ht'>
<td>이&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;름</td>
<td><input type=text class=ed name='mb_name' size='25' itemname="이름" required></td>
</tr>
<tr class='ht'>
<td>비밀번호</td>
<td><input type=password class=ed name='mb_password' size='25' itemname="비밀번호" required></td>
</tr>
<tr class='ht'>
<td>탈퇴사유</td>
<td><textarea class=ed name='leave_reason' rows='3' style='width:99%;'></textarea></td>
</tr>
<tr class='ht'>
    <td>
    <img id="zsfImg">
    </td>
    <td colspan=3>
        <input class='ed' type=input size=10 name=wr_key id=wr_key itemname="자동등록방지" required >&nbsp;&nbsp;왼쪽의 글자를 입력하세요.
    </td>
</tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>

</form>

<script type="text/javascript" src="<?="$g4[path]/zmSpamFree/zmspamfree.js"?>"></script>
<script language="javascript">
function fconfigform_submit(f)
{
    if (typeof(f.wr_key) != 'undefined') {
        if (!checkFrm()) {
            alert ("스팸방지코드(Captcha Code)가 틀렸습니다. 다시 입력해 주세요.");
            return false;
        }
    }

    f.action = "./mb_leave_update.php";
    return true;
}
</script>
<?
include_once ("./_tail.php");
?>
