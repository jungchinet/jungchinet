
<?

include_once('_common.php');

/*
echo "<script type=\"text/javascript\" src=\"".$g4['path']."/js/fakeselect.js\"></script>";
echo "<link rel=\"stylesheet\" href=\"".$g4['path']."/fakeselect.css\" type=\"text/css\">";
*/

if($_REQUEST[depth]=='8'){
		
		$hCatee=$hcate;
		$grInfo=mysql_fetch_array(mysql_query("select gr_id from g4_board where bo_table='$bo_table' limit 1"));
	
		$scSql="select * from cate_1st where hcate='$hCatee' and gr_id='$grInfo[gr_id]' order by rank asc";
		$scData=mysql_query($scSql);
		$scNum=mysql_num_rows($scData);
				
		if($scNum>0){
			
			$cate9="<select id='cate3s' name='wr_5' onchange='myCate(this.value)'>";
			$cate9.="<option value='0'>선택하세요</option>";
			
			while($sCate=mysql_fetch_array($scData)){
				
				$wow="{$sCate[no]}";
				if($wow==$cate3){
					$selected="selected='selected'";	
				}
				$cate9.="<option value='$sCate[no]' $selected>$sCate[name]</option>";
				$selected='';
				
				$scSql2="select * from cate_2nd where parent='$sCate[no]' order by rank asc";
				$scData2=mysql_query($scSql2);
				$scNum2=mysql_num_rows($scData2);
				
				if($scNum2>0){
			
					while($sCate2=mysql_fetch_array($scData2)){
						
						$wow2="{$sCate[no]}|{$sCate2[no]}";
						if($wow2==$cate3){
							$selected2="selected='selected'";	
						}
						$cate9.="<option value='{$sCate[no]}|{$sCate2[no]}' $selected2>$sCate[name]&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;$sCate2[name]</option>";
						$selected2='';
						
						$scSql3="select * from cate_3rd where parent='$sCate2[no]' order by rank asc";
						$scData3=mysql_query($scSql3);
						$scNum3=mysql_num_rows($scData3);
						
						if($scNum3>0){
			
							while($sCate3=mysql_fetch_array($scData3)){
								
								$wow3="{$sCate[no]}|{$sCate2[no]}|{$sCate3[no]}";
								if($wow3==$cate3){
									$selected3="selected='selected'";	
								}
								
								$cate9.="<option value='{$sCate[no]}|{$sCate2[no]}|{$sCate3[no]}' $selected3>$sCate[name]&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;$sCate2[name]&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;$sCate3[name]</option>";
								$selected3='';
								
							}
						
						}else{
								
						}
						
					}
					
				}
				
			}
			
		}else{
			//echo 0;	
		}

	$cate9.="</select><script>$(\"#cate9\").css('display', 'block');</script>";
	echo $cate9;

}else if($_REQUEST[depth]=='9'){
	
	$grInfo=mysql_fetch_array(mysql_query("select gr_id from g4_board where bo_table='$bo_table' limit 1"));
	
	if(!$sca){
		$brdCate=mysql_fetch_row(mysql_query("select bo_category_list from g4_board where gr_id='$grInfo[gr_id]' and (bo_category_list IS NOT NULL or bo_category_list <> '') limit 1"));	
		$bcData=explode('|', $brdCate[0]);
		$bcNum=count($bcData);
	}else{
		$bcData[0]=$hcate;
		$bcNum=1;	
	}
		
	$allCnt=0;
	$cate9="<select id='cate3s' name='wr_5' onchange='myCate(this.value)''>";
	$cate9.="<option value='0'>선택하세요</option>";
	for($g=0;$g<$bcNum;$g++){
		
		$hCatee=trim($bcData[$g]);
	
		$scSql="select * from cate_1st where hcate='$hCatee' and gr_id='$grInfo[gr_id]' order by rank asc";
		$scData=mysql_query($scSql);
		$scNum=mysql_num_rows($scData);
		

		
		if($scNum>0){
			
			$allCnt++;
			
			while($sCate=mysql_fetch_array($scData)){
				$wow="{$sCate[no]}";
				if($wow==$cate3){
					$selected="selected='selected'";
				}
				$cate9.="<option value='$sCate[no]' $selected>".str_pad($sCate[name], 30, ' ')."</option>";
				$selected='';
				
				$scSql2="select * from cate_2nd where parent='$sCate[no]' order by rank asc";
				$scData2=mysql_query($scSql2);
				$scNum2=mysql_num_rows($scData2);
				
				if($scNum2>0){
			
					while($sCate2=mysql_fetch_array($scData2)){
						
						$wow2="{$sCate[no]}|{$sCate2[no]}";
						if($wow2==$cate3){
							$selected2="selected='selected'";	
						}
						$cate9.="<option value='{$sCate[no]}|{$sCate2[no]}' $selected2>".str_pad($sCate[name], 30, ' ')."&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($sCate2[name], 30, ' ')."</option>";
						$selected2='';
						
						$scSql3="select * from cate_3rd where parent='$sCate2[no]' order by rank asc";
						$scData3=mysql_query($scSql3);
						$scNum3=mysql_num_rows($scData3);
						
						if($scNum3>0){
			
							while($sCate3=mysql_fetch_array($scData3)){
								
								$wow3="{$sCate[no]}|{$sCate2[no]}|{$sCate3[no]}";
								if($wow3==$cate3){
									$selected3="selected='selected'";	
								}
								$cate9.="<option value='{$sCate[no]}|{$sCate2[no]}|{$sCate3[no]}' $selected3>".str_pad($sCate[name], 20)."&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($sCate2[name], 20)."&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($sCate3[name], 20)."</option>";
								$selected3='';
								
							}
						
						}
						
					}
					
				}
				
			}
			
		}
			
	}
	$cate9.="</select><script>fakeselect.initialize();</script>";
	
	if($allCnt){
		echo $cate9;
	}else{
		echo 0;
		exit;	
	}
	

}

?>