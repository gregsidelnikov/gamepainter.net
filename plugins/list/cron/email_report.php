<?php  require('/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php');
	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport); // Create the Mailer using your created Transport


	$message = Swift_Message::newInstance('Hello from list/cron/email_report.php')->setFrom(array('hello@byspirit.net' => 'By Spirit'))
	  ->setTo(array('greg.sidelnikov@gmail.com'))
	  ->setBody('Here is the message itself');

	$result = $mailer->send($message);
		
?>