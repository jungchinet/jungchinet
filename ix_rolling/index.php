<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>IX Rolling</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Description" name="Description" content="twitter api rolling ix rolling facebook rss">
		<link rel="stylesheet" href="./ix_rolling.min.css" type="text/css">
		<script src="http://code.jquery.com/jquery-1.7.1.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="./ix_rolling-latest.js?ver=0.7" charset="utf-8"></script>
	</head>
	<body>

<?
/*
function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken("75257164-vkwqUANcY4i0vQxVIedC52D2NY7Fa4rE7TfjEKakU", "VUZXcIPGnbNjw7BkVaxtNq8oWYskMYkLgzBdwugyZXLev");
$content = $connection->get("statuses/user_timeline");
*/
?>

		<div id="wrap">
			<div id="container">
				IX rolling - jQuery SNS rolling plugin examples
				<table>
					<tr>
						<td valign="top"><div id="ix-rolling" class="ix-rolling"></div></td>
						<td valign="top"><div id="ix-rolling11" class="ix-rolling"></div></td>
						<td valign="top"><div id="ix-rolling1" class="ix-rolling"></div></td>
					</tr>
					<tr>
						<td valign="top"><div id="ix-rolling2" class="ix-rolling"></div></td>
						<td valign="top"><div id="ix-rolling22" class="ix-rolling"></div></td>
						<td valign="top"><div id="ix-rolling222" class="ix-rolling"></div></td>
					</tr>
				</table>
				<script type="text/javascript">
					var ix_path = ".";
					jQuery(function() {
						jQuery("#ix-rolling").ix_rolling({
							template : "twitter",
							keyword : "KARA",
							width : 300,
							height : 300,
							use_profile_img : true,
							ix_path : ix_path
						});
						jQuery("#ix-rolling11").ix_rolling({
							template : "xml",
							url : "http://rss.ohmynews.com/rss/top.xml",
							width : 300,
							height : 300,
							use_profile_img : true,
							ix_path : ix_path
						});
						jQuery("#ix-rolling1").ix_rolling({
							template : 'facebook',
							where:"page",
							where_id : "165106760172502",
							width : 300,
							height : 300,
							ix_path : ix_path,
							cut_text : 140
						});

						jQuery("#ix-rolling2").ix_rolling({
							template : 'youtube',
							width : 300,
							height : 300,
							userid : 'officialpsy',
							cut_text : 140
						});

						jQuery("#ix-rolling22").ix_rolling({
							template : 'twitter',
							width : 300,
							height : 300,
							screen_name : 'kalcapt',
							cut_text : 140
						});
						jQuery("#ix-rolling222").ix_rolling({
							template : 'twitter',
							width : 300,
							height : 300,
							screen_name : 'oisoo',
							cut_text : 140
						});
					});

				</script>
			</div>
		</div>
	</body>
</html>
