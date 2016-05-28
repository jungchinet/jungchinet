<?
$sub_menu = "400100";
include_once("./_common.php");
$g4['title'] = "쇼핑몰 설정";
include_once ("./manual.head.php");
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>쇼핑몰 설정</title>
<meta name="generator" content="Namo WebEditor v6.0">
</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p><b>쇼핑몰 설정</b></p>
<p><img src="img/adm.shop.config.010.gif" width="690" height="192" border="1"></p>
<p>&bull; 이곳에 입력하는 내용은 홈페이지의 하단에 기본으로 표시됩니다. tail.php<br>&nbsp;&nbsp;<img src="img/adm.shop.config.020.gif" width="560" height="126" border="1"><br>&bull; 회사명의 경우 SMS 의 {회사명}에서도 사용합니다. SMS 경우 한글 40글자가 한계이므로 회사명을 너무 길게하지 않는 것이 좋습니다.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.config.030.gif" width="690" height="167" border="1"></p>
<p>&bull; 초기화면(index.php)에 상품을 출력하는 설정값입니다.<br>&bull; 해당 용도에 맞는 스킨을 선택합니다. 아래는 스킨별 설명입니다.<br></p>
<ul>
    <p><b>maintype10.inc.php</b></p>
    <ul>
        <p>가장 기본적인 스킨입니다. 1라인 이미지수 x 라인수 만큼 출력합니다.</p>
    </ul>
    <ul>
        <p><img src="img/adm.shop.config.040.gif" width="591" height="165" border="1"></p>
    </ul>
    <p><b>maintype11.inc.php</b></p>
    <ul>
        <p>가장 기본적인 스킨에 큰이미지 버튼만 추가된 것입니다.</p>
        <p><img src="img/adm.shop.config.050.gif" width="594" height="183" border="1"></p>
    </ul>
    <p><b>maintype12.inc.php</b></p>
    <ul>
        <p>가장 기본적인 스킨에 아이콘과 큰이미지 버튼만 추가된 것입니다.</p>
        <p><img src="img/adm.shop.config.060.gif" width="594" height="261" border="1"></p>
    </ul>
    <p><b>maintype20.inc.php</b></p>
    <ul>
        <p>상품명과 가격을 옆으로 출력합니다. 기본상품설명도 같이 출력합니다.</p>
        <p><img src="img/adm.shop.config.070.gif" width="591" height="134" border="1"></p>
    </ul>
    <p><b>maintype30.inc.php</b></p>
    <ul>
        <p>한줄씩 위로 스크롤 됩니다.</p>
        <p><img src="img/adm.shop.config.080.gif" width="575" height="182" border="1"></p>
    </ul>
    <p><b>maintype31.inc.php</b></p>
    <ul>
        <p>위의 스킨처럼 위로 스크롤 됩니다.&nbsp;1라인 이미지수가 가로로 표시됩니다.</p>
    </ul>
    <ul>
        <p><img src="img/adm.shop.config.090.gif" width="192" height="390" border="1"></p>
    </ul>
    <p><b>maintype40.inc.php</b></p>
    <ul>
        <p>왼쪽으로 스크롤 됩니다.</p>
        <p><img src="img/adm.shop.config.100.gif" width="596" height="170" border="1"></p>
    </ul>
    <p><b>maintype50.inc.php</b></p>
    <ul>
        <p>몇초후 상품이 바뀝니다.</p>
        <p><img src="img/adm.shop.config.120.gif" width="580" height="179" border="1"></p>
    </ul>
