<?php include('../Migration/Composition.php');
    $PrivilegedAccess = false;
    /* Prevent unauthorized access -- based on IP address of administrator */
    //  print $_SERVER["REMOTE_ADDR"]; //print $BLACK_SHEEP_IP;
    if ($LOCALHOST) { } else {
        // print "ipp=".$BLACK_SHEEP_IP;
		// Older: 65.24.43.194
        if ("65.24.51.186" != $_SERVER["REMOTE_ADDR"]) {
            exit;
        } else {
            $PrivilegedAccess = true;
        }
    }

    $Connection = new db();
    $Article    = db::get("content", "*", "", "", "1"); // test article
    //$sections   = db::get("sections", "*", "", "`index` ASC");
    //$settings   = db::get("settings", "`virtual-folder`", "", "", "1");  // type`!='homepage' &&
    $Articles   = db::get("content", "*", "`deleted` != 1", "`navi_order` DESC", "");
    $List       = db::get("subscribers", "*");
    //$CAT        = db::get("`categories`", get_all_from("categories"), "", "");
    //$CAT2       = db::get("`categories2`", get_all_from("categories2"), "", "");
    $Slide      = db::get("`slideshow`", get_all_from("slideshow"), "", "");
    $Navigation = db::get("`navigation`", get_all_from("navigation"), "", "");

    ?><!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
    <head><title>Site Settings - Admin</title>
    <META http-equiv="Content-Type" content="text/html;charset=utf-8">
    <script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
    <script type = "text/javascript">
        window.website = new Object();
        website.url = '<?php print $URL; ?>';
        website.img_dir_name = '<?php print $IMAGE_DIR_NAME; ?>';
    </script>
        <script src = '<?php print $URL; ?>/plugins/jsdb/lib.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/util.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/calendar.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/calendar_api.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/default2.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/js/default3.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/admin/editor.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/admin/slideshow.js' type = 'text/javascript'></script>
    <script src = '<?php print $URL; ?>/admin/navigation.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/jquery.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/ui.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/code-formatting.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/default1.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/viewport.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/js/scrollto.js' type = 'text/javascript'></script>
	<script src = '<?php print $URL; ?>/Templates/simplicity/script.js' type = 'text/javascript'></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/utility.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/canvas.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/animate.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/spritesheet.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/sprite.js?v=5" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/sound.js?v=10" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/world.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/point.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/vector.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/segment.js" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/circle.js?v=3" type = "text/javascript"></script>
	<script src = "http://www.learnjquery.org/games/Tig_jsGE/rectangle.js?v=1" type = "text/javascript"></script>    
    <link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/admin/editor.css' />
    <link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/css/code.css' />
    <link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/css/calendar.css' />
    <link rel = 'stylesheet' type = 'text/css' href = '<?php print $URL; ?>/admin/index.css' />

    <script type="text/javascript">

        function isSelected(input) {
            if (typeof input.selectionStart == "number") {
                return input.selectionStart == 0 && input.selectionEnd == input.value.length;
            } else if (typeof document.selection != "undefined") {
                input.focus();
                return document.selection.createRange().text == input.value;
            }
        }

        function load_settings() {

            // Reset button state styles
            $("#btn_webpage,#btn_blog,#btn_email").removeClass("btn_sel");

            $.ajax( {

                url : 'load-settings.php',
                data : {},
                success : function(msg) {

                    if (is_json(msg)) {

                        var previous_content_type = JSON.parse(msg).previous_content_type;

                        if (previous_content_type != "") {
                            // Apply state styles to buttons
                            $("#btn_" + previous_content_type).addClass("btn_sel");
                            $("#new_page_type").val(previous_content_type);
                        }
                        else {
                            console.log("Editor Settings: previous_content_type = empty");
                            $("#btn_webpage").addClass("btn_sel");
                            $("#new_page_type").val("webpage");
                        }

                        // Build URL from title as it is being typed in
                        $("#new_page_title").on("keyup", function() {
                            var v = $(this).val().replace(/ /g,"_").toLowerCase();
                            $("#nfn").val(v + ".html");
                        } );

                        // Attach clickers to buttons
                        $("#btn_webpage").on("click", function(msg) {
                            $("#btn_webpage,#btn_blog,#btn_email").removeClass("btn_sel");
                            $("#btn_webpage").addClass("btn_sel");
                            $("#new_page_type").val("webpage");
                            $("#new_page_title").select();
                            dbjs.table = "settings";
                            dbjs.set( { "previous_content_type" : "webpage" }, "", 1, function(msg){} );
                        });
                        $("#btn_blog").on("click", function(msg) {
                            $("#btn_webpage,#btn_blog,#btn_email").removeClass("btn_sel");
                            $("#btn_blog").addClass("btn_sel");
                            $("#new_page_type").val("blog");
                            $("#new_page_title").select();
                            dbjs.table = "settings";
                            dbjs.set( { "previous_content_type" : "blog" }, "", 1, function(msg){} );
                        });
                        $("#btn_email").on("click", function(msg) {
                            $("#btn_webpage,#btn_blog,#btn_email").removeClass("btn_sel");
                            $("#btn_email").addClass("btn_sel");
                            $("#new_page_type").val("email");
                            $("#new_page_title").select();
                            dbjs.table = "settings";
                            dbjs.set( { "previous_content_type" : "email" }, "", 1, function(msg){} );
                        });

                    } else {
                        console.log("load-settings.php: Unable to load editor settings. Msg is not a valid json = " + msg);
                    }


                }

            } );
        }

        function update_doc_state() {
            article_todraft($("#key").val());
        }

        function hide_all_subcontrols() {
            $("#html-email-it").hide();
            $("#html-new-page").hide();
            $("#html-publish").hide();
            $("#html-schedule").hide();
            $("#html-details").hide();
            window.file_details = false;
        }

        /* Move html-preview up/down */
        function reveal(h_pixels) {
            $("#html-preview").animate( { "top": h_pixels + "px" }, 400 );
            if (h_pixels != 97)
                $("#fold-up").animate({opacity:1},300);
            else
                $("#fold-up").animate({opacity:0},300);
        }

        /* Toggle File Details */
        window.file_details = false;
        function ctrl_details()
        {
            hide_all_subcontrols();
		    $("#html-details").show();
		    reveal(560);
		    window.file_details = true;
        }

        /* Toggle Calendar */
        function ctrl_schedule()
        {
            hide_all_subcontrols();
		    $("#html-schedule").show();
		    reveal(680);
		    // Remove current options of the scheduler
		    //$(".AddTitle").hide();
        }

        /* Toggle Publish */
		function ctrl_publish()
		{
		    hide_all_subcontrols();
		    $("#html-publish").show();
		    reveal(280);
//		    article_todraft($('#key').val())
		}

        /* Toggle Email Sender */
        function ctrl_email() {
            hide_all_subcontrols();
            $("#html-email-it").show();
        	reveal(300);
        }

        /* Toggle Email Sender */
        function ctrl_new() {
            var filename = filename_rnd("html");
            $("#nfn").val(filename);
            // select "Untitled" name
            $("#new_page_title").val("Untitled Page").select();

            hide_all_subcontrols();
            $("#html-new-page").show();
        	reveal(330);
        	$("#new_page_title").select();
        }

        /* Make article list draggable */
        function make_draggable() {

            $(".q_a").sortable( {
            stop:function(event, ui) {
                var list = $(".q_a").sortable('toArray');
                var arr = [];
                var txt = "";
                for(var i = 0; i < list.length; i++) {
                    if (list[i] != "") {
                        arr[arr.length] = list[i];
                        if (i > 1) txt += "|";
                        txt += list[i].split("-")[1];
                    }
                }
                $.ajax( {
                    url: "reorder-navi-items.php",
                    type: "POST",
                    data: { "txt" : txt },
                    success: function(msg) {
                        /* cache this page -- todo: reduce cacher to a single article id */
                        cache(undefined);
                    }
                });
            }});
        }

		function update_html() {
    		var html = get_html(true);
    		$('#text-editor').html(html);
		}

		function remove_menu_items() {
		    $(".main-menu-item").removeClass("sel");
		}

        // hide content, slideshow, navigation, etc. views
        // (Note: the main content editor screen is always on,
        // All other screens are overlaid on top of it.)
        function hide_all_controls() {
            $("#slideshow-view").hide();
            $("#navigation-view").hide();
        }

        $(document).ready(function() {




			$(".main-menu-item").on("click", function(msg) {
  			    remove_menu_items();
			    $(this).addClass("sel");
			    var type = $(this).attr("type");
			    if (type == "content") {
			        hide_all_controls();
			    }
			    if (type == "slideshow") {
			        hide_all_controls();
			        $("#slideshow-view").show();
			    }
			    if (type == "navigation") {
			        hide_all_controls();
			        $("#navigation-view").show();
			    }

			} );



            hide_all_subcontrols();




            // Load editor settings
            load_settings();

            // Load content article

            <?php if (array_key_exists("article_id",$_REQUEST) == true && is_numeric($_REQUEST["article_id"])) { ?>

                window.load_article(<?php print $_REQUEST["article_id"]; ?>);



            <?php } else { /* Load default article (first one, or last saved one, if there was such) */ ?>

                load_most_recent_article_id();

            <?php } ?>



            // Make article list draggable
            make_draggable();

            $("#text-editor").css({border:"1px dotted gray"});

            /* Create draggable panes */
            $("#VerticalPane").draggable( { axis: "x",
                start: function() {
                    window.pane = new Object();

                    window.pane["pane1"] = parseInt($("#VerticalPane").css("width"));

                    /* width of text editor textarea */
                    window.pane["text-editor"] = parseInt($("#text-editor").css("width"));
                },
                drag: function() {
                    resize_to_pane();
                }});

            resize_to_pane();
        });

        function resize_to_pane() {

            var W = parseInt($("#VerticalPane").css("left"));

            $("#EditPage").css( { width: (W - 32) + "px", height: 200 + "px" } );

            /* Defaults: Adjust the left-hand side editor view */
            $("#text-editor").stop().css( { width: W - 55 + "px" } );
            $("#EditPage textarea").stop().css({ width: W - 190 + "px" });
            $("#EditPage div.InputValue").stop().css({ width: W - 175 + "px" });
            $("#EditPage #PageSettings").stop().css({ left: (W - 229) + "px" });
            $("#EditPage #PageSettings").stop().css({ left: (W - 229) + "px" });
            $("#editor-options-pad").stop().css( { width: W - 20 + "px", background: "#dddddd" } );

            /* The right-hand side (preview) */
            var ww = window.width - 535 - parseInt($("#text-editor").css("width"));

            var MARGIN = 16;

            // Resize HTML preview pane
            $("#html-preview").stop().css( { left: W + MARGIN + 3 + "px", width: ww + 48 - MARGIN } );
            $("#DocumentControls").stop().css({left: 0 + "px", width: ww + 24 + 48 + "px"});

            // Resize slideshow pane:
            $("#slideshow-view").stop().css( { left: W + MARGIN + 3 + "px", width: ww + 250  } );

            // Resize navigation pane:
            $("#navigation-view").stop().css( { left: W + MARGIN + 3 + "px", width: ww + 250  } );

            $("#preview-options").stop().css( { left: W+30+"px" } );
            $("#dragup").stop().css( { width: (W - 22) + "px" } );
            $("#editor-options").stop().css( { width: W - 22 + "px" } );

            /*
            if (W < 500) { // Mini view
                $("#EditPage input[type='text']").css( { width: 105 + "px" } );
                $("#EditPage select").css( { width: 111 + "px" } );
                $("#EditPage #PageSettings").css( { left: '271px', width: 100 + (W-400) + "px" } );
            }
            else
            {
                $("#EditPage input[type='text']").stop().css({ width: W - 395 + "px" }, 100);
                $("#EditPage select").stop().css({ width: W - 389 + "px" }, 100);
                $("#EditPage textarea").stop().css({ width: W - 190 + "px" }, 100);
                $("#EditPage #PageSettings").stop().css({ width: 195 + "px" }, 100);
            } */

            save_pane_position();
        }


