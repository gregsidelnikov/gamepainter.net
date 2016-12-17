<?php include('../Migration/Composition.php');

    $Connection = new db();

    $S = db::get("saved_publish_configs", get_all_from("saved_publish_configs"), "`key` = " . $_POST['key'], "", "1");

    if ($S != FALSE)
        print $S['json'];
    else
        print mysql_error();

?>