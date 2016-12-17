<?php
	require_once "twitteroauth/twitteroauth.php";
	                        
	define("CONSUMER_KEY", "0N38KMeER6nBMUjXlhOLwg");
	define("CONSUMER_SECRET", "EI30CfuoUugsdp3udaHPOQZaFdRoUl4fXUau3PclGss");
	define("OAUTH_TOKEN", "441271748-SPTNn3OU8jUZM1sHga5wZr8Uas01WxQg9UVz115x");
	define("OAUTH_SECRET", "ovOnj3N2HEn5dN6UVwd0N3kakVSilodwwhGG1xBu8");
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
	$content = $connection->get('account/verify_credentials');
	$res = $connection->post('statuses/update', array('status' => str_replace('\\','', str_replace('&gt;', '>', str_replace('&lt;', '<', $_REQUEST['msg']))) ));
?>