</script>

</head>
<body>
<style type= "text/css">
    table.grid {
        border-color: #ddd;
        border-width: 0 0 1px 1px;
        border-style: solid;
        border-spacing: 0;
        border-collapse: collapse;
    }
    table.grid td {
        border-color: #ddd;
        border-width: 1px 1px 0 0;
        border-style: solid;
        margin: 0;
        padding: 4px;
        vertical-align: top;
    }
    #NavControls a { color: #cfcd9e }
    #sun-ic div { float: left; }
    #moon-ic div { float: left; }
    *:focus {
        outline: 0;
    }
</style>

<div id = "NavControls">
    <div style = "background: #435481;">
        <div class = "option"><a href = "index.php#" onclick = "to_admin(); $('#Admin').show().end().add('#Editor').hide();">Admin</a></div>
        <div class = "option"><a href = "index.php#" onclick = "to_editor(); $('#Admin').hide().end().add('#Editor').show();">Editor</a></div>
        <div class = "option"><a onclick = "return false;" href = "#" target = "_blank" style = "color:gray;">Builder</a></div>
        <div class = "option"><a onclick = "return false;" href = "#" target = "_blank" style = "color:gray;">List</a></div>
       	
       	<?php if ($PrivilegedAccess) { ?><div class = "option" style = "background: transparent;"><a href = "#" style = 'text-decoration:none; background:#555;color:#dd0;'>&nbsp;&nbsp;Privileged Access&nbsp;&nbsp;</a> <span style = 'color:silver;'><b>db=</b><?php print MysqlConfig2::$CATALOG; ?> IP_ADDRESS=<?php print $_SERVER["REMOTE_ADDR"]; ?></span></div><?php } ?>
       
        <?php /*<div class = "option"><a href = "<?php print $URL; ?>/admin/messenger.php" target = "_blank" style = "">Messenger</a></div> */ ?>
        <?php /*<div class = "option"><a href = "#" onclick = "" style = "color:gray;">Schedule</a></div>
        <div class = "option"><a href = "#" onclick = "" style = "color:gray;">Twitter</a></div>
        <div class = "option"><a href = "#" onclick = "" style = "color:gray;">Affiliates</a></div> */ ?>
        <div class = "option" id = "sun-ic" onclick = "set_view_mode('day')"><div class = "smode" style = "position: relative; width: 22px; height: 18px; cursor: pointer;" title = "day mode"></div></div>
        <div class = "option" id = "moon-ic" onclick = "set_view_mode('night')"><div class = "smode" style = "position: relative; width: 22px; height: 18px; cursor: pointer; " title = "night mode"></div></div>
        <div style = "float: right; line-height:16px !important; width: 50%;text-align:right;font-family:Verdana,sans-serif; font-size:10px !important; margin-right:3px;" id = "status22"></div>
    </div>
