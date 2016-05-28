<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

include_once("./_common.php");

if($is_admin=='super' and ($depth and $no)){
	if($depth==1){
    
    	$csql="select count(*) from cate_2nd where parent='$no'";
        $crst=mysql_query($csql);
        $crst=mysql_fetch_row($crst);
        if($crst[0]>=1){
        	echo "<script>alert('하위 2차 카테고리가 존재하므로 삭제가 불가합니다.');location.href='cate3.php';</script>";
        }else{

			$sql="delete from cate_1st where no='$no'";
			$rst=mysql_query($sql);
			
			if($rst){
				echo "<script>alert('1차 카테고리 삭제완료!');location.href='cate3.php';</script>";
			}
				
		}
		
    }else if($depth==2){
		
		$csql="select count(*) from cate_3rd where parent='$no'";
        $crst=mysql_query($csql);
        $crst=mysql_fetch_row($crst);
		if($crst[0]>=1){
        	echo "<script>alert('하위 3차 카테고리가 존재하므로 삭제가 불가합니다.');location.href='cate3.php';</script>";
        }else{	
			$sql="delete from cate_2nd where parent='$p' and no='$no'";
			$rst=mysql_query($sql);
			
			if($rst){
				echo "<script>alert('2차 카테고리 삭제완료!');location.href='cate3.php';</script>";
			}
		}

    }else if($depth==3){
		
		$sql="delete from cate_3rd where parent='$p' and no='$no'";
		$rst=mysql_query($sql);
		
		if($rst){
			echo "<script>alert('3차 카테고리 삭제완료!');location.href='cate3.php';</script>";
		}

    }
	
	
}

?>