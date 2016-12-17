<?php
include("../../Lib/function.Database.php"); // added for print_g only!
$DatabaseName = "master";
    $TableName = "leonart_custom_pricing";
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

        if ($db_ok)
        {
            $sql = 'SELECT * FROM `' . $TableName . '`';
            if (mysql_query($sql, $con))
            {
                echo "<b>$TableName</b> already exists. Nothing to build. You're ok.<br/>";
            }
            else
            {

            }

            $sql = 'CREATE TABLE `'.$TableName.'`( '. '`key` INT NOT NULL AUTO_INCREMENT, '.
                       'primary key(`key`),'.
                       '`item` VARCHAR(255), '.
                       'description TEXT, '.
                       'price FLOAT, '.
                       '`image_url` TEXT,'.
                       '`misc` TEXT,'.
                       '`json` TEXT)';

                if (mysql_query($sql, $con))
                    echo "<b>$TableName</b> created on <b>$DatabaseName</b><br/>";
                else
                    echo "Error creating table: " . mysql_error($con) . "<br/>";

                $Cust = array(
                    array(0=>"Paper",1=>"Printed on paper", 2=>"10.00", 3=>"", 4=>"{}"),
                    array(0=>"Canvas",1=>"Printed on canvas", 2=>"20.00", 3=>"", 4=>"{}"),
                    array(0=>"Small 10 x 12",1=>"10 x 12", 2=>"20.00", 3=>"", 4=>"{}"),
                    array(0=>"Medium 18 x 24",1=>"18 x 24", 2=>"40.00", 3=>"", 4=>"{}"),
                    array(0=>"Large 24 x 36",1=>"24 x 36", 2=>"50.00", 3=>"", 4=>"{}"),
                    array(0=>"Frame 1",1=>"f1", 2=>"10.00", 3=>"", 4=>"{}"),
                    array(0=>"Frame 2",1=>"f2", 2=>"20.00", 3=>"", 4=>"{}"),
                    array(0=>"Frame 3",1=>"f3", 2=>"30.00", 3=>"", 4=>"{}"),
                    array(0=>"Frame 4",1=>"f4", 2=>"40.00", 3=>"", 4=>"{}"),
                    array(0=>"White",1=>"color 1", 2=>"10.00", 3=>"", 4=>"{}"),
                    array(0=>"Black",1=>"color 2", 2=>"10.00", 3=>"", 4=>"{}"),
                    array(0=>"Grey",1=>"color 3", 2=>"10.00", 3=>"", 4=>"{}"),
                    array(0=>"Brown",1=>"color 4", 2=>"10.00", 3=>"", 4=>"{}")
                );

            print_g($Cust);

            /* Drop table to clean it */
            mysql_query("DELETE FROM `$TableName`", $con);

            /* Populate table */
            for ($i = 0; $i < count($Cust); $i++)
            {
                $mysql = 'INSERT INTO `'.$TableName.'` (`item`,`description`,`price`,`image_url`,`json`) VALUES ("'.$Cust[$i][0].'", "'.$Cust[$i][1].'", "'.$Cust[$i][2].'", "'.$Cust[$i][3].'", "'.$Cust[$i][4] . '")';
                if (mysql_query($mysql, $con))
                {
                    print "Inserted Items.";
                }
            }

        }

    }

?>