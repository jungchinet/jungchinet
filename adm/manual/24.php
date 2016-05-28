<?
$sub_menu = "400410";
include_once("./_common.php");
$g4['title'] = "주문개별관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>주문개별관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>주문개별관리</b></p>
<p>&bull; 주문서 한건에 대해 여러 가지의 상품이 포함될 수 있는 방식이므로 각 주문에 속한 상품별 조회가 어려운점을 감안하여 주문상품별로 관리할 수 있는 
페이지입니다.</p>
<p><img src="img/adm.shop.orderstatus.010.gif" width="690" height="269" border="1"></p>
<p>&bull; 상단의 주문,&nbsp;준비,&nbsp;배송,&nbsp;완료,&nbsp;취소,&nbsp;반품,&nbsp;품절 버튼을 클릭하면 해당 상태만 표시하므로 주문대기 중인 상품 또는 배송이 완료된 상품들로만 조회가 가능합니다.<br>&bull; 주문번호를 클릭하시면 같은&nbsp;주문번호의 주문만 조회합니다.<br>&bull; 주문자를 클릭하시면 같은&nbsp;주문자의 주문만 조회합니다.<br>&bull; 회원ID를 클릭하시면 같은 회원ID의 주문만 조회합니다.<br>&bull; 수정을 클릭하시면 해당 주문에 대한 주문관리의 상세페이지로 이동합니다.</p>
 
</body>

</html>
<?
include_once ("./manual.tail.php");
?>