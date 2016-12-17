<?php





	// MailChimp only;
	
	
	

    error_reporting(E_ALL);//E_ALL); //0); //E_ALL);

    // Include APIs
    include("../api/mcapi/MailChimp.class.php");

    if ($_POST) {
        $title1     = $_POST["title1"];         // Browser title bar text
        $title2     = $_POST["title2"];         // Article title
        $ver_html   = $_POST["ver_html"];       // The article body HTML
        $ver_email  = $_POST["ver_email"];      // The e-mail version of the article
        $recipient  = $_POST["recipient"];      // guest blogger's email address
        $date       = $_POST["date"];           // schedule date: 1 - immediate, otherwise format is -- 01/15/2013 01:00 P      (or A)
        $type       = $_POST["type"];           // type of message
    }

    // mc -- mailchimp newsletter
    // em -- send an email to a guest blogger, publisher
    // tw -- twitter message
    // aw -- aweber message
    // fb -- facebook message
    // ar -- publish article to the site


    $type = "mc";


    /* Send a mailchimp campaign */
    if ($type == "mc")
    {
        $MailChimp = new MailChimp("13046a0f1ae59b347dc4ad3e90b55b53-us2");
        $MailChimp->call("method", array(""));
        print_r($MailChimp->call('lists/list'));
    }


?>