<?php
	require_once "twitteroauth/twitteroauth.php";
	                        
	define("CONSUMER_KEY", "BqPB4jmgB4xOwm9p3yqmCg");
	define("CONSUMER_SECRET", "x0T5X0hUxvlAVV0U0QHOt2YWXaf4Copav1KEUTOgq0Q");
	define("OAUTH_TOKEN", "14769591-cfEJTlLVLMH6725WYsk1LIxJlmHFVLSsHV5FauF8o");
	define("OAUTH_SECRET", "feJSFnJ4JsTgk6432z6JxeOXkGNy3EC0T8x101bPN4");
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
	$content = $connection->get('account/verify_credentials');
	$connection->post('statuses/update', array('status' => str_replace('\\','',$_REQUEST['msg'])  ));
?>