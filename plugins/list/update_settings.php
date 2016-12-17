<?php

    include("../../Migration/Composition.php");
    $uid = $_GET["uid"];
    $name = $_GET["name"];
    $email = $_GET["email_address"];
    $db = new db();
    if (($db->set("subscribers", array("name","email_address"), array($name,$email), "`key` = '" .$uid . "'", 1)!=FALSE)) {
        print "Your account settings have been updated.";
    } else {
        print "Something went wrong. Your account settings were not updated. Try again later or contact newsletter owner.";
    }

?>