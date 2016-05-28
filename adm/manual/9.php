<?
$sub_menu = "100800";
include_once("./_common.php");
$g4['title'] = "세션 삭제";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>세션 삭제</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>버전정보</b></p>
<p><img src="img/middot.gif" border="0">   
세션이란? <br><br>
어떤 사용자가 특정 웹사이트에 접속해 머물러있는 시간을 의미합니다<br><br><br>

쿠키는 모든 사용자데이타를 사용자 시스템 내에 저장하나 세션의경우는 사용자데이타는<br><br>
서버에 저장하고 사용자시스템에는 이 데이터에 접근할 수 있는 식별자만 저장합니다<br><br>

아무래도 보안측면에서 볼때 쿠키보다 세션이 더 안전할 수 있습니다<br><br>

즉 회원인증/쇼핑몰장바구니등에 쓰이는게 세션,쿠키가 되겠습니다.<br><br><br>
세션 삭제란?<br> 즉 오래된 세션데이터를 삭제하는 기능입니다.<br> <br>
<br><br><br>
<img src="img/middot.gif" border="0">   실행예)<br><br>
'완료' 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.<br><br>
세션데이터 3건 삭제 완료.<br>
프로그램의 실행을 끝마치셔도 좋습니다.<br>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>