<?php
    
    /*  Pre-configuration
    	if (file_exists('config/index.php')) { include("config/index.php"); exit; } */

    $ERROR_REPORTING = E_ALL;
    error_reporting(0); // $ERROR_REPORTING);
	$LOCALHOST       = false;
	$MOBILE_DEVICE   = false; // This page is being displayed on a mobile device (subdomained as: 'm.url.com')

	$DOMAIN_NAME = $WEBSITE_URL_NAME = $WEBSITE_URL	
	
	/*** Replace with your own domain name ***/
	
		= "www.learnjquery.org";	 
		
	/*** --------------------------------- ***/
		
	$PRODUCTION_URL = $URL = "http://" . $DOMAIN_NAME;								// Production URL for A-href links, incl. http://
    $SERVER_PATH = "/var/www/" . str_replace("www.", "", $DOMAIN_NAME) . "/"; 		// Path to the site's root folder -- must have trailing "/"
    
    $WEBSITE_NAME    = "---";
    $WEBSITE_DESCRIPTION = "---";
    $WEBSITE_DOCTYPE = "<!doctype html>";             		// page doctype
    $WEBSITE_CHARSET = "utf-8";                       		// page charset
    $TIMEZONE = "America/New_York";
    date_default_timezone_set($TIMEZONE);
    $FILESYSTEM = "";
	if (preg_match("/localhost/", $_SERVER["HTTP_HOST"]) > 0) {
	    $LOCALHOST   = true;
	    $TRACK_GOOGLE_ANALYTICS = false;      
	    // Windows:
	    $FILESYSTEM  ="C://Program Files (x86)//Apache Software Foundation//Apache2.2//htdocs//---"; // __your__ Apache path
	    $URL = "http://localhost/$LOCALHOST_DIR";
	    // Mac: 
   	    //$FILESYSTEM = "/Users/gsidelnikov/Sites/bladerunner";
   	    //$URL = "http://localhost/~gsidelnikov/bladerunner";
    } else {
        $URL = $PRODUCTION_URL; // Resurrect production URL
        $FILESYSTEM = str_replace("/Migration", "", dirname(__FILE__));     // Linux
    }
    
    !$LOCALHOST ? $COOKIE_URL = "localhost" : $COOKIE_URL = "localhost"; // Cookie URL path
    $INCLUDE_AMAZON_LINKS   = false;                    // Default... must be turned on in Index.php file for that page (generally, articles only)
    $REMOVE_ADSENSE = true;                             // Hide all adsense blocks from the entire site
    $DYNAMIC_STYLE_SHEETS = false;                      // Alternate CSS Stylesheets (more than one, for one page)
    $DEFAULT_SUBSCRIBER_LIST_ID = "25";                // seahorse -- newsletter list id
    
    /* Needed for PayPal shopping cart */
    $PAYPAL_EMAIL_ADDRESS = "---@gmail.com";
    $IMAGE_DIR_NAME = "Images";                         // Global image directory
    $TEMPLATE_DIR_NAME = "Templates";                   // Global website template directory
    
    $LOCALE_ABBR = "en-US";                             // en is the default language locale
    $SITEMAP_XML     = "news.xml";                   // Sitemap for using with Google Webmaster Tools, leave it alone
    $INCLUDE_AMAZON_LINKS   = false;                    // Default... must be turned on in Index.php file for that page (generally, articles only)
    $BLACK_SHEEP_IP = "65.24.43.194";				    // trim($_SERVER['REMOTE_ADDR']); //"12";//trim($_SERVER['REMOTE_ADDR']); //"67.169.73.142"; // Prevent showing ads to yourself
    $REMOVE_ADSENSE = true;                             // Hide all adsense blocks from the entire site
    $DYNAMIC_STYLE_SHEETS = false;                      // Alternate CSS Stylesheets (more than one, for one page)
    $GOOGLE_SEARCH_ENGINE_ID = "---";                   // Google custom search engine unique ID
    $GOOGLE_ANALYTICS_ID = "UA-xxxxxx-xx";              // Google Analytics tracker ID
    $GOOGLE_WEBMASTER_VERI = "---"; // Webmaster tools verification code

    /* Website Social Identity */
    $GOOGLE_PLUS_PROFILE_ID = "---";
    $GOOGLE_PLUS_PROFILE_URL = "https://plus.google.com/u/0/---";
    $FACEBOOK_USERNAME = "";
    $TWITTER_USERNAME = ""; // Twitter account associated with the website
    
    /* Libs */    
    include("Database.php");                                            // Database logins
	include("Newsletter.php");											// Newsletter emails...
    include($FILESYSTEM . "/Lib/function.FavIcon.php");                 // Favicon definition
    include($FILESYSTEM . "/Lib/function.Image.php");                   // Used by class.MysqlDatabase.php
    include($FILESYSTEM . "/Lib/function.JSON.php");                    // There is no json lib in PHP5, attempt to rewrite json funcs!
    include($FILESYSTEM . "/Lib/function.Database.php");                // Used by class.MysqlDatabase.php
    include($FILESYSTEM . "/Lib/function.Session.php");
    include($FILESYSTEM . "/Classes/class.HTML.php");            // Page contruction classes
    include($FILESYSTEM . "/Classes/class.Page.php");
    include($FILESYSTEM . "/Classes/class.MysqlDatabase.php");   // Enable MySQL database library

?>