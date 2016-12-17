<?php
    include("../../Migration/Composition.php");
    $db = new db();
    $headers = "From: Greg Sidelnikov <greg@learnjquery.org>\r\n";
    $headers .= "Reply-To: Greg Sidelnikov <greg@learnjquery.org>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $msgid = $_POST["msgid"] . "-" . time();
    $message = $_POST["message"];
    $subject = $_POST["subject"];
    $dest = explode(":", $_POST["target"]);
    $type = $dest[0]; // $_POST["type"];    // $dest[0]; // "list", or "email"
    $id = $dest[1];   // $_POST["email"];     // $dest[1]; // numeric_list_id like "123" or "email@adddress.com" depending on what's in $type.
    $t = time();
    $num = 0;
    $_POST["json"] = json_decode($_POST["json"],true);
    // In some PHP set ups this will be an Array,
    // in others an Std Object
    if (is_array($_POST["json"]))
        $_POST["json"]["sent"] = 1;
    else
        $_POST["json"]->sent = 1;
    //print_g($_POST);
    $url = $_POST["url"];
    $casual_name = $_POST["casual_name"];
    if (!isset($casual_name)) $casual_name = "";
    $email = $_POST["email"];
    $article_id = $_POST["article_id"];
    $schedule_id = $_POST["key"];
    $date = $_POST["date"];
    $key = $_POST["key"];
    if (array_key_exists("article_id", $_POST)) {
        if (is_numeric($article_id)) {
            $Article = $db->get("content", get_all_from("content"), "`key` = " . $article_id, "", 1, 1);
            $title = $Article["title"];
            $message = $Article["article"];
            $subject = $Article["title"];
            $message = $Article["article"];
            $msgid = $article_id . "-" . time();
            //print_g($Article);
        } else {
            print "PHP Scheduler: article_id is not defined. Cannot read article content without id.";
            exit;
        }
    } else {
        print "PHP Scheduler: article_id is not defined. Cannot read article content without id.";
        exit;
    }
    if ($db->set("`schedule`", array("json", "sent"), array(addslashes(json_encode($_POST["json"])), "1"), "`key` = $key", "1") != FALSE) {
        //print "db->set( schedule ); Success\r\n";
    } else {
        print "Unable to set 'sent' status to 1; exiting to prevent send loop.\r\n";
        exit;
    }
    //print "lets see if type ($type) is email....\r\n";
    if ($type == "email") {
	    //print "type==email\r\n";
        $r = $db->get("subscribers", get_all_from("subscribers"), "`email_address` = '$id'", "", "1");
        $uid = $r[0]["key"];
        //$message = addslashes($message);
        $message .= "<br/><img src = '$URL/hit/t.png?uid=$uid&msgid=$msgid' alt = 'This is an open image' style = 'width:0px; height: 0px; border: 0' width = '0' height = '0' />";
        if ($LOCALHOST) {
            print("You're on LOCALHOST. Supposedly mail() has been sent... You're ok.\r\nBut verify that this works on your production server as well.\r\n");
            $num++;
        } else {
            if (mail($id, $subject, $message, $headers)) {
                $num++;
                $db->insert("sent", array("msg_id", "timestamp", "num"), array($msgid, time(), 1)); // always 1 recipient
                print "Scheduler: 1 email '$title' was sent to <$id>\r\n";
            }
            else {
                print "mail($id,$subject) failed...\r\n";
            }
        }
    } else if ($type == "list") {
        /* Store message $msgid in a separate database "sent messages"  */
        $db->insert("sent", array("msg_id", "timestamp"), array($msgid, time()));
        $r = $db->get("subscribers", get_all_from("subscribers"), "", "", "10000000000");  // `list_id` = '$id'
        $original_message = $message;
        for ($i = 0; $i < count($r); $i++) {
            $uid = $r[$i]["key"];
            $email_address = $r[$i]["email_address"];
            $message = $original_message;
            $message .= "<br/><img src = '$URL/hit/t.png?uid=$uid&msgid=$msgid' alt = 'This is an open image' style = 'width:0; height: 0; border: 0' width = '0' height = '0' />";
            if ($email_address != "") {
                if ($LOCALHOST) {
                    print("You're on LOCALHOST. Supposedly mail() has been sent to your entire newsletter list... You're ok.\r\nBut verify that this works on production server.\r\n");
                    $num = count($r);
                } else {
                    if (mail($email_address, $subject, $message, $headers)) {
                        $num++;
                        $db->set("sent", array("num"), array($num), "`msg_id` = '" . $msgid . "'");
                    }
                    else
                    {
                        print "Scheduler: unable to send mail $email_address\r\n";
                    }
                }
            }
        }
    }
    print "Scheduler: It took " . (time() - $t) . "ms to send '$title' to $num email recipients.\r\n";
?>