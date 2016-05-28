<?
$sub_menu = "300100";
include_once("./_common.php");
$g4['title'] = "게시판관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>게시판관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>게시판관리</b></p>
<p><img src="img/adm.board.010.gif" width="690" height="315" border="1"></p>
<p><img src="img/middot.gif" border="0">  게시판관리 리스트에서는 게시판의 제목과 그룹, 스킨, 포인트, 검색은 일괄 수정이 가능합니다.<br><img src="img/middot.gif" border="0">  삭제의 경우 게시판에 있는 모든 게시글과 DB 테이블을 삭제하는 것이므로 주의하셔야 합니다. 삭제한 게시판은 복구할 수 없습니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.020.gif" width="690" height="180" border="1"></p>
<p><img src="img/middot.gif" border="0">  TABLE은 게시판 아이디이며 실제 DB 테이블명은 cm_age 의&nbsp;경우 wr_write_cm_age 입니다.<br><img src="img/middot.gif" border="0">  그룹은 게시판그룹에서 생성된 내용을 선택하는것입니다. 게시판의 반드시 하나의 게시판그룹에 속해야 합니다.<br><img src="img/middot.gif" border="0">  상단, 하단 이미지는 게시판의 상단과 하단에 이미지를 넣고 싶을 경우에 사용합니다.<br><img src="img/middot.gif" border="0">  카운트 조정은 게시판의 글 숫자가 맞지 않는 경우에 사용합니다. 게시판의 글 숫자는 게시글 목록에서 페이지수를 나눌때 주로 사용합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.030.gif" width="690" height="338" border="1"></p>
<p><img src="img/middot.gif" border="0">  앞에 있는 체크박스에 체크하게 되면 해당 게시판이 속한 게시판그룹의 모든 게시판을 동일한 값으로 설정합니다.</p>
<p><img src="img/middot.gif" border="0">  최고관리자, 그룹관리자 이외에 게시판별로 별도의 게시판 관리자를 둘 수 있습니다. 게시판 관리자는 게시판의 설정 권한은 없으나 게시물의 수정, 삭제, 공지글 작성등 해당 게시판에 대한 설정 이외의 모든 권한을 갖습니다. 게시물 삭제시 자신보다 권한이 높은 회원이 쓴글에 대한 수정, 삭제 권한은 없습니다. 그러므로 게시판 관리자에게는 일반 회원보다 한단계 높은 권한을 부여하는 것이 좋습니다.<br><img src="img/middot.gif" border="0">  권한은 1부터 10까지 있으며 1이 제일 낮은 일반 방문자의 권한입니다. 2부터는 회원권한이며 10은 보통 최고관리자의 권한으로 사용됩니다. 해당 게시판에 맞는 권한을 부여합니다.</p>
<p><img src="img/middot.gif" border="0">  여기서 트랙백이란? 간단하게 이어말하기라고 설명하는 것이 좋을 듯 하며 내 게시판에서 글을 쓰면 네이버등의 블로그에 글이 엮이는 기능을 말합니다. 말로는 설명이 힘들어 그림과 같이&nbsp;간단하게 설명드리겠습니다.</p>
<p><img src="img/adm.board.040.gif" width="690" height="533" border="0"></p>
<p><img src="img/middot.gif" border="0">  그림으로 설명을 드렸으나 약간의 글로 더 설명을 드리자면 ... 블로그의 엮인글 주소를 복사하여 게시판 글쓰기의 트랙백주소에 복사해 넣습니다. 제목과 내용을 넣고 나서 확인을 클릭하면 게시판 제목이 블로그의 엮인글 내용으로 등록되고 이 엮인글 링크를 클릭하게 되면 내가 작성한 게시글로 이동된다는것입니다. 트랙백은 블로그의 어떤 내용을 보고나서 이 블로그에 직접 코멘트를 쓰는 것이 아니라 내 홈페이지에 글을 씀과 동시에 블로그에 코멘트로 기록되게 하는것입니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.050.gif" width="690" height="213" border="1"></p>
<p><img src="img/middot.gif" border="0">  원글 수정, 삭제 불가는 반드시 보관해야 될 필요성이 있는 게시물의 경우 코멘트가 일정 개수 이상 달리면 게시자도 자신의 글을 수정 또는 삭제할 수 없는 기능을 말합니다. 관리자(게시판, 그룹, 최고)는 이 설정에 상관없이 수정, 삭제가 가능합니다.<br><img src="img/middot.gif" border="0">  게시판별로 포인트 부여를 다르게 설정할 수 있습니다. 회원가입시, 로그인시 일정 포인트만 부여하고 글읽기시 일정 포인트를 차감하는 방법을 사용하는것도 방문객을 더 자주 우리 사이트로 유도하기 위한 방안이 될 것입니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.060.gif" width="690" height="416" border="1"></p>
<p><img src="img/middot.gif" border="0">  분류는 단어를 | 로 구분합니다. 이곳에 다음과 같이 입력했다면 ... 질문|답변|일반 ... 게시판 목록의 분류에는 다음과 같이 표시됩니다. <select name="formselect1" size="1">
    <option>질문</option>
    <option>답변</option>
    <option>일반</option>
