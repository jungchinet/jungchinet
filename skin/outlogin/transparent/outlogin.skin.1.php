<? 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($g4['https_url']) { 
    $outlogin_url = $_GET['url']; 
    if ($outlogin_url) { 
        if (preg_match("/^\.\.\//", $outlogin_url)) { 
            $outlogin_url = urlencode($g4[url]."/".preg_replace("/^\.\.\//", "", $outlogin_url)); 
        } 
        else { 
            $purl = parse_url($g4[url]); 
            if ($purl[path]) { 
                $path = urlencode($purl[path]); 
                $urlencode = preg_replace("/".$path."/", "", $urlencode); 
            } 
            $outlogin_url = $g4[url].$urlencode; 
        } 
    } 
    else { 
        $outlogin_url = $g4[url]; 
    } 
} 
else { 
    $outlogin_url = $urlencode; 
} 

// 아이디 자동저장 
$ck_auto_mb_id = decrypt( get_cookie("ck_auto_mb_id"), $g4[encrypt_key]); 
if ($ck_auto_mb_id) { 
    $auto_mb_id = "checked"; 
} 
?> 

<!-- 로그인 전 외부로그인 시작 --> 
<table width="100%" border="0" cellpadding="0" cellspacing="1" style='border:solid 1px #ddd;'> 
<tr> 
<td> 
<form name="fhead" method="post" onsubmit="return fhead_submit(this);" autocomplete="off" style="margin:0px;"> 
<table width="100%" border="0" cellpadding="2" cellspacing="0"> 
<input type="hidden" name="url" value="<?=$outlogin_url?>"> 
<tr> 
    <td width="100%" colspan="2"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
        <tr><td width="100%" height="4" colspan="2"></td></tr> 
        <tr> 
            <td width="120"> 
                <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
                <tr> 
                    <td width="120" height="23" colspan="2" align="center" valign="top"> 
                        <? if ($ck_auto_mb_id) {?> 
                        <input class=ed name="mb_id" type="text" style="width:110;height:19; background-color:transparent;" maxlength="20" required itemname="아이디" value='<?=$ck_auto_mb_id?>' align='absmiddle'> 
                        <? } else { ?> 
                        <input class=ed name="mb_id" type="text" style="width:110;height:19; background-color:transparent;" maxlength="20" required itemname="아이디" value='' align='absmiddle'> 
                        <? } ?> 
                    </td> 
                </tr> 
                <tr> 
                    <td width="120" height="23" colspan="2" align="center"><input class=ed name="mb_password" id="mb_password" type="password" style="width:110;height:19; background-color:transparent;" maxlength="20" required itemname="비밀번호" value='' align='absmiddle'></td> 
                </tr> 
                </table> 
            </td> 
            <td width="55" height="46" rowspan="2" align="center"><input type="image" src="<?=$outlogin_skin_path?>/img/login_button.gif" width="40" height="45" align="absmiddle" onfocus="this.blur()"align='absmiddle'></td> 
        </tr> 
        </table> 
</td> 
</tr> 
<tr> 
    <td width="40" height="20" align="left"> 
    <input type="checkbox" name="auto_login" value="1" onclick="if (this.checked) { if (confirm('자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n\공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?')) { this.checked = true; } else { this.checked = false; } }"><img src="<?=$outlogin_skin_path?>/img/login_auto.gif" width="16" height="20" align="absmiddle"> 
    </td> 
    <td height="20" align="center"> 
        <a href="<?=$g4[bbs_path]?>/register.php" onfocus="this.blur()"><img src="<?=$outlogin_skin_path?>/img/login_join_button.gif" width="46" height="20" border="0"></a> 
        <a href="javascript:win_password_lost();" onfocus="this.blur()"><img src="<?=$outlogin_skin_path?>/img/login_pw_find_button.gif" width="61" height="20" border="0"></a> 
</td> 
</tr> 
</table> 
</form> 
</td> 
</tr> 
</table> 

<script type="text/javascript"> 
function fhead_submit(f) 
{ 
    if (!f.mb_id.value) 
    { 
        alert("회원아이디를 입력하십시오."); 
        f.mb_id.focus(); 
        return false; 
    } 

    if (!f.mb_password.value) 
    { 
        alert("패스워드를 입력하십시오."); 
        f.mb_password.focus(); 
        return false; 
    } 

    <? 
    if ($g4[https_url]) 
        echo "f.action = '$g4[https_url]/$g4[bbs]/login_check.php';"; 
    else 
        echo "f.action = '$g4[bbs_path]/login_check.php';"; 
    ?> 

    return true; 
} 
</script> 
<!-- 로그인 전 외부로그인 끝 --> 