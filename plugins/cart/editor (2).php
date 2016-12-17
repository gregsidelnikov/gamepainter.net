<?php include("../../Migration/Composition.php");

    $db = new db();

/*
    $q = mysql_query("ALTER TABLE `cart` ADD json TEXT");
    if ($q)
    {
        print "success";
    }*/

    if ($db->isReady()) {
        $I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "", "", "1000");
        $C = $db->get($plugin_table_cart_cat, get_all_from($plugin_table_cart_cat), "", "", "1000");
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
                   var json = j[0].json; // misc description of the product...

                   if (j[0].json == "" || j[0].json == "{}" || j[0].json == undefined || j[0].json == null)
                       j[0].json = '{"" : ""}';

                       json = j[0].json;

                   //var obj = $.parseJSON(json);
                   var first = true;
                   var str = "";
                   var a = "";
                   var b = "";
                   $(".json").html("");

                   $.each(JSON.parse(json), function(idx, obj) {
                       //alert(obj);
                       //if (first)
                       //{
                           a = idx;
                       //}
                       //if (!first)
                       //{
                           b = obj;
                           var row = '<tr><td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: Product Model" value = "'+a+'" /></td><td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: 1234567-ABCD" value = "'+b+'" /></td>' +
                           '<td><img alt = "Delete" style = \'cursor: pointer; width: 16px; height: 16px;\' src = "<?php print $URL; ?>/plugins/cart/close.png" onclick = "if ($(\'tr\', $(this).parent().parent().parent().parent()).length > 1) $(this).parent().parent().remove();"/></td>' +
                           '</tr>';

                           $(".json").append(row);
                       //}

                       first ? first=false : first=true;
                   });

                   $("#i_name").val(name);
                   $("#i_desc").val(description);
                   $("#i_category").val(category);
                   $("#i_price").val(price);
                   $("#i_img").attr("src", image_url);



            $("#modal1").fadeIn();
            $("#modal2").fadeIn();

            $("#i_name").select();
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
                '<td class = "res" style="text-align: center;"><a href = "<?php print $URL; ?>/plugins/cart/viewitem.php?id='+msg+'" target = "_blank"><img src = "view.png" style = "border:0;" /></a></td>'+
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
      {}else
      open_item_editor($(this).parent().attr("key"));
   });
}

