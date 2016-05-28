<?
$sub_menu = "100999";
include_once("./_common.php");
$g4['title'] = "phpMyAdmin";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>phpMyAdmin</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>phpMyAdmin</b></p>
<p>phpMyAdmin 이란 웹상에서 MySQL을 실행, 관리하는 도구를 말합니다.<br>보통 일반 사용자는 SQL <SPAN class="tit16 b">[structured query language]을</SPAN> 모르며, 자주 사용하는 사용자들도 구문을 모두 외우고 있지는 못합니다.<br>이 MySQL 관리툴은 <a href="http://phpmyadmin.net">http://phpmyadmin.net</a> 에서 최신버전으로 다운로드 받아 자유롭게 다운로드 받아 서버에 설치, 사용할 수 있습니다.</p>
<p>홈페이지 관리자 페이지의 환경설정 &gt; phpMyAdmin 메뉴를 클릭하여 직접 연결하는 경우에는 adm/phpMyAdmin 에 업로드 하시면 됩니다.</p>
<p>phpMyAdmin을 업로드 하신 후 phpMyAdmin 의 config.inc.php 파일을 열어 <font color="red">$cfg['Servers'][$i]['auth_type'] = 'config'; </font>를 <font color="red">$cfg['Servers'][$i]['auth_type'] = 'http';</font> 로 수정하여 주십시오.</p>
<p>웹경로가 일반인들에게 알려지지 않기를 원하신다면 config.php 의 <font color="red">$g4[phpmyadmin_dir] = $g4[admin] . &quot;/phpMyAdmin/&quot;;</font><font color="#990000"> </font>설정값을 다른 값으로 변경하시기 바랍니다. 그리고 난 후 phpMyAdmin 디렉토리명을 바꾼 값으로 변경하여 주십시오.<br>예를 들어 $g4[phpmyadmin_dir] = $g4[admin] . &quot;/pma123/&quot;; 으로 수정하셨다면 phpMyAdmin 디렉토리명을 php123 으로 변경하시면 됩니다.</p>
<p>phpMyAdmin 으로 접속하시면 다음과 같은 화면이 표시됩니다.</p>
<p><img src="img/adm.phpmyadmin.010.gif" width="690" height="366" border="1"></p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>