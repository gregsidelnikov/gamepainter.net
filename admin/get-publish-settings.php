<?php include('../Migration/Composition.php');

    $Connection = new db();

    $S = db::get("content", "publish_settings", "`key` = " . $_POST['key'], "", "1");

    if ($S != FALSE)
    {
       print $S['publish_settings'];
       return;
    }
    else
    {
        print mysql_error();
    }

?>