</ul>
</a>
<a name='결제정보'></a>
<p>&nbsp;</p>
<p><a href='#결제정보'><b>결제정보</b></a></p>
<p><img src="img/adm.shop.config.130.gif" width="690" height="406" border="1"></p>
<p>
&bull; 무통장입금사용, 계좌이체결제사용, 신용카드결제사용은 주문서 입력에서 결제방식을 선택받기 위해서 하나 이상은 '예'로 설정하셔야 합니다.<br>
&bull; 은행계좌번호는 여러개 입력이 가능하며 한줄에 하나씩 입력합니다. 은행계좌번호가 여러개 있다면 주문서 입력에서 셀렉트박스로 표시합니다.<br>
&bull; 포인트 사용은 환경설정 &gt; 기본환경설정의 값과 동일한것입니다. 이곳에서 값을 변경한다면 마찬가지로 기본환경설정의 포인트 사용도 변경됩니다.<br>
&bull; 포인트 결제사용은 회원이 보유한 포인트가 설정값 이상일 경우에만 결제가 가능합니다. 만약, 여기에 설정한값이 10000 이고 회원이 보유한 포인트가 9000 이라면 포인트로 결제에 사용할 수 없습니다. 포인트 결제사용은 포인트 사용에 '사용'으로 체크가 되어 있어야 결제 방식으로 사용할 수 있습니다.<br>
&bull; 포인트결제 %는 주문금액의 몇% 까지 포인트로 결제할지를 정합니다. 주문금액이 10,000 원이고 포인트결제 %가 50 이라면 주문금액의 50% 즉, 5,000 까지만 포인트로 결제할 수 있습니다.<br>
&bull; 포인트부여는 신용카드나 계좌이체결제시(수수료가 들어가는 결제) 포인트를 부여할지를 설정합니다. '아니오'인 경우 포인트를 부여하지 않습니다.<br>
&bull; 주문완료 포인트를 언제 부여할지를 나타냅니다. 0 으로 설정하면 주문후 바로 부여합니다. 그러나 포인트 부여가 자동으로 부여되는 것이 아니라 쇼핑몰관리 &gt; 주문관리에서 주문서 수정 페이지를 실행하여야 부여됩니다.
<br><br>
&bull; <font color="blue"><b>KCP 결제 적용 방법</b> : KCP와 계약 하시면 메일로 SITE CODE, SITE KEY를 전송받게 됩니다.<br>
    이 SITE CODE, SITE KEY 를 결제정보의 KCP SITE CODE, KCP SITE KEY 에 각각 복사해 넣습니다.<br>
    ftp 사용시 <font color=red>shop/kcp/payplus/bin/pp_cli</font> 를 <font color="red">반드시 바이너리 모드로 업로드 하신 후 퍼미션을 777 로 변경</font>하십시오.<br>
    <font color=red>shop/kcp/payplus/bin 폴더와 shop/kcp/payplus/log 폴더의 퍼미션은 777 로 변경</font>하십시오.
    </font> 
<br><br>
&bull; <font color="green"><b>이니시스 결제 적용 방법</b> : 이니시스와 계약 하시면 메일로 키 파일을 전송받게 됩니다.<br>
    이 키 파일을 압축해제 하시면 mcert.pem, mpriv.pem, keypass.enc, readme.txt 파일이 있는데 이 파일들을 shop/INIpay41_escrow/key/ 폴더 밑에 이니시스에서 부여한 상점아이디로 폴더를 하나 생성하여 그곳에 업로드(복사)해 넣습니다.<br>
    INIpay41_escrow 폴더와 log 폴더의 퍼미션을 707로 변경합니다.<br>
    phpexec 폴더 아래 3개 파일의 퍼미션을 705로 변경합니다.</font> 
