<?
$sub_menu = "100000";
include_once("./_common.php");
$g4['title'] = "기본환경설정";
include_once ("./manual.head.php");
?>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>기본환경설정</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>기본환경설정</b></p>
<p><img src="img/adm.config.010.gif" border="1" width="690" height="93"></p>

<p><img src="img/middot.gif" border="0">  홈페이지 제목은 브라우저의 상단에 표시됩니다.<br> &nbsp;&nbsp;<img src="img/adm.config.020.gif" border="1" width="255" height="42"></p>
<p><img src="img/middot.gif" border="0">  최고관리자 권한이 10 인 회원중에서 최고관리자를 선택합니다. 최고관리자는 환경설정등의 설정을 수정할 수 있으며 관리자 페이지중에는 최고관리자만 접근이 가능한 페이지가 있습니다. 예) 기본환경설정, 관리권한설정 등<br><img src="img/middot.gif" border="0">  포인트는 회원가입시, 추천시, 로그인시, 게시판 글(코멘트) 작성시, 파일을 다운로드 할 경우, 주문시, 주문배송 완료시, 관리자가 특정회원에게 임의로 부여할 수 있습니다. 포인트사용에 체크를 하지 않으시면 이 모든 기능이 해제 됩니다.(사용하지 않습니다.) 포인트 1점은 1원과 같습니다<br><img src="img/middot.gif" border="0">  로그인시 포인트는 하루에 한번만 부여하므로 자연스럽게 방문객수를 늘릴 수 있습니다. 방문만 해도 하루에 한번 포인트가 늘어난다는 것을 강조하십시오.<br><img src="img/middot.gif" border="0">  이름(별명) 표시는 이름이나 별명을 표시할 경우에 몇자리 까지만 표시할 지를 설정합니다. 한글 1글자는 영문 2글자에 해당합니다. 10으로 표시했다면 한글 5자리만 표시됩니다.<br><img src="img/middot.gif" border="0">  별명은 실명 대신에 사용하는 것으로 너무 자주 바뀌게 되면 혼란이 있습니다. 한번 수정 후 설정일 이내에는 수정할 수 없습니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.config.030.gif" width="690" height="93" border="1"></p>

