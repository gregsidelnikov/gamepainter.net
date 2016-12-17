<?php

    include("../../Migration/Composition.php");

class Browser { 
    /** 
    Figure out what browser is used, its version and the platform it is 
    running on. 

    The following code was ported in part from JQuery v1.3.1 
    */ 
    public static function detect() { 
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari. 
        if (preg_match('/opera/', $userAgent)) { 
            $name = 'opera'; 
        } 
        elseif (preg_match('/chrome/', $userAgent)) { 
            $name = 'chrome'; 
        } 
        elseif (preg_match('/webkit/', $userAgent)) { 
            $name = 'safari'; 
        } 
        elseif (preg_match('/msie/', $userAgent)) { 
            $name = 'msie'; 
        } 
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) { 
            $name = 'mozilla'; 
        } 
        else { 
            $name = 'unrecognized'; 
        } 

        // What version? 
        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
            $version = $matches[1]; 
        } 
        else { 
            $version = 'unknown'; 
        } 

        // Running on what platform? 
        if (preg_match('/linux/', $userAgent)) { 
            $platform = 'linux'; 
        } 
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) { 
            $platform = 'mac'; 
        } 
        elseif (preg_match('/windows|win32/', $userAgent)) { 
            $platform = 'windows'; 
        } 
        else { 
            $platform = 'unrecognized'; 
        } 

        return array( 
            'name'      => $name, 
            'version'   => $version, 
            'platform'  => $platform, 
            'userAgent' => $userAgent 
        ); 
    } 
} 
	$browser = Browser::detect(); 
 
    $db = new db();

    $time = time();
    $timeZone = date("T", $time);
    $theTime  = date("h:i A", $time) . " " . $timezone;
    $day_of_year = date('z') + 1;
    
    $names  = array("day_of_year", "time", "timezone", "device", "browser", "browser_version", "url", "timestamp", "date", "user_agent", "ip_address", "referrer");
    $values = array($day_of_year, $theTime, $timeZone, $browser["platform"], $browser["name"], $browser["version"], $_POST["REQUEST_URI"], $time,  date("m-d-Y", $time),  $_POST["HTTP_USER_AGENT"],  $_SERVER["REMOTE_ADDR"], $_POST["HTTP_REFERER"] );

    if ($db::insert("visitor", $names, $values)) {
    	print "Visitor registered";
    } else {
    	print "Failed to register visitor." . mysql_error();
    }

?>