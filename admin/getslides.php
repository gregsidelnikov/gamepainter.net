<?php
    include('../Migration/Composition.php');
    $Connection = new db();
    $Slide      = db::get("`slideshow`", get_all_from("slideshow"), "`slide_id` != 'w' AND `slide_id` != 'h'", "");   
    print json_encode($Slide);
?>