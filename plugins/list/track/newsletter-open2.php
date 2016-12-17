<?php error_reporting(0);//E_ALL);

    include("../../../Migration/Composition.php");
    include("../../../swift/lib/swift_required.php");
    include("Browser.php");
    include("get_browser.php");

    $b = get__browser($_SERVER['HTTP_USER_AGENT']);

    $subject = "+1 Open | " . $_GET['uid'];

    $message .= $_GET['uid'] . "<br/>";
    $message .= $_GET['msgid'] . "<br/>";
    $message .= $b[0] . "<br/>"; // platform
    $message .= $b[1] . "<br/>"; // browser
    $message .= time() . "<br/>";
    $message .= date("m-d-y") . "<br/>";
    $message .= $_SERVER["REMOTE_ADDR"] . "<br/>";
    $message .= $_SERVER['HTTP_USER_AGENT'] . "<br/>";


    // ~~~todo: Add this info to subscriber database
    $db = new db();
    $e=$db->get("subscribers", "email_address", "`key` = '" . $_GET["uid"] . "'", "", "1");

    print_g($e);

    if ($db->insert("msg_opens",
        array("email_address", "user_id", "msg_id", "date", "timestamp", "ip_address", "platform", "browser", "http_user_agent"),
        array($e["email_address"],$_GET['uid'], $_GET['msgid'], date("m-d-y"), time(), $_SERVER["REMOTE_ADDR"], $b[0], $b[1], $_SERVER["HTTP_USER_AGENT"] )) != FALSE)
        {
        print "inserted" ;
        }
        else
        {
        print "error=".mysql_error();
        }
        

    // Add tracker image
	$message .= "<br/><img style = 'width:32px; height: 32px; border:1px solid red;' src = '".$URL."/hit/t-" . $_GET['uid'] . "-" . $_GET['msgid'] . ".png?uid=" . $_GET['uid'] . "&msgid=" . $_GET['msgid'] . "'>";

	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")->setUsername('greg.sidelnikov@gmail.com')->setPassword('Aurzik55723!');
    $mailer = Swift_Mailer::newInstance($transport);
    $msg = Swift_Message::newInstance($subject)
      ->setFrom(array('greg@gregswebdesign.net' => 'Hit Counter'))
      ->setTo(array( "greg.sidelnikov@gmail.com" ))
      ->setContentType('text/html')
      ->setBody($message);
    $mailer->send($msg);

?>
