<?php include('../Migration/Composition.php');

    $Connection = new db();

    $set = db::set("content", array("scheduled"), array($_POST['time']), "`key` = '" . $_POST['key'] . "'", "1");

    $t1 = time();
    $t2 = strtotime($_POST['time']);

    if ($t2 < $t1)
        print "-1";
    else
        print tval(time(), strtotime($_POST['time']));

?>