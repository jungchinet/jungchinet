<?
include_once('_common.php');
include 'head2.php';
?>

<style>
@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
.adsWrap {
	width:746px;
	margin:10px 0px 10px 0px;
}
.adsImg {
	width:125px;
	height:200px;
	overflow:hidden;
	float:left;
	cursor:pointer;
}
.spacer1 {
	width:0px;
	margin:15px;	
	float:left;
}
.spacer2 {
	width:0px;
	margin:15.5px;	
	float:left;
}
.brrer {
	clear:both;	
}
.adsTitle{
	width:95%;
	text-align:center;
	color:#999;
	margin-top:4px;
	overflow:hidden;	
}
.cnum1{
	font-size:8pt;
	color:blue;
}
.cnum2{
	font-size:8pt;
	color:red;
}
.prem_all_top {
	margin:10px 0px 20px 0px;
	font-size:40px;
	color:#05a8f1;
	font-family:"Nanum Gothic";
	text-align:center;
	width:100%;
}
a:link, a:hover, a:visited, a:active {
	color:#05a8f1;
	font-family:"Nanum Gothic";
	text-decoration:none;
}
.gg:link, .gg:hover, .gg:visited, .gg:active{
	color:#000;	
	text-decoration:none;
}
</style>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
function gogo(num, e){
	var e = e || window.event;
    var btnCode;
	
	if ('object' === typeof e) {
        btnCode = e.button;
		
		switch(btnCode){
			case(0):
				location.href='<?=$g4[path]?>/bbs/board.php?bo_table=<?=$bo_table?>&wr_id='+num;
				break;
			case(1):
				var open=window.open('about:blank');
				open.location.href='<?=$g4[path]?>/bbs/board.php?bo_table=<?=$bo_table?>&wr_id='+num;
				break;
		}
	}	
}
</script>
<?
$sssql="select bo_subject, bo_category_list from g4_board where bo_table='$bo_table'";
$ssrst=mysql_query($sssql);
$ssdata=mysql_fetch_row($ssrst);
?>
<div class='prem_all_top'>
<a href='./bbs/board.php?bo_table=<?=$bo_table?>'><strong><?=$ssdata[0]?> 게시판</strong></a>
</div>
<?

$aller=explode('|', trim($ssdata[1]));

