<?php
/**************************************************************************
	파일명 : safe_hs_cert3.php
	
	생년월일 본인 확인서비스 결과 화면(return url)
**************************************************************************/

include_once("./_common.php");

// 비회원 접속불가
if ($member['mb_id'] == "")
    die;

$g4[title] = "KCB(코리아크레딧뷰로) - okname 본인확인";

include_once("./nc.config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="content-type" content="text/html; charset=<?=$g4['charset']?>">
<html xmlns="http://www.w3.org/1999/xhtml">
<?
/* 공통 리턴 항목 */
$idcfMbrComCd			=	$_POST["idcf_mbr_com_cd"];		  // 고객사코드
$hsCertSvcTxSeqno	=	$_POST["hs_cert_svc_tx_seqno"];	// 거래번호
$rqstSiteNm				=	$_POST["rqst_site_nm"];			    // 접속도메인	
$hsCertRqstCausCd	=	$_POST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

$resultCd				=	$_POST["result_cd"];			// 결과코드
$resultMsg			=	$_POST["result_msg"];			// 결과메세지
$certDtTm				=	$_POST["cert_dt_tm"];			// 인증일시

/**************************************************************************
 * 모듈 호출	; 생년월일 본인 확인서비스 결과 데이터를 복호화한다.
 **************************************************************************/
$encInfo = $_POST["encInfo"];

//KCB서버 공개키
$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
//KCB서버 서명값
$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

// 본인확인 - 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성 됨
if ($kcb_test)
    $keypath = "$kcblog/tsafecert_$idcfMbrComCd.key";
else
    $keypath = "$kcblog/safecert_$idcfMbrComCd.key";

$cpubkey = $WEBPUBKEY;    //server publickey
$csig = $WEBSIGNATURE;    //server signature

// 명령어
$cmd = "$exe $keypath $idcfMbrComCd $EndPointURL $WEBPUBKEY $WEBSIGNATURE $encInfo $logPath $option3";
if ($kcb_test) {
    echo "$cmd<br>";
}

// 실행
exec($cmd, $out, $ret);
if ($kcb_test) {
    echo "ret=$ret<br/>";
}

if($ret == 0) {
		echo "복호화 요청 호출 성공.<br/>";		 
		// 결과라인에서 값을 추출
		foreach($out as $a => $b) {
			if($a < 17) {
				$field[$a] = $b;
			}
		}
		$resultCd = $field[0];
} else {
		echo "복호화 요청 호출 에러. 리턴값 : ".$ret."<br/>";		 
		if($ret <=200)
			$resultCd=sprintf("B%03d", $ret);
		else
			$resultCd=sprintf("S%03d", $ret);
}

// *** 이 두 값을 $_POST 의 값 대신 사용.
$resultCd = $field[0];
$resultMsg = $field[1];
$hsCertSvcTxSeqno = $field[2];

// *** 테스트할때 풀어주세요.
//$kcb_test = 1;
if ($kcb_test) {
    echo "처리결과코드		:$resultCd	<br/>";
    echo "처리결과메시지	:$field[1]	<br/>";
    echo "거래일련번호		:$field[2]	<br/>";
    echo "인증일시			  :$field[3]	<br/>";
    echo "DI				      :$field[4]	<br/>";
    echo "CI				      :$field[5]	<br/>";
    echo "성명				    :$field[7]	<br/>";
    echo "생년월일			  :$field[8]	<br/>";
    echo "성별				    :$field[9]	<br/>";
    echo "내외국인구분		:$field[10]	<br/>";
    echo "통신사코드		  :$field[11]	<br/>";
    echo "휴대폰번호		  :$field[12]	<br/>";
    echo "리턴메시지		  :$field[16]	<br/>";
}
// *** 테스트할 때 풀어주세요.
//print_r($field);die;

// 결과처리 ===
switch ($resultCd) {
    case "B000" : // 정상처리
        $sql = " update $g4[member_table] set mb_name = '$name', mb_realcheck = '$g4[time_ymdhis]', mb_hp = '$field[12]' where mb_id = '$member[mb_id]' ";
        sql_query($sql);

        // 사용자 확장파일
        @include("./realcheck.skin.php");

        break;
    default :     // 정상이 아닌 경우
        ;
        break;
}

// 무조건 로그를 남긴다
$sql = " insert into $g4[realcheck_table] set mb_id = '$member[mb_id]', cb_authtype = '$hsCertRqstCausCd', cb_ip = '$_SERVER[REMOTE_ADDR]', cb_datetime = '$g4[time_ymdhis]', cb_errorcode = '$resultCd' ";
sql_query($sql);
?>
<head>
	<title>KCB 생년월일 본인 확인서비스 샘플</title>
  <script language="javascript" type="text/javascript" >
	function fncOpenerSubmit() {
		opener.document.kcbResultForm.idcf_mbr_com_cd.value = "<?=$idcfMbrComCd?>";
		opener.document.kcbResultForm.hs_cert_svc_tx_seqno.value = "<?=$hsCertSvcTxSeqno?>";
		opener.document.kcbResultForm.idcf_mbr_com_cd.value = "<?=$idcfMbrComCd?>";
		opener.document.kcbResultForm.hs_cert_rqst_caus_cd.value = "<?=$hsCertRqstCausCd?>";
		opener.document.kcbResultForm.result_cd.value = "<?=$resultCd?>";
		opener.document.kcbResultForm.result_msg.value = "<?=$field[1]?>";
		opener.document.kcbResultForm.hs_cert_svc_tx_seqno.value = "<?=$field[2]?>";
		opener.document.kcbResultForm.cert_dt_tm.value = "<?=$field[3]?>";
		opener.document.kcbResultForm.di.value = "<?=$field[4]?>";
		opener.document.kcbResultForm.ci.value = "<?=$field[5]?>";
		opener.document.kcbResultForm.name.value = "<?=$field[7]?>";
		opener.document.kcbResultForm.birthday.value = "<?=$field[8]?>";
		opener.document.kcbResultForm.gender.value = "<?=$field[9]?>";
		opener.document.kcbResultForm.nation.value = "<?=$field[10]?>";
		opener.document.kcbResultForm.tel_com_cd.value = "<?=$field[11]?>";
		opener.document.kcbResultForm.tel_no.value = "<?=$field[12]?>";
		opener.document.kcbResultForm.return_msg.value = "<?=$field[16]?>";
		opener.document.kcbResultForm.action = "safe_hs_cert4.php";
		opener.document.kcbResultForm.submit();
		self.close();
	}	
	</script>
	</head>
	<body onload="javascript:fncOpenerSubmit()">
	</body>
</html>
