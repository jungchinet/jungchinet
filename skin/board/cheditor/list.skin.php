<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 7;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>

// image를 cdn에 올려둔 경우에는 해당 cdn의 url 주소를 적어주면 됩니다.
// $board_skin_path = "http://echo4me.imagetong.com/gnuboard4/skin/board/cheditor"

//보드 설정에서 동네이름 가져오기
$asql="select bo_1 from g4_board where bo_table='$_GET[bo_table]'";
$rst=mysql_query($asql);
$myarea=mysql_fetch_object($rst);;
$myarea=explode(",", $myarea->bo_1);

$prSql=mysql_query("select * from prem_config");
$premConfig=mysql_fetch_array($prSql);


//3단카테 시작
$grInfo=mysql_fetch_array(mysql_query("select gr_id from g4_board where bo_table='$bo_table' limit 1"));

if($grInfo[gr_id]=='premium'){
		
	$brdCate=mysql_fetch_row(mysql_query("select bo_category_list from g4_board where gr_id='$grInfo[gr_id]' and (bo_category_list IS NOT NULL or bo_category_list <> '') limit 1"));	
	$bcData=explode('|', $brdCate[0]);
	$bcNum=count($bcData);
	
	if($bcNum>0) $allCnt=0;

		
}else{

	if(!$sca){
		$brdCate=mysql_fetch_row(mysql_query("select bo_category_list from g4_board where gr_id='$grInfo[gr_id]' and (bo_category_list IS NOT NULL or bo_category_list <> '') limit 1"));	
		$bcData=explode('|', $brdCate[0]);
		$bcNum=count($bcData);
	}else{
		$hcate=$sca;
		$bcData[0]=$hcate;
		$bcNum=1;	
	}
		
	$allCnt=0;
	$cate9="<select id='cate3s' name='wr_5' onchange='myCate(this.value)' style='font-size:8pt;'>";
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
						
						}
						
					}
					
				}
				
			}
			
		}
			
	}
	$cate9.="</select>";
}
//3단카테 끝

//rss 설정에 의한 원글링크 및 새창 띄우기
$rsql="select * from rss_info where bo_table='$bo_table' and idx=999"; //원글링크
$rsql2="select * from rss_info where bo_table='$bo_table' and idx=997"; //새창
$rst=sql_fetch($rsql);
$rst2=sql_fetch($rsql2);
$r_ori=$rst['rss_addr'];
$r_new=$rst2['rss_addr'];


//카테고리별 새글
$cates=@explode('|',$board[bo_category_list]);
$catesCnt=count($cates);
$c_today=date('Y-m-d');

$ccnt=array();
$ccnt_total=0;
for($cts=0;$cts<$catesCnt;$cts++){

	$cntsql="select count(*) cnt from g4_write_".$bo_table." where wr_is_comment = 0 and ca_name='{$cates[$cts]}' and substring(wr_datetime,1,10)='$c_today'";
	$cntRst=sql_fetch($cntsql);
	$ccnt[$cts]=$cntRst['cnt'];
	//$ccnt_total+=$cntRst['cnt'];

}




if($allCnt){
	$colspan++;	
}

