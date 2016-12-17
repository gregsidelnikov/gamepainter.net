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
<meta property="fb:admins" content="gregsidelnikov"/>
<script src = 'js/jquery.js' type = 'text/javascript'></script>
<script src = 'js/ui.js' type = 'text/javascript'></script>
<?php /* <script src = 'js/script.js' type = 'text/javascript'></script> */ ?>
<link rel = 'stylesheet' type = 'text/css' href = 'http://www.gamepainter.net/css/style.css' />
    <script type = "text/javascript">
        /* Create global website's object */
        window.w = 0; // responsive width
        window.website = new Object();
		website.url = '<?php print $URL; ?>';
        website.img_dir_name = 'Images';
        website.bs_ip = '65.24.43.194';
        website.this_ip = '2600:3c01::f03c:91ff:feae:69f9';
        website.admin = 0;</script>
	<script src = 'js/script.js' type = 'text/javascript'></script>
    <script type = "text/javascript">
        /* Custom JavaScript */
    </script>
<style type="text/css">
	#username {
		text-transform: lowercase;
	}
</style>
<?php /* ?><base href = "http://www.gamepainter.net" target="_blank"> <?php */ ?>
</head>
    <script type = "text/javascript">
		/* Template custom parameters */
    </script>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type = "text/javascript">

    </script>
    <style type = "text/css">

    body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; background: #f1f1f1; }
    #Header { height: 48px; background: #fff; border-bottom: 1px solid #e8e8e8; }
    .GameInfo { margin: 16px; margin-bottom: 8px; width: 200px; height: 190px; border: 0; float: left; }
    #MenuOptions { width: 500px; margin: auto; }
    .MenuOption { width: 75px; height: 28px; line-height: 24px; float: left; margin-left: 10px; margin-right: 10px; text-align: center; }
    .MenuOption { border-bottom: 3px solid #ddd; cursor: pointer; }
    .MenuOption.Selected { border-bottom: 3px solid #a1dc00; }
	.gamedesc { font-size: 11px; position: relative; font-family: Arial, sans-serif; }
	.gameinfo { font-size: 11px;  }
	.GameInfo a { color: #2388de; text-decoration: none; }
	#Navigation { background: white; width: 100%; height: 31px; margin: 0 auto; position: relative; padding-top: 8px; }
	.gamestat { margin-top: 3px; font-size: 11px; font-family: Arial; color: #777; }
    #GameList { position: relative;  margin: 32px; height: auto; background: #fff; }

	#Sidebar { display: none; }
	.sb-opt { cursor: pointer; padding: 5px; height: 30px; line-height: 32px; border-bottom: 1px solid #ddd; color: gray; }
	.sb-opt:hover { background: #555; color: white; }

	body.Sidebar #GameList { margin-left: 200px; }
	body.Sidebar #Sidebar { display: block !important; }

	#Footer a { color: gray; }

	.icon { display: inline-block; width: 16px; height: 16px; border: 1px solid #ddd; vertical-align: middle; margin-top:-3px; margin-left: 6px; margin-right: 8px; }

	a { color: #2388de;  }

	#CreateGame { position: relative; width: 650px; margin: 32px auto; height: auto; background: #fff; }

	#Login { position: relative; width: 650px; margin: 32px auto; height: auto; background: #fff; }

	#LaunchGamePainter { position: relative; width: 650px; margin: 32px auto; height: auto; background: #fff; }

	.block { padding: 16px; }
	.block-100 { width: 100px; display: inline-block; }
	.block-500 { width: 450px; display: inline-block; }

	.MenuOption:hover { border-bottom: 3px #a1dc00 solid; }

		#Register, #CreateGame, #Login, #LaunchGamePainter { display:none; }

    </style>
</head>
<body>
	<div id = "Header">
	    <img src = "http://www.gamepainter.net/grid.png" alt = "menu" onclick = "ToggleSidebar()" style = "cursor: pointer;" />
        <img src = "http://www.gamepainter.net/game-painter-logo.png" style = "margin-top: 5px;" alt = "Game Painter Logo"/>
		<img src = "http://www.gamepainter.net/userpic.png" alt = "user" style = "opacity: 0.5; position: absolute; top: 11px; right: 10px; border: 2px solid #333; border-radius: 777px;" />
		<div style = "position: absolute; top: 20px; right: 50px; width: auto; text-align: right;"><b style = "color:#88c000;" id = "loggedin_status"></b> <span id = "loggedin_email"></span></div>
	</div>

	<div id = "Navigation">
		<div style = "width: 600px; margin: 0 auto">
			<div id = "browse"   ui = "#GameList"   class = "MenuOption Selected" onclick = "view(this)">Browse</div>
			<div id = "create"   ui = "#CreateGame"   class = "MenuOption" style = "min-width: 120px;" onclick = "view(this);">Create New Game</div>
			<div id = "register" ui = "#Register" class = "MenuOption" style = "width: 65px;" onclick = "view(this)">Register</div>
			<div id = "login"    ui = "#Login"    class = "MenuOption" style = "width: 65px;" onclick = "view(this)">Login</div>
		</div>
	</div>

	<div id = "Sidebar" style = "position: absolute; top: 89px; left: 0; width: 180px; height: 100%; background: white;">
		<div class = "sb-opt" onclick = "location.href='<?php print $URL; ?>'"><div class = "icon"></div> Home</div>
		<div class = "sb-opt"><div class = "icon"></div> My Games</div>
		<div class = "sb-opt"><div class = "icon"></div> Analytics</div>
		<div class = "sb-opt"><div class = "icon"></div> Contact</div>
		<div class = "sb-opt" onclick = "LogOut()" id = "logout_button"><div class = "icon"></div> <b>Log Out</b></div>
	</div>

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

	<div id = "CreateGame">

		<div class = "block">
			<b>Register Free Game Painter Account</b>
		</div>

		<div class = "block">
			<p>To start making games you need a Game Painter account. This will enable you to:</p>
			<ul>
				<li>Use Game Painter software to make your game right in your browser.</li>
				<li>Publish your game for free at <span style = "color: gray">http://www.gamepainter.com/<b>jkD35sfai</b></span> (unique game identifier)</li>
				<li>Compete with other game developers, receive feedback from players and share your game with friends!</li>
			</ul>

		</div>

		<div class = "block">
			<div class = "block-100">Email Address</div>
			<div class = "block-500"><input type = "text" name = "email" id = "email_address" /></div>
		</div>

		<div class = "block">
			<div class = "block-100">Username</div>
			<div class = "block-500"><input type = "text" name = "username" id = "username"/></div>
		</div>

		<div class = "block">
			<div class = "block-100">Password</div>
			<div class = "block-500"><input type = "password" id = "password"/></div>
		</div>

		<div class = "block">
			<div class = "block-100">Password Again</div>
			<div class = "block-500"><input type = "password" id = "password2"/></div>
		</div>

		<div class = "block">
			<p id = "msg">Status of your registration: awaiting information.</p>
		</div>

		<div class = "block">
			<div class = "block-100"></div>
			<div class = "block-500"><input type = "button" value = "Register" onclick = "RegisterUser()" id = "register_button"/></div>
		</div>

	</div>

	<div id = "GameList">
		<div style = "padding: 16px;"><b>Game Painter</b> is free online 2D game maker software that you can use to <a href = "#">create your own game</a>, share it with your friends or browse and play games created by others.</div>
		<div class = "GameInfo">
			<img src = "http://www.gamepainter.net/make-game.png" alt = "Add Game - Make Your Own Game" onclick = "CreateGame();"/>
			<?php /* <b><a href = "http://www.gamepainter.net/fFJKHD86vh2461">Make Your Own Game</a></b> */ ?>
			<div class = "gamedesc">Create your own 2D game, publish it for free on Game Painter and invite friends to play it.</div>
			<div class = "gamestat">0 plays - now</div>
		</div>
		<?php include("gameblock.php"); ?>
		<?php include("gameblock.php"); ?>
		<?php include("gameblock.php"); ?>
		<div style = "clear: both"></div>
	</div>

	<div id = "Footer" style = "text-align: center; font-size: 11px; color: gray;">
		<p>&copy; 2016 Game Painter, developed by <a href = "http://www.tigrisgames.com/" title = "indepedenent game development studio">Tigris Games</a></p>
		<p>Contact: <input type = "text" value = "dev@tigrisgames.com" onclick = "this.select();" style = "background: #f1f1f1; border: 1px solid #ddd; padding-left: 4px; height: 14px; font-size: 11px;"/></p>
	</div>

</body>
</html>