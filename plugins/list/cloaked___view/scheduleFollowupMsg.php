<?php
    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/plugins/list/maintenance/multisort.php");

	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport); 
	
	date_default_timezone_set ( "America/New_York" );
	
	$db = new db();
	$message_Type = $_POST["message_Type"];
	$list = $_POST["list"];

	if ($db->isReady()) {
		$list = explode(",", $_POST["list"]);
		$ins = 0;
		for ($i = 0; $i < count($list); $i++) {
			$email_address = $list[$i];
			$entry = $db->get("followup", "*", "`email_address` = '" . $email_address . "'", "", "1");
			if ($entry[0]["email_address"] == $list[$i]) { }
			else
				if (($db->insert( "followup", array("email_address", "message_Type", "sent", "sent_timestamp", "sent_date"), array($email_address, $message_Type, "0", "0", "0") )) != NULL)
					$ins++;
		}	
		print "$ins $message_Type entries inserted!";
	}
	
?>