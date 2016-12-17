<?php include('../../Migration/Composition.php');


/*
    $PrivilegedAccess = false;
    // Prevent unauthorized access -- based on IP address of administrator
    //  print $_SERVER["REMOTE_ADDR"]; //print $BLACK_SHEEP_IP;
    if ($LOCALHOST) { } else {
        // print "ipp=".$BLACK_SHEEP_IP;
		// Older: 65.24.43.194
        if ("65.24.51.186" != $_SERVER["REMOTE_ADDR"]) {
            exit;
        } else {
            $PrivilegedAccess = true;
        }
    }
  */  
    $PrivilegedAccess = true;
    
?>
<html>
<head>
<script type = "text/javascript">
    window.url = '<?php print $URL; ?>';
    window.list_id = '<?php print $DEFAULT_SUBSCRIBER_LIST_ID; ?>';
</script>
<script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
<script type = "text/javascript">
	$(document).ready(function() {
	
	});
	
	function generate(title)
	{
		var msg_info = $("#MessageInfo option:selected").val();
		var msg_id = msg_info.split("-")[0];
		console.log("msg_id = " + msg_id);
		var interval = $("#Interval option:selected").val();
		console.log("interval = " + interval);
		
		
		$("#ReportView").html("Generating report for '" + title + "'...");

		
		$.ajax({
				"url" : "generateReport.php",
				"type" : "POST",
				"data" : { "msg_id":msg_id,
						   "interval":interval },
				success : function(msg) {
 					console.log(msg);
					$("#ReportView").html(msg);
				}
			});
		
	}
</script>
</head>
<body>
<style>
body * { font-size: 20px; font-family: Arial, sans-serif; }
#ReportView { height: 250px; border: 1px solid silver; padding: 32px; position: relative; }
</style>
<center>
<?php
    if ($PrivilegedAccess) {
		$db = new db();
		$sent = $db->get("sent", "*", "", "`timestamp` DESC", 5, "");
		      //$db->get("subscribers", "email_address", "`key` = '" . $_GET["uid"] . "'", "", "1");
		?><p>Last 5 newsletters that were sent:</p><select id = "MessageInfo"><?php
		for ($i = 0; $i < count($sent); $i++)
		{	
			$key_id = explode("-",$sent[$i]["msg_id"])[0];
			$msg_info = $db->get("content", "*", "`key` = $key_id", "", 1, "");
			?><option title = "<?php print $msg_info[0]['title']; ?>" value = "<?php print $sent[$i]["msg_id"]; ?>"><?php print $sent[$i]["key"] . " " . $sent[$i]["msg_id"] . " - " . $msg_info[0]["title"]; ?></option><?php 
		}
		?></select>
		
		<p>Select interval <select id = "Interval">
		    <option value = "60" selected>1 minute</option>
		    <option value = "300">5 minutes</option>
		    <option value = "900">15 minutes</option>
		    <option value = "1800">30 minutes</option>
		    <option value = "3600">1 hour</option>
		    <option value = "10800">3 hours</option>
		    <option value = "21600">6 hours</option>
		    <option value = "43200">12 hours</option>
		</select></p>
		<p><input type = "button" value = "Generate Report" onclick = "generate($('#MessageInfo option:selected').attr('title'))"></p>
		
		<?php
    }
?><br>
<div id = "ReportView">
</div>
</center>
</body>
</html>