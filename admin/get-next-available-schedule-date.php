<?php include('../Migration/Composition.php');

    $Connection = new db();

    $Article = db::get("`content`", "scheduled", "", "", "10000");




    print $Settings[0]["web-template"];

    $t1 = time();
    $t2 = strtotime($_POST['time']);

    if ($t2 < $t1)
        print "-1";
    else
        print tval(time(), strtotime($_POST['time']));

?>