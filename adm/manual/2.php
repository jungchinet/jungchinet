<?
$sub_menu = "100200";
include_once("./_common.php");
$g4['title'] = "관리권한설정";
include_once ("./manual.head.php");
?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>관리권한설정</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>관리권한설정</b></p>
<p><img src="img/adm.auth.010.gif" width="690" height="386" border="1"></p>
<p><img src="img/middot.gif" border="0">    입력방법은 아래 하단에 회원아이디를 입력하고 접근가능메뉴와 권한을 선택한 후 확인을 클릭하면 상단 리스트에 표시됩니다.<br> <img src="img/middot.gif" border="0">    관리권한은 특정한 회원에게 특정 관리자페이지에 접근할 수 있는 권한을 줄 경우에 사용합니다.<br><img src="img/middot.gif" border="0">    위의 이미지에서 보시는 바와 같이 test 라는 회원에게 회원관리 페이지에 읽기 권한만을 부여하였습니다.<br> <img src="img/middot.gif" border="0">    로그아웃 한 후 test 아이디로 로그인 하시면 관리자 메뉴에서 회원관리만 리스트 읽기가 가능한 것을 확인할 수 있습니다.<br><img src="img/middot.gif" border="0">    보시는 바와 같이 r 은 읽기, w 는 입력 및 수정, d 는 삭제 권한을 줄 경우에 체크합니다.<br><img src="img/middot.gif" border="0">    기존 권한을 수정하는 경우에는 삭제 후 새로 입력하시면 됩니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>