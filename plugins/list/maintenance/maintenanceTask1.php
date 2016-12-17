<?php

    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/plugins/list/maintenance/multisort.php");

	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport); 
	
	date_default_timezone_set ( "America/New_York" );
	
	$db = new db();

	if ($db->isReady())
	{
		// Ping subscribers who have 0 lifetime opens
$u = $db->get("msg_opens", "*");
    $f = array();
    for ($i = 0; $i < count($u); $i++) {
        $user_id = $u[$i]["email_address"];
        $msg_id = $u[$i]["msg_id"];
        if (array_key_exists($user_id, $f))
            $f[$user_id]["total_opens"] = $f[$user_id]["total_opens"] + 1;
        else {
            $f[$user_id] = array();
            $f[$user_id]["last_msg_id"] = $msg_id; /* id of most recently opened message */
            $f[$user_id]["unique_opens"] = 0;
            $f[$user_id]["total_opens"] = 1;
            $f[$user_id]["msgs"] = array();
        }
        if (array_key_exists($msg_id, $f[$user_id]["msgs"]))
            $f[$user_id]["msgs"][$msg_id] = $f[$user_id]["msgs"][$msg_id] + 1;
        else {
            $f[$user_id]["unique_opens"]++;
            $f[$user_id]["msgs"][$msg_id] = 1;            
        }
    }
    
    $ID = 0;
    $f = array_msort($f, array('unique_opens' => SORT_DESC, 'total_opens' => SORT_DESC));    

    foreach($f as $k => $v) {
        print "<div id = '" . $k . "'>" . $ID;
        print "<b><img src = 'boy.png' style = 'vertical-align:middle; margin-top:-2px; width:16px;height:16px;'/>".$k . "</b> ";
        foreach($v as $k1 => $v1) {
            if ($k1 == "unique_opens")
                print "<span style = 'color: brown;'><b>" . $v1 . "</b></span> / ";
            if ($k1 == "total_opens") {
                if ($v1 >= 50)
                    print "<span style = 'color: orangered;'>" . $v1 . " total</span>";
                else
                	print "<span style = 'color: gray;'>" . $v1 . " total</span>";
            }
        }
        print "</div>";
        $ID++;
    }



	
	}

	
	

?>