<?php include('../Migration/Composition.php');

    $Connection = new db();

    $key = $_POST['key'];

    $Article = db::get("`content`", get_all_from("content"), "`key` = '$key'", 1, 1);

    if ($Article[0]["navi"] == 1)
    {
        print "incl-navi-0.png";
        db::set("`content`", array("navi"), array("0"), "`key` = '$key'");
    }
    else
    {
        print "incl-navi-1.png";
        db::set("`content`", array("navi"), array("1"), "`key` = '$key'");
    }

?>