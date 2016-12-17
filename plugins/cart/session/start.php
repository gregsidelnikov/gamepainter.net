<?php

    session_start();

    if (isset($_SESSION['id']))
    {
        //echo "session_id=" . $_SESSION['id'];
    }
    else
    {
        // Create session id
        srand(time());
        $let = array("A","B","C","D","E","F","G","H","I");
        $_SESSION['id'] = rand(0, 1000000);
        srand(time());
        $_SESSION['id'] .= $let[rand(0,7)];

        // Create shopping cart item placeholder
        $_SESSION['items'] = array();

        // Reset shopping cart items
        $_SESSION['num'] = 0;
    }

    // Important: define database table name
    $plugin_table_cart = "sfpickle_cart";
    $plugin_table_cart_cat = "sfpickle_cart_cat";


?>