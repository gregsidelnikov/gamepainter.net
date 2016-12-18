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
        function switch_style(css_title) {
            var i, link_tag;
            for (i = 0, link_tag = document.getElementsByTagName("link"); i < link_tag.length ; i++ ) {
                if ((link_tag[i].rel.indexOf( "stylesheet" ) != -1) && link_tag[i].title) {
                    link_tag[i].disabled = true;
                    if (link_tag[i].title == css_title) {
                        link_tag[i].disabled = false;
                        console.log("setting stylesheet to " + css_title);
                        localStorage.setItem("stylesheet", css_title);
                        if (css_title == "dark") {
                            $(".Brightest").css( { "background" : "#000000" } );
                        }
                    }
                }
            }
        }
        function set_style_from_localStorage() {
            var css_title = localStorage.getItem("stylesheet");
            if (css_title.length) {
                console.log("css_title = " + css_title);
                switch_style(css_title);
            }
        }
        $(window).on("load", function(){ set_style_from_localStorage(); });
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

	<?php include("navigation.php"); ?>

	<?php include("sidebar.php"); ?>

	<?php include("login.php"); ?>

	<?php include("launchgp.php"); ?>

	<?php include("registeraccount.php"); ?>

	<?php include("gamelist.php"); ?>

	<?php include("footer.php"); ?>

</body>
</html>