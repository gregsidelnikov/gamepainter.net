<div id = "Navigation" class = "Brightest">
    <div style = "width: 600px; margin: 0 auto;">
        <div id = "browse"   ui = "#GameList"   	 class = "MenuOption Selected" 		onclick = "view(this)">Browse</div>
        <div id = "register" ui = "#RegisterAccount" class = "MenuOption" style = "width: 65px;" onclick = "view(this)">Register</div>
        <div id = "login"    ui = "#Login"    		 class = "MenuOption" style = "width: 65px;" onclick = "view(this)">Login</div>
        <div id = "lighbulb" ui = ""                 class = "MenuOption" style = "" onclick = "ToggleLights()"><img src = "<?php print $URL; ?>/lightbulb.png" alt = "Light Switch"/></div>
    </div>
</div>