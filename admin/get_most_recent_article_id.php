<?php include('../Migration/Composition.php');

    $Connection = new db();

    if (array_key_exists("type", $_REQUEST) && $_REQUEST['type'] != "undefined")
    {
        if (($Article = db::get("content", "*", "`type` = '" . $_REQUEST['type'] . "'", "`time` DESC", 1, 1))==FALSE)
            print mysql_error();
    }
    else
    {
        if (($Article = db::get("content", "*", "`deleted` = 0", "`last_saved_time` DESC", 1, 1))!=FALSE)
            print mysql_error();
    }

    print $Article["key"]; // old way
    //print $Article[0]["key"];

?>