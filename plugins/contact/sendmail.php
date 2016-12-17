<?php
    include(__DIR__ . "/../../Migration/Composition.php");
    include(__DIR__ . "/../../swift/lib/swift_required.php");
    
	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport);
		
	if ($_REQUEST["name"] == "") $_REQUEST["name"] = "Anonymous";
	if ($_REQUEST["subject"] == "") $_REQUEST["subject"] = "No Subject";
	
	$msg = $_REQUEST["message"];
	$subject = $_REQUEST["subject"];
	
	$message = Swift_Message::newInstance("Message from " . $_REQUEST["name"] . " <" . $_REQUEST["email"] . "> submitted from " . trim($NEWSLETTER_NAME))
	  ->setFrom(array($CONTACTFORM_EMAIL_FROM_EMAIL => 'Contact Form'))
	  ->setTo(array('greg.sidelnikov@gmail.com'))
	  ->setBody('IP: ' . $_SERVER['REMOTE_ADDR'] . '<br/>Referrer: ' . $_SERVER['HTTP_REFERER'] .
	  '<br/>Newsletter URL: ' . $URL . '<br/>Newsletter Name: ' . $NEWSLETTER_NAME . '<br/><b>Subject:</b>' . $subject . '<br/><b>Message:</b> ' . $msg,
	  'text/html');

	$result = $mailer->send($message);
	
	if ($result) print 1; else print 0;
/*
    $headers = "From: Tornado PHP Framework <info@tornadoframework.net>\r\n";
    $headers .= "Reply-To: Tornado PHP Framework <info@tornadoframework.net>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    $subject = "+1 " . $WEBSITE_NAME . " Message";

    $message = $_REQUEST["message"];

    $email_address = "greg.sidelnikov@gmail.com";

    if (mail($email_address, $subject, $message, $headers)) print 1; else print 0;
*/

?>