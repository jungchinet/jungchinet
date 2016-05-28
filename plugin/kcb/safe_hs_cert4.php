<?php
include_once("./_common.php");

$g4[title] = "KCB(코리아크레딧뷰로) - okname 본인인증";
include_once("./_head.php");
include_once("./nc.config.php");

//	생년월일 본인 확인서비스 결과 화면
/* 공통 리턴 항목 */
$idcfMbrComCd		  = $_POST["idcf_mbr_com_cd"];		  // 고객사코드
$hsCertSvcTxSeqno	= $_POST["hs_cert_svc_tx_seqno"];	// 거래번호
$hsCertRqstCausCd	= $_POST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타);// 

$resultCd			    = $_POST["result_cd"];				    // 결과코드
$resultMsg			  = $_POST["result_msg"];				    // 결과메세지
$certDtTm			    = $_POST["cert_dt_tm"];				    // 인증일시
$di					      = $_POST["di"];						        // DI
$ci					      = $_POST["ci"];						        // CI
$name				      = $_POST["name"];					        // 성명
$birthday			    = $_POST["birthday"];				      // 생년월일
$gender				    = $_POST["gender"];					      //성별
$nation				    = $_POST["nation"];					      //내외국인구분
$telComCd			    = $_POST["tel_com_cd"];			      //통신사코드
$telNo				    = $_POST["tel_no"];					      //휴대폰번호
$returnMsg			  = $_POST["return_msg"];			      //리턴메시지
?>

<link rel="stylesheet" href="<?=$g4['path']?>/plugin/kcb/css/style.css" type="text/css">

<? if ($resultCd == "B000") { ?>
<div class="kcb-summary">
	<h2>KCB 본인확인 시스템</h2>
	<div class="content">
		<ul>
			<li>다음과 같이 본인확인 되었습니다.</li>
			<li>관련 법률에 따라 다른 사람의 개인정보를 도용하여 인터넷 서비스에 가입하는 경우는 명백한 범죄행위로
		    <noth class="color_red">3년 이하의 징역또는 1천만원 이하의 벌금</noth>에 처해질 수 있습니다.</li>
		</ul>
	</div>
</div>

<fieldset><label>성명</label><?=$name?></fieldset>

<table>
<tr><td width=120px>이름</td><td width=200px><?=$name?></td></tr>
<tr><td width=120px>휴대폰번호</td><td width=200px><?=$telNo?></td></tr>
</table>

<? } else {?>
<div class="kcb-summary">
	<h2>KCB 본인확인 시스템</h2>
	<div class="content">
		<ul>
			<li>본인확인 오류 입니다.</li>
			<li>다시 본인확인을 받으시려면, <a href="./index.php"><b>이곳</b></a> 을 클릭해주세요.</li>
			<li>관련 법률에 따라 다른 사람의 개인정보를 도용하여 인터넷 서비스에 가입하는 경우는 명백한 범죄행위로
		    <noth class="color_red">3년 이하의 징역또는 1천만원 이하의 벌금</noth>에 처해질 수 있습니다.</li>
		</ul>
	</div>
</div>

<table>
<tr><td width=120px>이름</td><td width=200px><?=$name?></td></tr>
<tr><td width=120px>휴대폰번호</td><td width=200px><?=$telNo?></td></tr>
<tr><td width=120px>결과코드</td><td width=200px><?=$resultCd?></td></tr>
<tr><td width=120px>결과메세지</td><td width=200px><?=$resultMsg?></td></tr>
</table>

<? } ?>

  <div id="content">
    <div class="post">
        <div class="postheader">
            <span class="date"><strong>본인확인</strong>KCB<small>Ok Name</small></span>
            <h2><a href="http://okname.allcredit.co.kr" target="new" alt="OK Name">당 사이트의 본인확인은 KCB (코리아크레딧뷰로,OK Name) 의 본인확인 서비스로 이루어 집니다.</a></h2>
            <a href="#" class="comments">중요</a>
            <p><span>OK Name 서비스문의 KCB(T.02-708-1000) <a href="http://www.buspang.kr" target=new>ⓒ buspang.kr</a></span>
			<a href="http://okname.allcredit.co.kr">기입된 정보로 개인정보가 변경될 수 있습니다.</a></p>
        </div>
    </div>

<!--  // 개발과정에서만 Open해서 보세요.
<h3>인증결과</h3>
<ul>
  <li>고객사코드	: <?=$idcfMbrComCd?> </li>
  <li>인증사유코드	: <?=$hsCertRqstCausCd?></li>
  <li>결과코드		: <?=$resultCd?></li>
  <li>결과메세지	: <?=$resultMsg?></li>
  <li>거래번호		: <?=$hsCertSvcTxSeqno?> </li>
  <li>인증일시		: <?=$certDtTm?> </li>
  <li>DI			: <?=$di?> </li>
  <li>CI			: <?=$ci?> </li>
  <li>성명			: <?=$name?> </li>
  <li>생년월일		: <?=$birthday?> </li>
  <li>성별			: <?=$gender?> </li>
  <li>내외국인구분	: <?=$nation?> </li>
  <li>통신사코드	: <?=$telComCd?> </li>
  <li>휴대폰번호	: <?=$telNo?> </li>
</ul>
-->

<?
include_once("./_tail.php"); 
?>
