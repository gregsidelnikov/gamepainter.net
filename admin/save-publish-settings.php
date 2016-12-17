<?php include('../Migration/Composition.php');

    $Connection = new db();

    if (db::set("`content`", array("publish_settings"), array(addslashes($_POST['settings'])), "`key` = " . $_POST['key']) != FALSE)
       print "Publish settings updated";

?>