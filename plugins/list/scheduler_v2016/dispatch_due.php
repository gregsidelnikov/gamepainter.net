<html>
<head>
	<title></title>
</head>
<body>
	<style type = "text/css">
		.sch-item { border: 1px solid silver; border-bottom:0; padding: 4px; height: 20px; }
		.title { float: left; min-width: 250px; display: inline-block; line-height: 22px; }
		.ago { float: left; min-width: 90px; line-height: 22px; font-size: 10px; } 
		.when { float: left; min-width: 90px; line-height: 22px; font-size: 10px; } 
		.status { float: left; min-width: 40px }
		.button { margin-top: -1px; display: inline-block; cursor: hand !important; border-radius: 3px; border: 1px solid silver; padding: 4px; text-align: center; font-family: Verdana; font-size: 11px; }
		body { font-family: verdana; font-size: 12px; }
		.green div { color: green !important; }
		.silver { color: silver; }
		.last { border-bottom: 1px solid silver; }
	</style>
<?php
//    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
//    require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");

    require_once('/var/www/tigrisdev.net/Migration/Composition.php');
    require_once("/var/www/tigrisdev.net/swift/lib/swift_required.php");

	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport); 
	
	date_default_timezone_set ( "America/New_York" );
	
	$db = new db();
	
	function shorter($str) { if (strlen($str) > 32) return substr($str,0,32)."..."; else print $str; }
	
	 
	?>
	<div style = "width: 675px; margin: 0 auto;">
	<p><b>Schedule in <?php print date("T", time()); ?> Time Zone</b></p>
	<p>This is dispatching activity for the last 10 items that were scheduled.</p>
	<?php
	
	// Check if anything is scheduled
	if ($db->isReady())
	{
		$sch = $db->get("schedule", "*", "", "`timestamp` DESC", "10", "");
		
		for ($i = 0; $i < count($sch); $i++)
		{
			$timestamp = $sch[$i]["timestamp"];
			$tval_diff = time() - $timestamp;
			 
			
			$dif = tval(time(), $sch[$i]["timestamp"]);
			
			if ($tval_diff < 0)
			{
				//print "<b>FUTURE </b> <span style = 'color:green;'>" . $dif . " left</span> ==> " . $sch[$i]["type"] . "," . $sch[$i]["email"] . ",<b>" . $sch[$i]["article_id"] . "</b>," . $sch[$i]["date"] . "," . $timestamp . " ==> " . $tval_diff . "<br/>";
				?>
				<div class = "sch-item<?php if ($i==count($sch)-1) { print ' last'; } ?>">
					<div class = "title"><?php print shorter($sch[$i]["article_name"]); ?></div>
					<div class = "when"><?php print "<span style = 'color: #333'>" . date("M d h:ma", $sch[$i]["timestamp"]) . " &nbsp;</span>"; ?></div>
					<div class = "ago">sending in <?php print "<span style = 'color: #399ae5'>" . $dif . "</span>"; ?></div>
					<div class = "status"><div class = "button">In Queue</div></div>
				</div>
				<?php 
			}
			else		
			{
				//print "<b style = 'color: green;'>SENT</b> <span style = 'color:gray'>" . $dif . " ago</span>," . $sch[$i]["type"] . "," . $sch[$i]["email"] . ",<b>" . $sch[$i]["article_id"] . "</b>," . $sch[$i]["date"] . "," . $timestamp . " ==> " . $tval_diff . "<br/>";
				?>
				<div class = "sch-item<?php if ($i==count($sch)-1) { print ' last'; } ?>">
					<div class = "title"><?php print shorter($sch[$i]["article_name"]); ?></div>
					<div class = "when"><?php print "<span style = 'color: #333'>" . date("M d h:ma", $sch[$i]["timestamp"]) . " &nbsp;</span>"; ?></div>
					<div class = "ago"><?php print "<span style = 'color: gray'>" . $dif . " ago</span>"; ?></div>
					<div class = "status"><div class = "button silver">
					<img src = "mail<?php if ($sch[$i]["sent"] == 0) print "un"; ?>sent.png" alt = "sent" />
					<?php if ($sch[$i]["sent"] == 0) {

						print "Sending...";
						
						$post_json = $sch[$i]["json"];
						$post_type = json_decode($post_json);
						
						print $post_json;
						
						/* Make an attempt to send this item */	
						$url = $URL . "/plugins/list/send.php";
						$data = array('msg_id' => '$article_id',
						              'message' => '--- not required here ---',
						              'subject' => 'article_name',
						              'target' => $sch[$i]["type"] . ":" . $sch[$i]["email"],
						              'url' => '--- not required ---',
						              'casual_name' => '--- not required ---',
						              'email' => '--- not required ---',
						              'article_id' => $sch[$i]["article_id"],
						              'key' => $sch[$i]["key"],
						              'date' => '--- not required ---',
   						              'post_type' => $post_type->post_type);

						// use key 'http' even if you send the request to https://...
						$options = array(
						    'http' => array(
    					    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					        'method'  => 'POST',
					        'content' => http_build_query($data)
					    ));
					    
						$context = stream_context_create($options);
						$result = file_get_contents($url, false, $context);
						if ($result === FALSE) { print "<span style = 'color:redorange'>fail</span>"; } else { print "<span style = 'color:green'>ok!</span>"; }
						
					} else print "Sent!"; ?>
					
					</div></div>
				</div>
				<?php
			}
			
		}
	
	}	
?>

</div>

</body>
</html>