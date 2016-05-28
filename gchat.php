<?
include_once("./_common.php");
//include_once("$g4[path]/lib/latest.lib.php");

//$g4['title'] = "";
//include_once("./_head.php");
?>
<html	xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>
<title>
<?=$config[cf_title]?> 대화방
</title>
<style type="text/css">
<!--
body {
	margin-left: 1px;
	margin-top:	1px;
	margin-right:	1px;
	margin-bottom: 1px;
}
-->
</style>
</head>
<body>
<?
if($GLOBALS['userKeyDefined']	!= 1)	 {
	$GLOBALS['userKeyDefined']	=	1;
	function userKey($user,	$roomKey)	 {
		return md5(md5($user . $roomKey) . $roomKey);
	}
}

if(true){
	$chatroom	=	"$config[cf_title]";
	//채팅방 option	주고 싶으면	아래 코맨트	제거 (예로 글씨	크게,	대화방 세로형)
	//$chatroom	=	$chatroom	.	"&fontlarge=true&position=2";
	$roomkey = "여기에 대화방	보안 키	입력";
	$gagaadmin =	"여기에	대화방 관리자	아이디 입력. 여러명인	경우 , 로	구분.";
	$heightz = "100%";
	$widthz	=	"100%";
	$gagaadmin = preg_replace('/\s*,\s*/', ',',	$gagaadmin);
	$gagaadmins	=	split(',', $gagaadmin);
	$userz = $member[mb_id];
	$usernickz = $member[mb_nick];
	$usernickz = iconv("EUC-KR", "UTF-8",	$usernickz);
	$userkey = userKey($usernickz, $roomkey);
	foreach($gagaadmins	as $value)	{
		if($userz	== $value)	{
      $userkey = userKey(userKey($usernickz, $roomkey), $roomkey);
		}
	}
$usernickz = urlencode($usernickz);
?>
<center>
<script	src="http://www.gagalive.kr/Scripts/AC_RunActiveContent.js"	type="text/javascript"></script>
<script	type="text/javascript">
AC_FL_RunContent(	'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','<?=$widthz?>','height','<?=$heightz?>','title','가가라이브 대화방','src','http://www.gagalive.kr/livechat1?&chatroom=<?echo	$chatroom?>&user=<?echo	$usernickz?>&encrypt=<?echo	$userkey?>','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','http://www.gagalive.kr/livechat1?&chatroom=<?echo	$chatroom?>&user=<?echo	$usernickz?>&encrypt=<?echo	$userkey?>'	); //end AC	code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"	codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"	width="<?=$widthz?>" height="<?=$heightz?>"	title="가가라이브	대화방">
<param name="movie"	value="http://www.gagalive.kr/livechat1.swf?&chatroom=<?echo $chatroom?>&user=<?echo $usernickz?>&encrypt=<?echo $userkey?>">
<param name="quality"	value="high">
<embed src="http://www.gagalive.kr/livechat1.swf?&chatroom=<?echo	$chatroom?>&user=<?echo	$usernickz?>&encrypt=<?echo	$userkey?>"	quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer"	type="application/x-shockwave-flash" width="<?=$widthz?>"	height="<?=$heightz?>"></embed>
</object></noscript>
</center>
<?
}	
?>
</body>
</html>
