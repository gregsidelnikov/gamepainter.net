<?php include("Migration/Composition.php"); ?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Game Painter - Free Online Game Maker Software - No Download</title>
<?php /* <link rel = "icon" href = "http://www.gamepainter.net/favicon.gif" /> */ ?>
<META http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<META name = "description" content = "Welcome to Game Painter - The Official Game Maker software, there is no download because it's written in JavaScript language. Make games right in the browser."/>
<META name = "keywords" content = "game,maker,software,tool,free,no,download,browser,js,javascript,tutorials"/>
<meta name="language" content="">
<meta http-equiv="content-language" content="en-US" />
<meta name="verify-v1" content="---" /> <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta property="og:title" content="GamePainter.net - free online game maker software tool no download"/>
<?php /* <meta property="og:type" content="article"/>
<meta property="og:url" content="http://www.learnjquery.org/homepage/draft-dge1380.0162756006573.html"/>
<meta property="og:image" content="http://www.learnjquery.org/Images/tutorial-article.png"/>
<meta property="og:site_name" content=""/> */ ?>
<meta property="fb:admins" content="gregsidelnikov" />
<script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/hashids.min.js' type = 'text/javascript'></script>
<?php /* <script src = 'js/script.js' type = 'text/javascript'></script> */ ?>
<link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/css/style.css' />
    <script type = "text/javascript">
        /* Create global website's object */
        window.w = 0; // responsive width
        window.website = new Object();
		website.url = '<?php print $URL; ?>';
        website.img_dir_name = 'Images';
        website.bs_ip = '65.24.43.194';
        website.this_ip = '2600:3c01::f03c:91ff:feae:69f9';
        website.admin = 0;</script>
	<script src = '<?php print $URL; ?>/js/script.js' type = 'text/javascript'></script>
    <script type = "text/javascript">
        /* custom javascript */
    </script>
</head>
    <style type = "text/css">
		/* custom css */
    </style>
</head>
<body>

	<?php include("header.php"); ?>

	<?php include("navigation.php"); ?>

	<?php include("sidebar.php"); ?>

	<div id = "Login">

		<div class = "block">
			<b>Login To Your Game Painter Account</b>
		</div>

		<div class = "block">
			<p>You must be logged in to start making games with Game Painter.</p>
			<ul>
				<li>Use Game Painter software to make your game right in your browser.</li>
				<li>Publish your game for free at <span style = "color: gray">http://www.gamepainter.com/<b>jkD35sfai</b></span> (unique game identifier)</li>
				<li>Compete with other game developers, receive feedback from players and share your game with friends!</li>
			</ul>

		</div>

		<div class = "block">
			<div class = "block-100">Email Address</div>
			<div class = "block-500"><input type = "text" name = "email" id = "login_email_address" /></div>
		</div>

		<div class = "block">
			<div class = "block-100">Password</div>
			<div class = "block-500"><input type = "password" name = "login_password" id = "login_password"/></div>
		</div>

		<div class = "block">
			<p id = "msg">Your login status: enter information above to sign in.</p>
		</div>

		<div class = "block">
			<div class = "block-100"></div>
			<div class = "block-500"><input type = "button" value = "Sign In" onclick = "SignIn()" id = "signin_button"/></div>
		</div>

	</div>

	<div id = "LaunchGamePainter">
		<div class = "block">
			<b>Launch Game Painter</b>
		</div>
		<div class = "block">
			<p>Looks like you're already logged into your account. This means you're ready to start using Game painter! So go make games and have fun.</p>
		</div>
	</div>

	<?php include("registeraccount.php"); ?>

	<?php include("gamelist.php"); ?>

	<div id = "Footer" style = "text-align: center; font-size: 11px; color: gray;">
		<p>&copy; 2016 Game Painter, developed by <a href = "http://www.tigrisgames.com/" title = "indepedenent game development studio">Tigris Games</a></p>
		<p>Contact: <input type = "text" value = "dev@tigrisgames.com" onclick = "this.select();" style = "background: #f1f1f1; border: 1px solid #ddd; padding-left: 4px; height: 14px; font-size: 11px;"/></p>
	</div>

</body>
</html>