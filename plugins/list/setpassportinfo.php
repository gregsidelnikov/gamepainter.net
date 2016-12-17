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
//    $TableName = "subscribers";

if ($db->isReady())
{
	$db->set("subscribers",
		array("name", "skype", "twitter", "projects", "software", "occupation", "website"),
		array($_POST["name"],
			  $_POST["skype"],
			  $_POST["twitter"],
			  $_POST["projects"],
			  $_POST["software"],
			  $_POST["occupation"],
			  $_POST["website"]),
		"`email_address` = '" . $_POST["email"] . "'");
		
		$body = "";
		foreach($_POST as $k => $v) {
			$body .= "<b>" . $k . "</b> = " . $v . "<br>";
		}
		
		$passport = $db->get("subscribers", "*", "`email_address` = '" . $_POST["email"] . "'", "", 1, 1);
		
		if ($passport["empty_pic"] == 0)
			$body .= "<br><img src = '" . $URL . "/Templates/simplicity/camera_pic_2.png' alt = 'image' />";
		else
			$body .= "<br><img src = '" . $URL . "/user/sub/64/" . $_POST["key"] . ".jpg' alt = 'image' />";
		
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
		// $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")->setUsername('greg.sidelnikov@gmail.com')->setPassword('Aurzik55723!');
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance("<" . $_POST["email"] . "> edited passport")
				  ->setFrom(array('hello@rivertigris.com' => 'Passport Edit'))
				  ->setTo(array('greg.sidelnikov@gmail.com'))
				  ->setBody($body, 'text/html');  
		$result = $mailer->send($message);
}
    
?>