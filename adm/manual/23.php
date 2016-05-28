<?
$sub_menu = "400400";
include_once("./_common.php");
$g4['title'] = "주문관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>주문관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>주문관리</b></p>
<p><img src="img/adm.shop.order.010.gif" width="690" height="139" border="1"></p>
<p>&bull; 주문번호는 주문일 6자리(2005년 11월 14일 일 경우 051114로 표시) + 순번(0001부터 9999까지) 으로 표시됩니다.<br>&bull; 주문자 링크를 클릭하면 해당 주문자가 주문한 내용만 표시됩니다.<br>&bull; 회원ID&nbsp;링크를 클릭하면 해당 회원이 주문한 내용만 표시됩니다.<br>&bull; 건수 : 하나의 주문에 여러 가지 상품을 담아 주문할 수 있습니다. 건수는 여러 가지 상품의 건수를 말하며 상품의 수량이 
아닙니다.<br>&bull; 주문합계는 각 상품별 (판매가격 x 수량) + 배송비의 합산 금액입니다.<br>&bull; 주문취소는 주문에 속한 상품별로 취소, 반품, 품절이 있는 상품의 합산된 금액입니다. 예를 들어 주문번호 0511140003 주문을 클릭하시면 더 자세히 확인하실 수 있습니다.<br>&nbsp;&nbsp;&nbsp;<img src="img/adm.shop.order.020.gif" width="690" height="198" border="1"></p>
<p>&bull; DC는 해당 주문에 대해 할인해준 금액이 표시됩니다. <br>&bull; 입금합계는 (무통장입금 또는&nbsp;신용카드 또는&nbsp;계좌이체) + 포인트결제액의 합산된 금액입니다.<br>&bull; 입금취소는 환불 또는 신용카드 승인취소 금액의 합산된 금액입니다.<br>&bull; 미수금(미입금) = 주문합계 - 주문취소 - DC - (입금합계 + 입금취소)<br>&bull; 포인트는 다른 결제수단과 같이 결제하는 것이 가능합니다.<br>&bull; 결제수단에는 신용카드로 결제한 경우 &quot;카드&quot;, 실시간 계좌이체로 결제한 경우&nbsp;경우 &quot;실시간&quot;, 무통장으로 입금한 경우 &quot;은행이름&quot;, 포인트 결제의 경우 &quot;포인트&quot;로 표시됩니다.</p>
<p>&nbsp;</p>
<p><b>상세내역</b></p>
<p><img src="img/adm.shop.order.030.gif" width="690" height="253" border="1"></p>
<p>&bull; 하나의 주문에 여러 가지 상품을 주문할 수 있는 방식이므로 상품 건별로 상태를 다르게 변경할 수 있습니다. 왼쪽의 체크박스는 상태를 변경하기 위하여 선택하는 것으로 상단의 전체를 체크하면 모든 상품의 체크박스가 선택되게 됩니다. 체크후 아래의 
주문 | 상품준비중 | ... | 반품 | 품절 링크를 클릭하시면 해당 체크한 상품의 상태가 변경됩니다.<br>&bull; 포인트가 반영되는 시점은 배송완료 후 주문완료 포인트(쇼핑몰설정 &gt; 결제정보)에서 설정한 날 이후입니다. 만약, 이 설정일을 0 으로 입력한다면 주문완료로 상태를 변경함과 동시에 포인트를 해당 주문 회원에게 부여합니다.<br>&bull; 재고가 반영되는 시점은 상태가 배송중이나 완료가 되는 시점입니다. 다시 다른 상태로 변경하게되면 재고는 되돌려 집니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.order.040.gif" width="690" height="101" border="1"></p>
<p>&bull; 해당주문에 대한 주문, 입금액에 대한 내역을 합산하여 표시하므로 한눈에 입금을&nbsp;파악하실 수 있습니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.order.050.gif" width="690" height="345" border="1"></p>
<p>&bull; 왼쪽의 결제상세정보는 오른쪽 수정에서 입력한 내용이 표시되는 것입니다.<br>&bull; 신용카드결제로 선택하여 결제를 실패하여 승인을 받지 못한 주문도 무통장입금으로 입력하여 처리할 수 있습니다.<br>&bull; 입금이나 배송내역을 입력 후 주문자님께 메일을 발송하시려면 메일발송에 '예'를 체크하여 수정을 클릭하시면 됩니다.<br>&bull; 입금 문자 전송은 입금자명 오른쪽에 있는 SMS 문자전송에 체크 하십시오.<br>&bull; 배송 문자 전송은 운송장번호 오른쪽에 있는 SMS 문자전송에 체크 하십시오.<br>&bull; 결제상세정보 수정에 어떤 내용이라도 입력한 후에는 반드시 아래의 결제/배송내역 수정 버튼을 클릭하셔야 반영됩니다.</p>
<p>&nbsp;</p>
<p><b>상점메모</b></p>
<p><img src="img/adm.shop.order.060.gif" width="690" height="141" border="1"></p>
<p>&bull; 상점메모에는 상점에서 메모를 하는 용도로 사용하기도 하며, 이미지에서 보시는 것 처럼 메일발송 내역이 자동으로 저장됩니다.</p>
<p>&nbsp;</p>
<p><b>주소정보</b></p>
<p><img src="img/adm.shop.order.070.gif" width="690" height="239" border="1"></p>
<p>&bull; 주소정보는 주문하신 분과 받으시는 분의 정보를 표시하며 입력 박스의 값은 수정이 가능합니다.</p>
 
</body>

</html>
<?
include_once ("./manual.tail.php");
?>