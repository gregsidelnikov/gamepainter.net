<?php include('../Migration/Composition.php');

    $Connection = new db();
    
    $divs = db::get("divs", "*", "`title` = '" . $_POST['title'] . "'");

    $lastkey = db::get("divs", "`key`", "", "`key` DESC");

    //print $lastkey[0]['key'];
    
    if (empty($divs))
    {
        db::insert("divs", array("title","url","index"), array($_POST['title'], $_POST['url'], $lastkey[0]['key'] + 1));

        print mysql_error();

        $data =  $lastkey[0]['key'] + 1 . "#" . $_POST['title'] . "#" . $_POST['url'];

        print '<li id = "' . $data . '">' . $_POST['title'] . ' <span style = "color:gray;">' .  $_POST['url'] . '</span> <a href = "#" onclick = \'$.ajax( { url: "delete-div.php",type: "POST", data: {key: "' . db::getLastInsertID() . '" } } )\'>delete</a></li>';
    }


?>