<script language = "JavaScript"></script>
<style>
div { position: relative; }
#slideshow_tbl td { vertical-align: top; }
.slideshow-item { padding-left: 3px; min-width: 80px;cursor: pointer; background: url('tab-on.png') repeat-x; padding: 4px; margin-bottom: 0px;
width: 90%; color: #999; font-family: Verdana, sans-serif; font-size: 12px; height: 15px; }
.slideshow-item:hover { background: url('tab-on-1.png') repeat-x; color: #555; }
.slideshow-item.sel { background: url('tab-off.png') repeat-x; color: #555; }
.slideshow-container { width: 600px; height: 250px; border: 1px solid gray; }
.ssh_sets td { line-height: 32px; }
.add-slideshow-item { width: 32px; height: 32px; border: 1px solid silver; border-radius: 4px; }
.minus { position: absolute; top: 3px; right: 2px; width: 18px; height: 18px; background: url("close-out.png") no-repeat; opacity: 0.9 }
.minus:hover { opacity: 1; }
.slideshow-container img { position: absolute; }
</style>

<div style = "padding: 16px;">

<div style = "position: absolute; top: 0px; left: 220px;">
    <a href = "#" onclick = "slideshow_toggle_play()"><img class = "play_on" src = "play-1.png" id = "slideshow_play_button" /></a>
</div>

<p>Slides</p>

<table style = "width: 100%;" id = "slideshow_tbl">
<tr>
  <td style = "width: 20%">

  <div id = "slides">
      <?php /* for ($i = 0; $i < count($Slide); $i++) {
          ?>
          <div id = "slide-<?php print $i; ?>"
            class = "slideshow-item"
          onclick = "select_slide(<?php print $i; ?>)"> Slide <?php print $i+1; ?><div class = "minus" onclick = "remove_slide(<?php print $i; ?>)"></div></div>
          <?php */
      //}
      ?> 
  </div>
    
    <div style = "text-align: center; margin-top: 8px;"><a href = "#"
        onclick = "add_slide_db(window.slideshow_num, website.url + '/admin/placeholder.png', 'Default text')"><img src = "plus.png" alt = "Add New Slideshow Item" /></a></div>
    
    <div style = ""></div>

  </td>
  <td style = "width: 80%">
  
      <div id = "slideshow-parent" style = "position: relative; width: 300px; height: 160px;">
          <div class = "slideshow-container" style = "position: absolute; top: 0; left: 0;
              width: 300px; height: 160px; clip: rect(0px, 300px, 160px, 0px)">
              <?php /* for ($i = 0; $i < count($Slide); $i++) {
                      ?><img id = 'slide-image-<?php print $i; ?>' src = '<?php print $Slide[$i]["url"]; ?>' style = 'position: absolute; top: 0; left: 0; z-index:1' /><?php
                  } */
              ?>
          </div>
          <div id = "resizer" style = "cursor: nwse-resize; position: absolute; bottom: -16px; right: -16px; width: 32px; height: 32px;
                                   background: url('resizer.png') no-repeat; z-index: 10000000000 "></div>
      </div>

      <div class = "slideshow-text-desc">
      
          <div style = "margin-top: 12px; border: 1px solid #999; border-radius: 7px; padding: 16px; width: 432px; position: relative;">
              <div style = "background: #eee; position: absolute; top: -8px; left: 16px; font-family:Verdana;font-size:12px;">Go to this URL when this image is clicked</div>
              <input
                    onkeyup = "update_href(window.slide_ix)"
                  onkeydown = "update_href(window.slide_ix)"
                  onchange = "update_href(window.slide_ix)"
              placeholder = "http://www.example.com/" type = "text" id = "slide-href" style = "width: 400px; border:1px solid silver; padding:2px; font-family:Arial,sans-serif;font-size: 12px;" />
          </div>
      
          <div style = "margin-top: 12px; border: 1px solid #999; border-radius: 7px; padding: 16px; width: 432px; position: relative;">
              <div style = "background: #eee; position: absolute; top: -8px; left: 16px; font-family:Verdana;font-size:12px;">Image URL Path</div>
              <input
                  onkeyup = "update_picture(window.slide_ix)"
                  onkeydown = "update_picture(window.slide_ix)"
                  onchange = "update_picture(window.slide_ix)"
              placeholder = "http://www.somewhere.com/image.png" type = "text" id = "slide-url" style = "width: 400px; border:1px solid silver; padding:2px; font-family:Arial,sans-serif;font-size: 12px;" />
          </div>
      
          <div style = "margin-top: 12px; border: 1px solid #999; border-radius: 7px; padding: 16px; width: 432px; position: relative;">
              <div style = "background: #eee; position: absolute; top: -8px; left: 16px; font-family:Verdana;font-size:12px;">Text Description</div>
              <input
                    onkeyup = "update_text(window.slide_ix)"
                  onkeydown = "update_text(window.slide_ix)"
                  onchange = "update_text(window.slide_ix)"
              placeholder = "Picture of a tree" type = "text" id = "slide-text" style = "width: 400px; border:1px solid silver; padding:2px; font-family:Arial,sans-serif;font-size: 12px;" />
          </div>
          
          <div style = "margin-top: 12px; border: 1px solid #999; border-radius: 7px; padding: 16px; width: 220px; position: relative;">
          
              <div style = "background: #eee; position:absolute; top: -8px; left: 16px; font-family:Verdana;font-size:12px;">Slideshow Dimensions</div>
          
              <table class = "ssh_sets">
              <tr>
                  <td>Width</td><td><input id = "slideshow_width" placeholder = "400" type = "text" style = "width: 45px;" value = "937" /> <i>px</i></td>
              </tr>
              <tr>
                  <td>Height</td><td><input id = "slideshow_height" placeholder = "250" type = "text" style = "width: 45px;" value = "374" /> <i>px</i></td>
              </tr>
              </table>
          
          </div>
          
      </div>
      
      <div class = "slideshow-settings">
          
      </div>
  
  </td>
</tr>
</table>

</div>