</select><br><img src="img/middot.gif" border="0">  글쓴이 사이드뷰는 빨간박스에 나와 있는 것처럼 게시판에서 해당 회원의 이름(별명) 클릭시 표시되는 내용입니다.</p>
<p><img src="img/adm.board.070.gif" width="435" height="64" border="1"> <img src="img/adm.board.080.gif" width="378" height="161" border="0">&nbsp;</p>
<p><img src="img/middot.gif" border="0">  파일 설명 사용은 파일을 업로드 하는 경우에 이 파일에 대한 설명을 입력합니다. 아래처럼 이미지를 올리면서 설명을 입력하였고 게시판 상세보기에서 나온 이미지에 마우스 오버시 이곳에서 입력한 내용을 풍선 도움말로 표시합니다.<br><img src="img/middot.gif" border="0">  코멘트 새창 사용은 게시판 목록에 나오는 코멘트의 숫자를 클릭하면 코멘트 내용만 새창으로 띄울지를 설정하는것입니다.<br><img src="img/middot.gif" border="0">  비밀글 사용은 게시판 관리자(그룹, 최고)와 해당 게시자에만 내용을 볼 수 있도록 하는 경우에 사용합니다. 다른 사람이 글 내용을 보아서는 안되는 경우에 사용합니다. 간단하게 예를 들어 병원에서 환자와 의사간의 대화에 사용하는 경우를 생각하시면 됩니다.<br><img src="img/middot.gif" border="0">  추천, 비추천 사용을 체크하면 게시판 상세보기에서 해당 게시물에 대한 추천 또는 비추천을 할 수 있는 버튼이 나타납니다. 그러나 해당 컴퓨터에서 단 한번만 추천(비추천)하는 방식이 아니므로 추천(비추천)수의 유효성에 대해서는 검증할 방법이 없습니다.<br><img src="img/middot.gif" border="0">  이름(실명)사용에 체크하면 회원이 글쓰기 하는 경우 회원의 이름(실명)으로 글쓰기 합니다. 이렇게 쓴 글은 추후 별명으로 변경이 쉽지 않으므로 처음 게시판 생성시 유의하시기 바랍니다.<br><img src="img/middot.gif" border="0">  서명보이기 사용은 게시글 보기에서 내용과 코멘트의 중간에 나오는 회원이 서명한 글 내용을 보이도록 하는것입니다.<br><img src="img/middot.gif" border="0">  IP 보이기 사용은 게시자(코멘트 포함)의 이름(또는 별명) 옆에 IP를 보이게 하는것입니다. 일반 방문객 또는 회원일 경우에는 IP를 전체보여주지 않으며 관리자인 경우 전체 IP를 보여줍니다.<br><img src="img/middot.gif" border="0">  트랙백 사용은 위의 트랙백 쓰기 권한 보다 우선합니다. 만약, 트랙백 사용을 하지 않는다면 트랙백 쓰기도 되지 않을 뿐 아니라, 외부 블로그에서 내 홈페이지로 트랙백을 쓸 수도 없습니다.<br><img src="img/middot.gif" border="0">  목록에서 내용 사용은 게시판에서 리스트를 출력할 경우 대부분 제목만을 사용하여 출력합니다. 그러나 방명록과 같은 게시판은 스킨은 제목 이외에 내용도 출력을 해주어야 합니다. 이때 사용하는 옵션이며 이 옵션을 체크를 하게 되면 게시판 목록 출력시 체감 속도가 느려지는 것을 확인할 수 있습니다.<br><img src="img/middot.gif" border="0">  전체목록보이기 사용은 게시물 상세 보기에서 하단에 게시판 목록을 출력해 줄것인지를 설정하는 옵션입니다.<br><img src="img/middot.gif" border="0">  메일발송사용은 이 게시판에 올라오는 게시물(코멘트포함)이 있을 경우 메일로 발송할지를 설정하는 옵션입니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.090.gif" width="690" height="306" border="1"></p>
<p><img src="img/middot.gif" border="0">  스킨디렉토리는 skin/board 에 있는 디렉토리를 선택하는 것입니다. 기본으로 board 와 cheditor 스킨이 있으며 cheditor 스킨을 선택하는 경우 경우에는 내용을 dhtml editor 로 작성할 수 있습니다.<br> <img src="img/middot.gif" border="0">  가로 이미지수는 스킨을 갤러리 형식으로 사용하는 경우에 사용하는 값으로 한줄(라인)에 이미지를 몇 개씩 보여줄지를 설정하는 값입니다.<br> 게시판 테이블폭은 게시판의 폭을 몇 픽셀 또는 몇 %로 할지를 설정하는 값입니다. &lt;table width='이값'&gt;에서 이값에 들어가는 내용입니다. &nbsp;설정값이 100이하일 경우에는 &middot; %로 100을 초과하는 경우에는 픽셀로 나타냅니다.<br> <img src="img/middot.gif" border="0">  페이지당 목록 수는 한페이지에 몇줄(라인)을 나타낼지를 설정하는 값입니다.<br> <img src="img/middot.gif" border="0">  제목 길이는 게시판 목록의 제목에서 제목을 몇자리 까지 표시할지를 설정할 때 사용하는 값입니다. 이 설정값보다 제목이 길다면 나머지는 ... 으로 표시합니다.<br> <img src="img/middot.gif" border="0">  new 이미지는 게시판 목록의 제목옆에 new 라는 이미지를 몇시간 동안 출력할것인지를 설정하는 값입니다. 글이 많이 올라오는 경우에는 시간을 조금 작게 설정하는 것이 좋습니다.<br> <img src="img/middot.gif" border="0">  hot 이미지는 게시글의 조회수가 설정값 이상되면 게시판 목록의 제목옆에 hot 이미지를 출력하는 것을 설정하는 값입니다.<br><img src="img/middot.gif" border="0">  이미지 폭 크기는 게시물에 포함된 이미지 태그 또는 업로드 된 파일의 이미지 출력시 설정값보다 이미지의 폭이 크다면 설정값만큼만 표시하여 테이블이 늘어나는 일이 생기지 않도록 하는 값입니다.<br><img src="img/middot.gif" border="0">  답변달기는 게시물에 답변을 다는 경우 가장 늦게 올라온 답변을 맨아래에 위치하게 할지 맨위에 위치하게 할지를 설정할 때 사용합니다.<br><img src="img/middot.gif" border="0">  사용금지태그는 단어를 | 로 구분하며 글 내용에 script 라는 태그가 있다면 script-x 라는 태그로 바꾸어 태그가 정상적으로 작동하지 못하게 할 때 사용합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.100.gif" width="690" height="120" border="1"></p>
<p><img src="img/middot.gif" border="0">  최소, 최대 글수 제한은 글 입력시 내용에 대한 글수를 제한합니다. 그러나 이 설정은 스킨의 영향을 많이 받으므로 사용이 안될 수도 있습니다. 보통 basic 스킨에서는 사용 가능합니다.<br><img src="img/middot.gif" border="0">  최소, 최대 코멘트수 제한은 코멘트 입력시 내용에 대한 코멘트 글수를 제한합니다. 그러나 이 설정은 스킨의 영향을 많이 받으므로 사용이 안될 수도 있습니다. 보통 basic 스킨에서는 사용 가능합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.110.gif" width="690" height="58" border="1"></p>
<p><img src="img/middot.gif" border="0">  파일 업로드 갯수는 게시판에 글 입력시 최대 몇 개의 파일을 업로드 할지를 설정합니다. 기본값은 2이며 0으로 설정하면 업로드 갯수에 제한이 없습니다.<br><img src="img/middot.gif" border="0">  파일 업로드 용량은 업로드하는 파일 한 개당 최대 몇바이트까지 업로드 할지를 설정합니다. (괄호)안의 최대 몇M 이하는 php.ini 에 설정된 값으로 최대 이 이상은 업로드가 가능하지 않습니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.120.gif" width="679" height="334" border="1"></p>
<p><img src="img/middot.gif" border="0">  상단, 하단 파일 경로는 게시판의 상단, 하단 디자인을 입혀주는 경우에 사용합니다. 보통 상단 파일 경로는 ../head.php 으로 하단 파일 경로는 ../tail.php 로 설정합니다.<br><img src="img/middot.gif" border="0">  상단, 하단 내용은 HTML 로 작성하여야 하며 게시판의 상단과 하단에 특정한 내용을 넣는 경우에 사용합니다.<br><img src="img/middot.gif" border="0">  글쓰기 기본 내용은 게시자가 글을 작성하려 할 때 내용에 기본으로 출력하는 내용입니다. 주문서를 게시판으로 입력받는 경우에 주로 사용합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.130.gif" width="690" height="58" border="1"></p>
<p><img src="img/middot.gif" border="0">   전체 검색 사용은 주로 홈페이지의 상단에 있는 검색을 말하며 http://도메인/bbs/search.php 에서 검색하는 경우에 사용할지를 설정합니다. 사용에 체크하지 않는 경우 개별게시판에서만 검색이 가능합니다.<br><img src="img/middot.gif" border="0">   전체 검색 순서는 http://도메인/bbs/search.php 에서 검색하는 경우에 검색 우선 순위를 나타냅니다. 숫자로 입력을 하며 숫자가 낮은 게시판부터 우선 출력합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.board.140.gif" width="690" height="92" border="1"></p>
<p><img src="img/middot.gif" border="0">   게시판의 여분 필드는 미리 10개가 준비되어 있습니다. 여분 필드는 테이블에 필드를 추가할 일이 생겼을 때 사용하는 것입니다. 여분 필드는 &lt;?=$board[bo_1]?&gt; 과 같은 방법으로 출력할 수 있습니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>