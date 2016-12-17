<?php include('../Migration/Composition.php');

    $Connection = new db();

    if (db::set("`content`", array("deleted"), array(1), "`key` = '" . $_POST['key'] .  "'"))
        print $_POST['key'];

    // Update RSS
        //include("../rss/generate.php");

?>