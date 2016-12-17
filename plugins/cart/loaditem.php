<?php require("../../Migration/Composition.php");

    $db = new db();

    if ($db->isReady()) {
        $I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "`key`='" . $_REQUEST["id"] . "'");
        echo json_encode($I);
    }

?>