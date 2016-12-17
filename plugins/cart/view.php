<?php

    //session_start();

    include("../../Migration/Composition.php");

    $db = new db();

    if ($db->isReady()) {
        //$I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "`key`=".$_GET['id'], "", "1");
    }
    else
    {
        //print "not connected!";
    }

?>
<!doctype html>
<html>
<head>
<title>San Francisco Pickle Company - sfpickleco.com</title>
<META http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta charset="utf-8">
<META name = "description" content = "Application tools."/>
<META name = "keywords" content = "eyelash, lash, application, tools."/>
<meta name="language" content="">
<script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/jquery-ui.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/plugins/cart/js.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/plugins/cart/filestyle.js' type = 'text/javascript'></script>
<link rel = "stylesheet" type = "text/css" href = "http://markusslima.github.io/bootstrap-filestyle/css/bootstrap.min.css">
<link rel = "stylesheet" type = "text/css" href = "<?php print $URL; ?>/css/style.css">
<script type = "text/javascript">
window.current_entry_id = 0;
$(document).ready(function() {
    calc_paypal_button();
});
function add_to_cart(key,name,price,qty)
{
    $.ajax(
    { url: "session/add.php", type: "GET", data: { 'item_name': name, 'item_price': price, 'item_qty': qty },
        success: function(msg)
        {
            $("#outcome").html(msg);
        }
    });
}
function recalculate_cart()
{
    $.ajax({url:"session/count.php", type: "GET", success:function(msg){
        var i = msg.split("|")[0];
        var p = msg.split("|")[1];
        var s = '';
        (i == 1) ? s = '' : s = 's'; 

        $("#total_items_num").html(i + ' item' + s);
        $("#total").html("$" + p);

        calc_paypal_button();

    }});
}
function calc_paypal_button()
{
    $.ajax({url:"session/calc_paypal_button.php", type: "GET", success:function(msg){
        $("#checkout").html(msg);
    }});
}
function remove_item(array_id)
{
    $.ajax( { url: "session/remove.php", type: "GET", data: { 'array_id': array_id },
        success: function(msg) {
            if (msg == 1) {
                $("#tr_item_" + array_id).fadeOut(400,function() {
                    recalculate_cart();
                });
            }
        }
    });
}
function set_item_num(array_id, num)
{
    $.ajax( { url: "session/set.php", type: "GET", data: { 'array_id': array_id, 'num': num },
        success: function(msg) { if (msg == 1) recalculate_cart(); }
    });
}
</script>
</head>
<body>
<style type = "text/css">
/* Regular content page CSS adjustment */
#Main { background: #2c2c2c; }
#ContentArea { position: relative; margin: 0; top: 0; left: 0; right:0; width: 850px; }
#ContentArea h1 { font-size: 22px; color: #9b8957; }
table#Products td { line-height: 16px; vertical-align: top; padding: 3px; }
table thead { font-weight: bold; color: white; }
table#Products td a {color:yellow;}
.modalbg { position: fixed; width: 100%; height: 100%; }
#modal1 { display:none; background: #000; color: #fff; opacity: 0.5; z-index: 100000; }
#modal2 { display:none; background: transparent; color: #fff; opacity: 1; text-align: center; z-index: 100001; }
#modalmsg { position: relative; margin: 0 auto; width: 580px; background: black; z-index: 100002; margin-top: 200px; padding: 10px; box-shadow: 0 0 30px #555; }
#modalmsg table td { text-align: left; vertical-align: top; line-height: 22px; }
#modalmsg table td input,
#modalmsg table td select { margin-left: 0; }
#ppic_prev { width: 64px; height: 64px; border:1px solid #333; background: url("no-image.png")}
#Products tr.i:hover { background: black; color: green; cursor: pointer; }
#StoreOptions { position: absolute; right: 0; top: 8px; width: 150px; }
#StoreOptions a { color: gray; text-decoration: none; }
#StoreOptions a:hover { color: white; text-decoration: none; }
#StoreOptions img { vertical-align: middle; }
.addnewitem a { color: gray; }
.conf { display:none; }
#blank_item { display:none; position: absolute; top:-10000px; }
.img_prev { width: 32px; height: 32px; position: relative; display: block; border: 1px solid #222;  }

table td { vertical-align: top; }

table.border1px {
    border-width: 0 0 1px 1px;
    border-spacing: 0;
    border-collapse: collapse;
    border-style: solid;
    border-color: #555;
}

.border1px td, .border1px th {
    margin: 0;
    padding: 4px;
    border-width: 1px 1px 0 0;
    border-style: solid;
    border-color: #555;
}

</style>

<center>

    <?php include("edit_item.php"); ?>

    <div id = "Container" style = "height:;">
        <div id = "Header">
            <?php include("$FILESYSTEM/header.php"); ?>
        </div>
        <div id = "Nav">
            <?php include("$FILESYSTEM/nav.php"); ?>
        </div>
        <div id = "Main" style = "height:auto;">

            <div id = "ContentArea">

                <h1>Your Shopping Cart</h1>

                <p>Below is an outline of all items currently in your shopping cart. Click check out to submit your order.</p>

                <center>

                    <?php if ($_GET["empty"]) {

                                session_destroy(); ?>

                            <script language = "javascript">
                                update_shopping_cart_header();
                            </script>

                            <p>Your cart has been emptied. Go <a  style = "color:white; font-size: 17px; text-decoration:none; border-bottom:1px dotted #fff;"  href = "<?php print $URL; ?>/store.php">back to the store</a>.</p>

                            <?php


                        } else { ?>
                        <table class = "border1px">
                        <tr style = "background:#000;">
                            <td><b>Product Name</b></td>
                            <td><b>Qty.</b></td>
                            <td><b>Price</b></td>
                            <td></td>
                        </tr>
                        <?php
                            $total = floatval(0.0);
                            $in = 0;
                            foreach($_SESSION['items'] as $key => $value) {
                                if (is_array($value) && !empty($value)) {
                                    $name = $value["name"];
                                    $array_id = $key;
                                    $price = floatval($value["price"]);
                                    $num = $value["num"];
                                    if (!empty($name))
                                    {
                                        $in += $num;
                                        $total += floatval($price) * $num;
                                        ?>
                                    <tr id = "tr_item_<?php print $key; ?>">
                                        <td><b><?php print $name ?></b></td>
                                        <td><input type = "text" value = "<?php print $num ?>" style = "width: 32px"
                                             onkeyup = "if ($.isNumeric(this.value)) {$(this).css({'background':'white',color:'black'}); $('#checkout').show(); set_item_num('<?php print $key; ?>', this.value);} else { $(this).css({'background':'red',color:'yellow'}); $('#checkout').hide(); }"
                                          onkeypress = "if ($.isNumeric(this.value)) {$(this).css({'background':'white',color:'black'}); $('#checkout').show(); set_item_num('<?php print $key; ?>', this.value);} else { $(this).css({'background':'red',color:'yellow'}); $('#checkout').hide(); }"
                                              onblur = "if ($.isNumeric(this.value)) {$(this).css({'background':'white',color:'black'}); $('#checkout').show(); set_item_num('<?php print $key; ?>', this.value);} else { $(this).css({'background':'red',color:'yellow'}); $('#checkout').hide(); }"
                                            onchange = "if ($.isNumeric(this.value)) {$(this).css({'background':'white',color:'black'}); $('#checkout').show(); set_item_num('<?php print $key; ?>', this.value);} else { $(this).css({'background':'red',color:'yellow'}); $('#checkout').hide(); }"
                                             onfocus = "if ($.isNumeric(this.value)) {$(this).css({'background':'white',color:'black'}); $('#checkout').show(); set_item_num('<?php print $key; ?>', this.value);} else { $(this).css({'background':'red',color:'yellow'}); $('#checkout').hide(); }" /></td>
                                        <td><?php print $price ?></td>
                                        <td><a href = "#" style = "color: silver;" onclick = "remove_item('<?php print $array_id; ?>'); return false;"><img src = "<?php print $URL; ?>/plugins/cart/x2.png" style = 'vertical-align:middle;'>  Remove</a></td>
                                    </tr>
                                    <?php
                                    }
                                }
                            }
                        ?>
                        <tr style = "background:#000;">
                            <td colspan = "7"><b>Total</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id = "total_items_num"><?php print $in; ?> item<?php $total==1 ? print "" : print "s"; ?></td>
                            <td id = "total" style = "color:yellow;">$<?php print number_format($total, 2); ?> </td>
                            <td></td>
                        </tr>
                        </table>
                    <?php } ?>

                    <div style = "margin-top: 16px;"></div>

                    <p>You can <a href = "view.php?empty=true" style = "color:white; font-size: 17px; text-decoration:none; border-bottom:1px dotted #fff;">empty your cart</a> and start over.</p>

                    <div style = "margin-top: 16px;"></div>

                    <p style = "">Click "Check out" or update Quantity numbers to recalculate total price.</p>

                    <?php if ($_GET['empty']) {} else { ?>

                        <div id = "checkout">
                            <?pph /*<a target = "_blank" href = "<?php print $URL; ?>/plugins/cart/view.php"><img src = "../../check-out.png" style = "border: 0;" /></a> */ ?>
                        </div>

                    <?php } ?>

                </center>

                <br />
            </div>
        </div>
        <div id = "Details">
            <?php //include("../../details.php"); ?>
        </div>
        <div class = "clear"></div>
        <div id = "Footer" style = "margin-top: 10px">
            <?php include("../../footer.php"); ?>
        </div>
    </div>
</center>
</body>
</html>