<p><img src="img/middot.gif" border="0">  최근게시물 삭제에 설정된&nbsp;설정일이 지난 최근게시물은 환경설정 &gt; 복구/최적화 메뉴를 실행하는 경우에 자동으로 삭제합니다.<br><img src="img/middot.gif" border="0">  쪽지 삭제에 설정된&nbsp;설정일이 지난 쪽지는 환경설정 &gt; 복구/최적화 메뉴를 실행하는 경우 자동으로 삭제합니다.<br><img src="img/middot.gif" border="0">  접속자로그에 설정된&nbsp;삭제 회원관리 &gt; 접속자현황에 나타나는 개별내역을 설정일이 지난 후, &nbsp;환경설정 &gt; 복구/최적화 메뉴를 실행하는 경우에 자동으로 삭제합니다. 접속자로그 개별내역을 삭제하여도 합계에는 영향을 미치지 않습니다. (합계 테이블은 별도로 운영합니다.)<br><img src="img/middot.gif" border="0">  인기검색어 삭제는 검색시 인기검색어 테이블에 자동으로 검색어가 저장되며 이 저장된 검색어를 언제 삭제할지를 설정합니다. 환경설정 &gt; 복구/최적화 메뉴를 실행하는 경우 자동으로 삭제합니다.<br><img src="img/middot.gif" border="0">  현재 접속자는 몇분 이내에 접속한 접속자를 현재 접속자로 정할지를 설정합니다. 방문객이 적은 경우 설정값을 크게하면 되지만 현재 접속한 회원에게 쪽지를 발송하는 경우 접속되어 있지 않을 확률이 높습니다.<br><img src="img/middot.gif" border="0">  한페이지당 라인수는 목록(리스트) 한페이지당 라인수입니다. 코드는 주로 이렇게 표현합니다.<br> &nbsp;&nbsp;&nbsp;get_paging($config[cf_write_pages], $page, $total_page, &quot;$_SERVER[PHP_SELF]?$qstr&amp;page=&quot;);</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.040.gif" border="1" width="690" height="93"></p>
<p><img src="img/middot.gif" border="0">  최근게시물 스킨은 skin/new 디렉토리 안에 있는 디렉토리 스킨중에서 하나를 선택하는 것입니다. http://도메인/bbs/new.php 에서 보여지는&nbsp;페이지입니다.<br><img src="img/middot.gif" border="0">  최근게시물 라인수는 http://도메인/bbs/new.php에서 보여지는 한페이지당 라인수입니다.<br><img src="img/middot.gif" border="0">  검색 스킨은 skin/search 디렉토리 안에 있는 디렉토리 스킨중에서 하나를 선택하는 것입니다. http://도메인/bbs/search.php 에서 보여지는&nbsp;페이지입니다.<br><img src="img/middot.gif" border="0">  접속자 스킨은 skin/connect 디렉토리 안에 있는 디렉토리 스킨중에서 하나를 선택하는 것입니다. currenct_connect.skin.php 파일은&nbsp;http://도메인/bbs/current_connect.php 에서 보여지는 페이지입니다. connect.skin.php 파일은 &lt;?=connect();?&gt; 로 표시합니다.</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.050.gif" width="690" height="148" border="1"></p>
<p><img src="img/middot.gif" border="0">  자동등록방지 사용은 회원 가입할 때, 게시판에서 비회원 글쓰기 할 때 로봇 프로그램에 의한&nbsp;자동등록을 방지할 수 있는 기능입니다. 회원 가입할 때는 아래와 같이 표시됩니다.<br> &nbsp;&nbsp;<img src="img/adm.config.060.gif" width="580" height="62" border="1"></p>
<p><img src="img/middot.gif" border="0">  복사, 이동시 로그는 게시물을 복사하거나 이동할 때 게시물의 하단에 아래와 같이 표시합니다.<br> &nbsp;&nbsp;<img src="img/adm.config.070.gif" width="488" height="42" border="1"></p>
<p><img src="img/middot.gif" border="0">  접근가능 IP는 인트라넷 홈페이지를 운영하는 경우에 접근 할 IP 만 입력하면 됩니다. 홈페이지를 제작하시는 경우 &nbsp;접근 할 IP 만 입력하면 해당 IP 이외에는 접근이 불가합니다.<br><img src="img/middot.gif" border="0">  접근차단 IP는 게시판에 도배를 하는 경우에 특정 IP에 대해 &nbsp;홈페이지에 접근할 수 없도록 하는 기능입니다.</p>

<p>&nbsp;</p>
<p><b>게시판 설정</b></p>
<p><img src="img/adm.config.080.gif" width="690" height="93" border="1"></p>
<p><img src="img/middot.gif" border="0">  글읽기 포인트, 글쓰기 포인트, 코멘트쓰기 포인트, 다운로드 포인트는 게시판을 생성하는 경우에 기본값으로 사용합니다.<br><img src="img/middot.gif" border="0">  LINK TARGET 은 게시판 내용중 http 로 시작하는 주소의 타켓을 설정합니다. _top 으로 하시는 경우에는 현재 창에 링크가 되며, _blank 또는 _new 로 하시는 경우에는 새창으로 링크를 합니다.<br><img src="img/middot.gif" border="0">  검색 단위는 게시판 개별 검색에서 자료가 많은 경우 검색이 느려지므로 설정단위로 나누어서 검색을 합니다. 게시물의 건수가 검색 단위 보다 크다면 게시판 하단에 아래와 같이 '다음검색'이 표시됩니다.<br> &nbsp;&nbsp;<img src="img/adm.config.090.gif" width="326" height="63" border="1"></p>
<p>&nbsp;</p>
<p><img src="img/adm.config.100.gif" width="690" height="93" border="1"></p>
<p><img src="img/middot.gif" border="0">  검색 배경 색상, 검색 글자 색상은 게시판 검색시에 검색된 글자의 배경 색상과 글자 색상을 정합니다.<br> &nbsp;&nbsp;<img src="img/adm.config.110.gif" width="618" height="93" border="1"></p>

