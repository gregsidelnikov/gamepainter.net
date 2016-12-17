<?php include("../../Migration/Composition.php");

    $db = new db();
    if ($db->isReady()) {
        $I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "", "", "1000");
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
function close_item_editor()
{
    $("#modal1").fadeOut(250);
    $("#modal2").fadeOut(250);
}
function open_item_editor(key_id) {
    $("#ppic_prev").css({"background-repeat":"no-repeat","background": "url('<?php print $URL; ?>/plugins/cart/pictures/64/" + key_id + ".jpg')" } );
    window.current_entry_id = key_id;
    $.ajax({url:'loaditem.php',type:'POST',data:{id:key_id},
    success: function(msg) {

             var j = JSON.parse(msg);
              if (j != undefined) {
                   var key = j[0].key;
                   window.current_entry_id = j[0].key;
                   var name = j[0].name;
                   var description = j[0].description;
                   var price = j[0].price;
                   var category = j[0].category;
                   var date_added = j[0].date_added;
                   var items_left = j[0].items_left;
                   var image_url = j[0].image_url;
                   $("#i_name").val(name);
                   $("#i_desc").val(description);
                   $("#i_category").val(category);
                   $("#i_price").val(price);
                   $("#i_img").attr("src", image_url);

            $("#modal1").fadeIn();
            $("#modal2").fadeIn();
        }
    }});

}
function add_new_item(prep)
{
    $.ajax({url:"add_new_item.php",type:"post",
        success: function(msg) {
        //alert("["+msg+"]");
        msg=msg.replace(/ |\s/g, "");
            var str = '<tr class = "i" key = "'+msg+'">'+
                '<td class = "j">'+msg+'</td>'+
                '<td><div class="img_prev"></div></td>'+
                '<td style="font-weight: bold;">Item'+msg+'</td>'+
                '<td style = "width: 300px; height: 28px; color: gray;">Description'+msg+'</td>'+
                '<td>$0.00</td>'+
                '<td nowrap>Category'+msg+'</td>'+
                '<td onclick = "delete_item('+msg+', this)" class = "res" style = "text-align: center; background: #000; z-index: 1000; position: relative;" onmouseover = "$(\'img\', this).attr(\'src\', \'trash2.png\')" onmouseout = "$(\'img\', this).attr(\'src\', \'trash1.png\')">'+
                '    <img src = "trash1.png" style = "margin-top:-4px;"/>'+
                '</td>'+
                '<td class = "res conf"><a href = "#" onclick = "confirm_delete_item('+msg+'); return false;">Confirm</a></td>'+
            '</tr>';
            //alert(str);
            //str = str.replace(/KEYID/g, msg);
            //alert(str);
            //str = str.replace(/</g, '&lt;');
            //str = str.replace(/>/g, '&gt;');
            //alert(str);
            if (prep == 1)
                $('#Products').prepend(str);
            else
                $('#Products').append(str);
            //$('tr[key=' + key + ']').fadeIn();

            attach_events_to_item_list();

        }
    });
}
function delete_item(id, td)
{
    $(td).next().toggle();
}
function confirm_delete_item(key)
{
    //alert(key);
    $.ajax({url:"delete_item.php",type:"post",data:{id:key},
        success: function(msg) {
            $('tr[key=' + key + ']').fadeOut();
        }
    });
}
$(document).ready(function() {
   // customize open file button
   $(":file").filestyle( { input: false, buttonText:"Upload Image" } );
   // open item editor on tr click
   attach_events_to_item_list();
   //$("body").append("<script>alert('hehehe');<\/script>");
   /*$("#file").on("upload.progress", function(e) {
       var value = Math.floor(e.loaded / e.total * 100);
       $("#prog").html(value + "% (" + e.loaded + " bytes) of " + e.total + " bytes");
   });*/
   $("#file").on("fileuploaddone", function(e){
        //alert("image uploaded");
   });
});
function attach_events_to_item_list()
{
    $("tr.i td").off("click");
    $("tr.i td").live("click", function() {
      if ($(this).hasClass("res"))
          return false;
      open_item_editor($(this).parent().attr("key"));
   });
}
function save_item(key)
{
//alert(window.current_entry_id);
if (window.current_entry_id!=0)
{
    $.ajax( { url:'save_item.php',
        type:'post',
        data: {
            "key" : window.current_entry_id,
            "name": $('#i_name').val(),
            "desc": $('#i_desc').val(),
            "price": $('#i_price').val(),
            "category": $('#i_category').val()
        },
        success: function(msg) {
            $("tr[key=" + window.current_entry_id + "]").html(msg);
            close_item_editor();
        }
    });
}
}

$(document).keyup(function(e) {
  //if (e.keyCode == 13) { $('.save').click(); }     // enter
  if (e.keyCode == 27) { close_item_editor(); }   // esc
});

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

#layt {  }
#layt td { vertical-align: top;  }
#layt td input[type=radio] { margin-top:-3px; display:inline; width: 12px; height: 12px; }

td.HL { }

</style>

<div id = "blank_item">
    <tr class = "i" key = "KEYID">
        <td class = "j">KEYID</td>
        <td></td>
        <td style="font-weight: bold;">ItemKEYID</td>
        <td style = "width: 300px; height: 28px; color: gray;">DescriptionKEYID</td>
        <td>$0.00</td>
        <td>CategoryKEYID</td>
        <td onclick = "delete_item(KEYID, this)" class = "res" style = "text-align: center; background: #000; z-index: 1000; position: relative;" onmouseover = "$('img', this).attr('src', 'trash2.png')" onmouseout = "$('img', this).attr('src', 'trash1.png')">
            <img src = "trash1.png" style = "margin-top:-4px;"/>
        </td>
        <td class = "res conf"><a href = "#" onclick = "confirm_delete_item(KEYID); return false;">Confirm</a></td>
    </tr>
</div>

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

                <?php include("menu.php"); ?>

                <br/>
                <br/>

                <h1>Store Layout Settings</h1>

                <table id = "layt">
                    <tr><td><label for = "cb1"><image src = "layout1.png"/><br/><input type="radio" name = "layout" checked id = "cb1"> <b>Simple List</b> This layout is good for showing an entire inventory in a simple list format.</label></td></tr>
                    <tr><td><label for = "cb2"><image src = "layout2.png"/><br/><input type="radio" name = "layout" id = "cb2"> <b>1-Column</b> One column layout with a big product photo.</label></td></tr>
                    <tr><td><label for = "cb3"><image src = "layout3.png"/><br/><input type="radio" name = "layout" id = "cb3"> <b>2-Column</b> Two column layouts are good for consolidating space.</label></td></tr>
                </table>

                <br />
            </div>
        </div>
        <div id = "Details">

        </div>
        <div class = "clear"></div>
        <div id = "Footer">
            <?php include("$URL/footer.php"); ?>
        </div>
    </div>
</center>
</body>
</html>