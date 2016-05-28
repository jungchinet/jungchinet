<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

global $is_admin;
?>

<div class="section_ul" style='border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border:1px solid #ddd;'>
<ul style='text-align:left;margin-left: 5px;margin-top: 12px;'>
	<li><span class="bu"></span> 오늘 <span><?=number_format($visit[1])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if ($is_admin == "super") { ?><a href="<?=$g4['admin_path']?>/visit_list.php"><img src="<?=$visit_skin_path?>/img/admin.gif" width="25" height="15" border="0" align="absmiddle"></a><?}?></span></li>
	<li><span class="bu"></span> 어제 <span><?=number_format($visit[2])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	<li><span class="bu"></span> 최대 <span><?=number_format($visit[3])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	<li><span class="bu"></span> 전체 <span><?=number_format($visit[4])?></span></li>
</li>
</ul>
</div>
