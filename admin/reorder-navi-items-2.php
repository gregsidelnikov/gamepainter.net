<?php include("../Migration/Composition.php");
    $db = new db();
    $text = explode("|", $_POST["txt"]);
    print_g($text);
    for ($i = 0; $i < count($text); $i++) {
        $where = "`id` = '" . $text[$i] . "'";
        $db->set("navigation", array("priority"), array($i+1), $where);
    }
?>