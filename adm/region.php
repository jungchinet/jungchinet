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

$rsql="select * from region_1st order by rank asc";
$rrst=mysql_query($rsql);
$rnum=mysql_num_rows($rrst);

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
    	<td align='right' height='40' colspan='3'><a href='./region_create.php?depth=1'>[1차지역 생성]</a></td>    
    </tr>
    <tr>
    	<td align='center' height='30' width='300'><strong>1차지역(순위) / 연결게시판</strong></td><td align='center' width='300'><strong>2차지역(순위) / 연결게시판</strong></td><td align='center'><strong>수정/삭제</strong></td>
    </tr>
    <tr>
    	<td colspan='3' style='border:none;border-bottom:solid 2px;#999;'></td>
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
            <td style='border-top:solid 2px #666;' height='25' align='center'><?=$z[name].'('.$z[rank].')'; if($z[brd]){ echo ' / '.$z[brd]; } /*if($mr[0]>=1){ echo ' + '.$mr[0]; }*/ ?></td><td style='border-top:solid 2px #666;' align='center'>&nbsp;</td><td style='border-top:solid 2px #666;' align='center'><a href='region_create.php?depth=2&parent=<?=$z[no]?>'>[2차지역 생성]</a> <a href='region_create.php?w=u&depth=1&no=<?=$z[no]?>&brd=<?=$z[brd]?>'>[수정]</a> <a href="javascript:region_del(1, false, false, <?=$z[no]?>, false);">[삭제]</a></td>
        </tr>
        
        <?
			$r2sql="select * from region_2nd where parent='$z[no]' order by rank asc";
			$r2rst=mysql_query($r2sql);
			$r2num=mysql_num_rows($r2rst);
			
			for($r2=0;$r2<$r2num;$r2++){
			$z2=mysql_fetch_array($r2rst);
			
			$m="select count(*) from g4_member where mb_6='$z2[no]'";
			$mr=mysql_query($m);
			$mr=mysql_fetch_row($mr);
		?>
        	<!--2차지역 출력-->
            <tr>
                <td height='25' align='center'>┖</td><td align='center'><?=$z2[name].'('.$z2[rank].')'; if($z2[brd]){ echo ' / '.$z2[brd]; } /*if($mr[0]>=1){ echo ' + '.$mr[0]; }*/ ?></td><td align='center'><a href='region_create.php?w=u&depth=2&&parent=<?=$z[no]?>&no=<?=$z2[no]?>&brd=<?=$z2[brd]?>'>[수정]</a> <a href="javascript:region_del(2, <?=$z[no]?>, '<?=$z[name]?>', <?=$z2[no]?>, <?=$r2num?>);">[삭제]</a></td>
            </tr>
        
        <? } ?>
        <tr>
            <td height=10' align='center' colspan='3' style='border:none;border-bottom:solid 2px #999;height:30px;'></div></td>
        </tr>
            
    <? }}else{ ?>
    <tr>
    	<td align='center' colspan='3' style='height:400px;'>생성된 지역이 없습니다.</td>
    </tr>
    <? } ?>
    
    <tr>
    	<td colspan='3'></td>
    </tr>

</table>

<script language='JavaScript'>
if (document.fboardgroup.w.value == '')
    document.fboardgroup.gr_id.focus();
else
    document.fboardgroup.gr_subject.focus();

function fboardgroup_check(f)
{
    f.action = "./boardgroup_form_update.php";
    return true;
}

function region_del(d, p, pn, n, q){
	var cf=confirm('정말로 삭제하시겠습니까?');
    
    if(cf){
		location.href='region_del.php?depth='+d+'&p='+p+'&pn='+pn+'&no='+n+'&q='+q;
    }else{
    	alert('취소하셨습니다');
    }
}
</script>

<?
include_once ("./admin.tail.php");
?>