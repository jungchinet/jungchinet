<?
$sub_menu = "100250";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

$html_title = "지역입력";
if ($w == "") 
{
    $gr_id_attr = "required";
    $gr[gr_use_access] = 0;
    $gr[gr_use_search] = '1';
    $html_title .= " 리스트";
} 
else if ($w == "u") 
{
    $gr_id_attr = "readonly style='background-color:#dddddd'";
    $gr = sql_fetch(" select * from $g4[group_table] where gr_id = '$gr_id' ");
    $html_title .= " 수정";
} 
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

$g4[title] = $html_title;
include_once("./admin.head.php");

//그룹을 불러오다...
$grInfo=mysql_query("select gr_id, gr_subject from g4_group");

?>
<style>
#region table, tr, td {
	collapse:collapse;
}
#region tr {
	border-right:solid 1px #CCC;	
}
#region td {
	border-bottom:solid 1px #CCC; 	
}
</style>

<table id='region' width=100% cellpadding=0 cellspacing=0>
	<tr>
    	<td align='right' height='40' colspan='4'><a href='./cate3_create.php?depth=1'>[1차 카테고리 생성]</a></td>    
    </tr>
    <tr>
    	<td colspan='4' style='border:none;border-bottom:solid 2px;#999;'></td>
    </tr>
    
<?

while($c=mysql_fetch_array($grInfo)){

	$brdCate=mysql_fetch_row(mysql_query("select bo_category_list from g4_board where gr_id='$c[gr_id]' and (bo_category_list IS NOT NULL or bo_category_list <> '') limit 1"));	
	$bcData=explode('|', $brdCate[0]);
	$bcNum=count($bcData);
	
	if($bcData[0]==''){
		continue;	
	}

?>
	
    
	<tr>
    	<td colspan='4' style='padding:5px;background-color:#F8BE25;height:35px;'><?='<strong>'.$c[gr_subject].'</strong> ('.$c[gr_id].')';?></td>
    </tr>
    
<?

		for($v=0;$v<$bcNum;$v++){
		
	
			$rsql="select * from cate_1st where gr_id='$c[gr_id]' and hcate='$bcData[$v]' order by rank asc";
			$rrst=mysql_query($rsql);
			$rnum=mysql_num_rows($rrst);
			
			if($rnum==0){
				continue;	
			}


?>
            <tr>
                <td colspan='4' style='padding:5px;background-color:#FF9;height:20px;'><?='<strong>'.$bcData[$v].'</strong>';?></td>
            </tr>
    <tr>
    	<td align='center' height='30' width='190'><strong>1차 카테고리(순위)</strong></td>
        <td align='center' width='190'><strong>2차 카테고리(순위)</strong></td>
        <td align='center' width='190'><strong>3차 카테고리(순위)</strong></td>
        <td align='center'><strong>수정/삭제</strong></td>
    </tr>

	<?    
    if($rnum>=1){
        for($r=0;$r<$rnum;$r++){
        $z=mysql_fetch_array($rrst);
		$m="select count(*) from g4_member where mb_5='$z[no]'";
		$mr=mysql_query($m);
		$mr=mysql_fetch_row($mr);
	?>
    	<!--1차지역 출력-->
        <tr>
            <td style='border-top:solid 2px #666;' height='25' align='center'><?=$z[name].'('.$z[rank].')'; if($z[brd]){ echo ' / '.$z[brd]; } /*if($mr[0]>=1){ echo ' + '.$mr[0]; }*/ ?></td>
            <td style='border-top:solid 2px #666;' align='center'>&nbsp;</td>
            <td style='border-top:solid 2px #666;' align='center'>&nbsp;</td>
            <td style='border-top:solid 2px #666;' align='center'><a href='cate3_create.php?depth=2&parent=<?=$z[no]?>'>[2차 카테고리 생성]</a> <a href='cate3_create.php?w=u&depth=1&no=<?=$z[no]?>'>[수정]</a> <a href="javascript:cate_del(1, false, false, <?=$z[no]?>, false);">[삭제]</a></td>
        </tr>
        
        <?
			$r2sql="select * from cate_2nd where parent='$z[no]' order by rank asc";
			$r2rst=mysql_query($r2sql);
			$r2num=mysql_num_rows($r2rst);
			
			for($r2=0;$r2<$r2num;$r2++){
			$z2=mysql_fetch_array($r2rst);
		?>
        	<!--2차지역 출력-->
            <tr>
                <td height='25' align='center'>┖</td><td align='center'><?=$z2[name].'('.$z2[rank].')';?></td>                
                <td></td>
                <td align='center'><a href='cate3_create.php?depth=3&parent=<?=$z2[no]?>'>[3차 카테고리 생성]</a> <a href='cate3_create.php?w=u&depth=2&&parent=<?=$z[no]?>&no=<?=$z2[no]?>'>[수정]</a> <a href="javascript:cate_del(2, <?=$z[no]?>, '<?=$z[name]?>', <?=$z2[no]?>, <?=$r2num?>);">[삭제]</a></td>
            </tr>
            
            <?
			$r3sql="select * from cate_3rd where parent='$z2[no]' order by rank asc";
			$r3rst=mysql_query($r3sql);
			$r3num=mysql_num_rows($r3rst);
			
			for($r3=0;$r3<$r3num;$r3++){
			$z3=mysql_fetch_array($r3rst);
			?>
            
            	<!--3차지역 출력-->
                <tr>
                    <td></td><td align='center'>┖</td>                
                    <td height='25' align='center'><?=$z3[name].'('.$z3[rank].')';?></td>
                    <td align='center'><a href='cate3_create.php?w=u&depth=3&&parent=<?=$z2[no]?>&no=<?=$z3[no]?>'>[수정]</a> <a href="javascript:cate_del(3, <?=$z2[no]?>, '<?=$z2[name]?>', <?=$z3[no]?>, <?=$r3num?>);">[삭제]</a></td>
                </tr>
            <? } ?>
        
        <? } ?>
        <tr>
            <td height='10' align='center' colspan='4' style='border:none;border-bottom:solid 2px #999;height:50px;'></td>
        </tr>
            
    <? }}else{ ?>
    <tr>
    	<td align='center' colspan='4' style='height:100px;'>생성된 카테고리가 없습니다.</td>
    </tr>
    <? } ?>
    
<? } ?>
<? } ?>
    
    <tr>
    	<td colspan='4'></td>
    </tr>

</table>

<script language='JavaScript'>
function cate_del(d, p, pn, n, q){
	var cf=confirm('정말로 삭제하시겠습니까?');
    
    if(cf){
		location.href='cate3_del.php?depth='+d+'&p='+p+'&pn='+pn+'&no='+n+'&q='+q;
    }else{
    	alert('취소하셨습니다');
    }
}
</script>

<?
include_once ("./admin.tail.php");
?>