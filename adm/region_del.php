<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

include_once("./_common.php");

if($is_admin=='super' and ($depth and $no)){
	if($depth==1){
    
    	$csql="select count(*) from region_2nd where parent='$no'";
        $crst=mysql_query($csql);
        $crst=mysql_fetch_row($crst);
        if($crst[0]>=1){
        	echo "<script>alert('하위 2차지역이 존재하므로 삭제가 불가합니다.');location.href='region.php';</script>";
        }else{

			$sql="delete from region_1st where no='$no'";
			$rst=mysql_query($sql);
			
			if($rst){
				echo "<script>alert('1차 지역 삭제완료!');location.href='region.php';</script>";
			}
			
			
			$gr_id			 = 'reg_1_'.$no;
			
			// 사용자 그룹 삭제
			sql_query(" delete from $g4[user_group_table] where ug_id = '$gr_id' ");
			
			// 사용자 그룹 회원 정보 초기화 
			sql_query(" update $g4[member_table] set ug_id = '' where ug_id = '$gr_id' ");
				
		}
		
    }else if($depth==2){
			
		$sql="delete from region_2nd where parent='$p' and no='$no'";
		$rst=mysql_query($sql);
		
		if($rst){
			echo "<script>alert('2차 지역 삭제완료!');location.href='region.php';</script>";
		}
		
		
		$gr_id			 = 'reg_2_'.$no;
		
		// 사용자 그룹 삭제
		sql_query(" delete from $g4[user_group_table] where ug_id = '$gr_id' ");
		
		// 사용자 그룹 회원 정보 초기화 
		sql_query(" update $g4[member_table] set ug_id = '' where ug_id = '$gr_id' ");
		
		$gr_id			 = 'reg_1_'.$p;
		$ug_subject      = $pn;
		$ug_admin        = '';
						
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

?>