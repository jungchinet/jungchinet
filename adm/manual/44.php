<?
$sub_menu = "500130";
include_once("./_common.php");
$g4['title'] = "전자결제내역";
include_once ("./manual.head.php");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>전자결제내역</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<P><b>카드결제내역</b></P>
<P>신용카드결제시 정상적으로 승인되면 승인된 결과를 결제대행사에서 넘겨받아 값을 아래와 같은 형식으로 저장해 놓습니다.</P>
<P>주의) 이곳에 내역이 존재한다고 하더라도 결제대행사에서 제공하는 관리페이지에서 해당 주문이 정상적으로 승인되었는지를 
반드시 확인해 보셔야 합니다.</P>
<P><img src="img/adm.shop.ordercardhistory.010.gif" width="690" height="135" border="1"></P>
<p>&bull; 주문번호를 클릭하시면 해당 주문서 수정 화면으로 이동합니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>