</div>

<div id = "List">
    Subscribers List...
</div>

<div id = "Admin" style = "height: 90%;">
<br><br>

<?php include("analytics.php"); ?>

</div>
<style type = "text/css">

    #VerticalPane { background: #7a967f url('vertical-line-1.png') !important; cursor: e-resize; z-index: 214748367; }
    #VerticalPane:hover { background: #9bc2a1 url('vertical-line.png') !important; }
    #dragup { background: #bbb url('horizontal-line-1.png') !important; }
    #dragup:hover { background: #9bc2a1 url('horizontal-line.png') !important; }

    #PublishContainer { display: block; }

    /* Main HTML preview view */
    #html-preview { position: absolute; top: 97px; left: 680px; background:#fff; width: 600px; min-height: 600px; height: 900px; overflow: auto; }
    #html-preview { font-family: Arial; font-size: 14px; padding: 48px; z-index: 10000; }
    #html-preview { padding-top: 48px; }
    #html-preview h1 { font-size: 18px; }
    #html-preview h2 { font-size: 17px; }
    #html-preview h3 { font-size: 16px; }
    #html-preview div { font-size: 14px; }

    /*  */
    #slideshow-view { position: absolute; z-index: 100000; position: absolute; top: 20px; left: 680px;
                      background: #eee; width: 700px; min-height: 600px; height: 900px; overflow: auto;
                      display:none; }

    /*  */
    #navigation-view { position: absolute; z-index: 100001; position: absolute; top: 20px; left: 0px;
                      background: #eee; width: 700px; min-height: 600px; height: 900px; overflow: auto;
                      display:none; }

    #text-editor { width: 600px; padding: 10px; margin-top: 0; }

    #preview-options { position: absolute; top: 10px; left: 673px; background:#eee; width: 600px; /*min-height: 120px;*/ }
    #editor-options { position:relative;  background: #dedede; width: 630px; margin-top: -68px; }
    #editor-options div { padding: 4px; }
    #html { display: none; border-radius: 10px; position: absolute; top: 150px; left: 300px; width: 600px; height: 450px;
            margin: auto 0; background: #000; z-index: 2147483647; }
    #cp-links { font-family: Arial,sans-serif; font-size: 12px; }