?>
<style>
.list_tr:hover{background-color:#f5f5f5;}
</style>
<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0>
<tr><td>

<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
<table><tr><td height="5px"></td></tr></table>
<table width="100%" cellspacing="0" cellpadding="0">
<tr height="25">
    <td width=40><? include("$g4[bbs_path]/my_menu_add_script.php");?></td>
    <td align=left>&nbsp;게시판 : <b><?=$board[bo_subject]?></b></td>
    <td align=right><? if($board[bo_rtlink]){ echo $board[bo_rtlink]; } ?></td>
    <table><tr><td height="6px"></td></tr></table>
    <? if ($is_category) { ?> 
  <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr> 
  <td width="100%" height="36" align=left cellpadding="0" cellspcing="0"> 
  <table width="100%" align="center" cellpadding="0" cellspacing="0" >
  <tr><td width="40" height="36" align=center style="padding:10 0 6 0;border-bottom-left-radius: 10px;  border-top-left-radius: 10px; border-top-width:1; border-right-width:0; border-bottom-width:1; border-left-width:1; border-color:rgb(216,216,216); border-style:solid;" bgcolor="F6F6F6">
  <?echo $bb_s;?><a href='./board.php?bo_table=<?=$bo_table?>&page=<?=$page?>#board'><span class=L_Tcategory><b>전체</b></span></a><?=$bb_e?> 
  </td>
  <td width='' height="36" align=left style="padding:10 0 6 6;  border-bottom-right-radius: 10px;  border-top-right-radius: 10px;border-top-width:1; border-right-width:1; border-bottom-width:1; border-left-width:0; border-color:rgb(216,216,216); border-style:solid;">
  <? {
  //echo "<table width='100%' cellpadding='0' cellspacing='0' style='margin:0 0 0 0;border:solid #55cc55 1px;'>"; //★ (카테고리목록의 테이블 길이를 100%로 할 경우)
  echo "<table cellpadding='20' cellspacing='' style='padding:0px 5px 0px 0px;'>"; //◆
   
  $ca_menu = explode("|",$board[bo_category_list]); 
  $ca_td_num = "10"; //가로칸수. 원하는 칸수만큼 지정해주면 됩니다. 
  //$ca_td_width = 100 / $ca_td_num ; //★ <td width='%'>값

   
  for ($c=0, $cnt=count($ca_menu); $c<$cnt; $c++) {
  $cccnt='';
  if (($c == "0") || (($c >= $ca_td_num) && ($c % $ca_td_num == "0"))) { echo "<tr>"; } 
  echo "<td>"; //★
  //echo "<td width='".$ca_td_width."0%'>"; //★
  //echo "<td style='padding:2 4 2 4;'>· "; //◆
   
  //★표와 ◆표는 어느 한쪽을 쓸 경우 다른 쪽을 주석처리하면 됩니다.
  if($ccnt[$c]>0){
  	$cccnt="<span style='font-size:8pt;font-weight:bold;color:#cf184c;'>(".$ccnt[$c].")</spsan>";
  }
   
  if ($sca == $ca_menu[$c]) { $bcoral = "<b style='color:coral'>"; } else { $bcoral = ""; }
  $sqlCnum = " select count(*) as Cnum from $write_table where wr_is_comment = 0 and ca_name = '$ca_menu[$c]'"; 
  $rowCnum = sql_fetch($sqlCnum);
  echo " <a href='".$g4['bbs_path']."/board.php?bo_table=".$bo_table."&sca=".urlencode($ca_menu[$c])."#board'>";
  echo $bcoral.$ca_menu[$c]."$cccnt</a>"; 
  echo "</td>"; 
  }
  if($c==9){
  	echo '</td>';
  }
  echo "</tr></table>"; 
  } ?>
  </td> 
  </tr>
  </table>
  </td>
  </tr>
  <tr><td colspan=<?=$colspan?> height=2></td></tr>
  </table>
  <? } ?> 

<table><tr><td height="10px"></td></tr></table>

<!-- 제목 -->
<form name="fboardlist" method="post" style="margin:0px;">
<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
<input type='hidden' name='sfl'  value='<?=$sfl?>'>
<input type='hidden' name='stx'  value='<?=$stx?>'>
<input type='hidden' name='spt'  value='<?=$spt?>'>
<input type='hidden' name='page' value='<?=$page?>'>
<input type='hidden' name='sw'   value=''>
<input type='hidden' name='sca'   value=''>
<?
  	$bInfo=mysql_fetch_array(mysql_query("select gr_id from g4_board where bo_table='$_GET[bo_table]' limit 1"));
?>
<style>
.myarea {font-size:8pt;}
</style>
<script>
function myArea(area){
	location.href="./board.php?bo_table=<?=$bo_table?>&sca=<?=$sca?>&area="+area+"&cate3=<?=$cate3?>#board";
}

function myCate(cate){
	location.href="./board.php?bo_table=<?=$bo_table?>&sca=<?=$sca?>&area=<?=$area?>&cate3="+cate+"#board";
}

</script>
<style>
.cates {
	float:left;
	margin-left:10px;	
}
</style>
<!--div id='cate1' class='cates'></div><div id='cate2' class='cates'></div><div id='cate3' class='cates'></div-->
<!--div id='cate9' class='cates' style='margin-left:0;'><select name='wr_5' onchange='myCate(this.value)'><option value='0'>선택하세요</option></select></div-->
<div style='clear:both'>
<? if($allCnt){ ?>
<div id='cate9' class='cates' style='margin-left:0;'>
	<?=$cate9;?>
</div>
<? } ?>

<? if(count($myarea)>1){ ?>
<div id='area' class='cates' style='margin-left:0;'>
<select name="wr_1" class='myarea' onchange='myArea(this.value)'>
	<option value=''>대상전체</option>
	<?
    for($c=0;$c<count($myarea);$c++){
		$myArea=trim($myarea[$c]);
		if($area==$myArea){ $selected='selected'; }else{ $selected=''; }
		echo "<option value='$myArea' $selected>$myArea</option>";
		
	}
	?>
</select>
</div>
<? } ?>

</div>

<table width=100% border="0" cellpadding=0 cellspacing="0">
<tr>
    <td height=2 style="background:#d5d5d5;"></td>
    <? if ($is_checkbox) { ?><td style="background:#d5d5d5;"></td><?}?>
    <td style="background:#d5d5d5;"></td>
    <td style="background:#d5d5d5;"></td>
    <td style="background:#d5d5d5;"></td>
    <td style="background:#d5d5d5;"></td>
    <? if($allCnt){ ?><td style="background:#d5d5d5;"></td><? } ?>
    <? if(count($myarea)>1){ ?><td style="background:#d5d5d5;"></td><? } ?>
    <? if ($is_good) { ?><td style="background:#d5d5d5;"></td><?}?>
    <? if ($is_nogood) { ?><td style="background:#d5d5d5;"></td><?}?>
</tr>
<tr height=28 align=center>
    <td width=50><?=subject_sort_link('wr_id', $qstr2, 1)?>번호</a></td>
    <?/* if ($is_category) { ?><td width=70>분류</td><?}*/?>
    <? if ($is_checkbox) { ?><td width=40><INPUT onclick="if (this.checked) all_checked(true); else all_checked(false);" type=checkbox></td><?}?>
   <td>제목</td>
   <td width=50>글쓴이</td>
   <td width=80>카테고리</td>
   <!--<? if($allCnt){ ?>
   <td width=80>카테고리</td>
   <? } ?>!-->
   <? if(count($myarea)>1){ ?>
   <td width=100>대상</td>
   <? } ?>
    <td width=40><?=subject_sort_link('wr_datetime', $qstr2, 1)?>날짜</a> <!--<?=subject_sort_link('wr_last', $qstr2, 1)?>U</a>--!></td>
    <td width=30><?=subject_sort_link('wr_hit', $qstr2, 1)?>조회</a></td>
    <?/*?><td width=40 title='마지막 코멘트 쓴 시간'><?=subject_sort_link('wr_last', $qstr2, 1)?>최근</a></td><?*/?>
    <? if ($is_good) { ?><td width=40><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></td><?}?>
    <? if ($is_nogood) { ?><td width=40><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></td><?}?>
</tr>
<tr><td colspan=<?=$colspan?> height=3 style="background:url(<?=$board_skin_path?>/img/title_bg.gif) repeat-x;"></td></tr>

<!-- 목록 -->
<?
//공지사항 체크용 임시변수
$n_arr=array();
?>
<? for ($i=0; $i<count($list); $i++) {

 //이 글이 프리미엄인가아아...
 $ip_sql="select count(prem_wr_id) from prem_info where del_date='0000-00-00 00:00:00' and prem_board='$bo_table' and prem_wr_id='{$list[$i][wr_id]}' and now() between prem_date and exp_date";
 $rst=mysql_query($ip_sql);
 $ip_data=mysql_fetch_row($rst);

			//현재 글의 wr_id 저장
			if(in_array($list[$i][wr_id], $n_chk)){
				if(in_array($list[$i][wr_id], $n_arr)){
					continue;	//저장된 글번호와 현재 글번호가 같으면!! 이미 출력 된놈이니껜.. continue~
				}else{
					$n_arr[]=$list[$i][wr_id];	//중복되지 않으면 다시 글번호 저장하고 패스~
				}
			}
			if($list[$i][is_notice] and ($list[$i][ca_name]!=$_GET[sca])){
					continue;
			}
if(!$list[$i][wr_singo] or ($list[$i][wr_singo]<$board[bo_singo_action])){
?>
<tr height=28 align=center class='list_tr'> 
    <td>
        <? 
			if ($list[$i][is_notice]) // 공지사항 이면 마크표시
				echo "<img src=\"$board_skin_path/img/icon_notice.gif\" alt='notice'>";
			else if ($wr_id == $list[$i][wr_id]) // 현재위치 게시물번호
				echo "<span style='font:bold 11px tahoma; color:#E15916;'>{$list[$i][num]}</span>";
			else
				echo "<span style='font:normal 11px tahoma; color:#BABABA;'>{$list[$i][num]}</span>";
        ?></td>
    <?/* if ($is_category) { ?><td><a href="<?=$list[$i][ca_name_href]?>"><span class=small style='color:#BABABA;'><?=$list[$i][ca_name]?></span></a></td><? } */?>
    <? if($ip_data[0]==1 and $is_admin!='super'){ $dis='disabled=disabled'; } ?>
    <? if ($is_checkbox) { ?><td><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>" <?=$dis?>></td><? } ?>
    <td align=left style='word-break:break-all;'>
    
        <? 
			echo "<nobr style='display:block; overflow:hidden; width:350px;'>";
			echo $list[$i][reply];
			echo $list[$i][icon_reply];
			if ($list[$i][comment_cnt]) 
				echo " <a href=\"{$list[$i][comment_href]}&area=$area&cate3=$cate3#board\"><span style='font-family:Tahoma;font-size:10px;color:#EE5A00;'>{$list[$i][comment_cnt]}</span></a>";
	
			// if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
			// if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }
	
			echo " " . $list[$i][icon_new];
		   // echo " " . $list[$i][icon_file];
		   // echo " " . $list[$i][icon_link];
			if (!$list[$i][is_notice]) {
	
			echo " " . $list[$i][icon_hot];
			}
			echo " " . $list[$i][icon_secret];
			/* if ($is_category && $list[$i][ca_name]) { 
				echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
			} */
			$style = "";
			if ($list[$i][is_notice] and ($list[$i][ca_name]==$_GET[sca])) $style .= " style='font-weight:bold;'";
			if ($list[$i][wr_singo]) $style .= '';//" style='color:#B8B8B8;'";


			//원글 링크 여부..
			if($r_ori==1 and $list[$i][wr_10]==1){
				$r_link=$list[$i][wr_link1];
			}else{
				$r_link=$list[$i][href]."&area=$area&cate3=$cate3#board";
			}

			//새창 띄우기 여부..
			if($r_new==1 and $list[$i][wr_10]==1){
				$nWin="target='_blank'";
			}else{
				$nWin='';
			}
	
			echo "<a href='{$r_link}' $style ".$nWin.">";
			echo stripslashes($list[$i][subject]);
			echo "</a>";
	
			
			echo $nobr_end;
        ?></td>
    
    <td><nobr style='display:block; overflow:hidden; width:105px;'><?=$list[$i][name]?></nobr></td>
    
    
    
    <td>
    <?
    
	$sCate=explode('|', $list[$i][wr_5]);
	$sCateNum=count($sCate);
	
	if(empty($list[$i][wr_5])){
	
		echo $list[$i][ca_name];
		
	}else if($sCateNum==3){
		
		$data=mysql_fetch_array(mysql_query("select name from cate_3rd where no='$sCate[2]'"));
		echo $data[name];
		$data[name]='';
		
	}else if($sCateNum==2){
		
		$data=mysql_fetch_array(mysql_query("select name from cate_2nd where no='$sCate[1]'"));
		echo $data[name];
		$data[name]='';
	
	}else if($sCateNum==1){
		
		$data=mysql_fetch_array(mysql_query("select name from cate_1st where no='$sCate[0]'"));
		echo $data[name];
		$data[name]='';
	
	}
	
	?>
    </td>
    
    
    <? if(count($myarea)>1){ //지역 ?>
    <td><? if($list[$i][wr_1]){ echo $list[$i][wr_1]; }else{ echo '전체'; } ?></td>
    <? } ?>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][datetime2]?></span></td>
    <td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_hit]?></span></td>
    <?/*?><td><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][last2]?></span></td><?*/?>
    <? if ($is_good) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_good]?></span></td><? } ?>
    <? if ($is_nogood) { ?><td align="center"><span style='font:normal 11px tahoma; color:#BABABA;'><?=$list[$i][wr_nogood]?></span></td><? } ?>
