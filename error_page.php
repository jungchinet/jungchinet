<?
// http://wiki.dreamhost.com/index.php/Custom_error_pages
$page_redirected_from = $_SERVER['REQUEST_URI'];  // this is especially useful with error 404 to indicate the missing page.
$server_url = "http://" . $_SERVER["SERVER_NAME"];
$redirect_to = "/";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>에러페이지 - 404에러</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<meta http-equiv="Refresh" content="5; url='<?php print($redirect_to); ?>'">
	
<style type="text/css">

* { margin: 0px; padding: 0px; }
body {
	font-family: "Dotum", Tahoma, sans-serif;
	font-size: 12px;
	line-height: 150%; color: #444;
	text-align: center;
	background: url(img/err_bg.gif) repeat-x; padding-top: 30px;
}
a:link, a:visited, a:active { text-decoration: none; color: #444; }
a:hover { color: #1b8a83; text-decoration: underline; }
img { border: 0px; }

.err_info { border: 3px solid #eeeeee; width: 550px; margin: 0 auto; }
.err_info .err_line { border: 1px solid #b2b2b3; padding: 35px; text-align: left; }

.err_info .err_quick { color: #d7d7d7; letter-spacing: -1px; text-align: right; }
.err_info .err_quick a { color: #444444; }

.err_info .err_logo { margin-bottom: 35px; }

.err_info h3 { font-size: 16px; letter-spacing: -1px; margin-bottom: 20px; }
.err_info .err_text { line-height: 180%; }
.err_info .err_text a { color: #1e68cd; text-decoration: underline; }
.err_info .err_text a:hover { text-decoration: none; }

</style>

</head>
<body>

<div class="err_info"><div class="err_line">

	<div class="err_logo"><a href="/" target="_blank">홈으로</a></div>

	<h3>죄송합니다.<br/>
	요청하신 페이지를 찾을 수 없습니다.<br/><br/>
	<? echo $server_url . $page_redirected_from?> 
	</h3>

	<div class="err_text">
	방문하시려는 페이지의 주소가 잘못 입력되었거나,<br/>
	페이지의 주소가 변경 혹은 삭제되어 요청하신 페이지를 찾을 수 없습니다.<br/><br/>
	입력하신 주소가 정확한지 다시 한번 확인해 주시기 바랍니다.<br/><br/>
	5초후에 처음 페이지로 이동 합니다.<br/><br/>
	감사합니다.<br/><br/>
 </div>

</div></div>

</body>
</html>
