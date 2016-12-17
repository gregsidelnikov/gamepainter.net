<?php
include('../Migration/Composition.php');
$Connection = new db();
$RecipientEmail = $_GET['email'];
$Password = $_GET['password'];

function EmailCode($to, $code) {
    global $RecipientEmail;
    global $CommunityID;
    $headers = "From: Game Painter <no-reply@gamepainter.com>\r\n" . "Reply-To: no-reply@gamepainter.com\r\n" . "X-Mailer: php\r\n";
    //$headers .= "BCC: greg.sidelnikov@gmail.com\r\n";
    //$headers .= "Content-type: text/html; charset=UTF-8\r\n";
    //$headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $IPADDRESS = trim($_SERVER['REMOTE_ADDR']);
    $subject = "--";
    $message = "This is the information needed to activate your Game Painter account.\n\nYour account activation code is: " . $code . "\n\nEnter the code into the website form. If you are no longer on the front page, please visit the following URL to activate your account: \n\nhttp://www.gamepainter.net/verify/" . $code;
    $mailerror = false;
    if (mail($to, $subject, $message, $headers) == TRUE) {
        //Text message sent
        //print "mail sent to $to";
    }
    // Send to myself, with IP
    $subject .= " " . $IPADDRESS;
    if (mail("greg.sidelnikov@gmail.com", "<$to> New Game Painter Account Registered", $message, $headers) == TRUE) {
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

//print "checking connection";

if ($Connection->isReady())
{
    global $RecipientEmail;
    global $Password;

//    print "Before database insert</br>";

    // ~~~TODO: (done) check if this user already exists... if user exists, return with a special code, change UI to reflect
    $PreviousUser = db::get("user", "*", "`email_address` = '" . $RecipientEmail . "'", "", 1);

    print_g($PreviousUser);

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
        if (db::insert("user",
                array("city", "email_address", "password", "birthdate", "gender", "first_name", "last_name", "display_name", "country", "state", "creation_time", "last_login", "relationship", "occupation", "prefs", "bio", "mana", "full_name", "account_activation_code", "account_status"),
                array('', $RecipientEmail,md5($Password),0,'','','','Anonymous','','',time(),0,'','',0,0,0,0,$CONFIRMATION_CODE,'0') ) != FALSE ) {

            print "Your account has been successfully registered!";

        }
        else
        {
            print "Sorry, there was a database error. Please contact dev@tigrisgames.com to report this problem: mysql_error()=" . mysql_error();
        }
    }
}
else
{
    print "Couldn't connect to database... -> " . mysql_error();
}

$Connection = null;

?>