<br><br>
&bull; <font color="#8D1D6A"><b>데이콤 결제 적용 방법</b> : https://pgweb.dacom.net/ (e-Credit 상점관리자) 페이지로 로그인하여<br>
    계약정보 > 상점정보관리 > 승인결과전송여부 > 수정 > 웹전송으로 변경 후 확인 > 저장하시기 바랍니다.    
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.config.140.gif" width="690" height="480" border="1"></p>
<p>&bull; 배송비유형은 상한과 없음이 있습니다. 없음을 선택한 경우에는 배송비를 사용하지 않는것입니다. 착불의 경우에 사용하시면 됩니다.<br>&bull; 배송비 상한가와 배송비는 서로 연결되어 사용되는 값입니다. 위의 이미지를 예로 들자면 주문금액이 20000원 미만일 경우에는 배송비 4000원을, 30000원 미만일 경우에는 3000원을, 40000원 미만일 경우에는 2000원을, 40000원 이상일 경우에는 0원을 받겠다는 의미입니다. ; 로 구분하여 더 입력할 수도 있으며 배송비 상한가의 갯수와 배송비의 갯수는 서로 일치하여야 합니다. 물론 한가지 조건만 입력해도 가능합니다. 배송비상한가 40000 , 배송비 3000 으로 말입니다.<br>&bull; 희망배송일을 사용하는 경우는 차례상과 같은 제래음식의 경우에는 반드시 필요한 기능입니다. 또는 직접배송의 경우에도 사용합니다. 희망배송일을 사용하면 주문서 입력시에 오늘+희망배송일날짜 부터 시작하여 날짜가 아래와 같이 셀렉트박스로 표시됩니다.<br>&nbsp;&nbsp;<img src="img/adm.shop.config.150.gif" width="343" height="163" border="1">&nbsp;</p>
<p>&bull; 배송정보는 상품상세보기의 배송정보에 출력하는 내용입니다.<br>&bull; 교환/반품은 상품상세보기의 교환/반품에 출력하는 내용입니다.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.config.160.gif" width="690" height="156" border="1"></p>
<p>&bull; 관련상품출력은 상품상세보기에 나오는 관련상품 이미지를 설정하는것입니다. 아래의 이미지를 참고하세요.<br>&nbsp;&nbsp;<img src="img/adm.shop.config.170.gif" width="690" height="216" border="1"></p>
<p>&bull; 이미지(소) 폭, 높이는 상품리스트에서 보여지는 이미지의 크기를 설정하는 것입니다.<br>&bull; 이미지(중) 폭, 높이는 상품상세보기에서 보여지는 이미지의 크기를 설정하는 것입니다.<br>&bull; 로고이미지는 쇼핑몰 화면의 좌측 상단에 있는 이미지를 말합니다. 플래쉬로 넣을실 경우에는 head.php의 코드를 직접 수정하세요.<br>&bull; 메인이미지는 쇼핑몰 화면의 메인 가운데 있는 이미지를 말합니다. 플래쉬로 넣을실 경우에는 index.php의 코드를 직접 수정하세요.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.config.180.gif" width="690" height="153" border="1"></p>
<p>&bull; 사용후기는 좋지 않은글이 올라오는것에 대비하여 관리자가 승인 후 출력을 해주도록 설정되어 있습니다. 사이트의 용도에 맞게 설정하여 사용하십시오.<br>&bull; 상품구입 권한 : 회원만 상품을 구입하게 하시려면 2 이상으로 설정하시고, 비회원도 구입하게 하시려면 1로 설정하시면 됩니다.<br>&bull; 코드 중복검사 : 분류와 상품을 입력하는 경우 이미 입력된 코드와 중복이 되는 것을 방지하기 위한 설정입니다. 입력이 빨리 진행되어야 한다면 사용에 체크를 하지 마십시오.<br>&bull; 장바구니 메시지 : 비회원가격과 회원가격이 다른 경우 비회원으로 장바구니에 담은 상품은 로그인을 하더라도 비회원가격으로 장바구니에 남아 있게 됩니다. 이런 것을 미연에 방지하고자 이 설정에 체크를 하게되면 가격이 다른 상품을 장바구니에 담을 경우 &quot;비회원가격과 회원가격이 다릅니다&quot;라는 경고 메시지를 출력하게 됩니다. 비회원가격과 회원가격을 다르게 하는 쇼핑몰에서는 반드시 체크하시기 바랍니다.<br>&bull; 프로그램 등록번호 : 서버 IP 또는 도메인, MYSQL USER, DB 명이 바뀌는 경우에는 프로그램을 등록번호가 달라지게 됩니다. 이런 경우에는 저희 회사 홈페이지를 방문하여 새로운 등록번호를 발급 받으셔야 합니다.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><img src="img/adm.shop.config.190.gif" width="690" height="449" border="1"></p>
<p>&bull; SMS 문자전송은 위에서와 같이 회원가입시, 주문서작성시, 입금확인시, 상품배송시에 고객 또는 관리자에게 전송합니다. 사용에 체크를 하게되면 문자를 전송하게 되므로 전송할 내용에만 체크하시면 됩니다.<br>&bull; SMS 는 쏜다넷에서 제공하는 서비스이므로 쏜다넷에 회원가입이 되어 있어야 합니다. SMS를 사용하신다면 쏜다넷 고객아이디는 반드시 입력하셔야 합니다.<br>&bull; 관리자 핸드폰핸드폰번호는 주문서작성시 관리자에게 문자로 전송이 되어야 하므로 반드시 핸드폰번호를 입력하셔야 합니다. 참고로 고객님께 문자를 전송하는 경우에는 발신자 전화번호가 대표전화번호로 전송됩니다.</p>
<p>&nbsp;</p>
</body>

</html>
<?
include_once ("./manual.tail.php");
?>