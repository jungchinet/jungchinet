<?
$sub_menu = "400630";
include_once("./_common.php");
$g4['title'] = "이벤트 관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>이벤트 관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>이벤트관리</b></p>
<p><img src="img/adm.shop.itemevent.010.gif" width="690" height="116" border="1"></p>
<p>&bull; 이벤트란 서로 다른 분류에 속한 상품들을 하나로 묶을 때 사용합니다.<br>&bull; <img align="absmiddle" src="img/icon_insert.gif" width="22" height="21" border="0"> 을 클릭하면 아래와 같은 화면이 표시됩니다.</p>
<p><img src="img/adm.shop.itemevent.020.gif" width="690" height="194" border="1"></p>
<p>&bull; 출력스킨은 이 이벤트에 해당하는 상품이미지를 출력하는 스킨으로 shop/list.skin.*.php 의 이름을 가진 파일들을 선택합니다.<br>&bull; 출력이미지의 폭과 높이는 작은이미지를 기준으로 입력하시면 됩니다.<br>&bull; 1라인 이미지수와 총라인수를 곱한 것이 한페이지에 출력되는 이미지의 수입니다.<br>&bull; 사용은 이벤트를 사용할 것인지에 대해 설정하는 것입니다. 사용을 하지 않는다면 쇼핑몰화면 좌측의 이벤트메뉴에서 제외되며  
사용자가 해당 이벤트 리스트에 접근할 수 없습니다.</p>
<p> <img src="img/adm.shop.itemevent.025.gif" width="690" height="414" border="1"></p>
<p>&bull; 메뉴이미지를 업로드하게 되면 쇼핑몰화면 좌측메뉴에 이벤트제목대신 이미지가 표시됩니다. 메뉴이미지의 경로는 
data/event/이벤트번호_m 입니다.<br>&bull; shop/event.php 에서 출력되는 이벤트 페이지의 상하단에 이미지와 HTML 내용을 넣을 수 있습니다.<br>&bull; 상단이미지의 경로는 data/event/이벤트번호_h, 하단이미지 경로는 data/event/이벤트번호_t 로 저장됩니다.<br>&bull; 상하단 내용은 기본&nbsp;HTML 로 입력됩니다. 
 
 
</p>
 

<p><img src="img/adm.shop.itemevent.030.gif" width="510" height="451" border="0"></p>
<p>&bull; 이 페이지는 이벤트관리의 리스트에서 연결상품을 클릭하면 새창에 출력하는 내용입니다.<br>&bull; 삭제는 해당 이벤트에서 해당 상품을 삭제할 때 사용합니다. 
</p>
 
</body>

</html>
<?
include_once ("./manual.tail.php");
?>