$anum=count($aller);
for($d=0;$d<$anum;$d++){
		
        /*
		//echo '<div style=\'clear:both\'>';
		$sql="select * from cate_1st a, g4_write_$bo_table b where b.ca_name='$aller[$d]' and b.wr_5=a.no order by a.rank asc";
		//echo '</div>';
		$rst=mysql_query($sql);
		
		$w5l='0,';
		while($l=mysql_fetch_array($rst)){
			$w5l.=$l[no].',';
		}
		$w5l=substr($w5l, 0, -1);
		
		$lsql="select wr_id from g4_write_$bo_table where wr_5 in ($w5l)";
		$lrst=mysql_query($lsql);
		$wrid='';
		while($b=mysql_fetch_array($lrst)){
			$wrid.=$b[wr_id].',';
		}
		$wrid=substr($wrid, 0, -1);
        */
		
		$sql="select no, name from cate_1st where hcate='$aller[$d]'";
		$rst=mysql_query($sql);
		$w5l='0,';
		while($g=mysql_fetch_array($rst)){
			//echo $g[name].'<br>';
			//$w5l.=$l[no].',';
		
		//$w5l=substr($w5l, 0, -1);
		
		
			$sql="select distinct a.prem_board, a.prem_wr_id from prem_info a, g4_write_".$bo_table." b, cate_1st c where a.del_date='0000-00-00 00:00:00' and a.prem_board='$bo_table' and now() between a.prem_date and a.exp_date and a.prem_wr_id=b.wr_id and c.no='$g[no]' and b.wr_5=c.no order by rand()";
			$prem_rst=mysql_query($sql);
			$prem_num=mysql_num_rows($prem_rst);
			
			if($prem_num){
				
				echo "<div class='adsWrap' style='width:100%;clear:both;'>";
				echo "<div style='font-size:32px;color:#000;text-align:center;width:100%;font-family:\"Nanum Gothic\";margin-bottom:15px;font-weight:bold;'><!--a href='/bbs/board.php?bo_table=".$bo_table."&area=".$aller[$d]."' class='gg'-->".$g[name]."<!--/a--></div>";
					
				while($r=mysql_fetch_array($prem_rst)){
					$prem_sql1="select bf_file from g4_board_file where bo_table='$r[prem_board]' and wr_id='$r[prem_wr_id]' and wr_id='$r[prem_wr_id]' and bf_no='0'";
					$prem_rst1=mysql_query($prem_sql1);
					$prem_k1=mysql_fetch_array($prem_rst1);
					
					$prem_sql2="select wr_subject, wr_1 from g4_write_{$r[prem_board]} where wr_id='$r[prem_wr_id]'";
					$prem_rst2=mysql_query($prem_sql2);
					$prem_k2=mysql_fetch_array($prem_rst2);
					
					$prem_sql3="select count(*) from g4_write_{$r[prem_board]} where wr_is_comment='1' and wr_parent='$r[prem_wr_id]'";
					$prem_rst3=mysql_query($prem_sql3);
					$prem_num=mysql_fetch_row($prem_rst3);
					if($prem_num[0]>0){
						if($prem_num[0]<100){
							$cclass='cnum1';	
						}else{
							$cclass='cnum2';
						}
						$cnum=' <span class=\''.$cclass.'\'>('.$prem_num[0].')</span>';
					}else{
						$cnum='';
					}
					
					if(is_file(($g4[path].'/data/file/'.$bo_table.'/'.$prem_k1[bf_file]))==true){
						$prem_width=125;
						$prem_height=125;
						$prem_qual=80;
						$ha=explode('/', $prem_k1[bf_file]);
						thumbnail($g4[path].'/data/file/'.$bo_table.'/'.$prem_k1[bf_file], $prem_width, $prem_height, $is_create=false, $is_crop=2, $prem_qual, $small_thumb=1, $watermark="", $filter="", $noimg="", $thumb_type="");
						$img_path=$g4[path].'/data/file/'.$bo_table.'/'.$ha[0].'/_thumb/'.$prem_width.'x'.$prem_height.'_'.$prem_qual.'/'.$ha[1];
						$img_title=$prem_k2[wr_subject];
						$amo=0;	
					}else{
						//$img_path=$g4[path].'/images/def.gif';
						//$img_title='등록된 이미지가 없습니다.';
						$img_path=$g4[path].'/images/def.gif';
						$img_title='등록된 이미지가 없습니다.';
						$amo=1;
					}
					
					if(!$prem_k2[wr_1]){ $prem_k2[wr_1]='지역전체'; }
					
					if($prem_num!=$z){
						/*echo "<div class='adsImg' onclick='gogo($r[prem_wr_id], this.value)' value='$r[prem_wr_id]'>";
						echo "<img src='$img_path' width='125' height='125' alt='$img_title' />";
						echo "<div class='adsTitle'><strong>".$prem_k2[wr_1]."</strong><br><div style='padding-top:5px;'>".cut_str($prem_k2[wr_subject], 65, '..')."{$cnum}</div></div>";
						echo "</div>";*/
						echo "<div class='adsImg'>";
						echo "<a href='$g4[path]/bbs/board.php?bo_table=$bo_table&wr_id=$r[prem_wr_id]'><img src='$img_path' width='125' height='125' alt='$img_title' /></a>";
						echo "<div class='adsTitle'><strong>".$prem_k2[wr_1]."</strong><br><div style='padding-top:5px;'>".cut_str($prem_k2[wr_subject], 65, '..')."{$cnum}</div></div>";
						echo "</div>";
						
						if($z%6<5){
							echo "<div class='spacer1'></div>";
						}else if($z%6==0){
							echo "<div class='spacer2'></div>";
							echo "<div class='brrer'></div>";
						}
					}
				}
				echo "</div>";
			}//echo "</div>";echo "</div>";
		
		} //end of first while
		
}

include '_tail.php';

?>