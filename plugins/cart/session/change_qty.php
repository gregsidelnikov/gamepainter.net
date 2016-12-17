<?php
    session_start();

    $KeyId = -1;

    $ItemName = $_GET['item_name'];

        $break = false;
        foreach ($_SESSION['items'] as $key => $value)
        {
            echo "$key > $value<br/>";
            foreach ($value as $k => $v)
            {
                echo "$k > $v<br/>";
                if ($v == $ItemName) {
                    $KeyId = $key;
                    //print $key."<br/>";
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
            echo "Item already exists, increase its num<br/>";
            $_SESSION['items'][$KeyId]['num']++;
        }

?>