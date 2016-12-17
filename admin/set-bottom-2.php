<?php include('../Migration/Composition.php');

    $Connection = new db();

    if(db::set("`settings`", array("bottom-content-2"), array($_POST['bottom-content-2']), "")!=FALSE)
       print "set to /" . $_POST['bottom-content-2'];

?>