<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$sub_menu = "100250";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

$html_title = "지역입력";
if ($w == "") 
{
	$mtd='생성';
    $bsql="select bo_table, bo_subject from g4_board";
	$brst=mysql_query($bsql);
	
	$brd_list='';
	$brd_list .= "<option value=''>선택안함</option><option value=''>선택안함</option>";
	while($d=mysql_fetch_array($brst)){
		$brd_list .= "<option value='$d[bo_table]'>$d[bo_subject]($d[bo_table])</option>";	
	}
	
	$w='w';
} 
else if ($w == "w") 
{
    if($depth==1){
    	$sql="insert into region_1st set name='$region_name', rank='$rank', brd='$brd'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('1차 지역 생성완료!');location.href='region.php';</script>";
        }
		
		$nono=mysql_fetch_row(mysql_query('select no from region_1st order by no desc limit 0,1'));
		
		$gr_id			 = 'reg_1_'.$nono[0];
		$ug_subject      = $region_name;
		$ug_admin        = $member[mb_id];
						
		$sql_common = " ug_subject      = '$ug_subject',
						ug_admin        = ''
						";

		$sql = " select count(*) as cnt from $g4[user_group_table] where ug_id = '$gr_id' ";
		$row = sql_fetch($sql);
		if ($row[cnt]) 
			alert("이미 존재하는 그룹 ID 입니다.");
	
		$sql = " insert into $g4[user_group_table]
					set ug_id = '$gr_id',
						$sql_common ";
		sql_query($sql);
		
		
    }else if($depth==2){
    	$sql="insert into region_2nd set name='$region_name', parent='$parent', rank='$rank', brd='$brd'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('2차 지역 생성완료!');location.href='region.php';</script>";
        }
		
		
		$nono=mysql_fetch_row(mysql_query('select no from region_2nd order by no desc limit 0,1'));
		
		$gr_id			 = 'reg_2_'.$nono[0];
		$gr_id2			 = 'reg_1_'.$parent;
		$ug_subject      = $region_name;
		$ug_admin        = $member[mb_id];
		
		// 사용자 그룹 삭제
		sql_query(" delete from $g4[user_group_table] where ug_id = '$gr_id2' ");
		
		// 사용자 그룹 회원 정보 초기화 
		sql_query(" update $g4[member_table] set ug_id = '' where ug_id = '$gr_id2' ");
						
		$sql_common = " ug_subject      = '$ug_subject',
						ug_admin        = ''
						";

		$sql = " select count(*) as cnt from $g4[user_group_table] where ug_id = '$gr_id' ";
		$row = sql_fetch($sql);
		if ($row[cnt]) 
			alert("이미 존재하는 그룹 ID 입니다.");
	
		$sql = " insert into $g4[user_group_table]
					set ug_id = '$gr_id',
						$sql_common ";
		sql_query($sql);
		
    }
}
else if ($w == "u") 
{
	$mtd='수정';
	if($depth==1){
		$rsql="select name, rank from region_1st where no='$no'";
		$rrst=mysql_query($rsql);
		$rrst=mysql_fetch_array($rrst);
	}else if($depth==2){
		$rsql="select name, rank from region_2nd where no='$no'";
		$rrst=mysql_query($rsql);
		$rrst=mysql_fetch_array($rrst);
	}
	
	$bsql="select bo_table, bo_subject from g4_board";
	$brst=mysql_query($bsql);
	
	$brd_list='';
	$brd_list .= "<option value=''>선택안함</option><option value=''>선택안함</option>";
	while($d=mysql_fetch_array($brst)){
		if($brd==$d[bo_table]){ $selected="selected='selected'"; }
		$brd_list .= "<option value='$d[bo_table]' $selected>$d[bo_subject]($d[bo_table])</option>";	
		$selected='';
	}
	
	$w='uu';
}
else if ($w == "uu") 
{
    if($depth==1){
    	$sql="update region_1st set name='$region_name', rank='$rank', brd='$brd' where no='$no'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('1차 지역 수정완료!');location.href='region.php';</script>";
        }
    }else if($depth==2){
    	$sql="update region_2nd set name='$region_name', parent='$parent', rank='$rank', brd='$brd' where parent='$parent' and no='$no'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('2차 지역 수정완료!');location.href='region.php';</script>";
        }
    }
}
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

$g4[title] = $html_title;
include_once("./admin.head.php");
?>

<form action='region_create.php' method='post'>
<input type='hidden' name='w' value='<?=$w?>'>
<input type='hidden' name='no' value='<?=$no?>'>
<input type='hidden' name='parent' value='<?=$parent?>'>
<input type='hidden' name='depth' value='<?=$depth?>'>
<table width=100% cellpadding=0 cellspacing=0>
	<tr>
    	<td>[<?=$depth?>차 지역<?=$mtd?>]</td>    
    </tr>
    <tr>
    	<td height='50'>
    		<hr />
    		지역이름 : <input type='text' name='region_name' value='<?=$rrst[name]?>' style='width:200px; height:20px; border:solid 1px #999;'> / 표시순위 <input type='text' name='rank' value='<?=$rrst[rank]?>' style='width:20px; height:20px; border:solid 1px #999;text-align:center;'> / 연결게시판 <select name='brd' style='height:20px;><?=$brd_list?></select>
            <hr />
        </td>
    </tr>
    <tr>
    	<td><input type='submit' value='<?=$mtd?>하기'></td>
    </tr>

</table>
</form>

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
</script>

<?
include_once ("./admin.tail.php");
?>