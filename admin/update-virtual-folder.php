<?php include('../Migration/Composition.php');

    $Connection = new db();

    if(db::set("`settings`", array("virtual-folder"), array($_POST['foldername']), "")!=FALSE)
       print "set to /" . $_POST['foldername'];

?>