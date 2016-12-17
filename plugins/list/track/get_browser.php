<?php

$platforms = array(
    "PLATFORM_WINDOWS",
    "PLATFORM_WINDOWS_CE",
    "PLATFORM_APPLE",
    "PLATFORM_LINUX",
    "PLATFORM_ANDROID",
    "PLATFORM_OS2",
    "PLATFORM_BEOS",
    "PLATFORM_IPHONE",
    "PLATFORM_IPOD",
    "PLATFORM_BLACKBERRY",
    "PLATFORM_FREEBSD",
    "PLATFORM_OPENBSD",
    "PLATFORM_SUNOS",
    "PLATFORM_OPENSOLARIS",
    "PLATFORM_IPAD"
);

$browsers = array(
    "BROWSER_OPERA",
    "BROWSER_WEBTV",
    "BROWSER_NETPOSITIVE",
    "BROWSER_IE",
    "BROWSER_POCKET_IE",
    "BROWSER_GALEON",
    "BROWSER_KONQUEROR",
    "BROWSER_ICAB",
    "BROWSER_OMNIWEB",
    "BROWSER_PHOENIX",
    "BROWSER_FIREBIRD",
    "BROWSER_FIREFOX",
    "BROWSER_MOZILLA",
    "BROWSER_AMAYA",
    "BROWSER_LYNX",
    "BROWSER_SAFARI",
    "BROWSER_IPHONE",
    "BROWSER_IPOD",
    "BROWSER_ANDROID",
    "BROWSER_CHROME",
    "BROWSER_GOOGLEBOT",
    "BROWSER_SLURP",
    "BROWSER_W3CVALIDATOR",
    "BROWSER_BLACKBERRY"
);

function get__browser($ua)
{
    $browser = new Browser($ua);

    if( $browser->getBrowser())
    {
        $p = "unknown";
        $b = "unknown";

        if ($browser->getPlatform() == Browser::PLATFORM_WINDOWS) $p = "PLATFORM_WINDOWS";
        if ($browser->getPlatform() == Browser::PLATFORM_WINDOWS_CE) $p = "PLATFORM_WINDOWS_CE";
        if ($browser->getPlatform() == Browser::PLATFORM_APPLE) $p = "PLATFORM_APPLE";
        if ($browser->getPlatform() == Browser::PLATFORM_LINUX) $p = "PLATFORM_LINUX";
        if ($browser->getPlatform() == Browser::PLATFORM_ANDROID) $p = "PLATFORM_ANDROID";
        if ($browser->getPlatform() == Browser::PLATFORM_OS2) $p = "PLATFORM_OS2";
        if ($browser->getPlatform() == Browser::PLATFORM_BEOS) $p = "PLATFORM_BEOS";
        if ($browser->getPlatform() == Browser::PLATFORM_IPHONE) $p = "PLATFORM_IPHONE";
        if ($browser->getPlatform() == Browser::PLATFORM_IPOD) $p = "PLATFORM_IPOD";
        if ($browser->getPlatform() == Browser::PLATFORM_BLACKBERRY) $p = "PLATFORM_BLACKBERRY";
        if ($browser->getPlatform() == Browser::PLATFORM_OPENBSD) $p = "PLATFORM_OPENBSD";
        if ($browser->getPlatform() == Browser::PLATFORM_FREEBSD) $p = "PLATFORM_FREEBSD";
        if ($browser->getPlatform() == Browser::PLATFORM_SUNOS) $p = "PLATFORM_SUNOS";
        if ($browser->getPlatform() == Browser::PLATFORM_OPENSOLARIS) $p = "PLATFORM_OPENSOLARIS";
        if ($browser->getPlatform() == Browser::PLATFORM_IPAD) $p = "PLATFORM_IPAD";

        if ($browser->getBrowser() == Browser::BROWSER_OPERA) $b = "BROWSER_OPERA";
        if ($browser->getBrowser() == Browser::BROWSER_WEBTV) $b = "BROWSER_WEBTV";
        if ($browser->getBrowser() == Browser::BROWSER_NETPOSITIVE) $b = "BROWSER_NETPOSITIVE";
        if ($browser->getBrowser() == Browser::BROWSER_IE) $b = "BROWSER_IE";
        if ($browser->getBrowser() == Browser::BROWSER_POCKET_IE) $b = "BROWSER_POCKET_IE";
        if ($browser->getBrowser() == Browser::BROWSER_GALEON) $b = "BROWSER_GALEON";
        if ($browser->getBrowser() == Browser::BROWSER_KONQUEROR) $b = "BROWSER_KONQUEROR";
        if ($browser->getBrowser() == Browser::BROWSER_ICAB) $b = "BROWSER_ICAB";
        if ($browser->getBrowser() == Browser::BROWSER_OMNIWEB) $b = "BROWSER_OMNIWEB";
        if ($browser->getBrowser() == Browser::BROWSER_PHOENIX) $b = "BROWSER_PHOENIX";
        if ($browser->getBrowser() == Browser::BROWSER_FIREBIRD) $b = "BROWSER_FIREBIRD";
        if ($browser->getBrowser() == Browser::BROWSER_MOZILLA) $b = "BROWSER_MOZILLA";
        if ($browser->getBrowser() == Browser::BROWSER_AMAYA) $b = "BROWSER_AMAYA";
        if ($browser->getBrowser() == Browser::BROWSER_LYNX) $b = "BROWSER_LYNX";
        if ($browser->getBrowser() == Browser::BROWSER_SAFARI) $b = "BROWSER_SAFARI";
        if ($browser->getBrowser() == Browser::BROWSER_IPHONE) $b = "BROWSER_IPHONE";
        if ($browser->getBrowser() == Browser::BROWSER_IPOD) $b = "BROWSER_IPOD";
        if ($browser->getBrowser() == Browser::BROWSER_ANDROID) $b = "BROWSER_ANDROID";
        if ($browser->getBrowser() == Browser::BROWSER_CHROME) $b = "BROWSER_CHROME";
        if ($browser->getBrowser() == Browser::BROWSER_GOOGLEBOT) $b = "BROWSER_GOOGLEBOT";
        if ($browser->getBrowser() == Browser::BROWSER_SLURP) $b = "BROWSER_SLURP";
        if ($browser->getBrowser() == Browser::BROWSER_W3CVALIDATOR) $b = "BROWSER_W3CVALIDATOR";
        if ($browser->getBrowser() == Browser::BROWSER_BLACKBERRY) $b = "BROWSER_BLACKBERRY";

        return array($p, $b);
    }
}

?>