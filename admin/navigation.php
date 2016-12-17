<style>
    .nav-item { padding-left: 3px; min-width: 80px;cursor: pointer; background: url('tab-on.png') repeat-x; padding: 4px; margin-bottom: 0px;
                      width: 90%; color: #999; font-family: Verdana, sans-serif; font-size: 12px; height: 15px; }
    .nav-item:hover { background: url('tab-on-1.png') repeat-x; color: #555; }
    .nav-item.sel { background: url('tab-off.png') repeat-x; color: #555; }
    table#navigation-cfg td { vertical-align: top; }
    
    .nav-item .drop-down { display: none; position: absolute; top: 7px; right: 25px; width: 9px; height: 9px; background: url("drop-dn-arrow.png") no-repeat; }
    .nav-item .drop-down.on { display: block !important; }
    
</style>
<div style = "padding: 16px;">

    <p>Navigation Menu</p>
    
    <div style = "height: 24px;"></div>
    
    <table id = "navigation-cfg">
    <tr>
    <td>
    
    <div class = "rounded" style = "width: 150px;">
    
        <div style = "background: #eee; position: absolute; top: -8px; left: 20px; font-family: Verdana; font-size: 12px; color: gray;">&nbsp;Main Items&nbsp;</div>
        
        <div style = "padding: 4px;">
            <p style = "font-size: 11px; font-family:Verdana;color:gray;">Click on an item and drag it vertically <img src = "vertical-arrow.png" style = "vertical-align: middle; margin-top:-2px"/> to rearrange its location.</p>
        </div>
        
        <ul id = "navi-pool" style = "margin:0; padding:0;">
        
        <?php /*
            for ($i = 0; $i < count($Navigation); $i++) {
                $id = $Navigation[$i]["id"];
                $name = $Navigation[$i]["name"];
                $priority = $Navigation[$i]["priority"];
                $subitems = $Navigation[$i]["subitems"];
                $is_dropdown = $Navigation[$i]["is_dropdown"];
                $url = $Navigation[$i]["url"];
                $special_bg = $Navigation[$i]["special_bg"];
                ?>
                <div class = "nav-item" id = "nav-<?php print $i; ?>" onclick = "nav_load(<?php print $i; ?>)"><?php print $name; ?></div>
                <?php
            } */
        ?>
        
        </ul>
        
        <div style = "width: 150px; margin-top: 8px;">
            <div style = "width: 24px; height: 24px; margin: 0 auto; margin-bottom: 8px;"><a href = "#" onclick = "add_navi_item()"><img src = "plus.png" /></a></div>
        </div>
        
    </div>
    
    </td><td>
    
    <div class = "rounded" style = "width: 450px;">
        <div style = "background: #eee; position: absolute; top: -8px; left: 20px; font-family: Verdana; font-size: 12px; color: gray;">&nbsp;Tab Name:&nbsp;</div>
        <div id = "nevigation-name"
        onkeyup = "delay_save(window.NAV_NAM)"
      onkeydown = "delay_save(window.NAV_NAM)"
       onchange = "delay_save(window.NAV_NAM)"
       placeholder = "About Us"
        style = "overflow:hidden;width: 450px; height: 18px !important; background: #fff;" contenteditable = "true">
            
        </div>
    </div>

    <div class = "rounded" style = "width: 450px;">
        <div style = "background: #eee; position: absolute; top: -8px; left: 20px; font-family: Verdana; font-size: 12px; color: gray;">&nbsp;Go To URL:&nbsp;</div>
        <div id = "nevigation-url"
        onkeyup = "delay_save(window.NAV_URL)"
      onkeydown = "delay_save(window.NAV_URL)"
       onchange = "delay_save(window.NAV_URL)"
       placeholder = "http://www.google.com/"
        style = "overflow:hidden;width: 450px; height: 18px !important; background: #fff;" contenteditable = "true">
            
        </div>
    </div>

	<div style = "height: 8px;"></div>

    <div class = "rounded" style = "width: 450px;">
        <div style = "background: #eee; position: absolute; top: -8px; left: 20px; font-family: Verdana; font-size: 12px; color: gray;">&nbsp;Sub Menu Options&nbsp;</div>
        <textarea id = "nevigation-ta"
            onkeyup = "delay_save(window.NAV_SUB)"
          onkeydown = "delay_save(window.NAV_SUB)"
           onchange = "delay_save(window.NAV_SUB)"
          style = "width: 445px; height: 200px !important; background: #fff;">
            
        </textarea>
    </div>
    
    </td></tr>
    </table>

</div>