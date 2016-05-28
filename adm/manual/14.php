<?
$sub_menu = "200300";
include_once("./_common.php");
$g4['title'] = "회원메일발송";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>회원메일발송</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>회원메일발송</b></p>
<p><img src="img/adm.mail.010.gif" border="1"></p>
<p><img src="img/middot.gif" border="0">   회원메일을 발송하기 위해서는 우선 메일의 내용을 작성하여야 합니다.<br><img src="img/middot.gif" border="0">   메일작성을 위하여 <img src="img/icon_insert.gif" width="22" height="21" border="0" align="absmiddle">를 클릭합니다.<br><img src="img/middot.gif" border="0">   작성된 내용을 확인하기 위하여 <u>테스트</u>를 클릭합니다. 테스트를 클릭하면 &quot;관리자님께 메일을 발송하였습니다.&quot; 라는 메시지를 출력합니다.<br><img src="img/middot.gif" border="0">   메일 확인 후 이상이 없다면 <u>보내기</u>를 클릭합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.mail.020.gif" border="1"></p>
<p><img src="img/middot.gif" border="0">   메일의 내용은 반드시 HTML 코드로 작성하셔야 합니다.<br><img src="img/middot.gif" border="0">   메일의 내용중에 이름, 별명, 회원아이디, 이메일, 생일을 넣고 싶다면 {이름}과 같이 {} 코드를 붙여줍니다.<br><img src="img/middot.gif" border="0">   모든 내용이 변환되는 것은 아니며 위의 다섯가지 항목만 가능합니다.</p>
<p>&nbsp;</p>
<p><img src="img/middot.gif" border="0">   리스트에서 보내기를 클릭하면 다음과 같은 화면이 표시됩니다.</p>
<p><img src="img/adm.mail.030.gif" width="690" height="341" border="1"></p>
<p>전체 또는 구간을 선택한 후 확인을 클릭합니다.</p>
<p><img src="img/adm.mail.040.gif" width="527" height="464" border="1"></p>
<p><img src="img/middot.gif" border="0">   위와 같이 회원아이디 순서로 표시됩니다.<br><img src="img/middot.gif" border="0">   선택된 정보가 올바르다면 메일 보내기를 클릭하십시오.</p>
<p>&nbsp;</p>
<p><img src="img/adm.mail.050.gif" width="332" height="185" border="1"></p>
<p><img src="img/middot.gif" border="0">   선택된 회원수만큼 메일을 발송합니다.<br><img src="img/middot.gif" border="0">   만약, 중간에 오류가 발생하여 중단된다면 그 회원아이디 부터 선택하여 보내시면 됩니다.</p>
<p><img src="img/middot.gif" border="0">   자체 서버에서 테스트 해본 결과 5,000건을 보내는 경우에도 문제가 없었습니다. 단, 서버의 특성, 설정에 따라 많은 건을 해결하지 못하는 경우가 생길 수도 있습니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>