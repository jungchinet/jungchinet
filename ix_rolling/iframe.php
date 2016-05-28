<?php
$template = htmlspecialchars(!empty($_GET['template'])? $_GET['template']:'twitter');
$keyword = htmlspecialchars(!empty($_GET['keyword'])? $_GET['keyword']:'KPOP,KARA,Tara');

$use_profile_img = htmlspecialchars(!empty($_GET['use_profile_img']) && $_GET['use_profile_img']=='true'? 'true':'false');
$count = (int) htmlspecialchars(!empty($_GET['count'])? $_GET['count']:400);


$_GET['width'] = '100%';
$_GET['height'] = '100%';

function ix_rolling($settings){
	static $_options = array(
		'template',
		'keyword',
		'width',
		'height',
		'bo_table',
		'count',
		'use_profile_img',
		'g4_path',
		'ix_path',
		'time',
		'url',
		'cut_text',
		'where',
		'where_id',
		'userid',
		'screen_name'
	);
	$script = '
jQuery(function() {
	jQuery("#ix-rolling").ix_rolling(
	{
		';
	$options = array();
	foreach($settings as $k=>$v){
		if(in_array($k,$_options)){
			if($v=='true' || $v=='false' || is_numeric($v)){
				$options[] = $k.' : '.$v.'';
			}else{
				$options[] = $k.' : "'.addSlashes($v).'"';
			}
		}
	}
	$script .= join(",\r\n\t\t",$options);
	$script .= '
	});
});';
return $script;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>IX Rolling</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="./ix_rolling.css" type="text/css" />
		<style type="text/css">
			/*<![CDATA[*/
			html {width:100%;height:100%;padding:0;margin:0;}
			body{background-color:#fff;height:100%;width:100%;padding:0;margin:0;overflow:hidden}
			/*]]>*/
		</style>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="./ix_rolling-latest.js"></script>
		<script type="text/javascript">
			/*<![CDATA[*/
			jQuery(function() {
				<?php echo ix_rolling($_GET);?>
			});
			/*]]>*/
		</script>
	</head>
	<body>
		<div style="width:99%;height:99%">
		<div id="ix-rolling" class="ix-rolling"></div>
		</div>
	</body>
</html>
