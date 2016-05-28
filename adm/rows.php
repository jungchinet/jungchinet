<?
include_once("./_common.php");

if($mode=='ww'){
	
	$sql="update rows_info
			set row1 = '$row1',
				row2 = '$row2',
				row3 = '$row3',
				row4 = '$row4',
				row5 = '$row5',
				row6 = '$row6',
				term1 = '$term1',
				term2 = '$term2',
				term3 = '$term3',
				term4 = '$term4',
				term5 = '$term5',
                term6 = '$term6',
                ord1 = '$ord1'";
	$rst=mysql_query($sql);
	
	if($rst){
		echo "<script>alert('정상적으로 수정되었습니다.');</script>";
		echo "<script>location.href='rows.php';</script>";
	}else{
		
		echo "<script>alert('수정에 실패했습니다.');</script>";
		echo "<script>location.href='rows.php';</script>";
	}
	
}else{
	
	$sql=mysql_query("select * from rows_info");
	$rowsInfo=mysql_fetch_array($sql);

auth_check($auth[$sub_menu], "r");

$token = get_token();

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");


$g4['title'] = " 최근게시물 갯수관리";
include_once ("./admin.head.php");
?>

<form name='fconfigform' method='post' onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type=hidden name=mode value='ww'>
<input type=hidden name=token value='<?=$token?>'>
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
    <td colspan=4 align=left><?=subtitle("최근게시물 갯수관리")?></td>
</tr>
<tr><td colspan=4 class=line1></td></tr>
<tr class='ht'>
  <td colspan="4"></td>
</tr>
<tr class='ht'>
    <td width="14%">내글에 달린 댓글 수</td>
    <td colspan="3">
    	<input type=text class=ed name='row1' value='<?=$rowsInfo[row1]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">내가 올린 글 수</td>
    <td colspan="3">
    	<input type=text class=ed name='row2' value='<?=$rowsInfo[row2]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">내가 단 댓글 수</td>
    <td colspan="3">
    	<input type=text class=ed name='row3' value='<?=$rowsInfo[row3]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">최고인기글 수</td>
    <td colspan="3">
    	<input type=text class=ed name='row4' value='<?=$rowsInfo[row4]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">내가 본 게시판</td>
    <td colspan="3">
    	<input type=text class=ed name='row5' value='<?=$rowsInfo[row5]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">전체최근글</td>
    <td colspan="3">
    	<input type=text class=ed name='row6' value='<?=$rowsInfo[row6]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">최고인기글 캐싱타임(초)</td>
    <td colspan="3">
    	<input type=text class=ed name='term1' value='<?=$rowsInfo[term1]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">회원수 캐싱타임(초)</td>
    <td colspan="3">
        <input type=text class=ed name='term2' value='<?=$rowsInfo[term2]?>'>
    </td>
</tr>
<?
    if($rowsInfo['ord1']==1){
        $os1='selected';
    }else if($rowsInfo['ord1']==2){
        $os2='selected';
    }else{
        $os1='selected';
    }
?>
<tr class='ht'>
    <td width="14%">최고 인기글 정렬</td>
    <td colspan="3">
        <select name='ord1'>
            <option value='1' <?=$os1?>>조회수</option>
            <option value='2' <?=$os2?>>추천수</option>
        </select>
    </td>
</tr>
<!--tr class='ht'>
    <td width="14%">여분 캐싱타임(초)</td>
    <td colspan="3">
    	<input type=text class=ed name='term3' value='<?=$rowsInfo[term3]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">여분 캐싱타임(초)</td>
    <td colspan="3">
    	<input type=text class=ed name='term4' value='<?=$rowsInfo[term4]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">여분 캐싱타임(초)</td>
    <td colspan="3">
    	<input type=text class=ed name='term5' value='<?=$rowsInfo[term5]?>'>
    </td>
</tr>
<tr class='ht'>
    <td width="14%">여분 캐싱타임(초)</td>
    <td colspan="3">
    	<input type=text class=ed name='term6' value='<?=$rowsInfo[term6]?>'>
    </td>
</tr-->

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
    f.action = "./rows.php";
    return true;
}
</script>

<?
include_once ("./admin.tail.php"); }
?>