<?php

	$db = new db();
    $u = $db->get("msg_opens", "*"); //, "", "`timestamp` DESC");

    $f = array();

	// Populate "f" 
    for ($i = 0; $i < count($u); $i++) {
        $user_id = $u[$i]["email_address"];
        $msg_id = str_replace(" ","",$u[$i]["msg_id"]); // bug where space appears in id like 26_5-1405372384
        $timestamp = $u[$i]["timestamp"];
        $date = $u[$i]["date"];
        if (array_key_exists($user_id, $f))
            $f[$user_id]["total_opens"] = $f[$user_id]["total_opens"] + 1;
        else {
            $f[$user_id] = array();
            $f[$user_id]["last_msg_id"] = $msg_id; /* id of most recently opened message */
            $f[$user_id]["unique_opens"] = 0;
            $f[$user_id]["total_opens"] = 1;
            $f[$user_id]["timestamp"] = $timestamp; /* timestamp of most recently opened message */
            $f[$user_id]["date"] = $date; /* string date of most recently opened message */
            $f[$user_id]["msgs"] = array();
            $f[$user_id]["msgs_timestamp"] = array();
            $f[$user_id]["how_fast"] = array();
        }
        if (array_key_exists($msg_id, $f[$user_id]["msgs"]))
            $f[$user_id]["msgs"][$msg_id] = $f[$user_id]["msgs"][$msg_id] + 1;
        else {
            $f[$user_id]["unique_opens"]++;
            $f[$user_id]["msgs"][$msg_id] = 1;
        }       
  		// Successfully grabs *last open* timestamp for this message!
        $f[$user_id]["msgs_timestamp"][$msg_id] = $timestamp;

/*        
        if (!array_key_exists($msg_id, $f[$user_id]["msgs_timestamp"]))
        {

        }
        else
        {
//        	if ($timestamp < $f[$user_id]["msgs_timestamp"][$msg_id])
//	            $f[$user_id]["msgs_timestamp"][$msg_id] = $timestamp;
        }    
        */
    }
        
  //  print "<pre>";
//    print_g($f);

	//exit;

    // count last open date
    /*
    for ($i = 0; $i < count($f); $i++)
    {
    	foreach($f as $k => $v) {
	        foreach($v as $k1 => $v1) {
	     		if ($k1 == "msgs") {
            		$tmp = array();
            		foreach($v1 as $k2 => $v2) array_push($tmp, explode("-", $k2)[1]);
            		$f[$k]["greatest"] = GetGreatestValueFrom($tmp);
            		$f[$k]["ago"] = tval_full(time(), GetGreatestValueFrom($tmp));
            	}
	        }
	    }                	
    }*/
    
    $ID = 0;
    $f = array_msort($f, array('unique_opens' => SORT_DESC, 'total_opens' => SORT_DESC));    


	function GetGreatestValueFrom($arr)
	{
		$greatest = 0;
		for ($i = 0; $i < count($arr); $i++)
			if ($arr[$i] > $greatest)
				$greatest = $arr[$i];
		return $greatest;
	}

	?>
	<table>
	<tr>
		<td></td>
		<td></td>
		<td colspan = "2">Opens</td>
		<td></td>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr style = "background: #444; color: #56f1b8; font-weight: normal;">
		<td>ID</td>
		<td>G</td>
		<td>U</td>
		<td>T</td>
		<td>&nbsp;</td>
		<td>Last Message Read</td>
		<td style = 'text-align:center;'>Time read</td>
		<td>Time took to open</td>
	</tr>
	
	<?php

	$MessageSentDate = 0;
	$MessageOpenDate = 0;
    foreach($f as $k => $v) {
    


        print "<tr><td id = '" . $k . "'>" . $ID . "</td>";
        print "<td><img src = 'boy.png' style = 'vertical-align: middle; margin-top: -2px; width: 8px; height: 8px;'/> <b class = 'email_address'>".$k . "</b></td>";
        foreach($v as $k1 => $v1) {
            if ($k1 == "unique_opens")
                print "<td><span style = 'color: brown;'><b>" . $v1 . "</b></span></td>";
            if ($k1 == "total_opens") {
                if ($v1 >= 50)
                    print "<td><span style = 'color: orangered;'>" . $v1 . " lifetime opens</span></td>";
                else
                	print "<td><span style = 'color: gray;'>" . $v1 . " lifetime opens</span></td>";
            }
            
            if ($k1 == "msgs") {
            		$r_tmp = array();
            		foreach($v1 as $k2 => $v2) { $MessageSentDate = explode("-", $k2)[1]; array_push($r_tmp, $MessageSentDate); }
            		$Greatest = GetGreatestValueFrom($r_tmp);
            		$ago = tval_full(time(), $Greatest);
                	print "<td>&nbsp;</td><td style = 'width: 50px; overflow: hidden;'><span style = 'color: brown'> " . $ago . " ago</span></td>";// ago (".$k2.") ";
            }
//            if ($k1 == "greatest") { print " & greatest = " . $v1; }
//            if ($k1 == "ago") { print " & ago = " . $v1; } 
            if ($k1 == "msgs_timestamp") {
                $ago_2 = tval_full(time(),$v1[$k2]);
                $MessageOpenDate = $v1[$k2];
                print "<td class = 'last_open_time' timestamp = '" . $v1[$k2] . "' style = 'background:#eee;'><span style = 'color: brown;'> read " . $ago_2 . " ago</span></td>";// ago (" . $v1[$k2] . ")";
            }
            if ($k1 == "how_fast")
            {
            	$T = tval_full($MessageOpenDate, $MessageSentDate);
  //          	print "<span style = 'color: green;'>" . $T . "</span>";
  				print "<td>took <span style ='color:#2ea0f6'>" .$T . "</span> to open</td>";
            }
        }
        print "</tr>";
        $ID++;
    }
    
    
	?></table><?php
    
?>