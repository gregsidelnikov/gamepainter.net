<?php include("../../../Migration/Composition.php");

    /* --- Recalculates PayPal button code -- */

    session_start();
    $total = floatval(0.0);
    $in = 0;

    if (empty($_SESSION['items'])) {

    }
    else
    {
        ?>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="business" value="<?php print $PAYPAL_EMAIL_ADDRESS; ?>">
        <input type="hidden" name="currency_code" value="US">
        <?php

        $i = 1;

        foreach($_SESSION['items'] as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $name = $value["name"];
                $price = floatval($value["price"]);
                $num = $value["num"];

                if (!empty($name) && is_numeric($price) && is_numeric($num)) {

                    $in += $num;
                    $total += floatval($price) * $num;

                    ?>

                    <input type="hidden" name="item_name_<?php print $i; ?>" value="<?php print str_replace('"', '\"', $name); ?>">
                    <input type="hidden" name="amount_<?php print $i; ?>" value="<?php print number_format($price,2); ?>">

                    <?php if (is_numeric($num) && $num != 0) { ?>
                    <input type="hidden" name="quantity_<?php print $i; ?>" value="<?php print $num; ?>">
                    <?php } ?>

                    <?php

                    $i++;
                }
            }
        }
        ?>
        <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
        </form>
        <?php
    }
?>