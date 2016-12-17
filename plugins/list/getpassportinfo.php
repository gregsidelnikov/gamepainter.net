<?php

//	  Relative ---
//    include("../../Migration/Composition.php");
//    include("../../swift/lib/swift_required.php");

//	  Other server ---
//    include("var/www/vulkantutorials.net/Migration/Composition.php");
//    include("var/www/vulkantutorials.net/swift/lib/swift_required.php");

//	Relative 
    include(__DIR__ . "/../../Migration/Composition.php");
    include(__DIR__ . "/../../swift/lib/swift_required.php");

    if (!strpos($_POST["email"], "@")) { // Basic email check, needs at least @ and one .
        print "Email must contain @ character";
        exit;
    }
    if (!strpos($_POST["email"], ".")) {
        print "Email must contain at least one dot character.";
        exit;
    }

    $db = new db(); 

	if ($db->isReady()) {
		$sub = $db->get("subscribers", "`key`, name, skype, twitter, projects, software, occupation, website, empty_pic", "`email_address` = '" . $_POST["email"] . "'", "", 1, 1);
		print json_encode( $sub );
	}
    
?>