<html>
<head><title>Stats</title></head>
<body>
<?php
	$website = "learnjquery.org";
	$path = "/home/gregsidelnikov/public/" . $website . "/public/Migration/Composition.php";
	include($path);
	$db = new db();
	generate_report(); 
	
	
	$ExludeIpAddresses = "`ip_address` != '65.24.51.186'";
	
	$all   = db::get("visitor", "*", "`user_agent` NOT LIKE '%Googlebot%' AND $ExludeIpAddresses", "`timestamp` DESC", "", ""); // Skip Googlebot
	$last   = db::get("visitor", "*", "`user_agent` NOT LIKE '%Googlebot%' AND $ExludeIpAddresses", "`timestamp` DESC", "30", ""); // Skip Googlebot
	
	
	$available = db::get("content", "*", "", "", "", "");
	
	function times_in_array($array, $what) {
		$count = 0;
			//print "what = " . $what . "<br/>";
		for ($i=0;$i<count($array);$i++)
		{
//			print $array[$i]['url'] . "<br/>";
			if (preg_match("/" . str_replace("-"," ",$what) . "/", str_replace("-"," ",$array[$i]['url'])  ) )
				$count++;
		}
		return $count;
	}
	function generate_report() { // Function that generates the report
		// Exclude IP -- 65.24.51.186
		$ExcludedIPs = "`ip_address` != '65.24.51.186'";
		global $db, $website;
		chdir("/home/gregsidelnikov/public/" . $website . "/public/admin/analytics/");
		$YearNow = date("Y",time());
		if (mkdir($YearNow)) { /*print "Current year dir created!";*/ } else { /*print "Failed to create current year dir...";*/ }
		$data = "";
		$base = 200;
		$multiplier = 5;
		$FinalHeight = $multiplier * $base;
		?><div style = 'position: relative; width: 365px; border: 1px solid silver; height: <?php print $base; ?>px;'>
			<div style = "position: absolute; top: 0; right: 2px; font-size: 11px; font-family: Verdana;"><?php print $FinalHeight; ?></div>
		<?php
		for ($i = 0; $i < 365; $i++) {
			$time = $db->get("visitor", "COUNT(*)", "$ExcludedIPs AND `day_of_year` = '" . $i . "'", "", 1);
			$height = $time[0]["COUNT(*)"];
			if ($height == "")
				$height = 0;
				$data .= "" . $i . "=" . $height . "\r\n";
			?><div style = "position: absolute; bottom: 0px; width: 1px; background: #333; left: <?php print $i; ?>px; height: <?php print ($height/$multiplier); ?>px"></div><?php
		}
		?></div><?php
		file_put_contents("/home/gregsidelnikov/public/" . $website . "/public/admin/analytics/" . $YearNow . "/data.txt", $data);
	}
	
	$organized = array();
	$j = 0; // create organized list of all urls accesse
	for ($i = 0; $i < count($available); $i++) {
		$LOC = $available[$i]["location"];
		$times = times_in_array($all, $LOC);
		if ($times > 0) {
			$organized[$j++] = array($times, $LOC);
		}
	}
	array_multisort($organized, SORT_DESC);
?>
<style type = "text/css">
	table td { vertical-align: top; }
	
	.inline { position: relative; width: 50px; display: inline-block; }
	.inline_v2 { position: absolute; top: 0; left: 0; width: 50px; height: 14px; overflow: hidden; border:1px solid silver; }
	
	.inline_url { position: relative; width: 250px; display: inline-block; }
	.inline_v2_url { position: absolute; top: 0; left: 0; width: 250px; height: 14px; overflow: hidden; border:1px solid silver; }

	.inline_icon { position: relative; width: 12px; display: inline-block; }
	.inline_v2_icon { position: absolute; top: 0; left: 0; width: 12px; height: 14px; overflow: hidden; border:1px solid silver; }
	
	.inline_time { position: relative; width: 38px; display: inline-block; }
	.inline_v2_time { position: absolute; top: 0; left: 0; width: 38px; height: 14px; overflow: hidden; border:1px solid silver; }
	
	.w16 { width: 16px; }
	.w32 { width: 32px; }
	.w64 { width: 64px; }
	.w64 { width: 128px; }	
	
</style>
<table><tr><td>
<div style = "font-family: Verdana; font-size: 11px;">
<b>Most recent 30 pages:</b><br/>
<?php

	$icon["windows"] = "win.png";
	$icon["mac"] = "mac.png";

	$mask = "http://www.learnjquery.org/";
	for ($i = 0; $i < count($last); $i++) {
		if ($LOC == "") $LOC = "<b>" . $website . "</b>";
	$useragent = "";
	$url = $last[$i]['url'];
	if ($url == $website || $url == "www." . $website || $url == "http://www." . $website ||
    	$url == $website . "/" || $url == "www." . $website . "/" || $url == "http://www." . $website . "/") {
		$url = "<b>homepage</b>";
	} else {
		$url = str_replace($mask, "", $url);
	}
	if (preg_match("/Googlebot/", $last[$i]['user_agent']))
		$useragent = "<span style = 'color: orangered;'>BOT</span>";
		$device = $last[$i]['device'];
		$dev_img = $icon[$device]; ?>
		<div class = "inline w16"><div class = "inline_v2 w16"><?php print $i; ?></div></div>
		<div class = "inline_url"><div class = "inline_v2_url"><?php print $url; ?></div></div>
		<div class = "inline"><div class = "inline_v2"><?php print $last[$i]['date']; ?></div></div>
		<div class = "inline_time"><div class = "inline_v2_time"><?php print $last[$i]['time']; ?></div></div>
		<div class = "inline_icon"><div class = "inline_v2_icon"><img src = "<?php print $dev_img; ?>"/></div></div>
		<div class = "inline"><div class = "inline_v2"><?php print $last[$i]['browser']; ?></div></div>
<!--		<div class = "inline"><div class = "inline_v2"><?php print $useragent; ?></div></div> //-->
		<div style = ""></div>
	
	<?php


} ?></div></td><td>
<div style = "font-family: Verdana; font-size: 11px;">
<b>Most visited pages:</b><br/><br/>
<?php for ($i=0;$i<count($organized);$i++) {
	print "<b>" . $organized[$i]['0'] . "</b> " . $organized[$i]['1'] . "<br/>";
} ?>
</div></td></tr></table>

</body>
</html>