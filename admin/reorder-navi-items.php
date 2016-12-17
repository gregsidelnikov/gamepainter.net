<?php include("../Migration/Composition.php");
    $db = new db();
    $text = explode("|", $_POST["txt"]);
    print_g($text);
    for ($i = 0; $i < count($text); $i++) {
        $where = "`key` = '" . $text[$i] . "'";
        $db->set("content", array("navi_order"), array($i+1), $where);
    }
?>