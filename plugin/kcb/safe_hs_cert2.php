<?php
/**************************************************************************
 * 파일명 : safe_hs_cert2.php
 *
 * 생년월일 본인 확인서비스 개인 정보 입력 화면
 *    (고객 인증정보 KCB팝업창에서 입력용)
 *
 * ※주의
 * 	실제 운영시에는 
 * 	response.write를 사용하여 화면에 보여지는 데이터를 
 * 	삭제하여 주시기 바랍니다. 방문자에게 사이트데이터가 노출될 수 있습니다.
**************************************************************************/
 
include_once("./_common.php");

// 비회원 접속불가
if ($member['mb_id'] == "")
    die;

$g4[title] = "KCB(코리아크레딧뷰로) - okname 본인확인";

include_once("./nc.config.php");

// 모듈호출명령어
$cmd = "$exe $svcTxSeqno \"$name\" $birthday $gender $ntvFrnrTpCd $mblTelCmmCd $mbphnNo $rsv1 $rsv2 $rsv3 \"$returnMsg\" $returnUrl $inTpBit $hsCertMsrCd $hsCertRqstCausCd $memid $qryIP $qryDomain $EndPointURL $logPath $option2 ";

if ($kcb_test) {
    echo $cmd."<br>";
    //exit;
}

//cmd 실행
exec($cmd, $out, $ret);

if ($kcb_test)
    echo "ret=".$ret."<br>";

/**************************************************************************
 okname 응답 정보
**************************************************************************/
$retcode = "";			// 결과코드
$retmsg = "";				// 결과메시지
$e_rqstData = "";		// 암호화된요청데이터
	
if ($ret == 0) {//성공일 경우 변수를 결과에서 얻음
		$retcode = $out[0];
		$retmsg  = $out[1];
		$e_rqstData = $out[2];
} else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
}
	
/**************************************************************************
 * safe_hs_cert3.php 실행 정보
 **************************************************************************/
$targetId = "";				// 타겟ID (팝업오픈 스크립트의 window.name 과 동일하게 설정

// ########################################################################
// # 운영전환시 변경 필요
// ########################################################################
if ($kcb_test)
    $commonSvlUrl = "https://tsafe.ok-name.co.kr:2443/CommonSvl";	// 테스트 URL
else
    $commonSvlUrl = "https://safe.ok-name.co.kr/CommonSvl";	      // 운영 URL
?>
<html>
	<head>
	<title>KCB 생년월일 본인 확인서비스 샘플</title>
	<script>
		function request(){
		window.name = "<?=$targetId?>";

		document.form1.action = "<?=$commonSvlUrl?>";
		document.form1.method = "post";

		document.form1.submit();
	}
	</script>
	</head>

 <body>
	<form name="form1">
	<!-- 인증 요청 정보 -->
	<!--// 필수 항목 -->
	<input type="hidden" name="tc" value="kcb.oknm.online.safehscert.popup.cmd.P901_CertChoiceCmd">				<!-- 변경불가-->
	<input type="hidden" name="rqst_data"				value="<?=$e_rqstData?>">		<!-- 요청데이터 -->
	<input type="hidden" name="target_id"				value="<?=$targetId?>">			<!-- 타겟ID --> 
	<!-- 필수 항목 //-->	
	</form>
  <form name="kcbResultForm" method="post" >
        <input type="hidden" name="idcf_mbr_com_cd" 		value="" 	/>
        <input type="hidden" name="hs_cert_svc_tx_seqno" 	value=""	/>
        <input type="hidden" name="hs_cert_msr_cd" 			value="" 	/>
        <input type="hidden" name="hs_cert_rqst_caus_cd" 	value="" 	/>
        <input type="hidden" name="result_cd" 				value="" 	/>
        <input type="hidden" name="result_msg" 				value="" 	/>
  </form>  
<?php
 	if ($retcode == "B000") {
		//인증요청
		echo ("<script>request();</script>");
	} else {
		//요청 실패 페이지로 리턴
		echo ("<script>alert(\"$retcode\"); self.close();</script>");
	}
?>
 </body>
</html>
