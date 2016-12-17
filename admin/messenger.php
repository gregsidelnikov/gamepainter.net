<?php include("../Migration/Composition.php");

    $db = new db();

    $List = db::get("subscribers", "*");



    $Target = db::get("publish_target", "*");

    $Article = db::get("content", "*", "", "", "");

?>
<html>
<head>
<title>Messenger</title>
<META http-equiv="Content-Type" content="text/html;charset=utf-8">
<script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/util.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/default2.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/default3.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/admin/editor.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/calendar.js' type = 'text/javascript'></script>
<script src = '<?php print $URL; ?>/js/calendar_api.js' type = 'text/javascript'></script>
<link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/admin/editor.css' />
<link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/css/code.css' />
<link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/css/calendar.css' />
<link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/admin/index.css' />
<script type = "text/javascript">
function get_article(id)
{
    $.ajax({url: "load-article.php",
        type: "post",
        data: {key:id},
        success: function(msg) {
            var data = JSON.parse(msg);
            $("#content").val(data['article']);
           //         alert(msg);
        }
    });
}
</script>
</head>
<body>
<h1>Messenger</h1>
Recipients:

<select id = "target">
<option value = "list:700"><?php print $URL; ?> list containing (<?php print count($List); ?> subscriber<?php count($List) != 1 ? print "s" : print ""; ?>)</option>
<option value = "email:greg.sidelnikov@gmail.com">greg.sidelnikov@gmail.com</option>
</select>

Load Content: <select id = "article" onchange = "get_article(this.value)">
<option>--Select Article--</option>
<?php for ($i = 0; $i < count($Target); $i++) { ?>
<option value = "<?php print $Article[$i]["key"]; ?>"><?php print $Article[$i]["title"]; ?></option>
<?php } ?>
</select>

<br/>
<textarea style = "width: 800px; height: 500px" id = "content">
</textarea>
</body>
</html>