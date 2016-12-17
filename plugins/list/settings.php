<?php include("../../Migration/Composition.php");
    $password = $_GET["password"];
    $db = new db();
    $u = $db->get("subscribers", get_all_from("subscribers"), "`password` = '" . $password . "'", "", 1, 1);
    
    $uid = $u["key"];
    
//    $uid = simple_id_decrypt($uid);
    
?>
<html>
<head>
<title>Newsletter Settings</title>
    <META http-equiv="Content-Type" content="text/html;charset=utf-8">
    <script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
    <script type = "text/javascript">
        window.website = new Object();
        website.url = '<?php print $URL; ?>';
        website.img_dir_name = 'Images';
    </script>
    <script src = '<?php print $URL; ?>/plugins/jsdb/lib.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/util.js' type = 'text/javascript'></script>
    <!--// <link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/admin/editor.css' /> //-->
    <script type = "text/javascript">
        function update_settings() {
            $.ajax( { url : "<?php print $URL; ?>/plugins/list/update_settings.php",
                     data : {
                      uid : "<?php print $uid; ?>",
                     name : $('#user_first_name').val(),
                    email_address: $("#em_addr").val() },
                 success: function(msg) {
                    //alert(msg);
                    $("#updated_msg").html(msg);
                }
            } );
        }
        function unsubscribe() {
            $.ajax( { url : "<?php print $URL; ?>/plugins/list/unsubscribe.php",
                     data : {
                      uid : "<?php print $uid; ?>",
                     unsubscribed : 1 },
                 success: function(msg) {
                    $("#msg").html(msg);
                 }
            } );
        }
        function resubscribe() {
            $.ajax( { url : "<?php print $URL; ?>/plugins/list/unsubscribe.php",
                     data : {
                      uid : "<?php print $uid; ?>",
                     unsubscribed : 0 },
                 success: function(msg) {
                    $("#msg").html(msg);
                 }
            } );
        }
    </script>
</head>
<body>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        td { font-size: 12px; }
    </style>
    <div style = "width: 600px; margin: 0 auto; padding: 16px;">
        <h1>Settings</h1>

        <p>You've subscribed on <?php print date("m/d/y", $u["timestamp"]); ?>.</p>
        <hr/>
        <h3>Account Information</h3>
        <table border = "0" padding = "0" cellpadding = "0" cellspacing = "0" >
        <tr>
            <td>
                Name:<br/>
                <input type = "name" placeholder = "Name" id = "user_first_name" type = "text" style = "width: 200px; font-size:22px;" value = "<?php print $u["name"]; ?>"/>
            </td>
            <td style = "width: 5px;"></td>
            <td>
                Email Address:<br/>
                <input type = "email" id = "em_addr" placeholder = "Email Address" value = "<?php print $u["email_address"]; ?>" style = "width: 300px; font-size:22px;" /><br/>
            </td>
            <td>&nbsp;<br/>
                &nbsp;<input type = "button" value = "Update" onclick = "update_settings()" style = "font-size:22px;" />
            </td>
        </tr>
        </table>
        <br/>
        <br/>
        <p id = "updated_msg"></p>
        <br/>
        <br/>
        <h3>Unsubscribe / Restore</h3>
        <?php if ($u["unsubscribed"] == 0) { ?>
            <p>After you unsubscribe you will no longer receive emails. However, if you change your mind later, you can always come back to this page and restore your subscription. If you don't come back in over a month, your email will be removed from the newsletter database.</p>
            <p>Thank you for your subscription! But if you must part, this is how to do it. Just press the button below:</p>
            <div style = "text-align: center; font-size: 12px;">
                <input onclick = "unsubscribe()" type = "button" value = "Unsubscribe" style = "font-size:22px;" /><br />
            </div>
        <?php } else { ?>
            <p>It looks like you have unsubscribed from this newsletter. Your account will remain deactivated for another month before it is erased completely. You still have a chance to resubscribe during this period of time in case you change your mind. If not, then there is nothing else to do. Goodbye!</p>
            <div style = "text-align: center; font-size: 12px;">
                <input onclick = "resubscribe()" type = "button" value = "Subscribe Again" style = "font-size:22px;" /><br />
            </div>
        <?php } ?>
        <p id = "msg"></p>
    </div>
</body>
</html>