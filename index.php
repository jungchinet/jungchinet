<?
include_once("./_common.php");

//로그인 여부 파악 후 페이징
if($is_member){
   echo "<script>location.href='$g4[path]/menuhtml/logout/login.php';</script>";
	$goPath="$g4[path]/menuhtml/logout/login.php";
    }
	
	else{
	echo "<script>location.href='$g4[path]/menuhtml/logout/login.php';</script>";
	$goPath="$g4[path]/menuhtml/logout/login.php";
}
                
                

?>
