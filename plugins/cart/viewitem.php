<?php session_start();
    include("../../Migration/Composition.php");

    $db = new db();
    if ($db->isReady()) {
        $I = $db->get($plugin_table_cart, get_all_from($plugin_table_cart), "`key`=".$_GET['id'], "", "1");
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
    border-color: gray;
}

.border1px td, .border1px th {
    margin: 0;
    padding: 4px;
    border-width: 1px 1px 0 0;
    border-style: solid;
    border-color: gray;
}

.view_cart_link { color: gray; text-decoration: none; }

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
                <?php include("display_item.php"); ?><br />
            </div>
        </div>
        <div id = "Details">
            <?php include("../../details.php"); ?>
        </div>
        <div class = "clear"></div>
        <div id = "Footer" style = "margin-top: 10px">
            <?php include("../../footer.php"); ?>
        </div>
    </div>
</center>
</body>
</html>