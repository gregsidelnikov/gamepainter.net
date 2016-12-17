<?php
include('../Migration/Composition.php');
$Connection = new db();
$Password = $_REQUEST['token'];
if ($Connection->isReady()) {
    $user = $Connection->get("user", "*", "password = '" . $Password . "'", "", 1, 1);
    print $user["key"]; } else print 0; $Connection = null;
?>