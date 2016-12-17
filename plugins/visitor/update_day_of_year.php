<?php

	$website = "learnjquery.org";
	include("/home/gregsidelnikov/public/$website/public/Migration/Composition.php");
	
	$db = new db();
	$v = $db->get("visitor", "*");
	
	for ($i = 0; $i < count($v); $i++) {
		$day = date("z", $v[$i]['timestamp']) + 1;
		$id = $v[$i]['id'];
		print $id . ",";
		
		$db->set("visitor", array("day_of_year"), array($day), "`id` = '$id'", "1");
	}
	
?>