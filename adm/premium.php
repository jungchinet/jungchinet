<?
include_once("./_common.php");

if($mode=='ww'){
	
	$sql="update prem_config
			set picNum = '$picNum',
				picQuota = '$picQuota',
				picNum2 = '$picNum2',
				picQuota2 = '$picQuota2',
				modiFlag = '$modiFlag',
				kcp_site_code = '$kcp_site_code',
				kcp_site_key = '$kcp_site_key'";
	$rst=mysql_query($sql);
	
	if($rst){
		echo "<script>alert('정상적으로 수정되었습니다.');</script>";
		echo "<script>location.href='premium.php';</script>";
	}else{
		
		echo "<script>alert('수정에 실패했습니다.');</script>";
		echo "<script>location.href='premium.php';</script>";
	}
	
}else{
	
	$sql=mysql_query("select * from prem_config");
	$premConfig=mysql_fetch_array($sql);

auth_check($auth[$sub_menu], "r");

$token = get_token();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");


$g4['title'] = "뉴스환경설정";
include_once ("./admin.head.php");
?>

<form name='fconfigform' method='post' onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type=hidden name=mode value='ww'>
<input type=hidden name=token value='<?=$token?>'>
<input type=hidden name=cf_region_change_term_last value='<?=$config[cf_region_change_term_last]?>'>
<style>
.ht input {
	width:300px;	
}
</style>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<colgroup width=25% class='col1 pad1 bold right'>
<colgroup class='col2 pad2'>
<colgroup class='col1 pad1 bold right'>
<colgroup class='col2 pad2'>
<tr class='ht'>
    <td colspan=4 align=left><?=subtitle("뉴스 설정")?></td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4"></td>
</tr>
<tr class='ht'>
    <td width="14%">일반 등록가능 사진 갯수</td>
    <td colspan="3">
    	<input type=text class=ed name='picNum' value='<?=$premConfig[picNum]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">일반 등록가능 파일 용량</td>
    <td colspan="3">
    	<input type=text class=ed name='picQuota' value='<?=$premConfig[picQuota]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">게시판관리자 등록가능 사진 갯수</td>
    <td colspan="3">
    	<input type=text class=ed name='picNum2' value='<?=$premConfig[picNum2]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">게시판관리자 등록가능 파일 용량</td>
    <td colspan="3">
    	<input type=text class=ed name='picQuota2' value='<?=$premConfig[picQuota2]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">게시판관리자 글 수정 가능여부</td>
    <td colspan="3">
    	<input type=checkbox name='modiFlag' value='1' <? if($premConfig[modiFlag]){ echo "checked=checked"; }?> style='width:20px;'> 수정가능</td>
</tr>
<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<tr class='ht'>
  <td>KCP 사이트 코드</td>
  <td colspan=3>
    <input type=text class=ed name='kcp_site_code' size='30' value='<?=$premConfig[kcp_site_code]?>'>
    </td>
</tr>
<tr class='ht'>
    <td>KCP 사이트 키</td>
    <td colspan=3>
    	<input type=text class=ed name='kcp_site_key' size='30' value='<?=$premConfig[kcp_site_key]?>'>
    </td>
</tr>

<tr class='ht'>
  <td colspan="4">&nbsp;</td>
</tr>
<? for ($i=1; $i<=10; $i=$i+2) { $k=$i+1; ?>
<? } ?>
<tr><td colspan=4 class=line2></td></tr>
<tr><td colspan=4 class=ht></td></tr>
</table>

<p align=center>
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>
</form>

<script type="text/javascript">
function fconfigform_submit(f)
{
    f.action = "./premium.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php"); }
?>