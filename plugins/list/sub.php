<?php include("../../Migration/Composition.php");
    $password = $_GET["password"];
    $db = new db();
    $u = $db->get("subscribers", get_all_from("subscribers"), "`password` = '" . $password . "'", "", 1, 1);
    $uid = $u["key"];
    $su = $db->get("subscribers", "COUNT(*)", "");
    $subs = $su[0]["COUNT(*)"]; //print_g($su);
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
        function subscribe() {

            // check email address
            var em = $("#em_addr").val();
            if (/(.+)@(.+){2,}\.(.+){2,}/.test(em)) {
            $.ajax( { url : "<?php print $URL; ?>/plugins/list/subscribe.php",
                     data : {
                      email : em
                     },
                 success: function(msg) {
                        $("#updated_msg").html(msg);
                    }
                } );
            } else {
              // invalid email
              $("#updated_msg").html("Please enter a valid email address.");

            }
        }
    </script>
</head>
<body>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        td { font-size: 12px; }
    </style>
    <div style = "width: 600px; margin: 0 auto; padding: 16px;">

        <table>
        <tr>
            <td>
                <img src = "<?php print $URL; ?>/plugins/list/img.png" style = ""/>
            </td>
            <td style = "width: 5px;"></td>
            <td>
                <h1 style = "margin:0;">Substitute Teacher (<a href = "https://twitter.com/js_tut" target = "_blank">@js_tut</a>)</h1>
                <div style = "height:4px"></div>
                Subscribe to receive JavaScript Tutorials in your inbox every 1-2 weeks. No gimmicks, no ads. Just JavaScript tutorials. Unsubscribe any time.
            </td>
        </tr>
        </table>

        <hr/>

        <br><br>

        <h2>We are enrolling new students every day.</h2>

        <p>My online classroom is never full. Hi, my name is Greg Sidelnikov, and I will be your JavaScript substitute teacher during the following months. My online classroom is free to attend. I am thankful that so many people have joined so far. Let's learn programming together! You don't have to do anything. Just read and watch.</p>

        <h2>What are you waiting for?<br/>The other <?php print $subs; ?> students already signed up for free!</h2>



        <p>No gimmicks. No ads. Just read and watch coding tutorials.</p>

        <table border = "0" padding = "0" cellpadding = "0" cellspacing = "0" >
        <?php /*
        <tr>
            <td>
                Name:<br/>
                <input type = "name" name = "name" placeholder = "Name" id = "user_first_name" type = "text" style = "width: 200px; font-size:22px;" value = "<?php print $u["name"]; ?>"/>
            </td>
        </tr> */ ?>



        <tr><td style = "height: 20px;"></td></tr>
        <tr>
            
            <td>
                Primary Email Address <span style = "color:blue;font-style:italic;">*Required</span><br/>
                <input type = "text" name = "email_address" id = "em_addr" placeholder = "Email Address" value = "<?php print $u["email_address"]; ?>" style = "width: 300px; font-size:22px;" /><input onclick = "subscribe()" type = "button" value = "Subscribe Now" style = "font-size:22px;" />
                <div style = "display:inline">&nbsp;&nbsp;<?php print $subs; ?> subscribers</div>
            </td>
        </tr>
        </table>

        <p id = "updated_msg">&nbsp;</p>

        <h3>Email Newsletter Description</h3>
        <p>This newsletter is a weekly or bi-weekly free tutorial lesson sent directly to your inbox from the Substitute Teacher, your free online JavaScript tutor. Greg Sidelnikov is the author of JavaScript tutorials who occasionally works on educational material and posts it on his website, and you will know about them first by subscribing to this notification service.</p>
        <p style = "text-align: center;"></p>
        <p id = "msg"></p>
    </div>
</body>
</html>