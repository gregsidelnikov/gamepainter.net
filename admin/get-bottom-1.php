<?php //include('../Migration/Composition.php');

    //$Connection = new db();

    $Settings = db::get("`settings`", "`bottom-content-1`", "", "");

    print $Settings[0]["bottom-content-1"]; ?>