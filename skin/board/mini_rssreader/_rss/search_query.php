<?
$g4_path = "../../../..";
require_once "$g4_path/common.php";
$g4[title] = "뉴스 검색기";
require_once "$g4[path]/head.sub.php";
require_once "rss_inc.php";
?>
<body onload=document.srf.search.focus();>
<form name=srf action=RSS_reader.php>
<input type=hidden name=now_read value=1>
<input type=hidden name=bo_table value=<?=$bo_table?>>
<input type=hidden name=md value=ns>
<center><br>
<style type=text/css>
body {background-color:#EAF0FB;}
</style>

<table cellspacing=0 cellpadding=0>
<tr>
	<td colspan=2>
		<span style='color:#4954A0;font-weight:bold'>◈ RSS 뉴스 검색</span>
	</td>
</tr>
<tr>
	<td width=70>
		<select name=channel>
		<?
		for($i=0; $i<count($channellist); $i++) {
			echo "<option value='$i'>$channellist_name[$i]</option>\n";
		}
		?>
		</select>
	</td>
	<td style='padding-left:8'>
		검색어 : <input type=text name=search size=30> <input type=submit value='검색'>&nbsp;<input type=button value='닫기' onclick="javascript:self.close();">
	</td>
</tr>
</table>

</form>

<?
require_once "$g4[path]/tail.sub.php";
?>