</style>

<div id = "VerticalPane" style = "position: absolute; top: 17px; left: 454px; width: 8px; height: 100%; background: silver">

</div>

<div id = "Editor">

    <!-- Editor //-->

    <div id = "EditPage" style = "border: 0;">

        <div class = "LineBreak" style = "height: 14px;"></div>

        <style>
            .main-menu-item { position: relative; padding-left: 3px; min-width: 80px;cursor: pointer; background: url('tab-on.png') repeat-x; padding: 4px; margin-bottom: 0px;
                          width: 90%; color: #999; font-family: Verdana, sans-serif; font-size: 12px; height: 15px; }
            .main-menu-item:hover { background: url('tab-on-1.png') repeat-x; color: #555; }
            .main-menu-item.sel { background: url('tab-off.png') repeat-x; color: #555; }
            .main-menu-item img { position: absolute; top: 2px; right: 2px; }
        </style>

        <div class = "rounded" style = "border: 1px solid #bbb; width: 100px; margin: 0 auto; margin-top: 32px;">
            <div style = "background: #ddd; position: absolute; top: -8px; left: 20px; font-family: Verdana; font-size: 12px; color: gray;">&nbsp;Main Menu&nbsp;</div>
            <div type = "content"    class = "main-menu-item sel">Content <img src = "ic-1.png" /></div>
            <div type = "slideshow"  class = "main-menu-item">Slideshow <img src = "ic-2.png" /></div>
            <div type = "navigation" class = "main-menu-item">Navigation <img src = "ic-3.png" /></div>
        </div>

        <div style = "font-size: 11px; font-family: Verdana; margin-left: 16px; margin-top: 16px;"
            <p><b>PHP Config</b><br/>get_magic_quotes_gpc = <?php print get_magic_quotes_gpc(); ?></p>
        </div>

        <!-- Disabled~~ //-->

        <div style = "display:none;">
        <div class = "InputName"><p>Article Images</p></div>
        <div class = "InputValue"><a href = "index.php#">upload</a></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Facebook message</p></div>
        <div class = "InputValue"><input type = "text" id = "facebook_msg" value = ""/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Twitter message</p></div>
        <div class = "InputValue"><input type = "text" id = "twitter_msg" value = ""/></div>
        <div class = "LineBreak"></div></div>

       <?php /* <textarea id = "article"></textarea> */ ?>



    </div>

    <div id = "dragup" style = "margin-left:-24px;text-align: center; background: gray; height: 8px; margin-top: 10px; ">

    </div>

    <div id = "Queue" style = "padding: 4px; z-index: 77777775">

        <style>
            div#queue_ctrl { margin-top:10px; }
            div#queue_ctrl input,
            div#queue_ctrl select { font-size: 11px; font-family:Arial,sans-serif; }
        </style>

      <div id = "queue_ctrl"  style = "display:none">

          Newsletter layout:<br/>

          <select id = "aweber_article_settings_general" style = "width: 170px;">

            <?php

                if (isset($aweber_article_settings))
                for ($i = 0; $i < count($aweber_article_settings); $i++) {

                    $foreground_popup = $aweber_article_settings[$i]['foreground_popup'];
                    $foreground_popup_timing = $aweber_article_settings[$i]['foreground_popup_timing'];
                    $foreground_popup_wait_for_scrollbar = $aweber_article_settings[$i]['foreground_popup_wait_for_scrollbar'];
                    $sidebar_form = $aweber_article_settings[$i]['sidebar_form'];
                    $bottom_form = $aweber_article_settings[$i]['bottom_form'];
                    $settings_name = $aweber_article_settings[$i]['settings_name'];
                    $listname = $aweber_article_settings[$i]['listname'];

                    ?>

                    <option foreground_popup = "<?php print $foreground_popup; ?>"
                            foreground_popup_timing = "<?php print $foreground_popup_timing; ?>"
                            foreground_popup_wait_for_scrollbar = "<?php print $foreground_popup_wait_for_scrollbar; ?>"
                            sidebar_form = "<?php print $sidebar_form; ?>"
                            bottom_form = "<?php print $bottom_form; ?>"
                            listname = "<?php print $listname; ?>"
                     value = "<?php print $aweber_article_settings[$i]['key']; ?>"><?php print $listname . ": " . $settings_name; ?></option>

                <?php } ?>

            </select>

          <input type = "button" value = "Apply to selected" />

          <?php /* Apply template to all selected articles */ ?>

          Web page layout:<br/>
          <select id = "article_web_template_to_all">

            <option value = "None">None</option>

            <?php

                if ($handle = opendir($FILESYSTEM . '/Templates/AvailableTemplates'))
                {
                    echo "Directory handle: $handle\n";
                    echo "Entries:\n";

                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle))) {

                        if ($entry != "." && $entry != "..") {

                            ?>
                            <option value = "<?php print $entry; ?>"><?php print $entry; ?></option>
                            <?php
                        }
                    }

                    closedir($handle);
                }

            ?>

            </select>

          <input type = "button" value = "Apply to selected" />

      </div>

        <style>
            .ArticleTab {
                width: 100%;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                color: #555;
                font-size: 11px !important;
            }
        </style>

        <!-- Select: <a href = "#" onclick = "$('#scheduled input[type=checkbox]').prop('checked',true);">All</a> |
        <a href = "#" onclick = "$('#scheduled input[type=checkbox]').prop('checked',false);">None</a> //-->

        <style>
            ul.q_a { margin: 0; padding: 0; }
            ul.q_a li { position: relative; width: 240px; height: 24px; }
        </style>

        <?php include("filter_opts.php"); ?>

        <div style = "margin-top: 8px; position: relative; background: #eee" id = "scheduled">

        <ul class = "q_a">

        <?php

                for ($i = count($Articles) - 1; $i >= 0 ; $i--)
                {
                    $type = $Articles[$i]["type"];
                    $title = $Articles[$i]["title"];
                    $article_key = $Articles[$i]['key'];
                    $article_template = $Articles[$i]['template'];
                    $draft = $Articles[$i]['draft'];
                    $location = $Articles[$i]['location'];
                    $in_navigation = $Articles[$i]['navi'];

                    include("scheduled_article.php");
                }

            ?>

            </ul>

        </div>

    </div>

    <div id = "editor-options-pad"></div>

    <div id = "editor-options" style = "">

        <?php /*
        <div id = "options" style = "display:none;">
            <b>&gt;&gt;</b>
            <!-- Wrap in # //-->
            <button onclick = "ModifySelection('text-editor', '«', '»');">B</button>
            <button onclick = "ModifySelection('text-editor', '<i>', '</i>');" style = "text-style: italic !important;">I</button>
            <button onclick = "ModifySelection('text-editor', '<b><i>', '</i></b>');" style = "text-style: italic !important;">BI</button>
            <input type = "button" onclick = "ModifySelection('text-editor', '<u>', '</u>');" style = "text-style: underline !important;" value = "U"/>
            <button onclick = "ModifySelection('text-editor', '<span style=\'color:red;\'>', '</span>');" style = "text-style: italic !important; background: red;">R</button>
            <button onclick = "ModifySelection('text-editor', '<span style=\'color:blue;\'>', '</span>');" style = "text-style: italic !important; background: blue;">B</button>
            <!-- <button onclick = "$('#html').toggle()">HTML</button> //-->
            <button onclick = "ModifySelection('text-editor', '<code>', '</code>');" style = "text-style: italic !important;">&lt;code&gt;</button>
            <style>
                button.flat { border:0; padding:2px; padding-left: 8px; padding-right: 8px; }
                button.flat { margin-top: 4px; }
            </style>
            <button onclick = "save_article($('#key').val())" style = "float:right; background:blue; color: #eff1bb;" class = "flat">Save (CTRL+S)</button>
            <button onclick = "" style = "float:right; background:#528060; color: #eff1bb;" class = "flat">Save as New Draft</button>
            <button onclick = "clear_article()" style = "float:right; background:gray;" class = "flat">Clear</button>
            <span style = "min-width: 70px; display:block; z-index: 100000000000000; position: absolute; top: -18px; right: 20px; color:gray;" id = "article_save_status"></span>
        </div>
        */ ?>

    </div>

    <div style = "clear:both; height: 18px;"></div>

    <div id = "preview-options" style = "text-align: left !important; margin-top: 8px;">

    <div style = "position: relative; padding: 8px; padding-top: 4px;" id = "cp-links">

        <?php /* <div style = "display:none">

            <p><b>Paragraph Style <a href = "#" onclick = "$('')"></a></b></p>

            <div style = "height: 8px;"></div>

            Font: <select id = "paragraph_font">
                <option value = "Times New Roman">Times New Roman</option>
                <option value = "Arial,sans-serif">Arial</option>
                <option value = "Verdana,Arial,sans-serif">Verdana</option>
                <option value = "Tahoma,sans-serif">Tahoma</option>
            </select>

            Font-size: <select id = "paragraph_font_size">
                <option value = "12px">12px</option>
                <option value = "13px">13px</option>
                <option value = "14px">14px</option>
                <option value = "15px">15px</option>
                <option value = "16px">16px</option>
                <option value = "17px">17px</option>
                <option value = "18px">18px</option>
                <option value = "19px">19px</option>
                <option value = "20px">20px</option>
            </select>
            Line-height: <input type = "text" id = "paragraph_line_height" style = "width: 48px" />
            <input type = "button" value = "Build" onclick = "build()" style = "margin-left: 48px;"/>
            <input type = "button" value = "Clear" onclick = "clear_all_styles(); up();">
            <div style = "height: 8px;"></div>
            style = {<input type = "text" id = "paragraph_style" value = "" style = "width: 500px; border:0;" placeholder = "Ex: font-family: Arial, sans-serif; line-height: 14px;" />}
        </div>

        <div style = "height: 8px;"></div> */ ?>

        <?php /* <button onclick = "format_paragraphs()">Apply to HTML</button> */ ?>
        <?php /* <button onclick = "up();">Reset HTML</button> */ ?>

