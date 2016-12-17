<?php

    include("../../Migration/Composition.php");
    $uid = $_GET["uid"];
    $unsubscribed = $_GET["unsubscribed"];
    $db = new db();
    if (($db->set("subscribers", array("unsubscribed"), array($unsubscribed), "`key` = '" .$uid . "'", 1) != FALSE)) {
        if ($unsubscribed == 1) { $un = "un"; $from = "from"; };
        if ($unsubscribed == 0) { $un = ""; $from = "to"; };
        print "Your email address has been $un" . "subscribed $from this newsletter.";
    } else {
        print "Something went wrong. Your account settings were not updated. Try again later or contact newsletter owner.";
    }

?>