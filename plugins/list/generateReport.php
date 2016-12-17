<?php
    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/swift/lib/swift_required.php");

	$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
	$mailer = Swift_Mailer::newInstance($transport); 
	
	date_default_timezone_set ( "America/New_York" );
	
	$db = new db();

	if ($GenerateFromCron == false) // cron is already doing it;
	if (array_key_exists("msg_id", $_POST)) {
		if (is_numeric($_POST["msg_id"])) {
			if (($_POST["msg_id"] && is_numeric($_POST["interval"])))
				generate_report($_POST["msg_id"], $_POST["interval"]);
		} else
			print "*** Notice _POST[msg_id] is non numeric.\n*** Skipping generating report.\n*** This does not affect cron report generation.\n";
	} else
		print "*** Notice _POST[msg_id] array key does not exist.\n*** Skipping generating report.\n*** This does not affect cron report generation.\n";
	
	function generate_report($msg_id, $interval) // Function that generates the report
	{	
		if (!is_numeric($msg_id))
			return;
	
		global $URL, $db, $transport, $mailer, $REMOTE_ADDR, $LOCALHOST, $_SERVER, $SERVER_PATH;
						
		$content = $db->get("content", "title", "`key`='" . $msg_id . "'","",1,"");
		$sent = $db->get("sent", "`num`,`key`,`msg_id`", "LEFT(msg_id, 3) = '$msg_id'","",1,"");
		$TotalSent = $sent[0]["num"];
		$timestampFirst = 0;
		$timestampLast = 0;
		$time = $db->get("msg_opens", "*", "LEFT(msg_id, 3) = '$msg_id'", "`timestamp` ASC", 1, ""); // First
		$timestampFirst = $time[0]["timestamp"];
		$time = $db->get("msg_opens", "*", "LEFT(msg_id, 3) = '$msg_id'", "`timestamp` DESC", 1, ""); // Last
		$timestampLast = $time[0]["timestamp"];
		
		
		if ($timestampLast > $timestampFirst + 86400*5) // 5 days max report
			$timestampLast = $timestampFirst + 86400*5; 
		
		$all = $db->get("msg_opens", "DISTINCT(user_id)", "LEFT(msg_id, 3) = '$msg_id'", "", "");
		$total = count($all);		
		$intervalNum = $timestampLast - $timestampFirst; // how many invervals fit?
		
		$int_num = intval($intervalNum/$interval);
		
		$time_idx = 0;
		$jumper = 0;
		print "*** " . number_format($total,0) . " total messages opened.\n";
		$data = array();
		$data2 = array();
		$beginTime2 = array();
		$endTime2 = array();
		$PeakOpensR = 0; //	with repeats
		$PeakOpens = 0; // unique users only
		$PeakOpensPos = array(0, 0);
		$PeakOpensRPos = array(0, 0);
		$PeakDate = "";
		
		
		print "*** generating report for newsletter id#$msg_id, please wait...\n";

		
//		print date("M D Y h:s:ma T", $timestampFirst) . " ==> " . date("M D Y h:s:ma T", $timestampLast) . " hello... and total = " . $total . " and int_num = " . $int_num . " and intervalNum=" . $intervalNum;
//			exit;

		
		for ($i=0;$i<$int_num;$i++) {
		$beginTime = $timestampFirst + ($i * $interval);
		$endTime = $beginTime + ($i * $interval);
		$beginTime2[$i] = $beginTime;
		$msg = $db->get("msg_opens", "count(*)", "`timestamp` > '" . $beginTime . "' AND `timestamp` < '" . $endTime . "' AND LEFT(msg_id, 3) = '$msg_id'", "", "");
		$opens_num = $msg[0]["count(*)"];
		$msg2 = $db->get("msg_opens", "DISTINCT(user_id)", "`timestamp` > '" . $beginTime . "' AND `timestamp` < '" . $endTime . "' AND LEFT(msg_id, 3) = '$msg_id'", "", "");
		$opens_num2 = count($msg2);
		$data[$i] = $opens_num;
		$data2[$i] = $opens_num2;
		if ($PeakOpensR < intval($opens_num)) {
			$PeakOpensR = intval($opens_num);
			$PeakDateR = date("g:m:sa T", $beginTime);
			$PeakOpensRPos = array($i/* * 1.25*/, $opens_num);
		}
		if ($PeakOpens < intval($opens_num2)) { // collect unique only
			$PeakOpens = intval($opens_num2);
			$PeakDate = date("g:m:sa T", $beginTime);
			$PeakOpensPos = array($i/* * 1.25*/, $opens_num);
		}
		/* --- do not output report visually
		?>
		<div style = "position: absolute; bottom:0; left:<?php print $i*1.25; ?>px;width: 1.25px; height: <?php print ($opens_num/5); ?>px; background: #4db2ff;">
		<?php */
		if ($time_idx++ >= 60) {
			$jumper++;
			$adj = ($jumper % 2) * 16;
			/* -- disable visual output
				?><div style = "font-family: Verdana; font-size: 10px; color: gray; position: absolute; bottom: <?php print -32-$adj; ?>px; left: -16px; width: 32px; border: 0;"><?php print date("ga", $beginTime); ?><div style = "position: absolute; top:<?php print -32-$adj/2; ?>px;left:16px; height: 32px; width:1px; border-left:1px solid gray;"></div></div><?php
			*/
			$time_idx = 0;
		}
		/* ?></div><?php */
		}
		// Generate Image ---
		$CHART_SCALE = 7;
		$CHART_WIDTH = 1000;
		$CHART_HEIGHT = $PeakOpens/$CHART_SCALE + 200;
		$image = imagecreate($CHART_WIDTH, $CHART_HEIGHT + 32) or die("GD library not activated");
		$background_color = imagecolorallocate($image, 255,  255,  255);	
		$blue = imagecolorallocate($image, 77, 178, 255);
		$green = imagecolorallocate($image, 77, 278, 178);
		$white = imagecolorallocate($image, 255, 255, 255);
		$gray = imagecolorallocate($image, 50, 50, 50);
		$font_file = './arial.ttf';
		$font_bold = './arial_bold.ttf';
		$time_idx2 = 0;
		$BarCount = count($data);
		if ($BarCount < 1000) $BarCount = 1000;	// Always respect the minimum chart width of 1000, to avoid spacing between bars on smaller charts
		$BarDistance =  $CHART_WIDTH / $BarCount;
		for ($i=0;$i<count($data);$i++) { // write the bars to the image...
			$opens_num = $data[$i];
			$opens_num2 = $data2[$i];
			$notch_x = $i * $BarDistance;
			imagefilledrectangle($image, $notch_x, $CHART_HEIGHT, $notch_x, $CHART_HEIGHT-($opens_num/$CHART_SCALE), $blue);
			imagefilledrectangle($image, $notch_x, $CHART_HEIGHT, $notch_x, $CHART_HEIGHT-($opens_num2/$CHART_SCALE), $green);
			if ($time_idx++ >= 60) { imageline($image, $notch_x, $CHART_HEIGHT + 4, $notch_x, $CHART_HEIGHT, $green); imagefttext($image, 7, 0, $notch_x - 2, $CHART_HEIGHT + 16,  $gray, $font_file, date("g", $beginTime2[$i]) . "\r\n" . date("a", $beginTime2[$i])); $time_idx = 0; }
		}
		// Print peak values ---
		imagefttext($image, 9, 0,$PeakOpensPos[0]*$BarDistance-12, $CHART_HEIGHT-8-$PeakOpens/$CHART_SCALE,  $gray, $font_bold, $PeakOpens);
		imagefttext($image, 9, 0,$PeakOpensRPos[0]*$BarDistance-12, $CHART_HEIGHT-8-$PeakOpensR/$CHART_SCALE,  $blue, $font_bold, $PeakOpensR);
		$PercentOpened = ($total / $TotalSent) * 100;
		$TotalOpened = number_format($total,0);
		$S = "";
		$total == 1 ? $S = "" : $S = "s";
		imagefttext($image, 11, 0, $CHART_WIDTH/2-256, 32,  $gray, $font_file, /*'BarCount=' . $BarCount . ', BarDistance='.$BarDistance . ','.*/number_format($TotalSent, 0) . ' sent. ' . number_format($total, 0) . ' (' . number_format($PercentOpened, 0) . '%) opened. Peak messages ' . number_format($PeakOpens, 0) . ' at about ' . $PeakDate);
		$getcwd = getcwd();
		$GeneratedImageFile = $msg_id . "-" . $interval . ".png";
		chdir($getcwd . "/reports");
		$output_dir = $SERVER_PATH . "plugins/list/reports/" . $GeneratedImageFile;
		if (imagepng($image, $output_dir)) {
			print "*** imagepng($image, $output_dir) -- success!\n";
		} else {
			print "*** image $GeneratedImageFile -- failed to write to /reports directory!\n";
		}
		chdir($getcwd);
		
		// Set as "reported"
		$db->set("sent", array("reported"), array("1"), "msg_id = '" . $sent[0]["msg_id"] . "'");
		
		// Send notification ---
		$Subject = number_format($total,0) . " message" . $S . " (" . number_format($PercentOpened, 1) . "%) opened for <" . strtolower($content[0]["title"]) . ">";
		$img_url = $URL . '/plugins/list/reports/' . $GeneratedImageFile . '?v=' . time();
		$message = Swift_Message::newInstance( $Subject )
			  ->setFrom(array('reports@learnjquery.org' => 'Report'))
			  ->setTo(array('greg.sidelnikov@gmail.com'))
			  ->setBody('This is your newsletter opens report for ' . $msg_id . '-' . $interval . '<br/><b>Newsletter Name:</b> ' . $content[0]["title"] . '<br/><b>Total:</b> ' . number_format($total, 0) . ' messages were opened.<br/><b>Peak Hour:</b> ' . number_format($PeakOpens, 0) . ' at about ' . $PeakDate .
			  '<br><b>Generated image file:</b> http://www.learnjquery.org/plugins/list/repports/' . $GeneratedImageFile . '<a href = "<?php print $img_url; ?>"><img style = "width: 75%; height: 75%;" src = "' . $img_url . '" alt = "Newsletter report"/></a>', 'text/html');

		$result = $mailer->send($message);
	}
?>