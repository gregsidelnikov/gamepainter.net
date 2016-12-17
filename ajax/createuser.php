<?php

include('../Migration/Composition.php');

$Connection = new MysqlDatabase();

$RecipientEmail = $_GET['email'];

$Password = $_GET['password'];

function EmailCode($to, $code)
{
    global $RecipientEmail;
    global $CommunityID;
    $headers = "From: Authentic Society <no-reply@authenticsociety.com>\r\n" . "Reply-To: no-reply@authenticsociety.com\r\n" . "X-Mailer: php\r\n";
    //$headers .= "BCC: greg.sidelnikov@gmail.com\r\n";
    //$headers .= "Content-type: text/html; charset=UTF-8\r\n";
    //$headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $IPADDRESS = trim($_SERVER['REMOTE_ADDR']);
    $subject = "--";
    $message = "Below is the information needed to activate your account.\n\nYour account activation code is: " . $code . "\n\nEnter the code into the website form. If you are no longer on the front page, please visit the following URL to activate your account: \n\nhttp://www.authenticsociety.com/Verify/" . $code;
    $mailerror = false;
    if (mail($to, $subject, $message, $headers) == TRUE) {
        //Text message sent
        //print "mail sent to $to";
    }

    // Send to myself, with IP
    $subject .= " " . $IPADDRESS;
    if (mail("greg.sidelnikov@gmail.com", "($to)".$subject."[cid=".$CommunityID."]", $message, $headers) == TRUE) {
        //Text message sent
        //print "mail sent to $to";
    }
}

function CreateConfirmationCode()
{
    global $RecipientEmail;

    $AvailableCh = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v",0,1,2,3,4,5,6,7,8,9);
    $Code = "";
    for($i = 0; $i < 16/*count($AvailableCh)*/; $i++)
        $Code .= $AvailableCh[rand(0,count($AvailableCh))];
    // mail the code
    EmailCode($RecipientEmail, $Code);

    //print $RecipientEmail; /*all ok*/

    return $Code;
}

if ($Connection->isReady())
{
    global $RecipientEmail;
    global $Password;

    //print "Before database insert</br>";

    // ~~~TODO: (done) check if this user already exists... if user exists, return with a special code, change UI to reflect
    $PreviousUser = MysqlDatabase::getTableData("user", "`email_address`, `account_activation_code`, `account_status`", "`email_address` = '" . $RecipientEmail . "'", "", 1);

    if ($PreviousUser['email_address'] == $RecipientEmail) {
        if ($PreviousUser['account_status'] == 0)
            // The user with this email address already exists, but not yet activated
            print "The user with this email address already exists, but not yet activated.";
        else
            if ($PreviousUser['account_status'] == 1)
                // The user with this email address already exists, if this is your account you can log in now.
                print "The user with this email address already exists, if this is your account you can log in now.";
        exit;
    }
    else
    {
        $CONFIRMATION_CODE = CreateConfirmationCode();
        if (insert_table_data("user",
                array("city", "email_address", "password", "birthdate", "gender", "first_name", "last_name", "display_name", "country", "state", "creation_time", "last_login", "relationship", "occupation", "prefs", "bio", "mana", "full_name", "account_activation_code", "account_status"),
                array('', $RecipientEmail,md5($Password),0,'','','','Anonymous','','',time(),0,'','',0,0,0,0,$CONFIRMATION_CODE,'0') ) != FALSE )
        {
            $LID = mysql_insert_id();

            if (is_numeric($CommunityID))
            {
                /* Get this user into community he was interested in before creating an account */
                MysqlDatabase::insertTableData("feed_to_user", array('user_id', 'community_id'), array($LID, $CommunityID));

                /* Insert few basic communities to add to the list of new users by default */
                /* Music */
                MysqlDatabase::insertTableData("feed_to_user", array('user_id', 'community_id'), array($LID, 4));
                /* Movies */
                MysqlDatabase::insertTableData("feed_to_user", array('user_id', 'community_id'), array($LID, 5));
                /* Books */
                MysqlDatabase::insertTableData("feed_to_user", array('user_id', 'community_id'), array($LID, 42));

                /* Send customized community welcome message based on id */
            }

            /* Add Greg as first friend */
            MysqlDatabase::insertTableData("friend_to_friend", array('user_id', 'friends_with'), array($LID, 1));

            /* Add this user to Gregs list as first friend */
            MysqlDatabase::insertTableData("friend_to_friend", array('user_id', 'friends_with'), array(1, $LID));

            print $LID . '?' . $Password;




        }
        else
        {
            print "false";
            print "mysql_error()=" . mysql_error();
        }
    }
}
else
{
    print "Couldn't connect to database... -> " . mysql_error();
}

$Connection = null;
?>