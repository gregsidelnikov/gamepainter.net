<?php require("../../Migration/Composition.php");

    $db = new db();

    if ($db->isReady()) {
        $I = $db->insert($plugin_table_cart,
            array("name","description","price","category","date_added","items_left","image_url"),
            array("item","description","0.00","category",time(),"10000",""));
        echo trim($db->getLastInsertID());
    }
?>