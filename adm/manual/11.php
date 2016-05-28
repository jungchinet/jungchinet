<?
$sub_menu = "200000";
include_once("./_common.php");
$g4['title'] = "회원관리";
include_once ("./manual.head.php");
?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>회원관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p style="line-height:150%;"><b>회원리스트</b></p>
<p style="line-height:150%;"><img src="img/adm.member.010.gif" width="690" height="181" border="1"></p>
<p><img src="img/middot.gif" border="0">   처음 : 리스트의 첫페이지로 이동합니다.<br><img src="img/middot.gif" border="0">   총회원수는 관리자, 차단아이디, 탈퇴아이디를 포함한 전체&nbsp;회원수를 나타냅니다. 검색을 하는 경우에는 검색된 총 회원수를 나타냅니다.<br><img src="img/middot.gif" border="0">   검색은 특정 필드를 이용하여 회원을 검색할 수 있습니다. 회원이 많은 경우 유용하게 사용하실 수 있습니다.<br><img src="img/middot.gif" border="0">   리스트 제목을 클릭하면 순서대로 정렬합니다. 만약, 최종접속한 순서대로 리스트를 표시하려면 최종접속 제목을 클릭하시면 됩니다.<br><img src="img/middot.gif" border="0">   선택수정은 회원리스트에서는 권한과 차단 두 개의 필드를 수정하실 수 있습니다. 리스트의 앞에 있는 체크박스에 체크하신 후 권한 및 차단을 선택한 후 선택수정을 클릭하시면 체크박스에 선택하신 회원의 정보만 수정합니다. 일괄적으로 권한등을 수정하실 때 사용하시면 좋습니다.<br><img src="img/middot.gif" border="0">   선택삭제는 리스트의 앞에 있는 체크박스에 체크하신 후 선택삭제 버튼을 클릭하시면 해당 회원의 정보만 삭제합니다. 삭제시 회원의 아이디와 이름만 남겨놓고 모든 정보를 삭제합니다. 이렇게 하는 이유는 게시판등에 이 회원아이디로 남겨놓은 글이 있을 경우를 대비하기 위함입니다. 삭제된 자료를 다시 삭제하시면 완전히 삭제됩니다.<br><img src="img/middot.gif" border="0">   권한은 1 이 가장&nbsp;낮은 권한이며 10 이 가장 큰 권한입니다. 보통 회원의 권한은 2 로 설정되어 있습니다. 보통 최고관리자의 권한은 10 으로 설정되어 있습니다.<br><img src="img/middot.gif" border="0">   수신은 회원메일 발송시 메일을 받을지를 나타냅니다.<br><img src="img/middot.gif" border="0">   공개는 자신의 정보를 다른 회원에게 보여줄지를 나타냅니다.<br><img src="img/middot.gif" border="0">   인증은 메일인증을 사용하는 경우 인증된 회원인지를 나타냅니다.<br><img src="img/middot.gif" border="0">   차단은 홈페이지에 접근을 시키고 싶지 않은 경우에 체크합니다.<br><img src="img/middot.gif" border="0">   그룹은 접근가능한 게시판그룹의 갯수를 나타냅니다. 모든 게시판은 하나의 게시판그룹에 속해 있으며 해당 회원을 이 게시판그룹에 속한 게시판에 접근가능하게 할지를 선택할 수 있습니다. 게시판그룹관리의 접근사용에 체크했을 경우에만 유효하며 그렇지 않은 경우에는 의미가 없습니다. 이 부분은 게시판그룹관리에서 더 자세히 설명하겠습니다.</p>
<p><img src="img/icon_insert.gif" border="0" align="absmiddle">  : 임의로 회원을 추가하는 경우에 사용합니다.<A 
href="http://218.55.135.89:8080/~kagla/yc4/adm/member_form.php?sst=&amp;sod=&amp;sfl=&amp;stx=&amp;page=&amp;w=u&amp;mb_id=ddd"><br></A><IMG 
title=수정 src="img/icon_modify.gif" border=0 align="absmiddle"> : 해당 회원의 정보를 수정하는 경우에 사용합니다.<A 
href="javascript:del('./member_delete.php?sst=&amp;sod=&amp;sfl=&amp;stx=&amp;page=&amp;w=d&amp;mb_id=ddd&amp;url=/~kagla/yc4/adm/index.php');"><br></A><IMG 
title=삭제 src="img/icon_delete.gif" border=0 align="absmiddle"> : 해당 회원의 정보를 삭제하는 경우에 사용합니다. 회원을 완전히 삭제하기 위해서는 두 번 삭제하여야 합니다.<A href="http://218.55.135.89:8080/~kagla/yc4/adm/boardgroupmember_form.php?mb_id=ddd"><br></A><IMG title=그룹 
src="img/icon_group.gif" border=0 align="absmiddle"> : 해당 회원에게 접근 가능한 게시판그룹을 지정하고자 할 때 사용합니다.</p>
<p>&nbsp;</p>
<p><b>회원정보 등록 및 수정</b></p>
<p>회원정보 수정은 회원 가입한 내용을 보여주고 수정하는 역할을 합니다.<br>패스워드는 입력하지 않으면 기존에 사용하던 패스워드를 유지합니다.<br>여분 필드는 프로그램을 수정하여 사용하시는 경우 기존 테이블에 필드를 추가하는 불편없이 여분으로 사용하실 수 있도록 마련된 필드입니다.<br>mb_1에서 mb_10 까지 사용하실 수 있으며 프로그램에서 출력하시는 경우에는 회원로그인 된 경우에 한하여 &lt;?=$member[mb_1]?&gt; 와&nbsp;같은 방법으로 사용할 수 있습니다.<br>회원의 접근을 차단하는 경우에는 차단일자에 오늘 체크하시면 오늘 날짜가 자동으로 입력됩니다.</p>
<p><img src="img/adm.member.020.gif" border="1"></p>
<p>&nbsp;</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>