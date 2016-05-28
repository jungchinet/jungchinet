<?
$sub_menu = "200900";
include_once("./_common.php");
$g4['title'] = "투표관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>투표관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>투표관리</b></p>
<p><img src="img/adm.poll.010.gif" width="690" height="333" border="1"></p>
<p>&nbsp;</p>
<p><img src="img/middot.gif" border="0">   &nbsp;투표를 생성, 수정하는 경우에는 아래와 같은 화면이 표시됩니다. 이곳의 내용은 투표가 진행중에도 수정이 가능합니다.<br><img src="img/middot.gif" border="0">   기타의견에 내용을 입력하는 경우에는 투표에서 기타의견을 입력 받을 수 있습니다. 투표권한을 주어 일정권한 이상의 회원만 투표에 참여하게 할 수도 있습니다.<br><img src="img/middot.gif" border="0">   투표권한을 2이상으로 설정했다면 회원 1인당 한번만 투표가 가능하므로 공정한 투표를 진행할 수 있습니다.<br><img src="img/middot.gif" border="0">   투표권한이 1이상인 경우에는 비회원의 경우 IP 로 중복 투표인지를 가려냅니다. 또, 포인트를 부여할 수 있으므로 투표를 활성화 할 수도 있습니다.</p>
<p><img src="img/adm.poll.020.gif" width="690" height="676" border="1"></p>
<p><img src="img/middot.gif" border="0">   투표를 홈페이지에 연동하는 방법은 다음과 같습니다.</p>
<p>&lt;?=poll([스킨], [투표번호])?&gt;</p>
<p><img src="img/middot.gif" border="0">   투표의 스킨 디렉토리는 skin/poll&nbsp;이며, 이곳에 있는 스킨중에서 하나를 선택하여 투표를 출력하게 됩니다. 기본 스킨은 basic &nbsp;입니다.<br><img src="img/middot.gif" border="0">   투표번호는 리스트에 표시된 번호를 말합니다.<br><img src="img/middot.gif" border="0">   []는 생략가능 표시</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>