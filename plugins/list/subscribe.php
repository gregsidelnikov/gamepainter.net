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

    if (!strpos($_GET["email"], "@")) { // Basic email check, needs at least @ and one .
        print "Email must contain @ character";
        exit;
    }
    if (!strpos($_GET["email"], ".")) {
        print "Email must contain at least one dot character.";
        exit;
    }

    $Connection = new db();
    $TableName = "subscribers";

    if ($Connection->isReady())
    {
        $Subscriber = db::get("subscribers", get_all_from("subscribers"), "`email_address`='" . $_GET["email"] . "'", "", "1");
 
        if (is_numeric($Subscriber[0]["key"])) { // Already exists
            print "*<b style = 'color: #6ca71f;'>Already Subscribed</b> You are already subscribed here.<br/><br/><img src = '" .  $URL . "/plugins/list/plus.png' alt = 'Plus sign' style = 'vertical-align: middle; margin-top:-2px;' /> Please make sure to add <span style = 'color: #111'>" . $NEWSLETTER_EMAIL_FROM_EMAIL . "</span> to your email contacts for best deliverability.</p>";
        } else {
            if (db::insert("subscribers", array("elapsed", "http_user_agent", "window_location_href", "window_location_pathname", "subscribe_form_id", "name", "email_address", "original_email_address", "list_id", "timestamp", "date", "password"),
                                          array($_GET["hms"], $_GET["http_user_agent"], $_GET["window_location_href"], $_GET["window_location_pathname"], $_GET["subscribe_list_id"], "", $_GET["email"], $_GET["email"], "0", time(), date("m-d-Y"), md5(microtime()))))
            { 
                // First character -must- return "*" on success
				print "*<b style = 'color: #6ca71f;'>Thanks!</b> You've succesfully subscribed.<br/><br/><img src = '" . $URL . "/plugins/list/plus.png' alt = 'Plus sign' style = 'vertical-align: middle; margin-top:-2px;' /> Please make sure to add <span style = 'color: #111'>" . $NEWSLETTER_EMAIL_FROM_EMAIL . "</span> to your email contacts for best deliverability.";

/*
                // !~~todo: generate confirmation key
                $CONFIRMATION_KEY = 5712352;
                
                $headers = "From: $NEWSLETTER_EMAIL_FROM_NAME <$NEWSLETTER_EMAIL_FROM_EMAIL>\r\n";
                $headers .= "Reply-To: $NEWSLETTER_EMAIL_FROM_NAME <$NEWSLETTER_EMAIL_FROM_EMAIL>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";
                $message = "<p>Confirm your subscription to " . $NEWSLETTER_NAME . "</p>";
                $message .= "<p><a href = '<?php print $URL; ?>/plugins/list/confirm.php?id=" . $CONFIRMATION_KEY . "'>Click here to confirm your subscription.</a></p>";
                $message .= "<p>You are receiving this message because your email address was entered into a newsletter subscription box on " . $URL . ". If you didn't make this request, please disregard this message.</p>";

                mail($message, "Confirm Your Subscription", $headers);
                */
                
                $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
//                $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")->setUsername('greg.sidelnikov@gmail.com')->setPassword('Aurzik55723!');
				$mailer = Swift_Mailer::newInstance($transport);
				
				$tail = "";
				if (preg_match("/(sub_join_bottom)/", $_GET["subscribe_list_id"])) $tail .= " on " . $_GET["article_id"] . " via <Bottom>"; else
				if (preg_match("/(sub_join)/", $_GET["subscribe_list_id"])) $tail .= " on " . $_GET["article_id"] . " via <Header>"; else
				if (preg_match("/(sub_ul_msg)/", $_GET["subscribe_list_id"])) $tail .= " on " . $_GET["article_id"] . " via <UL>";
				$tail .= " in " . $_GET["hms"]; // How long did it take to subscribe after page visit?
				 
				$shorter_Email = $_GET["email"];
				$shorter_Email = explode("@", $shorter_Email);
				$shorter_Email = $shorter_Email[0];
				 
				$message = Swift_Message::newInstance("<" . $shorter_Email . "> subscribed to " . trim($NEWSLETTER_NAME) . $tail)
				  ->setFrom(array('hello@rivertigris.com' => 'Subscription'))
				  ->setTo(array('greg.sidelnikov@gmail.com'))
				  ->setBody('IP: ' . $_SERVER['REMOTE_ADDR'] . '<br/>Referrer: ' . $_SERVER['HTTP_REFERER'] . '<br/>Newsletter URL: ' . $URL . '<br/>Newsletter: ' . $NEWSLETTER_NAME . '<br/>Email: ' . $_GET["email"] . '<br/>Time now: ' . date("M D Y h:m:s T", time()),
				  'text/html');
				$result = $mailer->send($message);

            }
            else
            {
                print "Sorry, something went wrong and we were unable to subscribe you to this newsletter at this time. Please try again later.";
                print mysql_error();
            }
        }
    }
    else
    {
        print "Database Connection Problem";
    }

?>


