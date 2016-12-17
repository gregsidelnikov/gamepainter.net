/* window.url = "http://www.kokolash.com"; */
window.url = "http://localhost/sfpickleco";

function update_shopping_cart_header()
{
    $.ajax( { "url": window.url + "/plugins/cart/session/count.php",

            success: function(msg)
            {
                var dat = msg.split("|");
                var num = dat[0];
                var pri = dat[1];
                $("#cart_num").html(num);
                $("#cart_price").html(pri);
            }
        }
    );
}

function add_to_cart(key,name,price,qty,msg_output_id)
{
    $.ajax( {
        url: window.url + "/plugins/cart/session/add.php", type: "GET", data: { 'item_name': name, 'item_price': price, 'item_qty': qty },
        success: function(m) {
            var num = m.split("|")[0];
            var msg = m.split("|")[1];
            $("#" + msg_output_id).html('<p><b style = "color:yellow;">' + name + ' was added to your cart</b></p>' + msg);
           /// alert("." + "item_qty_" + key);
            $("." + "item_qty_" + key).html(num);
            update_shopping_cart_header();
        }
    } );
}

$(document).ready(function() {

    update_shopping_cart_header();

});
