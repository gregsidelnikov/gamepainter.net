<?php include('../Migration/Composition.php');

    $Connection = new db();

    $Settings = db::get("`settings`", "`web-template`", "", "");

    print $Settings[0]["web-template"]; ?>