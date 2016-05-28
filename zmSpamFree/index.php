<?php
error_reporting(E_ALL);
DEFINE ( 'AR' , dirname(__FILE__).'/' );
DEFINE ( 'AR1' , dirname(__FILE__).'/../data/' );
if ( !is_dir(AR1.'Log') ) { mkdir ( AR1.'Log', 0755 ); chmod( AR1.'Log', 0755); }
if ( !is_dir(AR1.'Log/Connect') ) { mkdir ( AR1.'Log/Connect', 0755 ); chmod( AR1.'Log/Connect', 0755); }
$noticeText = '<div id="rslt" class="r">ⓒ스팸방지코드를 입력하시면 결과를 표시합니다.</div>';
if ( isset($_POST['zsfCode']) )
{
	$zsfCode = stripslashes(trim($_POST['zsfCode']));
	$noticeText = 'ⓒ스팸방지코드 입력값이 ';
	include 'zmSpamFree.php';
	/*
		zsfCheck 함수는 두 개의 인수를 사용할 수 있다.
		$_POST['zsfCode'] : 사용자가 입력한 스팸방지코드 값
		'DemoPage' : 관리자가 로그파일에 남겨놓고 싶은 메모, 예를 들어 bulletin 게시판의 comment 쓰기시 스팸방지코드를 입력했다 한다면
						'bulletin|comment'라고 써 놓으면, 어떤 게시판의 어떤 상황에서 스팸차단코드가 맞거나 틀렸는지 알 수 있을 것이다.
						이외에 '제목의 일부'나 '글 내용의 일부'를 같이 넣으면, 어떤 스팸광고글이 차단되었는지도 확인할 수 있다.
						참고로 이 인수는 생략 가능하다.
	*/
	$r = zsfCheck ( $_POST['zsfCode'],'DemoPage' );	# $_POST['zsfCode']는 입력된 스팸방지코드 값이고, 'DemoPage'는 기타 기록하고픈
	$noticeText .= $r ? '맞았습니다.' : '틀렸습니다.';
	$noticeText .= '(값: \''.$zsfCode.'\')';
	$noticeText = '<div id="rslt" class="r'.($r*1).'">'.$noticeText.'</div>';
}
$listNo=1;	# 목록 번호
$solveNo=1;	# 문제해결 번호
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
	<title> ZmSpamFree 1.1 Demo - http://www.casternet.com/spamfree/</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="ZnMee,지앤미" />
	<meta name="keywords" content="http://www.casternet.com,http://www.spamfree.kr,CAPTCHA" />
	<meta name="description" content="Automatic test program to tell computers and humans apart. Programmed by ZnMee in Republic of Korea." />
	<style type="text/css">
	* { margin: 0; padding: 0; line-height: 1; }
	body { font-size: 12px; margin: 10px; background-color: #993300; color: #333; }
	a { text-decoration: none; }
	a:link { color: #754C23; }
	a:visited { color: #C69C6D; }
	span.lnk { color: #754C23; cursor: pointer; }
	a:hover, a:active { color: #754C23; text-decoration: underline; }
	#wrap { width: 450px; padding: 10px; background-color: #e4d5b8; border: solid 2px #5e2000; border-left: none; border-top: none; }
	.b1 { border: solid 2px #c1ac81; border-left: none; border-top: none; }
	.b2 { border: solid 2px #f3fffd; background-color: #e6d6b2; padding: 5px; }
	.tt { background-color: #d85f06; padding: 10px; border: solid 1px #930; border-right: none; border-bottom: none; }
	h1 { font-size: 18px; color: #00c; margin-bottom: 10px; font-family: Palatino Linotype; font-style: italic; }
	#wrap h1 a { color: #fff; text-decoration: none; border-bottom: solid 2px #e39819; }
	h2 { text-align: right; font-size: 11px; margin-bottom: 3px; font-weight: normal; color: #811c10; }
	.b1 p { text-align: right; line-height: 1.6; font-family: Arial; font-weight: bold; }
	.b1 p a { color: #e4d5b8; text-decoration: underline; }
	#wrap p { line-height: 1.6; }
	.tb { width: 100%; border-top: solid 2px #c99; border-collapse: collapse; background-color: #F4EEE3; margin: 5px 0; }
	.tb td { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #E1DBCB; padding: 5px; line-height: 1;}
	.tb td.l { font-size: 13px; font-weight: bold; color: #B57D3D; background-color: #EFE6D4; }
	.tb td p.txt { line-height: 1.6; }
	h3 { font-size: 15px; color: #633; margin: 20px 0 5px 0; border-bottom: solid 1px #C7B297; padding-bottom: 3px; }
	#zsfCode { width: 80px; border: solid 1px #B57D3D; padding: 2px 1px; }
	#rslt { border-style: solid; border-width: 1px; padding: 8px; font-weight: bold; }
	#rslt.r { border-color: #999; background-color: #eee; color: #666; }
	#rslt.r1 { border-color: #696; background-color: #efe; color: #090; }
	#rslt.r0 { border-color: #966; background-color: #fee; color: #c00; }
	ol.txt { margin-left: 30px; }
	ol.txt li { margin-bottom: 5px; }
	ol.txt li p { background-color: #F4EEE3; padding: 3px; margin-top: 3px; text-align: left; border: solid 1px #999; border-right-color: #f3f3f3; border-bottom-color: #f3f3f3;}
	p.b, td.b, p.able1, p.able0 { font-weight: bold; }
	p.able1 { color: #090; }
	p.able0 { color: #c00; }
	p.err { margin-left: 20px; }
	#foot { margin: 30px 0; text-align: center; }
	#copy { margin-top: 5px; width: 450px; text-align: center; font: italic bold 14px/1.2 "Palatino Linotype"; margin-bottom: 100px; }
	#copy a { color: #C69C6D; }
	</style>
	<script type="text/javascript">
	//<![CDATA[
	// Window Open
	function n(t) {
		window.open(t.href);
		return false;
	}
	// AJAX Start
	function getHTTPObject () {
		var xhr = false;
		if ( window.XMLHttpRequest ) { xhr = new XMLHttpRequest (); }
		else if ( window.ActiveXObject ) {
			try { xhr = new ActiveXObject ( "Msxml2.XMLHTTP" ); }
			catch ( e ) {
				try { xhr = new ActiveXObject ( "Microsoft.XMLHTTP" ); }
				catch ( e ) { xhr = false; }
			}
		}
		return xhr;
	}
	function grabFile ( file, func ) {
		var req = getHTTPObject ();
		if ( req ) {
			req.onreadystatechange = function () { eval(func+"(req)"); };
			req.open ( "GET", file, true );
			req.send(null);
		}
	}
	function axOk ( req ) {	if ( req.readyState==4 && (req.status==200 || req.status==304) ) { return true; } else { return false; } }
	// AJAX End
	function chkZsf ( zsfObj ) {
		zsfV=zsfObj.value;
		if ( zsfV.length>0 ) {
			grabFile ( "zmSpamFree.php?zsfCode="+zsfV, 'rsltZsf' );
		}
		else {
			document.getElementById("rslt").innerHTML = 'ⓒ스팸방지코드를 입력하시면 결과를 표시합니다.';
			document.getElementById("rslt").className = "r";
			document.getElementById('zsfCode').focus();
		}
	}
	function rsltZsf ( req ) {
		if ( axOk(req) ) {
			zsfV = document.getElementById('zsfCode').value;
			rsltTxt = "틀렸";
			rsltCls = "0";
			if ( req.responseText*1 == true ) {
				rsltTxt = "맞았";
				rsltCls = "1";
			}
			else {
				document.getElementById('zsfCode').value='';
				document.getElementById('zsfImg').src='zmSpamFree.php?re&zsfimg='+new Date().getTime();
			}
			document.getElementById("rslt").innerHTML = "ⓒ스팸방지코드 입력값이 "+rsltTxt+"습니다.(값: '"+zsfV+"')";
			document.getElementById("rslt").className = "r"+rsltCls;
			document.getElementById('zsfCode').focus();
		}
	}
	//]]>
	</script>
</head>
<body onload="document.getElementById('zsfCode').focus();">
<div id="wrap">
<div class="b1"><div class="b2"><div class="tt">
<h1><a href="./" title="스팸방지 지엠스팸프리 ZmSpamFree">ZmSpamFree 1.1 Demo</a></h1>
<h2>스팸방지 CAPTCHA 오픈소스 PHP 웹프로그램</h2>
<p><cite><a href="http://www.casternet.com/spamfree/" onclick="return n(this);" title="스팸프리닷케이알">SpamFree.kr</a></cite></p>
</div></div></div>

<h3><?php echo $listNo++,'. '; ?>사용 예</h3>
<p>아래 <strong>ⓒ스팸방지코드</strong> 입력란에 답을 맞게, 틀리게 입력해 보면서 테스트해 보세요.</p>
<table class="tb">
<colgroup>
<col width="26%" />
<col width="74%" />
</colgroup>
<tr>
	<td class="l">ⓐ이미지</td><td><p><img id="zsfImg" src="zmSpamFree.php?zsfimg" alt="여기를 클릭해 주세요." title="SpamFree.kr" style="border: none; cursor: pointer" onclick="this.src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime()" /></p><p>위 이미지를 클릭하시면 다른 문제로 바뀝니다.</p></td>
</tr>
<tr>
	<td class="l">ⓑ안내문</td><td><p class="txt">위 4자리 숫자를 그대로 아래에 입력해 주세요.<br />(스팸광고 방지를 위함)</p></td>
</tr>
<tr>
	<td class="l">ⓒ스팸방지코드</td><td><form method="post" action="./" onsubmit="var zsfCode=document.getElementById('zsfCode'); if(zsfCode.value==''){alert('스팸방지코드를 입력해 주세요.\r\n(스팸광고 방지를 위함)'); zsfCode.focus(); return false;}"><p><input name="zsfCode" id="zsfCode" type="text"<?php # onblur="chkZsf(this);" ?> /> <input type="submit" value="OK" /></p></form></td>
</tr>
<tr>
	<td class="l">ⓓ실시간 검사</td><td><p class="txt"><span onclick="chkZsf(document.getElementById('zsfCode'));" title="Ajax로 실시간 체크" class="lnk">[실시간 검사]</span>를 클릭하시면 Ajax를 이용, 페이지 이동 없이 검사합니다.</p></td>
</tr>
<tr>
	<td class="l">ⓔ새로고침 버튼</td><td><p class="txt">위 <strong>ⓐ이미지</strong>(문제)가 보이지 않거나 다른 문제를 보시려면<br /><span onclick="document.getElementById('zsfImg').src='zmSpamFree.php?re&amp;zsfimg='+new Date().getTime();" title="다른 숫자 보기" class="lnk">[새로고침]</span>을 클릭해 주세요.</p></td>
</tr>
<tr>
	<td class="l">ⓕ새창 버튼</td><td><p class="txt">위 <strong>ⓐ이미지</strong>(문제)가 계속 보이지 않으면<br /><a href="zmSpamFree.php?zsfimg" onclick="window.open(this.href); return false;" title="보안코드를 새 창으로 보기">[새창]</a>을 클릭하여 에러메시지를 확인해 주세요.</p></td>
</tr>
<tr>
	<td class="l">ⓖ검증결과</td><td><?php echo $noticeText; ?></td>
</tr>
</table>

<h3><?php echo $listNo++,'. '; ?>PHP 버전 체크 (PHP 4.3 이상)</h3>

<?php
	$_phpver = phpversion();
	$verMsg = array ( '불가', '가능' );
	$verRslt = false;
	if ( version_compare ( $_phpver, '4.3', '>=' ) ) { $verRslt = true; }
	echo '<p class="able',$verRslt*1,'">';
	echo '이 서버의 PHP 버전은 ',$_phpver,'으로, 사용 ',$verMsg[$verRslt],'합니다.</p>';
?>
<h3><?php echo $listNo++,'. '; ?>프로그램 적용 가능 여부 (사용함수 지원 체크)</h3>
<?php
$funcArr = array ( 'imageCreateTrueColor', 'imageColorAllocate', 'imagefill', 'imageSetPixel', 'imageCopyResampled', 'imageFilledRectangle', 'imageRectangle' );
$errCnt = 0;
foreach ( $funcArr as $k => $v )
{ if ( !function_exists($v) ) { $errCnt ++; echo '<p class="err">',$errCnt,') <strong>',$v,'</strong> 함수 사용 불가</p>'; } }
if ( !function_exists('imagepng') && !function_exists('imagegif') && !function_exists('imagejpeg') ) { $errCnt ++; echo '<p class="err">',$errCnt,') <strong>imagePng, imageGif, imageJpeg</strong> 함수 모두 사용 불가</p>'; }
if ( !$errCnt ) { echo '<p class="able1">검사 결과, 적용 가능합니다.</p>'; }
else { echo '<p class="able0">검사 결과, 위 ',$errCnt,'개의  함수가 지원되지 않아, 적용이 불가능합니다.<br />서버(웹호스팅) 관리자에게 문의해 주세요.</p>'; }
?>
<h3><?php echo $listNo++,'. '; ?>프로그램 정상 설치여부 검사</h3>
<?php
$chkFontName = array ( 'MalgunGothic40px', 'Gungsuh40px', 'Gulim40px', 'Impact40px', 'PyunjiR40px', 'YDISomaL40px', 'TimesNewRoman40px', 'Arial40px', 'Tahoma24px', 'TimesNewRoman26px', 'Arial26px', 'YDISomaL26px', 'PyunjiR24px', 'Impact27px', 'Gulim26px', 'Gungsuh27px', 'MalgunGothic24px' );
$errCnt = 0;
foreach ( $chkFontName as $v )
{
	if ( !is_file(AR.'Fonts/'.$v.'.php') ) { $errCnt ++; echo '<p class="err">',$errCnt,') <strong>',$v,'.php 파일이 없습니다.</strong></p>'; }
}
if ( !$errCnt ) { echo '<p class="able1">검사 결과, 모든 글꼴파일이 있습니다.</p>'; }
else { echo '<p class="able0">검사 결과, ',$errCnt,'개의 글꼴 파일이 없습니다.<br />하지만 환경설정에 따라 사용이 가능할 수도 있습니다.'; }
?>
<h3><?php echo $listNo++,'. '; ?>문제 해결</h3>
<ol class="txt">
	<li>지금 이 페이지에서 <strong>Permission denied</strong>라는 에러가 떠요.
		<p>현재 이 파일이 있는 <strong>디렉토리</strong>(zmSpamFree)의 <strong>퍼미션</strong>을 <strong>777</strong>로 변경해 보세요.<br />또는 새로 생성된 Log 디렉토리의 <strong>퍼미션</strong>을 <strong>777</strong>로 변경해 보세요.<br />퍼미션 변경 후에는 스팸방지이미지를 한 번 클릭하셔서 새로고침을 해야 합니다.</p></li>
	<li>위의 <strong>ⓓ[새로고침]</strong>을 클릭해도 이미지가 나오지 않아요.
		<p><strong>ⓔ[새창]</strong>을 클릭하시면 나오는 에러메시지를 참고하세요. <a href="http://www.casternet.com/spamfree/zmb/view.php?bd=manual&amp;no=6" onclick="return n(this);" title="새창을 클릭하면 나오는 에러메시지 종류">[관련자료 보기]</a></p></li>
	<li><strong>ⓔ[새창]</strong>을 클릭하면 이미지도, 에러메시지도 나오지 않아요.
		<p>이제껏 찾아낸 문제는 해당 서버의 특성문제로, 자세한 것은 <a href="http://www.casternet.com/spamfree/zmb/view.php?bd=faq&amp;no=2" onclick="return n(this);" title="이미지도 에러도 나오지 않는 경우">[관련자료 보기]</a>를 참고하세요.</p></li>
	<li>다른 건 문제가 없는데, 무조건 스팸방지코드가 틀렸다고 나와요.
	<li>AJAX를 이용하여 스팸방지코드 실시간 검사는 어떻게 구현하나요?
		<p><a href="http://www.casternet.com/spamfree/zmb/view.php?bd=manual&amp;no=8" title="AJAX를 이용한 스팸방지코드 실시간 검사 구현예제" onclick="return n(this);">[스팸방지코드 실시간 검사 구현예제]</a>를 참고하시면 쉽게 구현할 수 있습니다.</p></li>
	<li>이 프로그램을 완전히 지우고 싶은데 어떻게 하죠?
		<p><a href="uninstall.php" title="지엠스팸프리(ZmSpamFree) 프로그램 제거하기" onclick="return n(this)">[프로그램 제거하기]</a>를 클릭하고, 안내에 따라 uninstall.php 파일을 수정 및 실행하여 자동등록파일들을 지운 후, 나머지 남아있는 파일 및 디렉토리를 FTP 등을 이용, 삭제하시면 됩니다.</p></li>
		<p>이제껏 찾아낸 문제는 해당 서버의 설정문제로, 자세한 것은 <a href="http://www.casternet.com/spamfree/zmb/view.php?bd=faq&amp;no=10" onclick="return n(this);" title="무조건 틀렸다고 나오는 경우">[관련자료 보기]</a>를 참고하세요.</p></li>
	<li>위 자료를 다 봤는데도 다른 문제가 있어요. 또는 더 궁금한 것이 있어요.
		<p><a href="http://www.casternet.com/spamfree/" onclick="return n(this);" title="스팸프리닷케이알 홈페이지">개발자 홈페이지</a>의 <a href="http://www.casternet.com/spamfree/zmb/list.php?bd=faq" onclick="return n(this);" title="스팸프리닷케이알 홈페이지 잦은질문 게시판">잦은질문</a>을 참고하시고, 그래도 문제가 있으면 <a href="http://www.casternet.com/spamfree/zmb/list.php?bd=qna" onclick="return n(this);" title="스팸프리닷케이알 홈페이지 질문&amp;답변">질문&amp;답변</a> 게시판에 글 남겨 주세요.</p></li>
</ol>
<div id="foot">
<p>본 문서는 <a href="http://validator.w3.org/" onclick="return n(this);" title="The W3C Validation Service">XHTML 1.0 Strict</a> 와 <a href="http://jigsaw.w3.org/css-validator/" onclick="return n(this);" title="W3C CSS Validation Service">CSS Level 2.1</a> 을 준수합니다.</p>
<p>이 프로그램은 <a href="http://www.casternet.com/" onclick="return n(this); " title="강남캐스터넷 CangNam CasterNet Co.">강남캐스터넷</a>의 후원으로 개발, 무료배포됩니다.</p>
</div>
</div>
<div id="copy"><a href="http://www.casternet.com/" onclick="return n(this); " title="강남캐스터넷 CangNam CasterNet Co.">Powered by www.CasterNet.com</a></div>
</body>
</html>
