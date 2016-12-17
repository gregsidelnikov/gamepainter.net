<?php include('../Migration/Composition.php');

    $Connection = new db();

    db::delete("`divs`", "`key` = '" . $_POST['key'] .  "'");

?>