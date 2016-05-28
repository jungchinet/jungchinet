<?
$g4_path = "../../../..";
include_once("$g4_path/common.php");
if($is_admin != "super")	echo "<script>alert('관리자 로그인 필수!'); self.close();</script>";

include_once("rss_inc.php");
if($w == 'u') {
	save_addr($cf0);
	save_freq($cf1);
	echo "<script>alert('RSS 설정 OK!');self.close();</script>";
} else if($w == 'i') {
	@unlink($cacheFile);
	echo "<script>alert('캐쉬 초기화 OK!');self.close();opener.location.reload();</script>";
}
$addr = read_addr($configFile1);
$freq = read_freq();

?>

<title>RSS Reader 스킨 설정</title>

<style type=text/css>
td { background-color:white; color:#303030; font-size:10pt}
.title {background-color: #CCCCCC; color:white; font-weight:bold}
.menu {padding-left:5;background-color:#F3F3F3}
.bd {padding:5}
.button2 {color:white; background-color:#999999; height:25px; cursor: hand; cursor: pointer;}
</style>

<table cellSpacing=1 cellPadding=0 width=100% bgColor=silver>


 <FORM name=skinSetup method=get>
	<INPUT type=hidden value="u" name="w"> 
	<INPUT type=hidden value="<?=$bo_table?>" name="bo_table"> 
	<tr>
		<td class=title colSpan=2 height=25>&nbsp;&nbsp; RSS Reader 스킨 설정</td>
	</tr>
	
	<tr>
		<td class=menu>RSS 주소</td>
		<td class=bd>
		한줄에 RSS 주소를 하나씩 써주세요.<br> 
		<textarea cols=46 rows=16 name=cf0><?=$addr?></textarea>
		</td>
	</tr>
	
	<tr>
		<td class=menu>다시읽는 주기</td>
		<td class=bd>
			<INPUT type=text value='<?=$freq?>' size=6 name=cf1> 분
		</td>
	</tr>

	<tr height=30>
		<td align=middle colSpan=2>
			<INPUT type=submit class=button2 value=" 확인 "> &nbsp;&nbsp;
			<INPUT onclick=self.close() type=button class=button2 value=" 취소 "> &nbsp;&nbsp;
			<INPUT class=button2 type=button value=" 캐쉬초기화 " onclick=window.location="<?=$_SELF?>?w=i&bo_table=<?=$bo_table?>">
		</td>
	</tr>
	
	</FORM>
	
	</table>