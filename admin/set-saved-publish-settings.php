<?php include('../Migration/Composition.php');

    $Connection = new db();

    $G = db::get("saved_publish_configs", get_all_from("saved_publish_configs"), "`name` = '" . $_POST['name'] . "'", "", "1000");

    //print_g($G);

    if (empty($G))
    {
        $S = db::insert("saved_publish_configs",
            array("name", "json"),
            array(addslashes($_POST['name']), addslashes($_POST['json'])));
    }
    else
    {
        $S = db::set("saved_publish_configs",
            array("name", "json"),
            array(addslashes($_POST['name']), addslashes($_POST['json'])),
                  "`name` = '" . $_POST['name'] . "'");

        if ($S != FALSE)
            print "json set success!";
        else
            print mysql_error();
    }

?>