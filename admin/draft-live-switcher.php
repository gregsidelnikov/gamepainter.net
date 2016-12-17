<?php include('../Migration/Composition.php');

    $Connection = new db();

    $key = $_POST['key'];

    $Article = db::get("`content`", get_all_from("content"), "`key` = '$key'", 1, 1);

    if ($Article[0]["draft"] == 1)
    {
        print "live.png";
        db::set("`content`", array("draft"), array("0"), "`key` = '$key'");
    }
    else
    {
        print "draft.png";
        db::set("`content`", array("draft"), array("1"), "`key` = '$key'");
    }

    // Update RSS
            //include("../rss/generate.php");

?>