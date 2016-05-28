<?
$sub_menu = "400300";
include_once("./_common.php");
$g4['title'] = "상품관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>상품관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>상품관리</b></p>
<p><img src="img/adm.shop.item.010.gif" width="690" height="175" border="1"></p>
<p>&bull; 하나의 상품은 최대 3개의 분류를 지정할 수 있습니다. 기본분류는 반드시 선택하여야 합니다.<br>&bull; 코드 중복검사는 이미 이 코드로 상품이 등록 되어 있는지를 검사하는것입니다. 코드 중복검사를 하지 않으시려면 쇼핑몰설정 &gt; 코드 중복검사의 사용을 체크하지 않으시면 됩니다.<br>&bull; 상품명에는 HTML 쓰기가 가능하며 최대 영문 250자(한글 125자) 까지 입력이 가능합니다.<br>&bull; 출력유형을 갤러리로 사용에 체크하시면 이 상품은 구매하실 수 없는 상품으로 변경됩니다. 구매하기 버튼 없이 상품설명만 보이게&nbsp;할 
경우에 사용하시면 됩니다.<br>&bull; 출력순서는 보통 경중률이라고 하는 기능으로 리스트에서 상품의 출력순서를 정할 때 사용합니다. 숫자를 입력하며 숫자가 낮은 상품이 우선 출력됩니다. - 음수도 입력이 가능합니다.<br>&bull; 상품유형 히트, 추천, 최신, 인기, 할인상품등 총 다섯 개의 유형을 체크하실 수 있습니다. 이 유형은 쇼핑몰설정 &gt; 초기화면에 출력해 주는 상품들을 말합니다. 상품유형에 체크하시면 스킨별로 상품명 옆에 아이콘을 출력하기도 합니다.<br>&bull; 제조사와 원산지는 입력하지 않으시면 화면에 출력하지 않습니다.</p>
<p>&nbsp;</p>
<p><b>상품옵션</b></p>
<p><img src="img/adm.shop.item.020.gif" width="690" height="98" border="1"></p>
<p>&bull; 제조사, 원산지 이외에 6개의 별도 옵션을 마련해 놓고 있습니다.<br>&bull; 1의 경우 줄을 띄우면 안됩니다. 계속 붙여서 입력하셔야 하며 공백은 입력이 가능합니다.<br>&bull; 2의 경우 기본값은 옵션의 첫 라인에 있는 &nbsp;&quot;없음&quot;에 선택되게 됩니다. 그러나 &nbsp;옵션의 옵션의 첫 라인에는 금액이 있는 옵션은 입력이 불가하며 등록자체가 안됩니다.<br>&bull; 3의 경우&nbsp;상품 구입시 옵션을 반드시 선택하셔야 합니다.<br>&bull; 4의 경우 금액이 별도로 입력되어 있지 않아도 상관이 없습니다.</p>
<ul>
    <p>아래는 위의 옵션에서 설정한 값을 상품상세보기에 출력한 예입니다.</p>
    <p><img src="img/adm.shop.item.030.gif" width="690" height="354" border="1"></p>
