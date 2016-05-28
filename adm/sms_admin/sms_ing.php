<?
$sub_menu = "900300";
include_once("./_common.php");

$g4[title] = 'SMS 전송중';
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=<?=$g4['charset']?>">
<title><?=$g4[title]?></title>
<head>
<style>
td { font-size:12px; }
</style>
</head>
<body onblur="this.focus()">
<table border=0 width=100% height=100%>
<tr>
	<td align=center>
        SMS를 전송중입니다. 잠시만 기다려주십시오.
    </td>
</tr>
</table>
</body>
</html>
