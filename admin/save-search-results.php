<?php include('../Migration/Composition.php');

    $Connection = new db();

    mysql_query("TRUNCATE TABLE `search_results`");

    if (db::insert("`search_results`", array("listing"), array(addslashes($_POST['data']))) != FALSE)
       print "";
    else
        print_g(mysql_error());

?>