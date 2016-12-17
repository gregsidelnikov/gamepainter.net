<?php
    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/plugins/list/maintenance/multisort.php");
	date_default_timezone_set ( "America/New_York" );
	set_time_limit ( 0 ); // Execute the script for as long as it needs to run
	$db = new db();
	if ($db->isReady()) {
		//$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")->setUsername('gregsometimes@gmail.com')->setPassword('KOLBasa75!');
		//->setUsername('greg.sidelnikov@gmail.com')
		//->setPassword('Aurzik55723!');
		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
		$mailer = Swift_Mailer::newInstance($transport);
		
		$SEND_FROM 		= "dev@tigrisgames.com";
		$SEND_AS 		= "Greg Sidelnikov";
		
		//
		// --- Send 3 Belated ---------------------------------+
		//                                                     |
		$Emails_ToFetch = 10000;  //                               |
		$subs = $db->get("followup", "*", "`sent` = 0", "`id` ASC", $Emails_ToFetch, "");
		$sent_Count = 0;
		for ($i = 0; $i < count($subs); $i++) {
			$message_Type = $subs[$i]["message_Type"];
			$message_Email = $subs[$i]["email_address"];
			if ($message_Type == "Belated") { $message = file_get_contents("message_Belated.html"); $subject = "Just wanted to make sure you are still subscribed to my newsletter"; }
			if ($message_Type == "NeverOpened") { $message = file_get_contents("message_NeverOpened.html"); $subject = "Just wanted to make sure you are still subscribed to my newsletter"; }
			$user = $db->get("subscribers", "`key`", "email_address='" . $message_Email . "'", "", "1", ""); // Untested; but should work...
			if (!unset($user[0]["key"]) $message = str_replace("user_id", $user[0]["key"], $message); // If not unset -- replace user_id string from the baked message, with the user's actual ID 
			$msg = Swift_Message::newInstance( $subject )->setFrom(array("$SEND_FROM" => "$SEND_AS"))->setTo( $message_Email )->setContentType('text/html')->setBody($message);
            if ($mailer->send($msg)) {
                 $db->set("followup", array("sent", "sent_timestamp", "sent_date"), array(1, time(), date("M D Y h:ma T")), "`email_address` = '" . $message_Email . "'");
                 $sent_Count++;
            }
		}
		//           (potentially)
		// --- Send 2 Never Opened ----------------------------+
		//                                                     |
		$Emails_ToFetch = 10000;                                 //|
		$subs = $db->get("followup", "*", "`sent` = 0", "`id` DESC", $Emails_ToFetch, "");
		for ($i = 0; $i < count($subs); $i++) {
			$message_Type = $subs[$i]["message_Type"];
			$message_Email = $subs[$i]["email_address"];
			if ($message_Type == "Belated") { $message = file_get_contents("message_Belated.html"); $subject = "Just wanted to make sure you are still subscribed to my newsletter"; }
			if ($message_Type == "NeverOpened") { $message = file_get_contents("message_NeverOpened.html"); $subject = "Just wanted to make sure you are still subscribed to my newsletter"; }
			$user = $db->get("subscribers", "`key`", "email_address='" . $message_Email . "'", "", "1", ""); // Untested; but should work...
			if (!unset($user[0]["key"]) $message = str_replace("user_id", $user[0]["key"], $message); // If not unset -- replace user_id string from the baked message, with the user's actual ID 
			$msg = Swift_Message::newInstance( $subject )->setFrom(array("$SEND_FROM" => "$SEND_AS"))->setTo( $message_Email )->setContentType('text/html')->setBody($message);
            if ($mailer->send($msg)) {
                 $db->set("followup", array("sent", "sent_timestamp", "sent_date"), array(1, time(), date("M D Y h:ma T")), "`email_address` = '" . $message_Email . "'");
                 $sent_Count++;
            }
		}

		// Send report notification about messages sent
		$transport_v2 = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
		$mailer_v2 = Swift_Mailer::newInstance($transport_v2);
		$msg = Swift_Message::newInstance("$sent_Count follow-up emails were sent")
              ->setFrom(array('system@learnjquery.org' => 'System'))
              ->setTo( "greg.sidelnikov@gmail.com" )
              ->setContentType('text/html')
              ->setBody("Just to let you know, there were $sent_Count follow up emails sent just now. This is a system message from your cron job script.");
         $mailer_v2->send($msg);
	}
?>