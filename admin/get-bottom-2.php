<?php //include('../Migration/Composition.php');

    //$Connection = new db();

    $Settings = db::get("`settings`", "`bottom-content-2`", "", "");

    print $Settings[0]["bottom-content-2"]; ?>