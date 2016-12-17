<?php
    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    // require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");
    // require_once("/home/gregsidelnikov/public/learnjquery.org/public/plugins/list/maintenance/multisort.php");
//	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
//	$mailer = Swift_Mailer::newInstance($transport); 
//	date_default_timezone_set ( "America/New_York" );
	
	$db = new db();
	if ($db->isReady()) {
		$subs = $db->get("subscribers", "email_address", "`unsubscribed` = 1", "", "", "");
		print "new Array(";
		for ($i = 0; $i < count($subs); $i++) {
			if ($i != 0 && $i < count($subs)) print ",";
			print '"' . $subs[$i]["email_address"] . '"';
		}
		print ")";
	}
	
?>