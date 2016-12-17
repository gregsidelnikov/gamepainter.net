<?php

    $DatabaseName = "master";



    $TableName = "leonart_cart";
    $TableName2 = "leonart_cart_cat";



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

            // TABLE "cart"
            $sql = 'SELECT * FROM `' . $TableName . '`';
            if (mysql_query($sql, $con)) {
                echo "<b>$TableName</b> already exists. Nothing to build. You're ok.<br/>";
            }
            else
            {
                $sql = 'CREATE TABLE `'.$TableName.'`( '. '`key` INT NOT NULL AUTO_INCREMENT, '. 'primary key(`key`),'. '`name` VARCHAR(255), '. 'description  TEXT, '. 'price FLOAT, '. 'category TEXT, '. 'date_added INT(10),'. 'items_left INT(11),'. '`image_url` TEXT,'. '`misc` TEXT,'. '`json` TEXT)';
                if (mysql_query($sql, $con)) {
                    echo "<b>$TableName</b> created on <b>$DatabaseName</b><br/>";
                } else {
                    echo "Error creating table: " . mysql_error($con) . "<br/>";
                }
            }

            // TABLE "cart_cat"
            $sql = 'SELECT * FROM `' . $TableName2 . '`';
            if (mysql_query($sql, $con)) {
                echo "<b>$TableName2</b> already exists. Nothing to build. You're ok.<br/>";
            }
            else
            {
                $sql = 'CREATE TABLE `'.$TableName2.'`( '.
                        '`key` INT NOT NULL AUTO_INCREMENT, '.
                        'primary key(`key`),'.
                        '`name` TEXT)';
                if (mysql_query($sql, $con)) {
                    echo "<b>$TableName2</b> created on <b>$DatabaseName</b><br/>";
                } else {
                    echo "Error creating table: " . mysql_error($con) . "<br/>";
                }
            }

        }

    }

?>