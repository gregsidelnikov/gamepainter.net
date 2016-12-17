<?php

    include("../Migration/Composition.php");

    $db = new db();
    
    $res = $db->set("content", array("template_settings"), array($_REQUEST["config_settings"]), "`key` = '" . $_REQUEST["id"] . "'", 1);
   
   if ($res)
    	print "Template config saved as ". $_REQUEST["config_settings"] . "!";
    
//    $config = $res["template_settings"];

  //  if ($config == "") $config = "0,0,0,0"; // replace with default set if empty
    
    //print $config;  
    
    
     


?> 