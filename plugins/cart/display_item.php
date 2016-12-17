
<h2 style = "font-size: 18px;"><?php print $I["name"]; ?></h2>

<style>
    #it_desc ul { font-family: Verdana; font-size: 11px !important; }
    #it_desc li { font-family: Verdana; font-size: 11px !important; }
</style>

<table>
    <tr>
        <td style = "width:250px; vertical-align: top;"><img style = "width: 100%;" src = "<?php print $URL; ?>/plugins/cart/pictures/Original/<?php print $I["key"]; ?>.jpg"></td>
        <td style = "padding-left: 4px;vertical-align:top;">
            <div style = "margin-top: 8px;">
                <table>
                <tr>
                <td style = "width: 500px; vertical-align:top;line-height: 14px; padding-left: 10px; font-size: 14px !important; font-family: Arial, sans-serif;padding-top:0;">
                    <b style = "font-size: 18px;">Description <a target = "_blank" href = "<?php print $URL . "/plugins/cart/viewitem.php?id=".$I["key"]; ?>"><img src = "<?php print $URL; ?>/plugins/cart/popup.png" style = "z-index:10000;vertical-align:middle;border:0;"></a></b>
                    <p id = "it_desc" style = "font-size: 11px; font-family: Verdana, sans-serif;"><?php print $I["description"]; ?></p>

                    <?php $obj = json_decode($I["json"]);
                        if (!empty($obj)) { ?>
                        <p><b style = "font-size: 18px;">Item Details</b></p>
                        <table class = "border1px">
                            <?php
                                foreach($obj as $key => $value) {
                                    ?><tr><td><b><?php print $key; ?></b></td><td><?php print $value; ?></td></tr><?php
                                }
                            ?>
                        </table>
                    <?php } ?>
                </td>
                <td style = "text-align: right; width: 150px; padding-top: 24px; vertical-align: top;">
                    <b>Qty: </b> <input id = "qty_<?php print $I['key']; ?>" type = "text" style = "padding: 1px; width: 32px; text-align: right; margin-right: 8px;" value = "1" />
                    <a href = "#" onclick = "add_to_cart('<?php print $I['key']; ?>', '<?php print $I['name']; ?>', '<?php print $I['price']; ?>', $('#qty_<?php print $I['key']; ?>').val(), 'outcome_<?php print $I["key"]; ?>'); return false;"><img src = "<?php print $URL; ?>/plugins/cart/addtocart.png"/></a>
                    <br />
                    <div style = "height:8px;"></div>
                    <div style = "margin-left: 8px; font-family: Verdana; font-size: 11px; color: gray; line-height: 13px; text-align: left;">
                    <?php
                        $item_name = $I['name'];
                        $i_key = $I['key'];
                        foreach($_SESSION["items"] as $k=>$v)
                        {
                            if (array_search($item_name, $_SESSION["items"]["$k"]) == "name")
                            {
                                $i_num = $_SESSION["items"]["$k"]["num"];
                                $i_num == 1 ? $i_s = "" : $i_s = "s";
                                print "Shopping cart already contains <span class = 'item_qty_$i_key' style = 'font-family:verdana;font-size: 11px; color:#28a88b'>$i_num</span> item$i_s of this kind. You can <a style = 'font-family:verdana;font-size: 11px;color:#549cee;text-decoration:none;' href = '$URL/plugins/cart/view.php'>edit</a> your cart to change qty.";

                                break;
                            }
                        }
                    ?>
                    </div>
                    </td>
                </tr>
                </table>
                <span id = "outcome_<?php print $I["key"]; ?>"></span>
            </div>
        </td>
    </tr>
</table>