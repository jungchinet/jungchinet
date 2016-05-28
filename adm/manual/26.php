<?
$sub_menu = "400500";
include_once("./_common.php");
$g4['title'] = "배송일괄처리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>배송일괄처리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>배송일괄처리</b></p>
<p>&bull; 주문상세내역에서 배송내역을 하나씩 처리하는 번거로움을 해소하기 위하여 미배송된 내역을 한꺼번에 처리하는 화면입니다.</p>
<p><img src="img/adm.shop.delivery.010.gif" width="690" height="249" border="1"></p>
<p>&bull; 배송일시는 입력의 편의성을 위하여 기본적으로 현재시간을 기준으로 입력되어 있습니다. 배송한 날짜와 시간으로&nbsp;수정할 수 있습니다.<br>&bull; 배송회사는 배송회사관리에서 등록한&nbsp;내용이 셀렉트박스로 표시됩니다. 배송회사가 더 있다면 배송회사관리에서 추가하면 됩니다.<br>&bull; 메일발송, SMS 에 체크하면 일괄수정시 해당 배송건에 대해 메일과 SMS를 전송합니다.<br>&bull; 운송장번호를 해당 주문번호에 입력하여 일괄수정을 클릭하면 모두 반영됩니다. 
</p>
 
</body>

</html>
<?
include_once ("./manual.tail.php");
?>