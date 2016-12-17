<?php
    include("../../Migration/Composition.php");
    $db = new db();
    
    set_time_limit ( 0 ); // Execute the script for as long as it needs to run
    
    $headers = "From: $NEWSLETTER_EMAIL_FROM_NAME <$NEWSLETTER_EMAIL_FROM_EMAIL>\r\n";
    $headers .= "Reply-To: $NEWSLETTER_EMAIL_FROM_NAME <$NEWSLETTER_EMAIL_REPLY_TO>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;\r\n";//ISO-8859-1\r\n";//utf-8\r\n";  //  charset: UTF-8\r\n
    //$headers .= "Content-Transfer-Encoding: base64\r\n";
    
    $msgid = $_POST["msgid"] . "-" . time();
    $message = $_POST["message"];
    $subject = $_POST["subject"];
    $dest = explode(":", $_POST["target"]);
      
    $type = $dest[0]; // $_POST["type"];    // $dest[0]; // "list", or "email"
    $id = $dest[1];   // $_POST["email"];     // $dest[1]; // numeric_list_id like "123" or "email@adddress.com" depending on what's in $type.
  
    $t = time();
    $num = 0;
    $url = $_POST["url"];
    $casual_name = $_POST["casual_name"];
    if (!isset($casual_name)) $casual_name = "";
    $email = $_POST["email"];
    $article_id = $_POST["article_id"];
    $schedule_id = $_POST["key"];
    $date = $_POST["date"];
    $key = $_POST["key"];
    $post_type = $_POST["post_type"];
    
    if (array_key_exists("article_id", $_POST)) {
        if (is_numeric($article_id)) {
            $Article = $db->get("content", get_all_from("content"), "`key` = " . $article_id, "", 1, 1);
            $title = $Article["title"];
            $message = $Article["article"];
            //$original_message = $message;
            $subject = $Article["title"];
            $message = $Article["article"];
            $msgid = $article_id . "-" . time();
            $__Ttype = $Article["type"];
            $location = $Article["location"];
            $description = $Article["description"];
            
            $page_url = $URL . "/";
			if ($__Ttype == "homepage" || $__Ttype == "webpage" || $__Ttype == "nodir" || $__Ttype == "none" || $__Ttype == "article")
				$page_url .= $location;
			else
				$page_url .= "/" . $type . "/" . $location;
                        
			if ($post_type == 0) { // Header that leads to article URL
//				$message = "<a href = '" . $page_url . "' style = 'font-size: 17px;'>" . $subject . "</a><p>" . $description . "</p>" . "<a href = '$page_url' style = 'color:white;text-decoration:none;'><div style = 'margin:auto; position:relative;width:70px;height:70px;background:#ffa423;border-radius:777px;text-align:center;line-height:75px;'>Read</div></a>" . "<p style = 'text-align: center;'>New article is posted! Click to start reading.</p>";
				$message = "<a href = '" . $page_url . "' style = 'font-size: 17px;'>" . $subject . "</a><p>" . $description . "</p>" . "<a href = '$page_url' style = 'color:#7b7b7b;text-decoration:none;'><div style = 'margin: 0 auto; padding:0;position:relative;width:129px;height:35px;background: url(". $URL . "/plugins/list/read-bg.png) no-repeat;background-position:center center;border:1px solid #b5b5b5;border-radius:7px;text-align:center'><div style = 'height:11px;'></div>Read Online</div></a>" . "<p style = 'text-align: center;'>New article was posted! Click to start reading.</p>";
			} else
			if ($post_type == 1) { // Plain text, with basic footer (newsletter settings)
				/* Nothing do to -- default */
			} else
			if ($post_type == 2) { // Plain text, with donate button
				$message .= "<a href = '$URL/donate' style = 'color:white;text-decoration:none;'><div style = 'margin:auto; position:relative;width:70px;height:70px;background:#ffa423;border-radius:777px;text-align:center;line-height:75px;'>Donate</div></a>";
			} else
			if ($post_type == 3) { // Plain text, with invite friends button
				$message .= "<a href = '$URL/invite' style = 'color:white;text-decoration:none;'><div style = 'margin:auto; position:relative;width:70px;height:70px;background:#60d01c;border-radius:777px;text-align:center;line-height:75px;'>Invite</div></a><p style = 'text-align: center;'><i><b>An idea:</b> Invite your friends to join this newsletter.</i></p>";
			}
            
        } else {
            print "PHP Scheduler: article_id is not defined. Cannot read article content without id. Send aborted.\r\n";
            exit;
        }
    } else {
        print "PHP Scheduler: article_id is not defined. Cannot read article content without id. Send aborted.\r\n";
        exit;
    }
    // Set this entry as sent = 1; regardless of the status
    if ($db->set("`schedule`", array("sent"), array("1"), "`key` = $key", "1") != FALSE) {
    } else {
        print "Unable to set 'sent' status to 1; exiting to prevent send loop. Send aborted.\r\n";
        exit;
    }
    if ($type == "email") {
	    //print "type==email\r\n";
        $r = $db->get("subscribers", get_all_from("subscribers"), "`email_address` = '$id'", "", "1", 1);
        $uid = $r["key"];
        // Email footer
        $NL_PASSWORD = $r["password"];
        
        // Include email footer
        include("footer.php");

        $message .= $footer;
        $message .= "<br/><img src = '$URL/hit/t.png?uid=$uid&msgid=$msgid' alt = 'This is an open image' style = 'width:0px; height: 0px; border: 0' width = '0' height = '0' />";
        $message = str_replace(array("\r\n", "\n", "\r"), '', utf8_encode($message));

        // Must have a linebreak at least every 998 characters
        $message = str_replace("</p>","</p>\r\n",$message);
        $message = str_replace("<p>","\r\n<p>",$message);
        $message = str_replace('/<p style(.*)?>/ig','\r\n<p style$1>', $message);
        
        // print_g($message);

        if ($LOCALHOST) {
            print("You're on LOCALHOST. Supposedly mail() has been sent... You're ok.\r\nBut verify that this works on your production server as well.\r\n");
            $num++;
        } else {
            if (mail($id, $subject, $message, $headers)) {
                $num++;
                $db->insert("sent", array("msg_id", "timestamp", "num"), array($msgid, time(), 1)); // always 1 recipient
                print "*Scheduler: 1 email '$title' was sent to <$id>\r\n";
            }
            else {
                print "mail($id,$subject) failed...\r\n";
            }
        }
    } else if ($type == "list") {
        /* Store message $msgid in a separate database "sent messages"  */
        $db->insert("sent", array("msg_id", "timestamp"), array($msgid, time()));
        $r = $db->get("subscribers", get_all_from("subscribers"), "`key` > 0 AND unsubscribed = 0", "", "10000000", 1);  // `list_id` = '$id'  //  > 13287

         // Include email footer
         $message .= $footer;
         $message .= "<br/><img src = '$URL/hit/t.png?uid=$uid&msgid=$msgid' alt = 'i' style = 'width:0; height: 0; border: 0' width = '0' height = '0' />";
         $message = str_replace(array("\r\n", "\n", "\r"), '', utf8_encode($message));
         
        $original_message = $message;


        for ($i = 1; $i <= 3; $i++) { //count($r);
            $uid = $r[$i]["key"];
            $email_address = $r[$i]["email_address"];

            $message = $original_message;

            // Email footer
            $NL_PASSWORD = $r[$i]["password"];
            
            include("footer.php");

            // Must have a linebreak at least every 998 characters
            $message = str_replace("</p>","</p>\r\n",$message);
            $message = str_replace("<p>","\r\n<p>",$message);
            $message = str_replace('/<p style(.*)?>/ig','\r\n<p style$1>', $message);
            
            if ($email_address != "") {
                if ($LOCALHOST) {
                } else {
                    if (mail($email_address, $subject, $message, $headers)) {
                        $num++;
                        $db->set("sent", array("num"), array($num), "`msg_id` = '" . $msgid . "'");
                        print "if (type==list).\r\n";
                    }
                    else
                    {
                        print "+Scheduler: unable to send mail to $email_address\r\n";
                    }
                }
            }
        } // end main send mail loop
        if ($LOCALHOST) {
            print("You're on LOCALHOST. Supposedly mail() has been sent to your entire newsletter list (" . $num . ")... You're ok.\r\nBut verify that this works on production server.\r\n");
            $num = count($r);
        } else {

        }
    }
    print "@Scheduler: It took " . (time() - $t) . "ms to send '$title' to $num email recipients.\r\n";
?>