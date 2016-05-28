<?
// 회원 추천을 위한 인증 이메일
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=$g4[charset]?>">
<title>인증 메일</title>
</head>

<style>
body, th, td, form, input, select, text, textarea, caption { font-size: 12px; font-family:굴림;}
.line {border: 1px solid #868F98;}
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="600" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="25" height="25"></td>
    <td height="25"></td>
    <td width="25" height="25"></td>
</tr>
<tr>
    <td width="25" valign="top"></td>
    <td align="center" class="line" >
        <br>
        <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="500" border="0" cellspacing="0" cellpadding="4">
                <tr> 
                    <td width="100%" height="25" bgcolor=#F7F1D8>인증 메일입니다.</td>
                </tr>
                </table>
                <p>

                <table width="500" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr><td height="150">
                    <b><?=$mb_name?></b> 님이 회원가입을 추천하여 E-mail 이 발송 되었습니다.

                    <p>아래의 주소를 클릭하시면 회원가입에 필요한 인증 번호를 확인할 수 있습니다.
                    <p><a href='<?=$certify_href?>'><b><?=$certify_href?></b></a>

                    <p>회원님의 성원에 보답하고자 더욱 더 열심히 하겠습니다.
                    <p>감사합니다.
                    </td></tr>
                </table>
                <p>

                <table width="500" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed">
                <tr>
                    <td height="2" bgcolor="#E0E0E0" align="center"></td>
                </tr>
                <tr> 
                    <td height="25" bgcolor="#EDEDED" align="center">회원가입후 후 모든 정보를 이용하실 수 있습니다.[<a href="<?=$g4[url]?>/<?=$g4[bbs]?>/login.php" target=new>바로가기</a>]</td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
        <br>
    </td>
    <td width="25" valign="top"></td>
</tr>
</table>

</body>
</html>