<p><img src="img/middot.gif" border="0">  새로운 글쓰기는 도배를 방지하기 위한 것입니다. 글작성(코멘트 포함)을 한 후 설정값 이내에 다시 글작성을 하면 아래와 같은 메시지가 출력됩니다.<br> &nbsp;&nbsp;<img src="img/adm.config.120.gif" width="388" height="114" border="0"></p>
<p><img src="img/middot.gif" border="0">  페이지 표시수는 게시판 리스트에 표시하는 페이지의 수입니다. 아래와 같이 표시됩니다<br> &nbsp;&nbsp;<img src="img/adm.config.130.gif" width="244" height="74" border="1"></p>
<p><img src="img/middot.gif" border="0">  이미지 업로드 확장자는 이미지 파일로 사용할 확장자를 | 로 구분하여 설정할 수 있습니다. 이곳에 등록된 이미지 확장자 파일은 게시판 내용 출력시 &lt;img&gt; 태그를 기본으로 포함하여 출력합니다. bmp 같은 이미지 파일은 용량이 커서&nbsp;많은 트래픽을 유발할 수 있으므로 이미지 확장자로 권해 드리지&nbsp;않습니다.</p>
<p>&nbsp;</p>

<p><img src="img/adm.config.140.gif" width="690" height="180" border="1"></p>
<p><img src="img/middot.gif" border="0">  플래쉬 업로드 확장자는 플래쉬 파일로 사용할 확장자를 | 로 구분하여 설정할 수 있습니다. 이곳에 등록된 플래쉬 확장자 파일은 게시판 내용 출력 시 &lt;embed&gt; 태그를 기본으로 포함하여 출력합니다.<br><img src="img/middot.gif" border="0">  동영상 업로드 확장자는 동영상 파일로 사용할 확장자를 | 로 구분하여 설정할 수 있습니다. 이곳에 등록된 동영상 확장자 파일은 게시판 내용 출력시 &lt;embed&gt; 태그를 기본으로 포함하여 출력합니다.<br><img src="img/middot.gif" border="0">  단어 필터링은 게시판 글입력(코멘트 입력 포함)시 위 단어가 들어간 게시물은 등록이 되지 않도록 검사하여 경고창을 띄웁니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.config.150.gif" width="690" height="121" border="1"></p>
<p><img src="img/middot.gif" border="0">  회원 스킨은 회원가입과 정보수정, 달력, 폼메일, 로그인, 쪽지보내기, 자기소개, 스크랩, 우편번호, 아이디/패스워드 찾기가 들어 있는 통합스킨입니다. skin/member 디렉토리 안에 있는 디렉토리 스킨중에서 하나를 선택하는 것입니다.<br><img src="img/middot.gif" border="0">  홈페이지, 주소, 전화번호, 핸드폰, 서명, 자기소개 입력은 보이기에 체크하는 경우 회원가입시 입력을 받을 수 있도록 합니다. 필수입력에 체크하는 경우 체크된 정보는 반드시 입력하여야 합니다. 보이기에 체크하지 않고 필수입력에만 체크하는 경우에는 정보를 입력할 방법이 없으므로 주의하십시오.</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.160.gif" width="690" height="156" border="1"></p>
<p><img src="img/middot.gif" border="0">  회원가입시 권한은 회원가입하는 경우 기본으로 권한을 어떻게 줄것인지 설정합니다. 게시판 읽기 권한이 2이고 관리자에게 승인을 얻은 회원에게만 글읽기가 가능하도록 하려면 회원가입시 권한을 1로 주신 후 회원관리에서 권한을 관리자 임의로 설정하시면 됩니다.<br><img src="img/middot.gif" border="0">  회원가입시 포인트는 포인트 사용에 사용체크가 되어 있다면 회원을 가입함과 동시에 설정포인트를 해당 회원에게 부여합니다.<br><img src="img/middot.gif" border="0">  주민등록번호는 사용에 체크가 되어 있다면 회원가입시 주민등록번호를 필히 입력하도록 합니다. 그러나 실명인증&nbsp;사이트를 통하여 검사하는 것이 아니므로 틀린 주민등록번호를 입력하여도 회원가입이 가능합니다. 주민등록번호를 입력받으면 주민등록번호의 정보를 이용하여 생일과 성별에 기본으로 값을 입력합니다. 주민등록번호 앞 6자리 생년월일, 주민등록번호 7째자리 성별( 1과 3은 남자, 2와 4는 여자) 성별에서 3과 4는 2000도 이후의 출생을 나타냅니다.<br><img src="img/middot.gif" border="0">  회원아이콘 사용은<br> &nbsp;&nbsp;&nbsp;미사용 : 회원의 이름(별명)만 표시합니다.<br>&nbsp;&nbsp;&nbsp;아이콘만표시 : 회원의 아이콘이 있는 경우에는 아이콘만 표시하며, 아이콘이 없는 회원은 이름을 표시합니다.<br> &nbsp;&nbsp;&nbsp;아이콘+이름 표시 : 회원의 아이콘이 있는 경우에는 아이콘과 회원의 이름(별명)을 표시합니다. 아이콘이 없는 경우 이름(별명)만 표시합니다.<br><img src="img/middot.gif" border="0">  아이콘 업로드 권한은 회원 정보수정에서 아이콘을 올릴 수 있는 회원의 권한을 설정합니다.<br><img src="img/middot.gif" border="0">  회원아이콘 용량은 아이콘(gif) 이미지의 용량을 설정할 수 있습니다. 너무 큰 이미지는 게시판등의 출력시에 많은 트래픽을 유발 할 수 있습니다.<br><img src="img/middot.gif" border="0">  회원아이콘 사이즈는 아이콘(gif) 이미지의 폭과 높이 사이즈를 정할 수 있습니다. 게시판 디자인에 맞게 설정하는 것이 좋습니다.<br><img src="img/middot.gif" border="0">  추천인제도를 사용하는 경우 추천이 포인트를 같이 설정하는 것이 좋습니다.<br><img src="img/middot.gif" border="0">  추천인제도를 사용으로 하면 회원가입시 추천인 아이디를 입력받을 수 있도록 표시됩니다. 회원가입과 동시에 추천인에게 추천인 포인트 만큼을 부여합니다.</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.170.gif" width="690" height="197" border="1"></p>
<p><img src="img/middot.gif" border="0">  아이디, 별명 금지단어는 입력된 단어가 포함된 내용은 회원아이디, 별명으로 사용할 수 없습니다. 단어와 단어 사이는 , 로 구분합니다.<br><img src="img/middot.gif" border="0">  입력 금지 메일은 메일 주소로 입력하지 못하게 할 도메인 주소를 입력합니다.<br><img src="img/middot.gif" border="0">  회원가입약관은 회원가입시 회원님들께 보여줄 약관의 내용을 입력합니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.config.180.gif" border="1" width="690" height="93"></p>
<p><img src="img/middot.gif" border="0">  메일발송 사용은 메일을 전혀 사용하지 못하는 서버의 경우 또는 메일을 사용하고 싶지 않은 경우에 체크를 해제할 수 있습니다. 체크하지 않는 경우 메일 발송을 아예 사용하지 않으며 메일 테스트도 불가합니다.<br><img src="img/middot.gif" border="0">  메일인증 사용은 회원가입시 입력받은 이메일 주소로 인증메일을 발송합니다. 인증을 하지 않는 경우 로그인 하여도 인증이 되어 있지 않다면 로그인이 불가합니다.<br>또한, 메일 주소를 수정하여 사용하는 경우에도 메일인증을 하여야 합니다. 메일인증을 사용하면 회원 님들께서 실제 사용하는 메일주소를 얻을 수 있습니다.<br><img src="img/middot.gif" border="0">  폼메일 사용 여부는 아웃룩 익스프레스등 컴퓨터에 기본으로 메일 클라이언트가 설치되어 있지 않은 경우 관리자 또는 다른 회원에게 메일을 발송하기가 수월하지 않습니다. 이때는 홈페이지에 기본적으로 탑재된 메일 폼을 이용하여 메일을 발송할 수 있습니다. 보통 폼메일이라고 부릅니다. 회원만 사용에 체크를 하게 되면 로그인을 한 회원에게만 메일을 발송할 수 있는 권한을 주게 됩니다. 이 체크를 풀게되면 비회원(일반 방문객)에게도 메일을 발송할 수 있는 권한을 주게 되어 로그인을 하지 않아 편하지만 자칫 스팸을 보낼 빌미를 제공하게 되므로 체크여부는 신중하게 검토하십시오.&nbsp;폼메일 양식은 보통 아래과 같이 표시됩니다.<br> &nbsp;&nbsp;<img src="img/adm.config.190.gif" width="300" height="260" border="0">&nbsp;</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.200.gif" width="690" height="178" border="1"></p>
<p><img src="img/middot.gif" border="0">  게시판 글 작성시<br> &nbsp;&nbsp;게시판에 글을 작성시(코멘트 포함) 글 내용을 메일로 발송할지를 선택하는 설정입니다. 관리자는 게시판에 올라오는 글을 모두 파악하는 것이 중요하므로 게시판 수가 적은 경우에는 최고관리자가 모든 메일을 확인하시면 좋습니다. 게시판의 수가 너무 많아 최고관리자 혼자 모든 메일을 확인하기 힘든 경우에는 그룹관리자 또는 게시판관리자에게 분산하여 메일을 발송하게 할지를 선택하십시오.</p>
<p><img src="img/middot.gif" border="0">  최고관리자 메일발송은 게시판에 글이 올라오는 경우(코멘트 포함) 최고관리자에게 게시물 내용을 메일로 발송할지를 선택합니다.<br><img src="img/middot.gif" border="0">  그룹관리자 메일발송은 게시판에 글이 올라오는 경우(코멘트 포함) &nbsp;해당 게시판의 그룹관리자에게 게시물 내용을 메일로 발송할지를 선택합니다.<br><img src="img/middot.gif" border="0">  게시판관리자 메일발송은 게시판에 글이 올라오는 경우(코멘트 포함) &nbsp;해당 게시판의 게시판관리자에게 게시물 내용을 메일로 발송할지를 선택합니다.<br><img src="img/middot.gif" border="0">  원글 메일발송은 원글에 코멘트가 올라오는 경우 해당 원글 게시자에게 코멘트 내용을 메일로 발송할지를 선택합니다. 메일 디자인은 bbs/write_update_mail.php를 수정하시면 됩니다.<br><img src="img/middot.gif" border="0">  코멘트 메일발송은 원글에 코멘트가 올라오는 경우 이 글에 코멘트를 쓴 모든 분들께 코멘트 내용을 메일로 발송할지를 선택합니다. 메일 디자인은 bbs/write_update_mail.php를 수정하시면 됩니다.</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.210.gif" width="475" height="149" border="1"></p>
<p><img src="img/middot.gif" border="0">  회원 가입시<br>&nbsp;&nbsp;회원 가입시에 회원가입 축하메일을 발송할지를 선택합니다.</p>
<p><img src="img/middot.gif" border="0">  최고관리자 메일발송은 회원이 회원가입을 한 경우에 최고관리자에게 메일을 발송할지를 선택합니다. 메일&nbsp;디자인은 bbs/register_form_update2.php를 수정하시면 됩니다. 메일은 내용은 기본으로 아래과 같습니다.<br> &nbsp;&nbsp;<img src="img/adm.config.220.gif" width="300" height="189" border="1">&nbsp;</p>
<p><img src="img/middot.gif" border="0">  회원님께 메일발송은 회원이 회원가입을 한 경우에 회원님께 메일을 발송할지를 선택합니다. 메일&nbsp;디자인은 bbs/register_form_update1.php를 수정하시면 됩니다.<br><img src="img/middot.gif" border="0">  투표 기타의견 작성시 최고관리자 메일발송은 투표에는 기타의견을 입력할 수 있습니다. 이때 최고관리자에게 메일을 발송할지를 선택합니다. 메일 디자인은 bbs/poll_etc_update_mail.php를 수정하시면 됩니다.</p>

<p>&nbsp;</p>
<p><img src="img/adm.config.230.gif" width="690" height="151" border="1"></p>
<p><img src="img/middot.gif" border="0">  여분 필드는 프로그램을 수정하여 사용하시는 경우 기존 테이블에 필드를 추가하는 불편없이 여분으로 사용하실 수 있도록 마련된 필드입니다. cf_1에서 cf_10 까지 사용하실 수 있으며 프로그램에서 출력하시는 경우에는 &lt;?=$config[cf_1]?&gt; 과 같은 방법으로 사용하시면 됩니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>