function save_item(key)
{
    if (window.current_entry_id != 0)
    {

        get_json();
        ///alert($('#json').val());

        $.ajax( { url:'save_item.php',
            type:'post',
            data: {
                "key" : window.current_entry_id,
                "name": $('#i_name').val(),
                "desc": $('#i_desc').val(),
                "price": $('#i_price').val(),
                "category": $('#i_category').val(),
                "json": $('#json').val()
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

function get_json()
{
    var i = 0;
    var obj = "{";
    $(".json tr").each( function(o) {

        window.last_x = $("td:nth-child(1) input", this).val();
        window.last_y = $("td:nth-child(2) input", this).val();
        if (window.last_x != "" && window.last_y != "")
        {
            if (i > 0) obj += ",";
            obj += "\"" + window.last_x + "\":\"" + window.last_y + "\"";
        }
        i++;
    });
    obj += "}";
    //
    $("#json").val(obj);
    add_misc_row();
}

function add_misc_row()
{
    if (window.last_x != "" && window.last_y != "")
    {
        var row = '<tr><td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: Product Model" /></td><td><input onclick = "get_json()" onkeypress = "get_json()" onkeyup = "get_json()" onblur = "get_json()" type = "text" placeholder = "Ex: 1234567-ABCD" /></td>' +
        '<td><img alt = "Delete" style = \'cursor: pointer; width: 16px; height: 16px;\' src = "<?php print $URL; ?>/plugins/cart/close.png" onclick = "if ($(\'tr\', $(this).parent().parent().parent().parent()).length > 1) $(this).parent().parent().remove(function(){get_json();});"/></td>' +
        '</tr>';
        $(".json").append(row);
    }
}

$(document).ready(function() {
    //get_json();
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
.j { text-align: right; color: gray; }
.conf { display:none; }
#blank_item { display:none; position: absolute; top:-10000px; }
.img_prev { width: 32px; height: 32px; position: relative; display: block; border: 1px solid #222;  }

table.border1px {
    border-width: 0 0 1px 1px;
    border-spacing: 0;
    border-collapse: collapse;
    border-style: solid;
    border-color: gray;
}

.border1px td, .border1px th {
    margin: 0;
    padding: 4px;
    border-width: 1px 1px 0 0;
    border-style: solid;
    border-color: gray;
}

</style>

<input type = "hidden" id = "json"/>

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
            
            <br/><br/>

            <div class = "addnewitem" style = "text-align: center;">
                <a href = "#" onclick = "add_new_item(1); return false;"><img src = "addic.png" style = "vertical-align: middle;"> Add new item</a>
            </div>

                <h1>Product Manager</h1>
                
                <table id = "Products">

                    <thead style = "background: black; color: gray;">
                        <td>Key</td>
                        <td>IMG</td>
                        <td>Product Name</td>
                        <td>View</td>
                        <td>Description</td>
                        <td>Cost</td>
                        <td>Category</td>
                        <td>DELETE</td>
                        <td style = "width: 40px;"></td>
                    </thead>

                    <?php if (!empty($I))
                        for ($i = 0; $i < count($I); $i++)
                        {
                            ?>
                                <tr class = "i" key = "<?php print $I[$i]['key']; ?>">
                                    <td class = "j"><?php print $I[$i]['key']; ?></td>
                                    <td><div id = "img_prev<?php print $I[$i]['key']; ?>" class = "img_prev" style = "background: url('<?php print $URL; ?>/plugins/cart/pictures/32/<?php print $I[$i]['key']; ?>.jpg') no-repeat;"></div></td>
                                    <td style="font-weight: bold; width: 180px;"><?php print $I[$i]["name"]; ?></td>
                                    <td class = "res" style="text-align: center;"><a href = "<?php print $URL; ?>/plugins/cart/viewitem.php?id=<?php print $I[$i]['key']; ?>" target = "_blank"><img src = "view.png" style = "border:0;" /></a></td>
                                    <td style = "width: 370px; height: 28px; color: gray;">
                                       <?php $full_desc = $I[$i]["description"];
                                             $full_len = strlen($full_desc);
                                             if ($full_len != 1) $s = "s"; else $s = "";
                                             if ($full_len > 70)
                                                 $full_desc = substr($full_desc,0,70) . " (<i>$full_len letter$s</i>)...";
                                             print $full_desc;
                                       ?>
                                    </td>

                                    <td style = "padding-right: 8px; color: #dec476">$<?php print $I[$i]["price"]; ?></td>

                                    <td nowrap>
                                        <?php print $I[$i]["category"]; ?>
                                    </td>

                                    <td onclick = "delete_item(<?php print $I[$i]['key']; ?>, this)"
                                          class = "res"
                                          style = "text-align: center; background: #000; z-index: 1000; position: relative;"
                                        onmouseover = "$('img', this).attr('src', 'trash2.png')"
                                        onmouseout = "$('img', this).attr('src', 'trash1.png')">
                                        <img src = "trash1.png" style = "margin-top:-4px;"/>
                                    </td>


                                    <td class = "res conf">
                                        <a href = "#" onclick = "confirm_delete_item(<?php print $I[$i]['key']; ?>); return false;"><img src = "x.png" style="border:0"></a>
                                    </td>
                                    <?php /*<td><a href = "#?id=<?php print $I[$i]['key']; ?>" onclick = "open_item_editor(<?php print $I[$i]["key"]; ?>); return false;">Edit</a></td>*/ ?>
                                </tr>
                            <?php
                        }

                    ?>

                </table>

                <br><br>

                <div class = "addnewitem" style = "text-align: center;">
                    <a href = "#" onclick = "add_new_item(); return false;"><img src = "addic.png" style = "vertical-align: middle;"> Add new item</a>
                </div>

<!--
                <h1>Edit Categories</h1>

                <select id = "it1_cat">
                    <option>Extentions</option>
                    <option>Adhesive</option>
                    <option>Application Tools</option>
                    <option>After Care</option>
                </select>//-->

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