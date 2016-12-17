<?php include("../../../Migration/Composition.php");

    session_start();

    $total = floatval(0.0);
    $in = 0;

    if (empty($_SESSION['items']))
    {
        print -1;
        exit;
    }

    foreach($_SESSION['items'] as $key => $value) {
        if (is_array($value) && !empty($value)) {
            $name = $value["name"];
            $price = floatval($value["price"]);
            $num = $value["num"];

            if ($key == $_GET['array_id'])
            {
                $_SESSION['items'][$key]["num"] = $_GET["num"];

                print 1;
                exit;

            }

            //if (!empty($name) && is_numeric($price) && is_numeric($num)) {

            //}
        }
    }

    print 0;

?>