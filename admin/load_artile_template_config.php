<?php

    include("../Migration/Composition.php");

    $db = new db();
    
    $res = $db->get("content", "*", "`key` = '" . $_REQUEST["id"] . "'", "", "1", "1");
    
    $config = $res["template_settings"];

    if ($config == "") $config = "0,0,0,0"; // replace with default set if empty
    
    print $config;  
     


?>