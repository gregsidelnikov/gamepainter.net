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

    <script type = "text/javascript">
        var GameManager = function()
        {
            // Main game object
            this.state = -1;				// Game state; 0=main menu
            this.score = 0;					// Game score
            this.lives = 3;					// Lives left
            this.level = 1;					// Current level
            this.resourcesLoaded = false;   // Check if graphics (png) resources have finished loading
        };
        var game = new GameManager();
    </script>

    <!-- tig game engine library //-->
    <script src = "Tig_jsGE/utility.js?v=2" type = "text/javascript"></script>
    <script src = "Tig_jsGE/canvas.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/animate.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/spritesheet.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/sprite.js?v=10" type = "text/javascript"></script>
    <script src = "Tig_jsGE/sound.js?v=14" type = "text/javascript"></script>
    <script src = "Tig_jsGE/world.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/point.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/vector.js" type = "text/javascript"></script>
    <script src = "Tig_jsGE/segment.js?v=3" type = "text/javascript"></script>
    <script src = "Tig_jsGE/circle.js?v=3" type = "text/javascript"></script>
    <script src = "Tig_jsGE/rectangle.js?v=1" type = "text/javascript"></script>
    <script src = 'Tig_jsGE/triangle.js' type = 'text/javascript'></script>
    <script src = "Tig_jsGE/orientation.js?v=2" type = "text/javascript"></script>
    <script src = "Tig_jsGE/keyboard.js?v=2" type = "text/javascript"></script>
    <script src = "Tig_jsGE/mouse.js?v=4" type = "text/javascript"></script>
    <script src = "Tig_jsGE/touch.js?v=4" type = "text/javascript"></script>
    <script src = "Tig_jsGE/press.js?v=1" type = "text/javascript"></script>
    <script src = "Tig_jsGE/bullet.js?v=2" type = "text/javascript"></script>
    <script src = "Tig_jsGE/starfield.js?v=1" type = "text/javascript"></script>
    <script src = "Tig_jsGE/text.js?v=1" type = "text/javascript"></script>
    <script src = 'Tig_jsGE/register.js' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/grid.js?v=2' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/toolbox.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/box.js' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/player.js?v=5' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/rain.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/celestial.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/timeline.js' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/dust.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/bubble.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/enemy.js?v=1' type = 'text/javascript'></script>
    <script src = 'Tig_jsGE/textarea.js?v=1' type = 'text/javascript'></script>
    <link rel = 'stylesheet' type = 'text/css' href = 'gamepainter.css' />

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

    </script>
</head>
    <style type = "text/css">
		/* custom css */
    </style>
<link rel="stylesheet" type="text/css" title="bright" href="<?php print $URL; ?>/css/style.css">
<link rel="alternate stylesheet" type="text/css" title="dark" href="<?php print $URL; ?>/css/dark.css">
</head>
<body>

	<?php include("header.php"); ?>

    <?php include("paint.php"); ?>

	<?php include("navigation.php"); ?>

	<?php include("sidebar.php"); ?>

	<?php include("login.php"); ?>

	<?php include("launchgp.php"); ?>

	<?php include("registeraccount.php"); ?>

    <div id = "GameList" class = "Brightest">
        <div style = "padding: 16px;"><b>Welcome to Game Painter</b></div>
    </div>

	<?php include("gamelist.php"); ?>

	<?php include("footer.php"); ?>

</body>
</html>