<?php
if (!defined("_GNUBOARD_"))
	exit ;
// 개별 페이지 접근 불가
require_once $g4['path']."/ix_uploader/iu.gnu4.php";
$_options = array();
if($options){
	parse_str($options,$_options);
}
if(empty($_options['width'])){
	$_options['width'] = 350;
}
if(empty($_options['height'])){
	$_options['height'] = 150;
}
$class = "";
if(!empty($_options['content'])){
	$class=" ix-with-content";
}

$id = $bo_table.md5($options);
?>
<div class="ix-inline-title">
    <a href='<?=$g4[bbs_path] ?>/board.php?bo_table=<?=$bo_table ?>'><?=$board[bo_subject] ?></a>
    <span class="more"><a href='<?=$g4[bbs_path] ?>/board.php?bo_table=<?=$bo_table ?>'><img src='<?=$latest_skin_path ?>/img/more.gif' border=0></a></span>
</div>
<?php if(count($list) > 0):?>
	<?php if(empty($GLOBALS['ix_rolling_loaded'])):?>
	<style type="text/css">
		@import "<?=$g4['url'];?>/ix_rolling/ix_rolling.css";
		.ix-inline.ix-rolling {
			border: none !important
		}
		.ix-inline-title{position:relative;height:32px;background-color:#fff;font-weight:bold;vertical-align: middle;line-height:32px;padding-left:8px;
			border-bottom:2px #ddd solid;
			color:#000
		}
		.ix-inline-title span.more{position: absolute;right:4px;font-weight:normal}
		div.ix-inline.ix-with-content div.ix-item-title{
			text-overflow:hidden;white-space:nowrap
		}
		div.ix-inline.ix-with-content div.ix-item-title a{
			font-weight:bold;
		}
		.ix-inline.ix-rolling div.content{padding-left:8px;color:#666;border-top:1px #ddd dotted;padding-top:2px;
			word-break:break-all}
		.ix-inline.ix-rolling div.content img.thumb{
			width:50px;height:50px;
		}
	</style>
	<script src="<?=$g4['path'];?>/ix_rolling/ix_rolling-latest.js"></script>
	<?php endif;?>
<div id="<?=$id;?>" class="ix-inline ix-rolling<?=$class;?>">
	<ul>
	<?php for ($i=0; $i<count($list); $i++) { ?>
	    <li><div class="ix-item-title"><?php
		echo ' · ';
		echo date("m-d",strtotime($list[$i]['wr_datetime']));
		
		echo " <a href='{$list[$i]['href']}'>";
		if ($list[$i]['is_notice'])
			echo "{$list[$i]['subject']}";
		else
			echo "{$list[$i]['subject']}";
		echo "</a></div>";

		if ($list[$i]['comment_cnt'])
			echo " <a href=\"{$list[$i]['comment_href']}\"><span style='font-family:돋움; font-size:8pt; color:#9A9A9A;'>{$list[$i]['comment_cnt']}</span></a>";

		echo " " . $list[$i]['icon_new'];
		echo " " . $list[$i]['icon_file'];
		echo " " . $list[$i]['icon_link'];
		echo " " . $list[$i]['icon_hot'];
		echo " " . $list[$i]['icon_secret'];
		if(!empty($_options['content'])){
			$src = null;
			if(!empty($_options['thumb'])){
				$src = IU_Gnu4::getThumbSrcTable($bo_table,$list[$i]['wr_id']);
			}
			echo '<div class="content">';
			if($src){
				echo '<img src="'.$src.'" class="thumb" align="left"/>';
			}
			echo cut_str(strip_tags($list[$i]['wr_content']),240).'</div>';
		}
	    ?>
	    </li>      
	<?php } ?>
	<ul>
</div>
<script>
	jQuery(function() {
		jQuery("#<?=$id;?>").ix_rolling({
			template : "inline",
			width:"<?=$_options['width'];?>",
			height : "<?=$_options['height'];?>"
		});
	});

</script>	
<?php else: ?>
<font color=#6A6A6A>게시물이 없습니다.</a>
<?php endif; ?>

<?php
$GLOBALS['ix_rolling_loaded'] = true;
?>