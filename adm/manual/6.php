<?
$sub_menu = "100500";
include_once("./_common.php");
$g4['title'] = "phpinfo";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>phpinfo()</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>phpinfo()</b></p>
<p><img src="img/adm.phpinfo.010.gif" width="690" height="196" border="1"></p>
<p><img src="img/middot.gif" border="0">   현재 서버에서 구동되는 php 의 버전, 설치옵션 또는 설정값을 확인해 볼 수 있습니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.phpinfo.020.gif" width="690" height="93" border="1"></p>
<p><img src="img/middot.gif" border="0">   혹시나 Zend Encoding 되어 있는 파일을 실행할 수 없는 경우에는 위와 같이 Zend Optimizer 가 설치되어 있는지를 우선 확인해 주셔야 합니다.<br><img src="img/middot.gif" border="0">   Zend Optimizer 설치되어 있지 않은 서버에서 Zend Encoding 된 프로그램을 실행시키면 웹페이지에 다음과&nbsp;같은 알수 없는 문자들이 출력됩니다.<br>&nbsp;&nbsp;&nbsp;<img src="img/adm.phpinfo.030.gif" width="690" height="100" border="1">&nbsp;</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>