<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$sub_menu = "100250";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

if ($is_admin != "super" && $w == "") alert("최고관리자만 접근 가능합니다.");

$html_title = "카테고리입력";
if ($w == "") 
{
	$mtd='생성';	
	$w='w';
	$grInfo=mysql_query("select gr_id, gr_subject from g4_group");
} 
else if ($w == "w") 
{
    if($depth==1){
		$cate_grp=explode('|', $cate_grp);
		$gr_id=$cate_grp[1];
    	$sql="insert into cate_1st set gr_id='$gr_id', hcate='$hCate', name='$cate_name', rank='$rank'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('1차 카테고리 생성완료!');location.href='cate3.php';</script>";
        }
		
		
    }else if($depth==2){
    	$sql="insert into cate_2nd set name='$cate_name', parent='$parent', rank='$rank'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('2차 카테고리 생성완료!');location.href='cate3.php';</script>";
        }
		
    }else if($depth==3){
    	$sql="insert into cate_3rd set name='$cate_name', parent='$parent', rank='$rank'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('3차 카테고리 생성완료!');location.href='cate3.php';</script>";
        }
		
    }
}
else if ($w == "u") 
{
	$mtd='수정';
	if($depth==1){
		$rsql="select gr_id, hcate, name, rank from cate_1st where no='$no'";
		$rrst=mysql_query($rsql);
		$rrst=mysql_fetch_array($rrst);
		$grInfo=mysql_query("select gr_id, gr_subject from g4_group");		
		$grName=mysql_fetch_array(mysql_query("select gr_subject from g4_group where gr_id='$rrst[gr_id]'"));
	}else if($depth==2){
		$rsql="select name, rank from cate_2nd where no='$no'";
		$rrst=mysql_query($rsql);
		$rrst=mysql_fetch_array($rrst);
	}else if($depth==3){
		$rsql="select name, rank from cate_3rd where no='$no'";
		$rrst=mysql_query($rsql);
		$rrst=mysql_fetch_array($rrst);
	}
	
	$w='uu';
}
else if ($w == "uu") 
{
    if($depth==1){
		$cate_grp=explode('|', $cate_grp);
		$gr_id=$cate_grp[1];
    	$sql="update cate_1st set gr_id='$gr_id', hcate='$hCate', name='$cate_name', rank='$rank' where no='$no'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('1차 카테고리 수정완료!');location.href='cate3.php';</script>";
        }
    }else if($depth==2){
    	$sql="update cate_2nd set name='$cate_name', parent='$parent', rank='$rank' where parent='$parent' and no='$no'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('2차 카테고리 수정완료!');location.href='cate3.php';</script>";
        }
    }else if($depth==3){
    	$sql="update cate_3rd set name='$cate_name', parent='$parent', rank='$rank' where parent='$parent' and no='$no'";
        $rst=mysql_query($sql);
        if($rst){
        	echo "<script>alert('3차 카테고리 수정완료!');location.href='cate3.php';</script>";
        }
    }
}
else
    alert("제대로 된 값이 넘어오지 않았습니다.");

$g4[title] = $html_title;
include_once("./admin.head.php");
?>

<form action='cate3_create.php' method='post'>
<input type='hidden' name='w' value='<?=$w?>'>
<input type='hidden' name='no' value='<?=$no?>'>
<input type='hidden' name='parent' value='<?=$parent?>'>
<input type='hidden' name='depth' value='<?=$depth?>'>
<table width=100% cellpadding=0 cellspacing=0>
	<tr>
    	<td>[<?=$depth?>차 카테고리 <?=$mtd?>]</td>    
    </tr>
<? if($depth==1){ ?>
    <script>
	function cngCate(grp){
		var grpInit=document.getElementById('hCate');
		var num=grp.split('|');
			 num=num[0];
			 //alert(num);
			 document.getElementById('hCate').style.display='block';
			
    <?
	
	$grp='';
	$cNum=1;
	while($r=mysql_fetch_array($grInfo)){
		
		$grp.="<option value='{$cNum}|{$r[gr_id]}'>$r[gr_subject]</option>";
		$brdCate=mysql_fetch_row(mysql_query("select bo_category_list from g4_board where gr_id='$r[gr_id]' and (bo_category_list IS NOT NULL or bo_category_list <> '') limit 1"));	
		$bcData=explode('|', $brdCate[0]);
		$bcNum=count($bcData);
		
		if($bcNum>1){
			echo "if(num==".$cNum."){";
			$eachCate="가로카테고리 : <select name='hCate'>";
				
					for($v=0;$v<$bcNum;$v++){
						$eachCate.="<option value='$bcData[$v]'>$bcData[$v]</option>";
					}
			echo "grpInit.innerHTML=\"".$eachCate."</select>\"}";
		}else{
			echo "if(num==".$cNum."){grpInit.innerHTML=\"\"}";	
		}

		$cNum++;
	}
	
	?>
			if(num==''){
				 grpInit.style.display='none';
			 }else{
				 grpInit.style.display='block';
			 }
	}
	</script>
<? } ?>
    <tr>
    	<td height='50' style='line-height:280%;'>
    		<hr />
            <? if($depth==1){ ?>
            <? if($w=='u'){ ?>
            <div>기존에 선택된 그룹은 <?=$grName[gr_subject].' ('.$rrst[gr_id].')'?>이고 가로카테고리는 <?=$rrst[hcate]?>입니다. </div>
            <? } ?>
    		<div>그룹 : <select name='cate_grp' onchange='cngCate(this.value)'><option value=''>선택하세요</option><?=$grp?></select></div>
            <div id='hCate' style='display:none;'></div>
            <? } ?>
            <div>카테고리이름 : <input type='text' name='cate_name' value='<?=$rrst[name]?>' style='width:200px; height:20px; border:solid 1px #999;'> / 표시순위 <input type='text' name='rank' value='<?=$rrst[rank]?>' style='width:20px; height:20px; border:solid 1px #999;text-align:center;'></div>
            <hr />
        </td>
    </tr>
    <tr>
    	<td><input type='submit' value='<?=$mtd?>하기'></td>
    </tr>

</table>
</form>

<?
include_once ("./admin.tail.php");
?>