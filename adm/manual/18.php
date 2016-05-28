<?
$sub_menu = "300200";
include_once("./_common.php");
$g4['title'] = "게시판그룹관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>게시판그룹관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>게시판그룹관리</b></p>
<p><img src="img/adm.boardgroup.010.gif" width="690" height="258" border="1"></p>
<p><img src="img/middot.gif" border="0">  게시판그룹관리 리스트에서는 게시판그룹의 제목과 그룹관리자, 접근사용의 일괄 수정이 가능합니다.<br><img src="img/middot.gif" border="0">  게시판의 숫자는 해당 게시판그룹에 속한 게시판수입니다.<br><img src="img/middot.gif" border="0">  접근사용은 해당 게시판그룹에 접근할 수 있는 설정을 하는 것이며 옆에 보이는 접근회원수에 해당하는 회원만 해당 게시판그룹에 접근이 가능합니다. 접근회원이 아닌 경우에는 게시판의 목록을 보는 것은 가능하지만 게시물의 내용을 볼수는 없습니다.<br><img src="img/middot.gif" border="0">  게시판그룹을 삭제할 때는 해당 게시판그룹에 속한 게시판이 없어야 삭제가 가능합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.boardgroup.020.gif" width="690" height="249" border="1"></p>
<p><img src="img/middot.gif" border="0">  게시판그룹 생성시에 그룹 ID는 반드시 입력하셔야 하며 영문자, 숫자, _ 만 입력하여 ID를 만드셔야 합니다.<br><img src="img/middot.gif" border="0">  게시판그룹의 제목은 반드시 입력해야 하는 항목입니다. http://도메인/bbs/group.php?gr_id=그룹ID 로 사용하실때 빼고는 게시판그룹 제목은 사용하는곳이 거의 없습니다.<br><img src="img/middot.gif" border="0">  그룹관리자에는 회원아이디를 입력합니다. 이 회원은 해당 게시판그룹에 속한 모든 게시판에 대한 관리자 권한을 갖습니다. 그러므로 이곳에 입력한 회원을 게시판관리자에 따로 입력할 필요는 없습니다.<br><img src="img/middot.gif" border="0">  접근회원사용은 이 게시판그룹에 속한 게시판에 접근&nbsp;가능한 회원을 따로 설정하는것입니다.<br><img src="img/middot.gif" border="0">   게시판그룹의 여분 필드는 미리 10개가 준비되어 있습니다. 여분 필드는 테이블에 필드를 추가할 일이 생겼을 때 사용하는 것입니다. 여분 필드는 &lt;?=$group[gr_1]?&gt; 과 같은 방법으로 출력할 수 있습니다.</p>
<p>&nbsp;</p>
<p><b>접근회원</b></p>
<p><img src="img/adm.boardgroup.030.gif" width="690" height="138" border="1"></p>
<p><img src="img/middot.gif" border="0">   게시판그룹 리스트에서 접근회원수를 클릭하면 보시는 해당 게시판그룹에 접근이 가능한 회원의 목록이 출력됩니다.<br><img src="img/middot.gif" border="0">   게시판그룹에 접근이 가능한 회원으로 등록하려면 회원관리의 목록에 보이는 <img align="absmiddle" src="img/icon_group.gif" width="22" height="21" border="0"> 을 클릭합니다. 그러면 아래와 같은 화면이 표시되며 여기에서 접근가능한 그룹을 선택하여 등록하면 됩니다.</p>
<p><img src="img/adm.boardgroup.040.gif" width="690" height="222" border="1"></p>
<p>&nbsp;</p>
<p><img src="img/middot.gif" border="0">    게시판그룹에서 접근사용이 무엇인가요?</p>
<ul>
    <p>홈페이지를 운영하다보면 특정 게시판에는 특정 회원만 글읽기, 쓰기가 가능하도록 할 때가 있습니다. 이럴때 보통 타 게시판에서는 회원과 게시판의 권한을 조정하여 해결을 하고 있습니다. 그러나 이런 방식은 하나의 게시판에서만 가능한 방식이며 두 개 이상의 게시판에 서로 다른 회원을 접근 가능하게 하는 것은 프로그램을 수정해서 사용하지 않는한 불가능합니다.</p>
    <p>좀 더 쉽게 설명드리기 위하여 예를 들겠습니다.</p>
    <p>ㄱ, ㄴ, ㄷ 이라는 회원과 A, B, C 라는 게시판이 있다고 가정합니다.</p>
    <p>회원 ㄱ 은 A 라는 게시판에, 회원 ㄴ 은 B 라는 게시판에, 회원 ㄷ 은 C 라는 게시판에 접근이 가능하도록 할 경우가 생겼습니다.<br>이런 경우에는 회원의 권한과 게시판의 권한을 어떻게 바꾸더라도 만족하는 결과를 얻을 수 없습니다. (프로그램을 수정하기 이전에는...)</p>
    <p>그러나 이런 문제들도 게시판그룹 접근 권한을 사용하면 시원스럽게 해결됩니다.</p>
    <p>게시판그룹 AAA를 생성하여 게시판 A를 포함합니다. 접근을 사용으로 체크합니다.<br>게시판그룹 BBB를 생성하여 게시판 B를 포함합니다. 접근을 사용으로 체크합니다.<br>게시판그룹 CCC를 생성하여 게시판 C를 포함합니다. 접근을 사용으로 체크합니다.</p>
    <p>회원관리에서</p>
    <p>회원 ㄱ 의 게시판그룹을 AAA 로 선택합니다.<br>회원 ㄴ 의 게시판그룹을 BBB 로 선택합니다.<br>회원 ㄷ 의 게시판그룹을 CCC 로 선택합니다.</p>
    <p>회원의 권한과 게시판의 권한은 전혀 손대지 않고 만족하는 결과를 얻었습니다.</p>
    <p>특정회원에게 게시판그룹을 모두 지정해 주면 모든 게시판에 접근이 가능도록 하는 것도 가능합니다.</p>
</ul>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>