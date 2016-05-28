<?
$sub_menu = "400410";
include_once("./_common.php");
$g4['title'] = "주문통합관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>주문통합관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>주문통합관리</b></p>
<p>&bull; 회원의 주문중 여러건에 대해 통합으로 주문상품을 보여주는 방식. 회원에 여러가지 주문상품들에 대한 조회가 쉬어져 주문회원별로 주문상품을 통합관리할 수 있는 
페이지입니다.</p>
<p><img src="img/25_img01.gif" width="690" height="438" border="1"></p>
<p>&bull; 상단의 주문번호,&nbsp;주문자,&nbsp;회원ID,&nbsp;건수,&nbsp;주문취소,&nbsp;DC,&nbsp;입금취소&nbsp;미수금 버튼을 클릭하면 해당 상태만 표시하므로 주문대기 중인 상품 또는 배송이 완료된 상품들로만 조회가 가능합니다.<br>&bull; 주문번호를 클릭하시면 같은&nbsp;주문번호의 주문만 조회합니다.<br>&bull; 주문자를 클릭하시면 같은&nbsp;주문자의 주문만 조회합니다.<br>&bull; 회원ID를 클릭하시면 같은 회원ID의 주문만 조회합니다.<br>&bull; 수정을 클릭하시면 해당 주문에 대한 주문관리의 상세페이지로 이동합니다.</p>
 
</body>

</html>
<?
include_once ("./manual.tail.php");
?>