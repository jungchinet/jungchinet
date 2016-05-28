<? 
include_once("./_common.php");

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g4[title] = "KCB(코리아크레딧뷰로) - okname 본인확인";
include_once("./_head.php");
include_once("./nc.config.php");
?>

<link rel="stylesheet" href="<?=$g4['path']?>/plugin/kcb/css/style.css" type="text/css">
<div class="kcb-summary">
	<h2>KCB 본인확인 시스템</h2>
	<div class="content">
		<ul>
			<li>당 사이트는  회원 여러분의 개인정보 보호를 위해 최선을 다하고 있습니다.</li>
			<li>당 사이트에서는 원활한 서비스 이용과 익명사용자로 인한 명예회손 등의 피해를 방지하기 위하여 <noth class="color_red">회원 가입 실명제</noth>를 원칙으로 하고 있습니다.</li>
			<li>관련 법률에 따라 다른 사람의 개인정보를 도용하여 인터넷 서비스에 가입하는 경우는 명백한 범죄행위로
		    <noth class="color_red">3년 이하의 징역또는 1천만원 이하의 벌금</noth>에 처해질 수 있습니다.</li>
		</ul>
	</div>
</div>

          <? if ($member['mb_id'] == "") { ?>
			  회원대상 서비스 입니다.
		      <? } else {
          // 실명인증
          if ($okname_name) {

              if ($member[mb_namecheck] !== "0000-00-00 00:00:00") { ?>
              <?=$member[mb_namecheck]?> 에 실명확인을 받으셨습니다.
              <? } else { ?>

			      <form name="form1" method="post" onsubmit="return jsSubmit();" enctype="multipart/form-data">
							<fieldset>
	                    	<label>성명: </label>
							<input type="text" name="name" maxlength="20" size="20" value="" hangul required class="effect">
	                        </fieldset>
							<fieldset>
	                    	<label>생년월일: </label>
							<input type="text" name="birthday" maxlength="8" size="10" value="" numeric required class="effect"><label> (예:'19700101') </label>
	                        </fieldset>

							<p>
	                    	<label>성별: </label>
							<input type="radio" name="gender" value="1" checked>남
							<input type="radio" name="gender" value="0">여
	                        </p>
							<p>
            		  		<label>구분: </label>
							<input type="radio" name="nation" value="1" checked>내국인
            				<input type="radio" name="nation" value="2">외국인
						    </p>
							<div id="button"><a href="javascript:jsSubmit();" id="btn_submit" class="cssSubmitButton" rel="subscribeForm">실명확인</a></div>
                 </form>
				     <? } ?>
                <? } ?>

          <?
          $chk = 0;
          if ($okname_name) {
              if ($member[mb_namecheck] !== "0000-00-00 00:00:00") {
                  $chk = 1;
              }
          } else {
              $chk = 1;
          }
          ?>
          <? if ($okname_me && $chk ) { ?>
         		     <? if ($member[mb_realcheck] !== "0000-00-00 00:00:00") { ?>
              		 <?=$member[mb_realcheck]?> 에 본인인증을 받으셨습니다.
      	        	 <? } else { ?>
    		    	 본인인증을 받으시려면 <a href="javascript:popup_real();">이곳</a>을 클릭해주세요.
            		 <? } ?>
                 <? } ?>
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

<form name="kcbResultForm" method="post" >
    <input type="hidden" name="idcf_mbr_com_cd" 		  value="" 	/>    <!-- 고객사 코드 -->
    <input type="hidden" name="hs_cert_rqst_caus_cd" 	value="" 	/>    <!-- 인증사유코드2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타);//  -->
    <input type="hidden" name="hs_cert_svc_tx_seqno" 	value=""	/>    <!-- 거래번호 -->
    <input type="hidden" name="result_cd" 				    value="" 	/>    <!-- 결과코드 -->
    <input type="hidden" name="result_msg" 				    value="" 	/>    <!-- 결과메세지 -->
    <input type="hidden" name="cert_dt_tm" 			      value="" 	/>    <!-- 인증일시 -->
    <input type="hidden" name="cert_dt_tm" 			      value="" 	/>    <!-- 인증일시 -->
    <input type="hidden" name="di" 			              value="" 	/>    <!-- DI -->
    <input type="hidden" name="ci"         			      value="" 	/>    <!-- CI -->
    <input type="hidden" name="name"       			      value="" 	/>    <!-- 이름 -->
    <input type="hidden" name="birthday"   			      value="" 	/>    <!-- 생년월일 -->
    <input type="hidden" name="gender"     			      value="" 	/>    <!-- 이름 -->
    <input type="hidden" name="nation"   			        value="" 	/>    <!-- 생년월일 -->
    <input type="hidden" name="tel_com_cd"       			value="" 	/>    <!-- 이름 -->
    <input type="hidden" name="tel_no"   			        value="" 	/>    <!-- 생년월일 -->
    <input type="hidden" name="return_msg"       			value="" 	/>    <!-- 이름 -->
</form> 

<script type="text/javascript">
<!--
	function jsSubmit(){	
		var form1 = document.form1;
		var isChecked = false;
		var inTpBit = "";

			if (form1.name.value == "") {
				alert("성명을 입력해주세요");
				return;
			}

			if (form1.birthday.value == "") {
				alert("생년월일을 입력해주세요");
				return;
			}

		document.form1.action = "okbirthday.php";
		document.form1.submit();
	}
//-->
</SCRIPT>

<?
include_once("./_tail.php"); 
?>