</tr>
<tr><td colspan=<?=$colspan?> height=1 bgcolor=#E7E7E7></td></tr>
<?}}?>

<? if (count($list) == 0) { echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>"; } ?>
<tr><td colspan=<?=$colspan?> style="background:#d5d5d5;" height="2"></td></tr>
</table>
</form>

<!-- 페이지 -->
<table width="100%" cellspacing="0" cellpadding="0">
<tr> 
    <td width="100%" align="center" height=30 valign=bottom>
        <? if ($prev_part_href) { echo "<a href='{$prev_part_href}&area={$area}'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색' alt='prev search'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#000000\">$1</font></b>", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font style=\"font-family:tahoma; font-size:11px; color:#E15916;\">$1</font></b>", $write_pages);
        ?>
        <?=$write_pages?>
        <? if ($next_part_href) { echo "<a href='{$next_part_href}&area={$area}'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
    </td>
</tr>
</table>

<!-- 링크 버튼, 검색 -->
<form name=fsearch method=get style="margin:0px;" action="<?=$_SERVER['REQUEST_URI']?>#board">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=sca      value="<?=$sca?>">
<table width=100% cellpadding=0 cellspacing=0>
<tr> 
    <td width="70%" height="40">
        <? if ($list_href) { ?><a href="<?=$list_href?>#board"><img src="<?=$board_skin_path?>/img/btn_list.gif" border="0" alt='list'></a><? } ?>
        <? if ($write_href) { ?><a href="<?=$write_href?>#board"><img src="<?=$board_skin_path?>/img/btn_write.gif" border="0" alt='write'></a><? } ?>
        <? if ($is_checkbox) { ?>
            <? if($is_admin=='super' or ($is_admin=='board' and $premConfig[modiFlag])){ ?>
            	<a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" border="0" alt='delete'></a>
                <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" border="0" alt='copy'></a>
                <a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" border="0" alt='move'></a>
				<? if ($is_category) { ?>
                <a href="javascript:select_category();"><img src="<?=$board_skin_path?>/img/btn_select_category.gif" border="0" alt='select'></a>
                <select name=sca2><?=$category_option?></select>
                <? } ?>
                <a href="javascript:getRss();"><img src="<?=$board_skin_path?>/img/btn_getRss.jpg" border="0" alt='getRss'></a>
            <? } ?>
        <? } ?>
    </td>
    <td width="50%" align="right">
        <select name=sfl>
            <option value='wr_subject'>제목</option>
            <option value='wr_content'>내용</option>
            <option value='wr_subject||wr_content'>제목+내용</option>
            <option value='mb_id,1'>회원아이디</option>
            <option value='mb_id,0'>회원아이디(코)</option>
            <option value='wr_name,1'>이름</option>
            <option value='wr_name,0'>이름(코)</option>
        </select><input name=stx maxlength=15 size=10 itemname="검색어" required value='<?=stripslashes($stx)?>'><select name=sop>
            <option value=and>and</option>
            <option value=or>or</option>
        </select>
        <input type=image src="<?=$board_skin_path?>/img/search_btn.gif" border=0 align=absmiddle></td>
</tr>
</table>
</form>
<tr><td>
<? //include_once("$g4[path]/adsense_page_bottom2.php");
if(!$wr_id){
	include_once("$g4[path]/prem_top.php");
}else{
	include_once("$g4[path]/prem_bottom.php");
}
?>
</td></tr>
<tr><td height=10>
</td></tr>
</td></tr></table>


<script language="JavaScript">
/*
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';
    document.fsearch.sop.value = '<?=$sop?>';
}*/
</script>


<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";
                       
    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}

// 선택한 게시물 카테고리를 변경
function select_category() {
    var f = document.fboardlist;
    var f2 = document.fsearch;

    str = "카테고리변경";
    if (!check_confirm(str))
        return;

    str = f2.sca2.value;
    if (!confirm("선택한 게시물의 카테고리를 "+str+" 으로 변경 하시겠습니까?"))
        return;

    // sca에 값을 넣어줘야죠.
    f.sca.value = str;

    f.action = "./category_all.php";
    f.submit();
}

function getRss(){
	$.post( "/rss_proc/getRss.php", { bid: "<?=$bo_table?>", adm: "ok" })
		.done(function( data ) {
			if(data>0){
				alert( "총 "+data+"건의 RSS 리딩이 끝났습니다." );
			}else{
				alert('새로 수집된 내용이 없습니다.'+data);
			}
			location.reload();
	});
}
</script>
<? } ?>

<? if ($board[bo_hot_list]) { ?> 

<table width="100%" cellspacing="0"  cellpadding="0">
<tr><td> 

<? echo db_cache("popular_".$bo_table, 3600, "latest_popular('thumb',$bo_table, 5, 70, '', 3)"); ?> 

</td></tr> 

<tr height=5><td></td></tr> 

</table> 

<? } ?>  

<iframe src='/rss_proc/getRss.php?bid=<?=$_GET['bo_table']?>' style='display:none;'></iframe>

<!-- 게시판 목록 끝 -->
