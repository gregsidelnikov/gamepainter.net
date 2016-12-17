<?php include('../Migration/Composition.php');

    $Connection = new db();

    //print_g($_POST['order']);

    //$new_order = explode(":",$_POST['order']);

    //print_g($_POST['order']);

    //print "\r";

    if (!empty($_POST['order']))
    {
        for ($i = 0; $i < count($_POST['order']); $i++)
        {
            $line = explode("#", $_POST['order'][$i]);
            $id = $line[0];
            $title = $line[1];
            $url = $line[2];

            // reverse id
            //$id = $i;//count($_POST['order']) - 1 - $i;

            //print "$i $id $title $url;\r";

            if (is_numeric($id))
                db::set("`divs`", array("index"), array($i), "`title` = '" . $title .  "'");
        }
    }



    //$divs = db::get("divs", "*", "`title` = '" . $_POST['title'] . "'");

    /*if (empty($divs))

        db::insert("divs", array("title","url"), array($_POST['title'], $_POST['url']));
        print '<li><?php print $_POST[\'title\']; ?> <span style = "color:gray;"><?php print $_POST[\'url\']; ?></span> <a href = "#" onclick = "">delete</a></li>';
    }*/

    //return 0;

?>