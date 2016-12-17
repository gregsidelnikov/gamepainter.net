<?php require("../../Migration/Composition.php");

    $db = new db();

    if ($db->isReady()) {
        $I = $db->delete($plugin_table_cart, "`key`='" . $_REQUEST["id"] . "'");
    }

?>