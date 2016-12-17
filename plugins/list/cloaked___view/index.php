<?php
    require_once('/home/gregsidelnikov/public/learnjquery.org/public/Migration/Composition.php');
    require_once("/home/gregsidelnikov/public/learnjquery.org/public/plugins/list/maintenance/multisort.php");
    date_default_timezone_set ( "America/New_York" );
	?><html>
	<head>
		<title>List</title>
    	<script src = 'http://www.learnjquery.org/js/jquery.js' type = 'text/javascript'></script>
	    <script src = 'http://www.learnjquery.org/js/ui.js' type = 'text/javascript'></script>
		<script type = 'text/javascript' language = 'javascript'>	
			function ContainsEmail(arr, email) {
				for (var i = 0; i < arr.length; i++)
					if (arr[i] == email)
						return true;
				return false;
			}
			// Take an array of emails;
			// Subtract all emails in array Subtraction from SubstractFrom
			// And return the resulting array
			function subtractList(SubstractFrom, Substraction) {
				var result = SubstractFrom;
				for (var i = 0; i < Substraction.length; i++) {
					var index = result.indexOf(Substraction[i]);
					result.splice(index, 1);
				}
				return result;
			}
			
			// Grab list of emails from the list that are belated (message not opened by that user in over 2 months; or 8 weeks)
			window.AtLeastOneOpened = new Array();
			window.Belated = new Array();
			window.Subscribed = new Array();
			window.Unsubscribed = new Array();
			window.AllMinusUnsubscribed = new Array();
			window.BelatedMinusUnsubscribed = new Array();
			window.NeverOpened = new Array();
			
			function calc_push_lists() {
			
				window.AtLeastOneOpened = new Array();
				window.Belated = new Array();
				window.Subscribed = new Array();
				window.Unsubscribed = new Array();
				window.AllMinusUnsubscribed = new Array();
				window.BelatedMinusUnsubscribed = new Array();
				window.NeverOpened = new Array();	

				var unixtime = parseInt(new Date().getTime()/1000);
				var week = 604800;
//				var email_list_1_length = 0;
				console.log("unixtime = " + unixtime);
				$("td.last_open_time").each(function(i,v){
					var email = $("b.email_address", $(v).parent()).text();
					var timestamp = parseInt($(v).attr("timestamp"));
					window.AtLeastOneOpened[window.AtLeastOneOpened.length] = email;
					if (unixtime-timestamp >= week * 8) { // Last message was open later than 2 months (or 8 weeks!)
						$(v).addClass("highlighted");
						window.Belated[window.Belated.length] = email;
					}
				});
				
//				console.log("Belated Length = " + window.Belated.length);				
								
				// Get all subscribers who are still subscribed
				$.ajax({ url : "get_all_subscribed.php", type : "POST", data : {},
				    success : function( msg ) {
	
					    // 1. --- Get all subscribed
				    	window.Subscribed = eval( msg );
//				    	console.log( "Subscribed Len = " + window.Subscribed.length );
				    	
						$.ajax({ url : "get_all_unsubscribed.php", type : "POST", data : {},
						    success : function( msg ) {
						    
							    // 2. --- Get all unsubscribed
						    	window.Unsubscribed = eval( msg );
//						    	console.log( "Unsubscribed Len = " + window.Unsubscribed.length );
						    	$("#subs_unsubs").text(window.Unsubscribed.length);
						    	
						    	// 3. --- Get entire list, but skip all unsubscribed members:
								window.AllMinusUnsubscribed = subtractList(window.Subscribed, window.Unsubscribed); 
//								console.log("AllMinusUnsubscribed.length = " + window.AllMinusUnsubscribed.length);
								
								// 4. --- Get Belated minus unsubscribed
								window.BelatedMinusUnsubscribed = subtractList(window.Belated, window.Unsubscribed);
//								console.log("BelatedMinusUnsubscribed.length = " + window.BelatedMinusUnsubscribed.length);
								$('#subs_more_than_length').text( window.BelatedMinusUnsubscribed.length );
								
								// 5. --- Get all; minus unsubscribed, minus any that opened at least 1 or more times
								//        This gets us a list of members that never registered *any* opens, ever.
								window.NeverOpened = subtractList(window.AllMinusUnsubscribed, window.AtLeastOneOpened);
//								console.log("NeverOpened.length = " + window.NeverOpened.length);
								$("#subs_never").text(window.NeverOpened.length);
								
								$("#cron_button").fadeIn(300);
								
						    }
						}); // $.ajax 2
				    }
				}); // $.ajax 1
				
			}
			function push_to_cron() {
				console.log("Scheduling " + window.BelatedMinusUnsubscribed.length + " belated messages, please wait...");
				$.ajax({
					url : "scheduleFollowupMsg.php", type : "POST",
					data : { message_Type: "Belated", list: window.BelatedMinusUnsubscribed.toString() },
					success : function(msg) {
						console.log( msg );
						console.log("Scheduling " + window.NeverOpened.length + " messages for <never opened> subscribers, please wait...");
						$.ajax({
							url : "scheduleFollowupMsg.php", type : "POST",
							data : { message_Type: "NeverOpened", list: window.NeverOpened.toString() },
							success : function(msg) { console.log( msg ); }
						});
					}
				});
			}
		</script>
	</head>
	<body>

	<style>
		body * { font-family: verdana; font-size: 11px; }
		.empty { width: 100px; height: 3px; border: 1px solid gray; }
		table { 
		    border-spacing: 0px;
		    border-collapse: separate;
		}
		.highlighted { background : yellow !important }

		table tr:nth-child(4) { display:none; }
	</style>
	
	
	<div style = "padding: 4px; position: absolute; left: 850px; top: 50px; width: 325px; height: 200px; background: white; border:1px solid gray;">
		<b>Shepherd V1.0</b><br><br>
		<b>Belated Opens<span style = "color:gray;"> >= 2 months ago</span></b><br>
		<span id = "subs_more_than_length">0</span><br><br>
		<b>Never Opened Any</b><br>
		<span id = "subs_never">0</span><br><br>
		<b>Unsubscribed</b><br>
		<span id = "subs_unsubs">0</span><br><br>

		<div style = "text-align:center;">
			<input type = "button" value = "Recalculate" onclick = "calc_push_lists()" /><br><br>
			<input type = "button" value = "Push To Cron" onclick = "push_to_cron()" style = "display:none" id = "cron_button" />
		</div>
	</div>
	

	<?php
		include("list.php");
	?>

<div style = "position: absolute; top: 0; right: 0; padding: 16px; font-size: small; font-family:Verdana,arial,sans-serif">

<b>Batches Sent:</b>

<?php /*for ($i=0;$i<count($u) / 500;$i++) { ?>
<div class = "empty"></div>
<?php } */?>

</div>

</body>
</html>
