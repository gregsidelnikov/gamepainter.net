<?php

    include("../../Migration/Composition.php");

    error_reporting(0);

    function write_file($content, $fn) {
        global $FILESYSTEM, $LOCALHOST;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $XF = $FILESYSTEM . "//" . $fn; else $XF = $FILESYSTEM . "/" . $fn;
        $f = fopen($XF, 'w+') or die("fopen: can't open file [content] [$XF]");
        if (fwrite($f, $content) != FALSE) {
            print "fwrite: success - file written!<br/>";
        }
        fclose($f);
    }

    $error_reporting = $_REQUEST["error_reporting"];
    $localhost_dir = $_REQUEST["localhost_dir"];
    $url = $_REQUEST["url"];
    $production_url = $_REQUEST["production_url"];
    $localhost_apache_path = $_REQUEST["localhost_apache_path"];
    $website_name = $_REQUEST["website_name"];
    $website_description = $_REQUEST["website_description"];
    $doctype = $_REQUEST["doctype"];
    $charset = $_REQUEST["charset"];
    $timezone       = $_REQUEST["timezone"];
    $production_cookie_root  = $_REQUEST["production_cookie_root"];
    $default_subscribers_list_id  = $_REQUEST["default_subscriber_list_id"];
    $paypal_email_address  = $_REQUEST["paypal_email_address"];
    $image_dir_name  = $_REQUEST["image_dir_name"];
    $template_dir_name    = $_REQUEST["template_dir_name"];
    $newsletter_name    = $_REQUEST["newsletter_name"];
    $language_locale    = $_REQUEST["language_locale"];
    $sitemap_xml    = $_REQUEST["sitemap_xml"];
    $admin_ip      = $_REQUEST["admin_ip"];
    $google_search_engine_id  = $_REQUEST["google_search_engine_id"];
    $google_analytics_id   = $_REQUEST["google_analytics_id"];
    $google_webmaster_veri   = $_REQUEST["google_webmaster_veri"];
    $google_plus_profile_id   = $_REQUEST["google_plus_profile_id"];
    $google_plus_profile_url  = $_REQUEST["google_plus_profile_url"];
    $facebook_username     = $_REQUEST["facebook_username"];
    $twitter_username     = $_REQUEST["twitter_username"];

    $content =
    '<?php
    $ERROR_REPORTING = '.$error_reporting.';
    error_reporting($ERROR_REPORTING);//E_ALL);//E_ALL); //0); //E_ALL);
	$LOCALHOST       = false;
    $LOCALHOST_DIR   = "'.$localhost_dir.'";
	$MOBILE_DEVICE   = false; // This page is being displayed on a mobile device (subdomained as: \'m.url.com\')
	$PRODUCTION_URL  = "'.$production_url.'";
	$URL             = "'.$url.'";
    $LOCALHOST_APACHE= "'.$localhost_apache_path.'";
    $WEBSITE_NAME    = "'.$website_name.'";
    $WEBSITE_DESCRIPTION = "'.$website_description.'";
    $WEBSITE_DOCTYPE = "'.$doctype.'";             // page doctype
    $WEBSITE_CHARSET = "'.$charset.'";                       // page charset
    $TIMEZONE = "'.$timezone.'";
    date_default_timezone_set($TIMEZONE);
    $FILESYSTEM = "";
	if (preg_match("/localhost/", $_SERVER["HTTP_HOST"]) > 0) {
	    $LOCALHOST   = true;
	    $TRACK_GOOGLE_ANALYTICS = false;
	    $FILESYSTEM  ="'.$localhost_apache_path.'"; // __your__ Apache path
	    $URL = "http://localhost/$LOCALHOST_DIR";
    } else {
        $URL = $PRODUCTION_URL; // Resurrect production URL
        $FILESYSTEM = str_replace("/Migration", "", dirname(__FILE__));     // Linux
    }
    // Cookie URL path
    !$LOCALHOST ? $COOKIE_URL = "'.$production_cookie_root.'" : $COOKIE_URL = "localhost";
    $INCLUDE_AMAZON_LINKS   = false;                    // Default... must be turned on in Index.php file for that page (generally, articles only)
    $REMOVE_ADSENSE = true;                             // Hide all adsense blocks from the entire site
    $DYNAMIC_STYLE_SHEETS = false;                      // Alternate CSS Stylesheets (more than one, for one page)
    $DEFAULT_SUBSCRIBER_LIST_ID = "'.$default_subscribers_list_id.'";                // KaleidoscopeGames.net -- game newsletter list id
    // Needed for PayPal shopping cart
    $PAYPAL_EMAIL_ADDRESS = "'.$paypal_email_address.'";
    $IMAGE_DIR_NAME = "'.$image_dir_name.'";                         // Global image directory
    $TEMPLATE_DIR_NAME = "'.$template_dir_name.'";                   // Global template directory
    $NEWSLETTER_NAME = "'.$newsletter_name.'";
    $LOCALE_ABBR = "'.$language_locale.'";                             // en is the default language locale
    $SITEMAP_XML     = "'.$sitemap_xml.'";                   // Sitemap for using with Google Webmaster Tools, leave it alone
    $INCLUDE_AMAZON_LINKS   = false;                    // Default... must be turned on in Index.php file for that page (generally, articles only)
    $BLACK_SHEEP_IP = "'.$admin_ip.'";				    // trim($_SERVER[\'REMOTE_ADDR\']); //"12";//trim($_SERVER[\'REMOTE_ADDR\']); //"67.169.73.142"; // Prevent showing ads to yourself
    $REMOVE_ADSENSE = true;                             // Hide all adsense blocks from the entire site
    $DYNAMIC_STYLE_SHEETS = false;                      // Alternate CSS Stylesheets (more than one, for one page)
    $GOOGLE_SEARCH_ENGINE_ID = "'.$google_search_engine_id.'";                      // "004219325633306575865:fvjtkxrkbs0"; // Google custom search engine unique ID
    $GOOGLE_ANALYTICS_ID = "'.$google_analytics_id.'";              // Google Analytics tracker ID
    $GOOGLE_WEBMASTER_VERI = "'.$google_webmaster_veri.'"; // Webmaster tools verification code
    /* Website Social Identity */
    $GOOGLE_PLUS_PROFILE_ID = "'.$google_plus_profile_id.'";
    $GOOGLE_PLUS_PROFILE_URL = "'.$google_plus_profile_url.'";
    $FACEBOOK_USERNAME = "'.$facebook_username.'";
    $TWITTER_USERNAME = "'.$twitter_username.'"; // Twitter account associated with the website
    /* Libs */
    include("Database.php");                                            // Database logins
    include($FILESYSTEM . "/Lib/function.FavIcon.php");                 // Favicon definition
    include($FILESYSTEM . "/Lib/function.Image.php");                   // Used by class.MysqlDatabase.php
    include($FILESYSTEM . "/Lib/function.JSON.php");                    // There is no json lib in PHP5, attempt to rewrite json funcs!
    include($FILESYSTEM . "/Lib/function.Database.php");                // Used by class.MysqlDatabase.php
    include($FILESYSTEM . "/Lib/function.Session.php");
    include($FILESYSTEM . "/Classes/class.HTML.php");            // Page contruction classes
    include($FILESYSTEM . "/Classes/class.Page.php");
    include($FILESYSTEM . "/Classes/class.MysqlDatabase.php");   // Enable MySQL database library
    ?>';    

    error_reporting(E_ALL);

    $WRITE_FILE = "/Migration/Composition.php";

    //shell_exec("sudo chmod 777 $WRITE_FILE");

    //shell_exec("sudo chmod 777 +s /home/gregsidelnikov/public/kaleidoscope.net/public/admin");    

    //if (chmod($WRITE_FILE, 0777))
    //{

    //}
    //else
    //{
        //print "cmod failed to set permission to $WRITE_FILE";
    //}


    write_file($content, $WRITE_FILE);

?>