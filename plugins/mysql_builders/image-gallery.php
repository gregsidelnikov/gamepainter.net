<?php

    $DatabaseName = "master";

    $TableName2 = "leonart_gallery";

    $db_ok = true;

    $con = mysql_connect("localhost", "root", "55723105");

    if (!$con) {
        echo "Failed to connect to MySQL.<br/>";
        exit;
    } else {
        echo "Connected to db<br/>";
        if (!mysql_select_db($DatabaseName)) {
            $db_ok = false;
            $sql = "CREATE DATABASE $DatabaseName";
            if (mysql_query($sql, $con)) {
                echo "Database `$DatabaseName` created successfully<br/>";
                $db_ok = true;
            } else {
                echo "Error creating database: " . mysql_error($con) . "<br/>";
            }
        }
        else
            echo "Database <b>$DatabaseName</b> already created<br/>";

        if ($db_ok) {

            // TABLE "cart_cat"
            $sql = 'SELECT * FROM `' . $TableName2 . '`';
            if (mysql_query($sql, $con)) {
                echo "<b>$TableName2</b> already exists. Nothing to build. You're ok.<br/>";
            }
            else
            {
                // Create art gallery

                $sql = 'CREATE TABLE `'.$TableName2.'`( '.
                       '`key` INT NOT NULL AUTO_INCREMENT, '.
                       'primary key(`key`),'.
                       '`url` TEXT)'

                ;

                if (mysql_query($sql, $con))
                {
                    echo "<b>$TableName2</b> created on <b>$DatabaseName</b><br/>";
                } else {
                    echo "Error creating table: " . mysql_error($con) . "<br/>";
                }
            }

        }

    }

?>