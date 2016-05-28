<?
$sub_menu = "400200";
include_once("./_common.php");
$g4['title'] = "분류관리";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>분류관리</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>분류관리</b></p>
<p>쇼핑몰을 운영하기 위해서는 가장 먼저 입력해야 하는 정보가 분류입니다. 분류라는 것은 상품을 그룹 지어주는것입니다.<br>5단계까지의 분류를 사용하는 것이 가능합니다. 예를 들어 컴퓨터 -&gt; 모니터&nbsp;-&gt; 삼성 -&gt; 17&quot; -&gt; 평면 과 같은 분류도 생성할 수 있습니다.<br>분류는 각 단계별로 1,296개 까지 등록할 수 있으므로 총 5단계 분류로 이론상 3,656,158,440,062,976 개의 분류를 등록할 수 있습니다.</p>
<p>분류를 추가하는 방법에는 다음과 같이 두가지 방법이 있습니다.</p>
<ul>
    <p>1단계 분류를 추가하려면 리스트이 상단에 있는 추가 아이콘을 클릭하십시오.<br><img src="img/adm.shop.category.010.gif" width="395" height="118" border="0">&nbsp;</p>
</ul>
<ul>
    <p>2단계 이상의 하위분류 추가는 리스트 오른쪽에 있는 추가 아이콘을 클릭하십시오.<br><img src="img/adm.shop.category.020.gif" width="395" height="118" border="0">&nbsp;</p>
</ul>
<p><b>분류추가</b></p>
<p><img src="img/adm.shop.category.030.gif" width="690" height="346" border="1"></p>
<p>&bull; 분류추가시 분류코드는 자동으로 생성하여 보여줍니다. 물론 수정도 가능합니다. 처음 등록하는 경우 코드는 10에서 시작하며 20, 30 ... a0, b0 ... z0 와 같은 방식으로 생성합니다.<br>&bull; 코드 중복검사는 이미 이 코드로 분류가 등록 되어 있는지를 검사하는것입니다. 코드 중복검사를 하지 않으시려면 쇼핑몰설정 &gt; 코드 중복검사의 사용을 체크하지 않으시면 됩니다.<br>&bull; 관리 회원아이디는 해당 분류를 관리하는 회원의 아이디를 입력합니다. 이곳에 회원아이디를 등록하고 해당 회원에 대한 관리권한을 주게 되면 해당 회원이 직접 분류를 수정할 수 있으며 하위 분류도 추가할 수 있습니다. 그러나 관리권한에서 해당 회원에게 삭제권한을 주었더라도 프로그램에서는 최고관리자 이외에 누구도 분류를 삭제할 수는 없습니다. 이 기능은 해당 분류별로 관리하는 사람이 다를 경우에 유용하게 사용될 수 있습니다.<br>&bull; 출력스킨은 이 분류에 해당하는 상품을 리스트 형식으로 출력해 주는 것으로 shop/list.skin.*.php 의 이름을 가진 파일을 말합니다. 이 출력스킨에 대해서는 
<a href='?man=adm.shop.list.skin.htm'>별도의 페이지</a>에서 다시 설명하도록 하겠습니다.<br>&bull; 옵션제목은 각 분류별로 다르게 설정할 수 있습니다. 제조사와 원산지는 기본이므로 규격, 색상등의 제목을 입력하시면 됩니다.<br>&bull; 재고수량은 이 분류에 속한 상품을 등록시 기본적으로 출력하는 수량입니다. 만약, 재고를 사용하지 않는다면 큰 수를 입력하십시오. 예) 
99999<br>&bull; 판매자 E-mail은 이 분류에 속한 상품을 관리하는 사람과 판매(배송)하는 사람이 다른 경우에 사용합니다. 판매자 E-mail을 입력하면 주문시 판매자에게도 주문메일이 발송됩니다. (단, 판매가격은 보내지 않습니다.)<br>&bull; 판매가능은 이 분류를 사용하지 않을 경우에 체크만 해제하면 됩니다.</p>
<p>&nbsp;</p>
<p><b>선택입력</b></p>
<p><img src="img/adm.shop.category.040.gif" width="690" height="126" border="1"></p>
<p>&bull; 상단, 하단 파일 경로는 기본 상단, 하단 경로인 ../head.php 와 ../tail.php 대신에 다른 디자인으로 상품&nbsp;리스트를 출력할 때 입력합니다. 예를 들어 ../shop_head.php , ../shop_tail.php 와 같이 다른 디자인으로 적용할 수 있습니다.<br>&bull; 상단, 하단 이미지는 상품&nbsp;리스트의 상단과 하단에 이미지를 출력할 경우에 사용합니다. 기본적으로 상단이미지는 data/category/분류코드_h , 하단이미지는 data/category/분류코드_t 로 저장됩니다.</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.category.050.gif" width="690" height="357" border="1"></p>
<p>&bull; 상단, 하단 내용은 상품 리스트의 상단과 하단에 내용을 출력할 경우에 사용합니다. 기본 HTML 로 작성됩니다.</p>
<ul>
    <p>아래는 상단, 하단 이미지, 내용에 대해 적용한&nbsp;예제 이미지입니다.</p>
    <p><img src="img/adm.shop.category.060.gif" width="690" height="718" border="1"></p>
</ul>
<p><b>하위분류</b></p>
<p><img src="img/adm.shop.category.070.gif" width="690" height="62" border="1"></p>
<p>&bull; 체크하시면 이 분류에 속한 하위분류를 이&nbsp;분류에 설정된 값과 동일한 값으로 설정합니다. 상단, 하단 이미지는 복사하지 않습니다.<br>&bull; 분류에 대한 설정만 변경되는 작업이므로 상품의 설정에는 전혀 변함이 없습니다.</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>