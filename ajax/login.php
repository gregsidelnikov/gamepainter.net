<?php
include('../Migration/Composition.php');
$Connection = new db();
$Email = $_REQUEST['email'];
$Password = $_REQUEST['password'];

// print $Email;

if ($Connection->isReady())  {

    $user = $Connection->get("user", "*", "email_address = '" . $Email . "'", "", 1, 1);

//    print_g($user);
    if ($user["password"] == md5($Password)) {
        print 1;
        //print "You have succesfully logged in.";
    } else {
        print 0;
        //print "There is no such email or password combination.<br/>";
        //print $Email . "<br/>";
        //print $Password . "<br/>";
        //print md5($Password) . "<br/>";
    }

}  else
    print "Couldn't connect to database... -> " . mysql_error();

$Connection = null;

?>