</ul>
<p>&nbsp;</p>
<p><b>가격/포인트/재고 입력</b></p>
<p><img src="img/adm.shop.item.050.gif" width="690" height="64" border="1"></p>
<p>&bull; 3가지의 상품가격을 지원합니다. 로그인전에는 비회원가격을, 권한이 2인 회원에게는 회원가격을, 권한이 3이상이 회원에게는 특별회원가격을 적용합니다. 만약, 상품 가격이 동일하다면 비회원가격만 입력하시면 됩니다.<br> &nbsp;주의) 비회원, 회원 가격이 다른 경우 비회원으로 장바구니에 담고 로그인하여 주문을 하는 경우에 회원가격으로 표시되지 않습니다. 이런 경우를 방지하기 위하여 쇼핑몰설정 &gt; 기타정보 &gt; 장바구니 메시지를 체크해 놓으시면 장바구니에 담기전에 가격이 다르다는 메시지를 출력합니다.<br>&bull; 판매가격은 0 으로 입력하여도 주문이 가능하므로 주의하여 주의하여 주십시오.<br>&bull; 시중가격은 말 그대로 시중에서 판매되는 가격입니다. 입력하지 않으면 표시하지 않습니다.<br>&bull; 포인트는 주문의 배송이 완료된 후 회원에게만 지급됩니다. 적당한 포인트를 입력하십시오.<br>&bull; 재고수량은 현재 존재하는 재고의 수량으로 입력해 놓으시면 됩니다. 재고를 체크하지 않을 경우에는 큰 수로 입력해 놓으십시오. 99999 등...<br>&nbsp;&nbsp;재고가 반영되는 시점은 상품을 배송하거나 완료한 시점입니다.</p>
<p>&nbsp;</p>
<p><b>상품설명</b></p>
<p><img src="img/adm.shop.item.060.gif" width="690" height="383" border="1"></p>
<p>&bull; 기본설명은 상품상세보기의 상품정보에 최상단에 표시되는 한줄의 간단한 설명입니다. 아래의 이미지에서 빨간줄로 표시된 부분입니다.<br>&nbsp;&nbsp;&nbsp;<img src="img/adm.shop.item.070.gif" width="690" height="146" border="1">&nbsp;</p>
<p>&bull; 상품설명은 HTML 로 입력이 가능합니다. 다른 홈페이지의 복사, 붙여넣기도 가능합니다.<br>&bull; 판매자 e-mail 은 분류에서 등록한 e-mail 이 기본으로 입력됩니다.<br>&bull; 전화문의를 선택하시는 경우에는 상품의 가격대신 '전화문의'로 표시되며 장바구니에 담기나 바로구매 버튼이 표시되지 않습니다.<br>&bull; 판매가능에 체크를 해제하시면 리스트나 상품상세보기 페이지에 표시되지 않습니다.</p>
<p>&nbsp;</p>
<p><b>상품이미지</b></p>
<p><img src="img/adm.shop.item.080.gif" width="690" height="224" border="1"></p>
<p>&bull; 큰이미지를 입력하면 자동으로 중간이미지와 작은이미지를 생성하는 기능이 있습니다. 이 기능은 PHP 에 gd 라이브러리가 설치되어 있어야 가능합니다. 우선 자신의 PHP 에 gd 라이브러리가 설치되어 있는지 확인하려면, 환경설정 &gt; phpinfo() 메뉴를 클릭하여 아래와 비슷한 내용이 있는지 확인합니다. gd 라이브러리가 설치되어 있어도 버전이 낮은 경우에는 이 기능은 정상적으로 실행되지 않을 수 있습니다.<br>&nbsp;&nbsp;&nbsp;<img src="img/adm.shop.item.090.gif" width="610" height="163" border="1"><br>&bull; 이미지(중), (소)를 업로드하지 않으면 상품이미지 부분에 &quot;이미지 없음 (또는 no image)&quot;으로 표시합니다.</p>
<p>&nbsp;</p>
<p><b>관련상품 및 이벤트</b></p>
<p><img src="img/adm.shop.item.100.gif" width="690" height="239" border="1"></p>
<p>&bull; 관련상품은 오른쪽 상품목록에 등록된 모든 상품이 분류코드, 상품명 순으로 출력된 것을 클릭하여 선택된 목록으로 지정해 줍니다. 선택이 끝난 후에는 반드시 확인을 클릭하여야 관련상품에 반영 됩니다. 관련상품에 등록된 상품은 반대되는 상품에도 동일하게 관련상품으로 등록되어 동일한 작업을 두 번 해줄 필요가 없습니다.<br>&bull; 이벤트선택은 서로 다른 분류에 속한 상품을 동일한 분류로 다시 묶어주는 역할을 합니다. 관련상품과 동일한 방법으로 등록하시면 됩니다. 이 작업은 이벤트 일괄처리로 하시면 더욱 쉽게 처리하실 수 있습니다.</p>
<p>&nbsp;</p>
<p><b>기타정보</b></p>
<p><img src="img/adm.shop.item.110.gif" width="690" height="444" border="1"></p>
<p>&bull; 상단, 하단 이미지는 상품상세보기 페이지의 상단과 하단에 이미지를 출력할 경우에 사용합니다. 기본적으로 상단이미지는 data/item/상품코드_h , 하단이미지는 data/item/상품코드_t 로 저장됩니다.<br>&bull; 상단, 하단 내용은 상품상세보기 페이지의 상단과 하단에 내용을 출력할 경우에 사용합니다. 기본 HTML 로 작성됩니다.<br>&bull; 입력일시는 상품을 입력하고 난 다음에 표시되는 내용입니다. 말 그대로 상품을 입력한 날짜와 시간입니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>