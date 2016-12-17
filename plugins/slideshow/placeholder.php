<style>
#Slideshow { overflow:hidden; }
#Slideshow img { position: absolute; display:none; }
.clicker { opacity: 0.5; }
</style>
<div id = "Slideshow" style = "position: absolute; top:0;left:0;width: 756px; height: 465px; clip: rect(0px,756px,465px,0px);">
    <img src = "<?php print $URL; ?>/plugins/slideshow/images/image1.jpg" style = "" id = "slide1"/>
    <img src = "<?php print $URL; ?>/plugins/slideshow/images/image2.jpg" style = "" id = "slide2"/>
    <img src = "<?php print $URL; ?>/plugins/slideshow/images/image3.jpg" style = "" id = "slide3"/>
    <img src = "<?php print $URL; ?>/plugins/slideshow/images/image4.jpg" style = "" id = "slide4"/>
    <img src = "<?php print $URL; ?>/plugins/slideshow/images/image5.jpg" style = "" id = "slide5"/>
    <div  id = "text1"></div>
    <div  id = "text2"></div>
    <div  id = "text3"></div>
    <div id = "slide_navi" style = "position: absolute; top: 443px; right: 0; width: <?php print 5 * (18) ?>px;">
        <div class = "clicker"></div>
        <div class = "clicker"></div>
        <div class = "clicker"></div>
        <div class = "clicker"></div>
        <div class = "clicker"></div>
    </div>
</div>