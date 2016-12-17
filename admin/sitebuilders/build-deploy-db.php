<?php
    include("../../Migration/Composition.php");
    $SchemaName = $_REQUEST["cata"];

    $db_ok = true;
    $con = mysqli_connect($_REQUEST["host"], $_REQUEST["user"], $_REQUEST["pass"]);
    if (!$con) {
        echo "Failed to connect to MySQL. Check your login credentials.<br/>";
        exit;
    } else {
        //echo "Connected to db<br/>";
        $mysql = str_replace("__SCHEMA__", $SchemaName, file_get_contents("deployment.sql"));
        if ($con->multi_query($mysql))
            print 1;
    }

?>