<?php

    require_once("../../../Migration/Composition.php");

    session_start();

    $x = intval($_SESSION['num']);

    $KeyId = -1;
    $ItemName = $_GET['item_name'];
    $ItemPrice = $_GET['item_price'];
    $ItemQty = $_GET['item_qty'];

        $break = false;
        foreach ($_SESSION['items'] as $key => $value)
        {
            //echo "$key > $value<br/>";
            foreach ($value as $k => $v)
            {
                //echo "$k > $v<br/>";
                if ($v == $ItemName) {
                    $KeyId = $key;
                    $break = true;
                    break;
                }
            }
            if ($break)
                break;
        }

        // Item was found
        if ($break)
        {
            //echo "Item already exists, increase its num<br/>";
            $_SESSION['items'][$KeyId]['num'] += $ItemQty;

            $ItemQty == 0 ? $s = "" : $s = "s";
            $ItemQty == 1 ? $is = "is" : $is = "are";
            //$msg =  . " item was added to your shopping cart. You can <a href = 'view_cart_contents.php'>view your shopping cart</a> items and check out by clicking on this link.";
            $msg = $_SESSION['items'][$KeyId]['num']."|There $is now <b style = \"color:yellow;\">" .$_SESSION['items'][$KeyId]['num'] . "</b> '$ItemName' item$s in your shopping cart. You can <a id = 'view_cart_link' href = '$URL/plugins/cart/view.php' style = 'color: gray; text-decoration: none;'>view your shopping cart</a> items, manage quantities and check out by clicking on this link.";
        }
        else
        {
           // echo "Item does not exist add fresh<br/>";
            $_SESSION['items'][$x]['name'] = $ItemName;
            $_SESSION['items'][$x]['price'] = $ItemPrice;
            $_SESSION['items'][$x]['num'] = $ItemQty;

            $ItemQty == 0 ? $s = "" : $s = "s";
            $ItemQty == 1 ? $is = "is" : $is = "are";
            $msg = $_SESSION['items'][$KeyId]['num']."|There $is now <b style = \"color:yellow;\">$ItemQty</b> '$ItemName' item$s in your shopping cart. You can <a id = 'view_cart_link' href = '$URL/plugins/cart/view.php' style = 'color: gray; text-decoration: none;'>view your shopping cart</a> items, manage quantities and check out by clicking on this link.";

            $_SESSION['num']++;
        }

        echo $msg;

?>