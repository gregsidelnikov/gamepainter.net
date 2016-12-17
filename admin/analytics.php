<div style = "font-family: Verdana; font-size: 12px;">
<b><?php print $URL; ?></b><br/>
Welcome to your control panel. Click "Editor" to manage page content.
</div>
<style type = "text/css">
	#AnalyticsSidebar { width: 210px; }
	#AnalyticsList { list-style-type: none; width: 210px; margin-left: -32px;}
	#AnalyticsList li span { box-shadow: 0 0 3px #777; border-radius: 7px; width: 8px; height: 8px; display: block; position: absolute; top: 8px; right: 4px; background: black; }
	#AnalyticsList li { position: relative; cursor: pointer; padding: 4px; padding-left: 20px; padding-right: 24px; border-top: 1px solid silver; border-left: 1px solid silver; border-right: 1px solid silver; background: #fff; color: gray;font-family: Verdana; font-size: 11px; }
	#AnalyticsList li.active { background: #cfe5d8 url('analytics-check.png') no-repeat; background-position: 2px 2px; }
	#AnalyticsList li:hover { background-color: #cfe5d8; }
	#AnalyticsList li:nth-child(1) { border: 1px solid silver; border-bottom:0;border-top-left-radius: 8px; border-top-right-radius: 8px; }
	#AnalyticsList li:last-child { border: 1px solid silver; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
	#AnalyticsView { width: 100%; position: absolute; top: 0; left: 250px;  }
	#chart { background: #000; }
</style>

<script type = "text/javascript">
var colors = ["#7d7d7d",
"#f8c600",
"#87f900",
"#00ffe4",
"#008aff",
"#6300f7",
"#de00ff",
"#c43e54",
"#979911",
"#826d6c"];
function day_of_year(date) {
      var EnteredMonth = date.getMonth();// document.MyForm.Date1.value.substr(0,2) - 1;
      var EnteredDay = date.getDay();//document.MyForm.Date1.value.substr(3,2);
      var EnteredYear = date.getYear();//document.MyForm.Date1.value.substr(6,4);
      // Create a new date object with the entered month, day and year
      var EnteredDate = new Date(EnteredYear, EnteredMonth, EnteredDay, 0, 0, 0);
	  today=new Date()
	  var startofyear=new Date(EnteredDate.getFullYear(), 0, 1)
      var one_day=1000*60*60*24
      var DayOfYear = Math.ceil((EnteredDate.getTime() - startofyear.getTime()) / one_day) + 1
      return DayOfYear;
}
	function make_unselectable(selector, color) {
		$(selector).attr("unselectable", "on");
		$(selector).attr("onselectstart", "return false;");
		$(selector).attr("onmousedown", "return false;");
		$(selector).attr("select", "-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;");
		$(selector).attr("color", color);
	}
	$(document).ready(function() {
	
		var ChartWidthMultiplier = 3;
	
		var ChartWidth = 365;
		var ChartHeight = 200;
		var Context = new HTML("chart", ChartWidth*ChartWidthMultiplier, ChartHeight); window.gfx = Context.context;

		var date = new Date();

		setInterval(function() {
			gfx.globalAlpha = 1;
	        gfx.beginPath();
        	gfx.rect(0, 0, ChartWidth*ChartWidthMultiplier, ChartHeight);
    	    gfx.fillStyle = 'black';
	        gfx.fill();
	        
	        var x = day_of_year(date);
	        
        	var segment = new Segment(x*ChartWidthMultiplier,200,0,-200);
        	segment.draw(1, "gray");
	        
//	        for (var i = 0; i < 365; i++)
//	        {
	        	//var x = i * 7;
	        	var segment = new Segment(x*ChartWidthMultiplier,200,0,-200);
	        	segment.draw(1, "gray"); // today
//	        }
		});
	
		var color_index = 0;
		var can_store = html5_storage();
		$("#AnalyticsList li").each(function() {
			if (can_store) if (localStorage[$(this).text()] == "true") $(this).addClass("active"); else $(this).removeClass("active");
			make_unselectable($(this), colors[color_index]);
			$("span", this).attr("style", "background: " + colors[color_index]);
			color_index++;
		});
		
		$("#AnalyticsList li").on("click", function() {
			$(this).toggleClass("active");
			if (can_store) {
				if ($(this).hasClass("active"))
					localStorage[$(this).text()] = true;
				else
					localStorage[$(this).text()] = false;			
			}
		})
		
		
		
	});
</script>

<div id = "Analytics">
	<div id = "AnalyticsSidebar">
		<ul id = "AnalyticsList">
			<li>AuthenticSociety.com<span></span></li>
			<li>LearnjQuery.com<span></span></li>
			<li>FalloutSoftware.com<span></span></li>
			<li>WebsiteHomework.com<span></span></li>
			<li>BySpirit.net<span></span></li>
			<li>GregsWebDesign.net<span></span></li>
			<li>TigrisGames.com<span></span></li>
			<li>Wildfy.re<span></span></li>
			<li>RiverTigris.com<span></span></li>
			<li>CustomPortraitDrawings.net<span></span></li>
		</ul>
		<br/><br/>
		<div style = "cursor: pointer; text-align: center; position: relative; width: 100px; margin: auto;
				padding: 5px; font-family:verdana; font-size: 12px; color: gray; border:1px solid silver; border-radius: 5px;">
			Recalculate
		</div>
	</div>
	
	<div id = "AnalyticsView">
	
		<div id = "Chart">
		
			<canvas id = "chart" style = "position: relative; width: <?php print 365 * 3; ?>px; height: 200px;"></canvas>
			
		</div>
		
		<div id = "List">
		
			<ul>
				<li>http://www.authenticsociety.com/dali.html</b></li>
				<li>http://www.authenticsociety.com/persistence_of_memory.html</b></li>
				<li>http://www.authenticsociety.com/jquery-plugins.html</b></li>				
			</ul>
		
		</div>
	
	</div>
	
</div>

