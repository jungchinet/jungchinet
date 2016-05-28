<link rel="stylesheet" href="<?php echo $g4['path']?>/twitter_search/css/style.css">
<link rel="stylesheet" href="<?php echo $g4['path']?>/twitter_search/font-awesome/css/font-awesome.min.css">

<?php if($stx) { ?>
<div id="twitter_box">
	<div class="redo">
		<div style="float:left; color:#55acee">
			<i class="fa fa-twitter fa-3x"></i> &nbsp;
			<span class="sword">검색어 : <?php echo $stx?></span>
		</div>
		<div style="float:right">
			<a href="javascript:document.location.reload()">새로고침 <i class="fa fa-repeat fa-lg"></i></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="list_wrap">
		<div id="tweets_box">
		</div>
		<p id="no_tweet" style="display:none; text-align:center"><i class="fa fa-exclamation-circle"></i> 검색된 트윗이 없습니다.</p>
		<div id="tweets_loading">
			<img src="/twitter_search/img/loading.gif" alt="">
		</div>
		<button class="load-more" style="display:none">더 보기</button>
	</div>
</div>
<br><br><br>
<script>
var searchString = "<?php echo $stx?>";
var next_results = '';
var next_max_id = '';
</script>
<script type="text/javascript" src="<?php echo $g4['path']?>/twitter_search/js/init.js"></script>
<script type="text/javascript" src="<?php echo $g4['path']?>/twitter_search/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php echo $g4['path']?>/twitter_search/js/jquery.easing.1.3.js"></script>
<?php } ?>
