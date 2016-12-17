<?php include('../Migration/Composition.php');

    $Connection = new db();

    if (db::set("`settings`", array("web-template"), array($_POST['webtemplate']), "")!=FALSE)
        print "set to /" . $_POST['webtemplate'];

?>