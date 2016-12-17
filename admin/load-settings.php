<?php include('../Migration/Composition.php');

    $db = new db();

    $Article = $db->get("`settings`", get_all_from('settings'), "", 1, 1);
    print json_encode($Article[0]);

?>