<?php /*

        <a href = "#" onclick = "get_html()">Get Plain HTML</a> |
        <a href = "#" onclick = "$('#calendarArea').show()">Schedule</a> |
        <b><a href = "#" onclick = "email_it()">Email</a></b> |
        <a href = "#" onclick = "">Duplicate</a> |
        <b><a href = "#" onclick = "">Clear</a></b> |
        <b><a href = "#" onclick = "">Save</a></b> |
        <a href = "#" onclick = "">Publish</a> |
        <b><a href = "#" onclick = "">View</a></b> |
        <b><a href = "#" onclick = "">New</a></b> |
        */ ?>

        <div id = "panel-msg"></div>
        <?php /* <button onclick = "get_email_newsletter_html()">Email Format HTML</button> */ ?>
        <br/>
        <div style = "height:5px;"></div>
        <style>
            .get_plain_html_btn { background: #333; color: #fff; border: 0; padding: 4px;  }
            #panel-msg { position: absolute; font-family: Arial; font-size: 12px; color: #333; margin-top: 0px; margin-left: 0px; }
            #fold-up { opacity: 0; }
        </style>

        <button class = "get_plain_html_btn" onclick = "ctrl_new()" style = "cursor: pointer; background: #0057da">New</button>
        <button class = "get_plain_html_btn" onclick = "save_article($('#key').val())" style = "cursor: pointer;">Save</button>
        <button class = "get_plain_html_btn" onclick = "cache(function(){save_article($('#key').val())})" style = "cursor: pointer;">Save All</button>
        <button class = "get_plain_html_btn" onclick = "ctrl_publish()" style = "cursor: pointer;">Publish</button>
        <button class = "get_plain_html_btn" onclick = "ctrl_details()" style = "cursor: pointer;">Details</button>
        <button class = "get_plain_html_btn" onclick = "ctrl_email()" style = "cursor: pointer;">Email</button>
        <button class = "get_plain_html_btn" onclick = "ctrl_schedule()" style = "cursor: pointer;">Schedule</button>
        <button class = "get_plain_html_btn" onclick = "get_html()" style = "cursor: pointer;">HTML</button>
        <?php /* <button class = "get_plain_html_btn" onclick = "" style = "cursor: pointer;">Details</button> */ ?>
        <button class = "get_plain_html_btn" onclick = "save_as_draft()" style = "cursor: pointer;">Duplicate</button>
        <button class = "get_plain_html_btn" onclick = "var type = $('#article_type').val(); if (type=='nodir' || type=='homepage' || type=='webpage') { window.open('<?php print $URL; ?>/' + $('#location_uri').val(), '_blank'); } else { window.open('<?php print $URL; ?>/' + (type != '' ? $('#article_type').val() + '/' : '') + $('#location_uri').val(), '_blank'); }" style = "cursor: pointer;">View</button>
        <button class = "get_plain_html_btn" onclick = "reveal(97)" style = "cursor: pointer;" id = "fold-up">&#8593;</button>

        <style>
            .ctrl_btn {  }
            #ctrl_hyperlink {  }
            .ctrl_btn img { border: 0; }
        </style>

        <div id = "DocumentControls" style = "margin-top: 8px; text-align: center;">

            <a onclick = "hyperlink()" href = "javascript: return false;" class = "ctrl_btn" id = "ctrl_hyperlink"><img src = "hyperlink.png" alt = "Insert Hyperlink" /></a>
            <a onclick = "bold()" href = "index.php#" class = "ctrl_btn" id = "ctrl_bold"><img src = "bold.png" alt = "Make Bold" /></a>
            <a onclick = "italic()" href = "index.php#" class = "ctrl_btn" id = "ctrl_italic"><img src = "italic.png" alt = "Make Italic" /></a>
            <a onclick = "photo()" href = "index.php#" class = "ctrl_photo" id = "ctrl_photo"><img src = "photo.png" alt = "Insert Photo" /></a>
            <a onclick = "grid(2)" href = "index.php#" class = "ctrl_grid" id = "ctrl_grid"><img src = "grid.png" alt = "Insert Grid Layout" /></a>
            <a onclick = "grid(25)" href = "index.php#" class = "ctrl_grid" id = "ctrl_grid"><img src = "grid-m.png" alt = "Insert Grid Layout With Middle Separator" /></a>
            <a onclick = "grid(3)" href = "index.php#" class = "ctrl_grid" id = "ctrl_grid"><img src = "grid3.png" alt = "Insert Grid Layout" /></a>

        </div>





        <!-- Email sender view //-->
        <style>
            .under-menu { z-index: 5000; position: absolute; top: 100px; left: 32px; }
            .rounded { border: 1px solid #999; border-radius: 5px; padding: 8px; font-family: Arial;font-size:12px; position: relative;}
            .rounded-title { background:#eee;position: absolute; top:-8px; left: 16px; font-family: Arial;font-size:12px; font-weight: bold;}
            #html-email-it {  }
            .under-menu.on { display:block; }
            .under-menu.off { display:none; }
            #html-new-page { width: 400px; }
        </style>

        <div id = "html-email-it" class = "under-menu" style = "display:none;">
        Send this article to your subscribers:
        <br/>
        To: <select id = "target" style = "width: 150px; background: white; border:0;">
        <option value = "list:<?php print $DEFAULT_SUBSCRIBER_LIST_ID; ?>"><?php print count($List); ?> subscriber<?php count($List) != 1 ? print "s" : print ""; ?></option>
        <option value = "email:greg.sidelnikov@gmail.com">Email to greg.sidelnikov@gmail.com</option>
        <option value = "email:greg@learnjquery.org">Email to greg@learnjquery.org</option>
        </select><br/> 
        <input type = "text" value = "" placeholder = "From Name" /><br/>
        <input type = "text" value = "" placeholder = "Email Subject Line" /><br/>
        <div contenteditable = "true" style = "border: 1px solid gray; width: 350px; height: 50px !important;" placeholder = "Email Message"></div><br/>
        <input type = "button" value = "Send Message" />
        </div>

        <!-- New Document view //-->
        <div id = "html-new-page" class = "under-menu">
            <div class = "rounded">
                <div class = "rounded-title">Create New Content</div>

                <style>

                    .button_type {
                        position: relative;
                        width: 66px;
                        height: 24px;
                        line-height: 23px;
                        font-family: Verdana, sans-serif;
                        font-size: 12px;
                        color: white;
                        text-align: center;
                        float: left;
                        border-radius: 6px;
                        margin-left: 4px;
                        cursor: pointer;

                    }

                    .blue_btn { background: url("type_btn_1.gif") no-repeat; }
                    .gray_btn { background: url("type_btn_0.gif") no-repeat; }

                    .button_type.btn_sel .arrow {
                        position: absolute;
                        top: 24px;
                        left: 26px;
                        width: 11px;
                        height: 6px;
                        background: url("type_btn_0_tail.gif") no-repeat;
                    }

                    /*.button_type:hover {
                        background: url("type_btn_1.gif") no-repeat;
                    } */

                    /* On hover
                    .button_type:hover {
                        background: url("type_btn_1.gif") no-repeat;
                    }
                    .button_type:hover .arrow {
                        background: url("type_btn_1_tail.gif") no-repeat;
                    } */

                    .gray_btn:hover .arrow { position: absolute;
                        top: 24px;
                        left: 26px;
                        width: 11px;
                        height: 6px;
                        background: url("type_btn_0_tail.gif") no-repeat; }

                    .btn_sel { background: url("type_btn_1.gif") no-repeat !important; }
                    .btn_sel .arrow { background: url("type_btn_1_tail.gif") no-repeat !important; }

                </style>

                <div style = "height: 50px; padding-top: 8px;">
                    <div id = "btn_webpage"  class = "button_type gray_btn btn_sel">Page<div class = "arrow"></div></div>
                    <div id = "btn_blog"  class = "button_type gray_btn">Blog<div class = "arrow"></div></div>
                    <div id = "btn_email" class = "button_type gray_btn">Email<div class = "arrow"></div></div>
                </div>

                <table>
                <tr><td>Type</td><td>
                    <select id = "new_page_type">
                        <option value = "webpage">Web Page</option>
                        <option value = "blog">Blog</option>
                        <option value = "email">Email</option>
                    </select>
                </td></tr>
                <tr><td>Title</td><td><input id = "new_page_title" style = "width: 300px" type = "text" placeholder = "My Webpage or Blog Title" /></td></tr>
                <tr><td>Filename</td><td><input id = "nfn" style = "width: 300px" type = "text" placeholder = "example_page.html" /></td></tr>
                <tr><td>Template</td><td><input id = "tmpl" value = "respberry" style = "width: 140px" type = "text" placeholder = "Installed Template Folder Name" /> <span style = "color:gray;">Ex: wooden <i>or</i> respberry <i>etc</i></span></td></tr>
                </table>
                <div style = "width: 380px; text-align: middle;">
                    <button id = "start_new_draft" class = "get_plain_html_btn start_new_draft_button" onclick = "$(this).html('Please Wait...'); $(this).prop('disabled', true); start_fresh_draft($('#new_page_type').val(), $('#nfn').val(), $('#tmpl').val(), $('#new_page_title').val())" style = "display:block;cursor: pointer; margin: 0 auto;">Start New Draft</button>
                </div>
            </div>
        </div>

        <div id = "html-details" class = "under-menu">
            <div class = "rounded" style = "width: 490px;">
                <div class = "rounded-title">Web Page Details</div>

                <?php include("html-details.php"); ?>

            </div>
        </div>

        <!-- Publish //-->
        <div id = "html-publish" class = "under-menu">
            <div class = "rounded">
                <div class = "rounded-title">Publish Draft</div>
                In order for a page to appear live on your website it must be published. To publish a draft, click on the small blue icon <img src = "<?php print $URL; ?>/Images/draft.png" alt = "Document Draft" style = "vertical-align: middle;" /> to the left side of the article name. It will change to RSS icon <img src = "<?php print $URL; ?>/Images/live.png" alt = "RSS Published" style = "vertical-align: middle;" />. This means this page is ready to be published. You still have to save it (Ctrl + S) at least once for the page to be published. In addition you can use controls below.
                <table>
                <tr><td>Type</td><td>

                    <input id = "draft" type = "radio" name = "doc_state" value = "1" /> <img src = "<?php print $URL; ?>/Images/draft.png" alt = "Document Draft" style = "vertical-align: middle;" /> <label for = "draft">Draft</label><br/>
                    <input id = "live" type = "radio" name = "doc_state" value = "0" /> <img src = "<?php print $URL; ?>/Images/live.png" alt = "Live Document" style = "vertical-align: middle;" /> <label for = "live">Published</label><br/>

                </td></tr></table>
                <div style = "width: 380px; text-align: middle;">
                    <button id = "save_doc_state"
                         class = "get_plain_html_btn"
                       onclick = "update_doc_state()"
                         style = "display: block; cursor: pointer; margin: 0 auto;">Update State</button>
                </div>
            </div>
        </div>

        <div id = "html-schedule" class = "under-menu" style = "width: 545px; ">
            <div class = "rounded" style = "height: 500px">
                <div class = "rounded-title">Schedule Article</div>
                Schedule this article to be published at a future time.

                <div style = "width: 480px; text-align: middle;">
					<?php include("calendar.php"); ?>
                </div>

            </div>
        </div>

        <?php //include("msg.php"); ?>
    </div>
</div>

<!-- HTML Preview View //-->
<div id = "html-preview"
  style = "border: 1px solid silver; /*display:none;*/"
  contenteditable = "true">
</div>

<!-- Slideshow View //-->
<div id = "slideshow-view">
    <?php include("slideshow.php"); ?>
</div>

<!-- Navigation View //-->
<div id = "navigation-view">
    <?php include("navigation.php"); ?>
</div>

<div id = "email-preview" style = "display:none"></div>

<div style = "height: 64px"></div>
<div style = "line-height: 19px; padding-left:4px;font-family:Tahoma;font-size:11px;color:white; width: 75px; height: 20px; background: #000;">HTML Editor</div>
<textarea id = "text-editor" style ="border:1px solid red; width: 100px; " onkeyup = "up()" onkeydown = "up()" rows = "100">

</textarea>

</div>

<style></style>

<br/>
<br/>

<!-- The raw HTML code //-->

<div id = "html">
    <div style = "padding: 10px;">
        <textarea id = "ta-html" style = "width: 500px; height: 320px; padding: 10px; font-family: Arial, sans-serif; font-size: 11px;"></textarea><br/>
        <input type = "button" value = "Close" onclick = "$('#html').hide();" />
        <input type = "button" value = "<code> to <pre>" onclick = "convert_code_to_pre()" />
        <input type = "button" value = "<pre> to <code>" onclick = "convert_pre_to_code()" />

    </div>
</div>

<?php include('article-settings.php'); ?>

</div>

<div style = "display:none;position: fixed; top: 0; left: 0; width: 100%; height: 100%; text-align: center; margin-top: 280px" id = "saved_ctr">
    <div style = "position: relative; width: 200px; height: 200px; background: gray; border-radius: 16px; margin: auto; line-height: 190px; color: silver; opacity: 0.9" id = "saved">
        <p style = "font-size: 40px; font-weight: bold;">Saved</p>
    </div>
</div>

<style>
#faded { display: none; z-index: 2147483500; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; opacity: 0.0; }
#faded_2 { display: none; z-index: 2147483500; position: fixed; top: 40px; left: 0; width: 100%; height: 100%; background: transparent; opacity: 0; }
#hyperlink_ctrl { z-index: 2147483501; background: #fff; opacity: 1; width: 400px; padding: 5px; border-radius: 7px; margin: 0 auto; }
#hyperlink_ctrl input { width: 300px; padding: 2px; font-family: Arial; font-size: 17px;}
</style>

<div id = "faded"></div>
<div id = "faded_2">
    <div id = "hyperlink_ctrl">
        <table>
            <tr><td><b>Name</b></td><td><input type = "text" id = "link_anchor" placeholder = "Anchor Text" /></td></tr>
            <tr><td><b>URL</b></td><td><input type = "text" id = "link_url" placeholder = "http://www.example.com/" /></td></tr>
            <tr><td><b>Title</b></td><td><input type = "text" id = "link_title" placeholder = "keywords" /></td></tr>
            <tr><td colspan = "2" style = "text-align: center; padding-top: 5px;">
                <div onclick = "hyperlink_ok()"
                       style = "cursor: pointer; font-family: Tahoma; display:inline; padding: 5px;
                       width: 50px; text-align: center; background: #000; color: white;">Okay</div>
                <div onclick = "hyperlink_cancel()"
                       style = "cursor: pointer; font-family: Tahoma; display:inline; padding: 5px;
                       width: 50px; text-align: center; background: #000; color: white;">Cancel</div>
            </td></tr>
        </table>
    </div>
</div>

</body>
</html>