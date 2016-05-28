<?
$sub_menu = "100300";
include_once("./_common.php");
$g4['title'] = "메일 테스트";
include_once ("./manual.head.php");
?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>메일 테스트</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>메일 테스트</b></p>
<p><img src="img/adm.sendmail_test.010.gif" width="690" height="242" border="1"></p>
<p><img src="img/middot.gif" border="0">   메일 보내기가 되지 않는 경우&nbsp;기본환경설정 &gt; 메일발송 사용에 체크가 풀어져 있는지 우선 확인하여 주십시오.<br><img src="img/middot.gif" border="0">   홈페이지 내에는 환경설정 이외의 어떤 코드도 메일 발송과 관련된 코드가 존재하지 않습니다. 그러므로 메일 발송이 제대로 되지 않는다면 보내거나 받는 메일서버의 문제로 보셔야 합니다.<br><img src="img/middot.gif" border="0">   메일 테스트시에 여러개의 메일 주소로 테스트를 해보십시오. @naver.com @empal.com @hanmail.net @gmail.com @hotmail.com 등등 여러개의 메일 서버로 메일을 발송하여 아래와 같은 메시지를 받지 못하신다면 보내는 메일 서버의 오류로 보셔도 좋습니다. 이유는 위의 메일 서버가 동시에 작동하지 않을리는 없기 때문입니다.</p>
<p> &nbsp;&nbsp;<img src="img/adm.sendmail_test.020.gif" width="404" height="132" border="1"></p>
<p><img src="img/middot.gif" border="0">   보내는 메일 서버에 이상이 있는 것 같다면&nbsp;터미널 모드(telnet, ssh)에서 아래와 같은 코드로 점검해 보십시오. () 안의 내용은 입력하지 마십시오.<br><SPAN class="ct lh">$&gt; <BR>$&gt; telnet localhost 25 <BR>$&gt; ehlo sir.co.kr (메일 서버)<BR>$&gt;&nbsp;mail from: 
fr@sir.co.kr (보내는 메일 주소)<BR>$&gt; rcpt to: to@sir.co.kr (받는 메일 주소)<BR>$&gt; data <BR>$&gt; Send Test 
Message... (메일 내용)<BR>$&gt; quit <BR>$&gt;</SPAN>  </p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>