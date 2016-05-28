<?
include_once("./_common.php");

if(!$is_admin){
	echo "<script>alert('관리자만 접근 가능합니다.');window.close();</script>";	
}

mysql_query('set names utf-8');
$sql="select * from prem_payment where mb_id='$id' and order_idxx like '%_{$brd}_%' and order_idxx like '%_{$uid}_%' order by no desc";
$rst=mysql_query($sql);
$d=mysql_fetch_array($rst);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
body,tr,td {font-size:8pt;}
#sample_wrap {width:100%;text-align:center;}
#sample {margin:0 auto;text-align:left;}
</style>
<link href="../payment/p/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
<script>
	/* 신용카드 영수증 */ 
	/* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */ 
	/* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */ 
	function receiptView( tno ) 
	{ 
		receiptWin = "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" + tno; 
		window.open(receiptWin, "", "width=455, height=815"); 
	}
	/* 현금 영수증 */ 
	/* 실결제시 : "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */ 
	/* 테스트시 : "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */   
	function receiptView2( site_cd, order_id, bill_yn, auth_no ) 
	{ 
		receiptWin2 = "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp"; 
		receiptWin2 += "?"; 
		receiptWin2 += "term_id=PGNW" + site_cd + "&"; 
		receiptWin2 += "orderid=" + order_id + "&"; 
		receiptWin2 += "bill_yn=" + bill_yn + "&"; 
		receiptWin2 += "authno=" + auth_no ; 
	 
		window.open(receiptWin2, "", "width=370, height=625"); 
	}
</script>
</head>
<body>
    <div id="sample_wrap">
        <h1>프리미엄 리스트 결제 결과<span></span></h1>
    <div class="sample"><br>
                    <h2>&sdot; 주문 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 주문번호 -->
                        <tr>
                          <th>주문 번호</th>
                          <td><?=$d[order_idxx]?></td>
                        </tr>
                        <!-- KCP 거래번호 -->
                        <tr>
                          <th>KCP 거래번호</th>
                          <td><?=$d[tno]?></td>
                        </tr>
                        <!-- 결제금액 -->
                        <tr>
                          <th>결제 금액</th>
                          <td><?=$d[amount]?>원</td>
                        </tr>
                        <!-- 상품명(good_name) -->
                        <tr>
                          <th>상 품 명</th>
                          <td><?=($d[good_name])?></td>
                        </tr>
                        <!-- 주문자명 -->
                        <tr>
                          <th>주문자명</th>
                          <td><?=$d[mb_name]?></td>
                        </tr>
                        <!-- 주문자 휴대폰번호 -->
                        <tr>
                          <th>주문자 휴대폰번호</th>
                          <td><?=$d[mb_tel]?></td>
                        </tr>
                        <!-- 주문자 E-mail -->
                        <tr>
                          <th>주문자 E-mail</th>
                          <td><?=$d[mb_email]?></td>
                        </tr>
                        <!-- 주문자 ID -->
                        <tr>
                          <th>주문자 ID</th>
                          <td><?=$d[mb_id]?></td>
                        </tr>
                    </table>
                    
<? if($d[ordr_type]=='1') {  ?>            
                    
      <h2>&sdot; 신용카드 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 결제수단 : 신용카드 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>신용 카드</td>
                        </tr>
                        <!-- 결제 카드 -->
                        <tr>
                          <th>결제 카드</th>
                          <td><?=$d[card_cd]?> / <?=$d[card_name]?></td>
                        </tr>
                        <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$d[app_time]?></td>
                        </tr>
                        <!-- 승인번호 -->
                        <tr>
                          <th>승인 번호</th>
                          <td><?=$d[app_no]?></td>
                        </tr>
                        <!-- 할부개월 -->
                        <tr>
                          <th>할부 개월</th>
                          <td><?=$d[quota]?></td>
                        </tr>
                        <!-- 무이자 여부 -->
                        <tr>
                          <th>무이자 여부</th>
                          <td><?=$d[noinf]?></td>
                        </tr>
                        <tr>
                            <th>영수증 확인</th>
                            <td class="sub_content1"><a href="javascript:receiptView('<?=$d[tno]?>')"><img src="../payment/p/img/btn_receipt.png" alt="영수증을 확인합니다." /></td>
                        </tr>
                    </table>
                        
<? }else if($d[ordr_type]=='2'){ ?>               
                
                
                    <h2>&sdot; 계좌이체 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 계좌이체 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>계좌이체</td>
                        </tr>
                    <!-- 이체 은행 -->
                        <tr>
                          <th>이체 은행</th>
                          <td><?=$d[bank_name]?></td>
                        </tr>
                    <!-- 이체 은행 코드 -->
                        <tr>
                          <th>이체 은행코드</th>
                          <td><?=$d[bank_code]?></td>
                        </tr>
                    <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$d[app_time]?></td>
                        </tr>
                    </table>
                    
<? }else if($d[ordr_type]=='3'){ ?>
                    
                    <h2>&sdot; 가상계좌 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 가상계좌 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>가상계좌</td>
                        </tr>
                    <!-- 입금은행 -->
                        <tr>
                          <th>입금 은행</th>
                          <td><?=$bankname?></td>
                        </tr>
                    <!-- 입금계좌 예금주 -->
                        <tr>
                          <th>입금할 계좌 예금주</th>
                          <td><?=$depositor?></td>
                        </tr>
                    <!-- 입금계좌 번호 -->
                        <tr>
                          <th>입금할 계좌 번호</th>
                          <td><?=$account?></td>
                        </tr>
					<!-- 가상계좌 입금마감시간 -->
                        <tr>
                          <th>가상계좌 입금마감시간</th>
                          <td><?=$va_date?></td>
                        </tr>
					<!-- 가상계좌 모의입금(테스트시) -->
                        <tr>
                          <th>가상계좌 모의입금</br>(테스트시 사용)</th>
                          <td class="sub_content1"><a href="javascript:receiptView3()"><img src="./img/btn_vcn.png" alt="모의입금 페이지로 이동합니다." />
                        </tr>
                    </table>
                    
<? } ?>

                <div class="btnset">
                <a href="javascript:window.close();" class="home">창닫기</a>
                </div>
                
            </div>
        <div class="footer">
                Copyright (c) 정치.net All Rights reserved.               
        </div>
        <p></p>
    </div>