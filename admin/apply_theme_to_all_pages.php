<?php

    include(__DIR__ . "/../Migration/Composition.php");

    $db = new db();

    if ($db->isReady())
//    	if (strlen($_REQUEST["config_text"]) >= 8) // Minimum 8 characters eg "0,0,0,0"
	        if ($db->set("content", array("template_settings"), array($_REQUEST["config_text"]) ))
  				print 1;
  			else
  				print 0;
 
 
?>