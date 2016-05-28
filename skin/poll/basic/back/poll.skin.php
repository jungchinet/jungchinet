<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<link rel="stylesheet" href="<?=$poll_skin_path?>/style.css" type="text/css">

<script>
function polling(value){
	document.getElementById('gb_poll').value=value;
	document.fpoll.submit();
}
</script>

<!--새창 띄우지 않기 위한 hidden frame-->
<iframe src='about:blank' name='hdn' frame='0' frameborder='0' style='width:0px;height:0px;display:none'></iframe>

<div class="section_ol" style='padding:0;margin-bottom:0px;'>
<!--form name="fpoll" method="post" action="<?=$g4[bbs_path]?>/poll_update.php" onsubmit="return fpoll_submit(this);" target="winPoll" 원본살리기-->
<form name="fpoll" method="post" action="<?=$g4[bbs_path]?>/poll_update.php" onsubmit="return fpoll_submit(this);" target="hdn">
<input type="hidden" name="po_id" value="<?=$po_id?>">
<input type="hidden" name="skin_dir" value="<?=$skin_dir?>">
<input type="hidden" name="gb_poll" id="gb_poll" value="">

<!--
<h2><a style="text-decoration:none" href='#' title='<?=$po[po_summary]?>'><?=$po[po_subject]?></a></h2>
-->
<h2 title='<?=$po[po_summary]?>'><?=$po[po_subject]?></h2>
<!--ol style='text-align:left;margin-left:30px;'><li 기존소스 보존 131120 서승천-->
<ol style='margin:2px;'><li><table width='100%' cellspacing='0' border='0'><tr>
    <? 
    /*
        echo "<li>";
        echo "<span>";
        echo "<input type='radio' name='gb_poll' value='$i' id='gb_poll_$i'>";
        echo "<label for='gb_poll_$i'>" . $po['po_poll'.$i] . "</label>";
        echo "</span>";
        echo "</li>";
    }*/
	//총 카운트
	$total_cnt=0;
	for($z=1;$z<=9;$z++){
		$total_cnt+=$po['po_cnt'.$z];
	}
	
	//%계산을 위한...
	$perc=100/$total_cnt;
	
	//각 선택옵션의 배경색상을 배열로 초기화... 순서대로 할당..
	//색상은 관리자페이지의 투표 개요창에 #을 포함한 16진수 색상값을 입력하며 '|'로 구분한다.
	if($po[po_summary]){
		$scolor=explode('|', $po[po_summary]);
	}else{
		$scolor = array("#ffa200", "#4cadff", "#aaea58", "#ff76b6", "#fffa73", "#c994ff", "#94ffef", "#ff836a", "#d1d1d1");
	}
	
	$num=0;
	for ($i=1; $i<=9 && $po["po_poll{$i}"]; $i++) {
		
		$c=$i-1;
		$g='po_cnt'.$i;
		$percent=round($perc*$po['po_cnt'.$i], 1);
		
		//echo "<td width='50%' style='height:70px;background-color:$scolor[$c];cursor:pointer;color:#ffffff' id='gb_poll_$i' onclick='polling($i);submit()' align='center' valign='middle'><a href='#' onclick='polling($i);submit()'><span onclick='polling($i);submit()' >" . $po['po_poll'.$i] . "</span><br><span style='font-size:15pt;font-weight:bold;' onclick='polling($i);submit()' >".$percent."%</span><br><span style='font-size:.5em;'>(".$po['po_cnt'.$i]."표)</span></a></td>";
		
		echo "<td width='50%' style='height:70px;background-color:$scolor[$c];cursor:pointer;color:#ffffff' id='gb_poll_$i' align='center' valign='middle' onclick='polling($i);'>" . $po['po_poll'.$i] . "<br><span style='font-size:15pt;font-weight:bold;'>".$percent."</span><span style='font-size:8pt;'>%</span><br><span style='font-size:.5em;'>(".$po['po_cnt'.$i]."표)</span></td>";
		echo $p[$g];
		$num++;
		
		if($num==2){
			echo "</tr><tr>";
			$num=0;
		}		
	}
    ?></tr></table></li>
    <!--li style='text-align:center;'>
        <? if ($po_use) { ?>
        <!--input type="image" src="<?=$poll_skin_path?>/img/poll_button.gif" width="70" height="25" border="0"-->
        <? } ?>
        <!--a href="javascript:;" onclick="poll_result('<?=$po_id?>');"><img src="<?=$poll_skin_path?>/img/poll_view.gif" width="70" height="25" border="0"></a>
        <? if ($is_adminn == "super") { ?><a href="<?=$g4[admin_path]?>/poll_form.php?w=u&po_id=<?=$po_id?>"><img src="<?=$poll_skin_path?>/img/admin.gif" width="33" height="15" border=0 align=absmiddle></a><? } ?>
    </li-->
</ol>

</form>
</div>

<script type="text/javascript">
function fpoll_submit(f)
{	
    /*var chk = false;
    for (i=0; i<f.gb_poll.length;i ++) {
        if (f.gb_poll[i].checked == true) {
            chk = f.gb_poll[i].value;
            break;
        }
    }*/

    <?
    if ($member[mb_level] < $po[po_level])
        echo " alert('$po[gl_name] 이상의 회원만 투표에 참여하실 수 있습니다.'); return false; ";
    ?>

    /*if (!chk) {
        alert("항목을 선택하세요");
        return false;
    }*/

    win_poll();
    return true;
}

function poll_result(po_id)
{
    <?
    if ($member[mb_level] < $po[po_level])
        echo " alert('$po[gl_name] 이상의 회원만 결과를 보실 수 있습니다.'); return false; ";
    ?>

    win_poll("../bbs/poll_result.php?po_id="+po_id+"&skin_dir="+document.fpoll.skin_dir.value);
}
</script>
