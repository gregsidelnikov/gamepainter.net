<?php

    include("../../Migration/Composition.php");

    $db = new db();

    if (is_array($_REQUEST["action"]))
    {
        if (array_key_exists("table",  $_REQUEST["action"])) $table  = $_REQUEST["action"]["table"];
        if (array_key_exists("action", $_REQUEST["action"])) $action = $_REQUEST["action"]["action"];
        if (array_key_exists("where",  $_REQUEST["action"])) $where  = $_REQUEST["action"]["where"];
        if (array_key_exists("limit",  $_REQUEST["action"])) $limit  = $_REQUEST["action"]["limit"];
        if (array_key_exists("order",  $_REQUEST["action"])) $order  = $_REQUEST["action"]["order"];
        if (array_key_exists("index_param",
                                       $_REQUEST["action"])) $index_param  = $_REQUEST["action"]["index_param"];

    }

    //if (array_key_exists("payload", $_REQUEST))
        $payload = $_REQUEST["payload"];

    $columns = array();
    $values = array();

    //print "payload=$payload";

    // Collect payload if it is not "select everything" (*)
    if ($payload != "*") {
        foreach($payload as $key => $value) {
            $columns[count($columns)] = $key;
            $values[count($values)] = $value;
        }
        $columns = array_values($columns);
        $values = array_values($values);
    }

    // Get
    if ($action == "get") {
        if ($payload == "*")
            $names = get_all_from($table);
        else
            $names = array_to_list(explode(",", $payload), '`');
        $names = str_replace(" ", "", $names);
        //print "---" . trim($names) . "---";
        if (($R = $db->get($table, $names, $where, $order, $limit, $index_param)) != FALSE)
        {
            //print "***".print_g($R)."***";
            print json_encode($R);
        }
        else {
            print json_encode( array(0=>array("email_address" => mysql_error() )) );
        }

    }

    // Set
    if ($action == "set") {// print "setting...";
        // add slashes
        foreach($values as &$v)
        {
            $v = str_replace("'", "\'", $v);
            $v = str_replace('"', '\"', $v);
        }
        if ($R = ($db->set($table, $columns, $values, $where, $limit)) != FALSE) {
            print "db:set = success";//json_encode($R);
        } else print "db:set = error->".mysql_error();
    }

    // Insert
    if ($action == "insert") {
         
        // add slashes -- added Oct 1, 2015.
        foreach($values as &$v) {
            $v = str_replace("'", "\'", $v);
            $v = str_replace('"', '\"', $v);
        }
        
        if ($R = ($db->insert($table, $columns, $values, $where, $limit)) != FALSE) {
            print $db->getLastInsertID();
        } else
            print "error: insert operation - " . mysql_error();
    }

    // Remove
    if ($action == "remove") { print "where=$where";
        if ($R = ($db->delete($table, $where, $limit)) != FALSE) {
            print $R;
        } else
            print "error: remove operation - " . mysql_error();
    }

?>