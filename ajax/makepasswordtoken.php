<?php
include('../Migration/Composition.php');
$Connection = new db();
$Email = $_REQUEST['email'];
$Password = $_REQUEST['password'];
if ($Connection->isReady())  {
    $user = $Connection->get("user", "*", "email_address = '" . $Email . "'", "", 1, 1);
    if ($user["password"] == md5($Password))  print $user["password"]; else print 0;
} else print "Couldn't connect to database... -> " . mysql_error();
$Connection = null;
?>