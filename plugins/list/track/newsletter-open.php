<?php error_reporting(E_ALL);
    include("../../../Migration/Composition.php");
    include("../../../swift/lib/swift_required.php");
    include("Browser.php");
    include("get_browser.php");
    $b = get__browser($_SERVER['HTTP_USER_AGENT']);
?>
Here is how it works:<br/>
The image is<br/>
{$URL}/plugins/list/track/t.png?uid=3&msgid=183<br><br>
uid   = id of the user in subscribers database<br/>
msgid = id of the article being sent<br/>
<?php
    print_g($_REQUEST);
    $db = new db();
    $e=$db->get("subscribers", "email_address", "`key` = '" . $_GET["uid"] . "'", "", "1");
    print_g($e);
    if ($db->insert("msg_opens",
        array("email_address", "user_id", "msg_id", "date", "timestamp", "ip_address", "platform", "browser", "http_user_agent"),
        array($e[0]["email_address"],$_GET['uid'], $_GET['msgid'], date("m-d-y"), time(), $_SERVER["REMOTE_ADDR"], $b[0], $b[1], $_SERVER["HTTP_USER_AGENT"] )) != FALSE) {
        print "inserted" ;
    } else {
        print "error=".mysql_error();
    }
        
    // Grab newsletter subject:
        $msg = $db->get("content", "title,time", "`key` = '" . explode("-", $_GET['msgid'])[0] . "'", "", 1);
        $MESSAGE_NAME = $msg[0]["title"];
        $MESSAGE_TIME = date("M D Y h:m:s T", $msg[0]["time"]);
        
	// Set notification ---
		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance($e[0]["email_address"] . " opened message " . $_GET['msgid'] . " just now!")       // . date("M-D-Y h:m:s", time()))
		  ->setFrom(array('hello@learnjquery.org' => 'Notification'))
		  ->setTo(array('greg.sidelnikov@gmail.com'))
		  ->setBody('Newsletter Name: ' . $NEWSLETTER_NAME . '<br>Newsletter URL: ' . $URL .
		  '<br>Message: ' . $MESSAGE_NAME . '<br>Sent On: ' . $MESSAGE_TIME .
		  '<br>REMOTE_ADDR=' . $_SERVER["REMOTE_ADDR"] .
		  '<br>HTTP_USER_AGENT=' . $_SERVER["HTTP_USER_AGENT"],
		  'text/html');
		  
	$result = $mailer->send($message);
?>
