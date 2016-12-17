<?php
    include('../Migration/Composition.php');
    $Connection = new db();
    $Navigation = db::get("`navigation`", get_all_from("navigation"), "", "`priority` ASC", "70", 1);   
    print json_encode($Navigation);
?>