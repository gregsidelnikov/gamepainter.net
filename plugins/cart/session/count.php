<?php include("../../../Migration/Composition.php");


    session_start();
    $total = floatval(0.0);
    $in = 0;

    if (empty($_SESSION['items']))
    {
        print "0|0";
        exit;
    }

    foreach($_SESSION['items'] as $key => $value) {
        if (is_array($value) && !empty($value)) {
            $name = $value["name"];
            $price = floatval($value["price"]);
            $num = $value["num"];

           // print $name."|".$price."|".$num."|";

            if (!empty($name) && is_numeric($price) && is_numeric($num)) {



                $in += $num;
                $total += floatval($price) * $num;

                //print $total."<br/>";
            }
        }
    }
    print $in."|" . number_format($total,2);
?>