<style type = "text/css">
    #VerticalPane { background: #7a967f; cursor: e-resize; z-index: 214748367; }
    #VerticalPane:hover { background: #9bc2a1 !important; }
    #dragup { background: #bbb !important; }
    #dragup:hover { background: #9bc2a1 !important; }
</style>

<div id = "VerticalPane" style = "position: absolute; top: 17px; left: 454px; width: 8px; height: 100%; background: silver">

</div>

<div id = "Editor">

    <!-- Editor //-->

    <div id = "EditPage">

        <div class = "LineBreak" style = "height: 14px;"></div>

        <!-- Article Key ID //-->
        <div class = "InputName" custom = "key_container"><p>Article ID</p></div>
        <div class = "InputValue" custom = "key_container"><input type = "text" id = "key" style = "opacity: 1;" /></div>

        <div class = "LineBreak" style = ""></div>

        <!-- Main Category //-->
        <div style = "display:none;">
        <div class = "InputName"><p>Main Category</p></div>
        <div class = "InputValue">
            <select id = "article_cat" style = "display:none; margin-left:1px;border:1px solid white; width: 150px;">
                <option value = ""></option>
                <?php for ($i=0; $i < count($CAT); $i++) { ?>
                <option value = "<?php print $CAT[$i]['dir']; ?>"><?php print $CAT[$i]['name']; ?></option><?php } ?>
            </select>
            <span style = "display:none;position: relative; font-size: 11px; font-family:Verdana,sans-serif; font-weight:bold;">Sub: <select id = "article_subcat" style = "width: 150px; position: absolute; border:1px solid white;">
                <option value = ""></option>
                <?php for ($i=0; $i < count($CAT2); $i++) { ?>
                <option value = "<?php print $CAT2[$i]['key']; ?>"><?php print $CAT2[$i]['long_name']; ?></option><?php } ?>
            </select>
        </div>
        </div>

        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Navigation Name</p></div>
        <div class = "InputValue"><input id = "navi_name" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Browser &lt;title&gt;</p></div>
        <div class = "InputValue"><input id = "browser_title" type = "text" value = "" onkeydown = "type_double()" onkeyup = "type_double()"/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Page Title &lt;h1&gt;</p></div>
        <div class = "InputValue"><input id = "title" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Location URI</p></div>
        <div class = "InputValue"><input id = "location_uri" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>meta description</p></div>
        <div class = "InputValue"><input id = "meta_description" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <!-- Auto-correct tabs ~todo: Add database look-up functionality + add new tags //-->
        <div class = "InputName"><p>meta keywords (tags)</p></div>
        <div class = "InputValue"><input id = "meta_keywords" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <!-- Article Template: minimalist.php, extended.php, etc.  //-->
        <div class = "InputName"><p>Template</p></div>
        <div class = "InputValue"><input id = "article_template" type = "text" value = ""/></div>
        <div class = "LineBreak"></div>

        <!-- Article Type (folder) about, newsletter, plugin, story, draft, etc. //-->
        <div class = "InputName"><p>Page Type</p></div>
        <div class = "InputValue">
            <select id = "article_type" style = "font-size:11px; margin:0; margin-left:1px; border:0;height: 18px;">
                <option value = "nodir">no_dir</option> <!-- no sub-directory, go straight to file from root url //-->
                <option value = "webpage">webpage</option>
                <option value = "blog">blog</option>
                <option value = "homepage">homepage</option>
                <option value = "article">article</option> <!-- legacy support //-->
                <option value = "about">about</option> <!-- legacy support //-->
                <option value = "content">content</option> <!-- legacy support //-->
                <option value = "none">none</option>
            </select>
        </div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>JavaScript</p></div>
        <div class = "InputValue" style = "height: 50px; z-index:1000000000000 !important">
            <textarea id = "javascript" value = "" style = "border: 0; width: 466px; height:45px !important; z-index:1000000000001 !important; margin-left:1px"/></textarea>
        </div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>css</p></div>
        <div class = "InputValue" style = "height: auto; z-index:1000000000000 !important">
            <textarea id = "css" value = "" style = "border: 0; width: 466px; height:45px; z-index:1000000000001 !important; margin-left:1px"/></textarea>
        </div>
        <div class = "LineBreak"></div>

        <!-- Disabled~~ //-->

        <div style = "display:none;">
        <div class = "InputName"><p>Article Images</p></div>
        <div class = "InputValue"><a href = "#">upload</a></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Facebook message</p></div>
        <div class = "InputValue"><input type = "text" id = "facebook_msg" value = ""/></div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>Twitter message</p></div>
        <div class = "InputValue"><input type = "text" id = "twitter_msg" value = ""/></div>
        <div class = "LineBreak"></div></div>

       <?php /* <textarea id = "article"></textarea> */ ?>

       <div id = "PageSettings" style = "font-family:Verdana,sans-serif;font-size:11px; color: gray; font-weight: bold;position: absolute; top: 18px; left: 425px; width: 195px; height: 183px; background: #dddddd;">
           <input type = "checkbox" id = "noindex" style = "vertical-align: middle; margin-top:1px; cursor:pointer;"/> <label for = "noindex" alt = "asd" style = "cursor:pointer;">n&shy;o&shy;i&shy;n&shy;d&shy;e&shy;x</label><br/>
       </div>

    </div>

    <div id = "dragup" style = "text-align: center; background: gray; height: 8px; margin-top: 10px; ">

    </div>

    <div id = "Queue" style = "padding: 4px; z-index: 777777777777">

        <style>
            div#queue_ctrl { margin-top:10px; }
            div#queue_ctrl input,
            div#queue_ctrl select { font-size: 11px; font-family:Arial,sans-serif; }
        </style>

      <div id = "queue_ctrl"  style = "display:none">

          Newsletter layout:<br/>

          <select id = "aweber_article_settings_general" style = "width: 170px;">

            <?php

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
        ul.q_a { margin:0; padding:0; }
        ul.q_a li { position: relative; width: 240px; height: 24px; }
        </style>

        <div style = "position: relative; background: #eee; "
                id = "scheduled">
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

        <div id = "options">

            <b>&gt;&gt;</b>

            <!-- Wrap in # //-->
            <button onclick = "ModifySelection('text-editor', '«', '»');">B</button>
            <button onclick = "ModifySelection('text-editor', '<i>', '</i>');" style = "text-style: italic !important;">I</button>
            <button onclick = "ModifySelection('text-editor', '<b><i>', '</i></b>');" style = "text-style: italic !important;">BI</button>
            <input type = "button" onclick = "ModifySelection('text-editor', '<u>', '</u>');" style = "text-style: underline !important;" value = "U"/>
            <button onclick = "ModifySelection('text-editor', '<span style=\'color:red;\'>', '</span>');" style = "text-style: italic !important; background: red;">R</button>
            <button onclick = "ModifySelection('text-editor', '<span style=\'color:blue;\'>', '</span>');" style = "text-style: italic !important; background: blue;">B</button>
            <!--<button onclick = "$('#html').toggle()">HTML</button>//-->
            <button onclick = "ModifySelection('text-editor', '<code>', '</code>');" style = "text-style: italic !important;">&lt;code&gt;</button>

            <style>
                button.flat { border:0; padding:2px; padding-left: 8px; padding-right: 8px; }
                button.flat { margin-top: 4px; }
            </style>

            <button onclick = "var type = $('#article_type').val();if (type=='nodir' || type=='homepage' || type=='webpage') { window.open('<?php print $URL; ?>/' + $('#location_uri').val(), '_blank'); } else { window.open('<?php print $URL; ?>/' + (type != '' ? $('#article_type').val() + '/' : '') + $('#location_uri').val(), '_blank'); }" style = "float:right; width: 32px; height: 20px; margin-top: 4px; padding: 0; "><img style = "border:0;" src = "<?php print $URL; ?>/Images/icon-view.png"></button>
            <button onclick = "save_article($('#key').val())" style = "float:right; background:blue; color: #eff1bb;" class = "flat">Save (CTRL+S)</button>
            <button onclick = "save_as_draft()" style = "float:right; background:#528060; color: #eff1bb;" class = "flat">Save as New Draft</button>
            <button onclick = "clear_article()" style = "float:right; background:gray;" class = "flat">Clear</button>

            <span style = "min-width: 70px; display:block; z-index: 100000000000000; position: absolute; top: -18px; right: 20px; color:gray;" id = "article_save_status"></span>

        </div>

    </div>

    <div style = "clear:both; height: 18px;"></div>

    <div id = "preview-options" style = "text-align: left !important; margin-top: 8px;">

    <div style = "padding: 8px; padding-top: 4px; ">

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

        <button id = "get_plain_html_btn" onclick = "get_html()">Get Plain HTML</button>

        <?php /* <button onclick = "get_email_newsletter_html()">Email Format HTML</button> */ ?>

        <button id = "schedule_btn" onclick = "$('#calendarArea').show()" style = "border:0;padding:4px;background:blue;color:yellow;font-family:Verdana,sans-serif;font-size:11px;">Schedule</button>

        <br/>
        <select id = "target">
        <option value = "list:<?php print $DEFAULT_SUBSCRIBER_LIST_ID; ?>"><?php print $URL; ?> list containing (<?php print count($List); ?> subscriber<?php count($List) != 1 ? print "s" : print ""; ?>)</option>
        <option value = "email:greg.sidelnikov@gmail.com">greg.sidelnikov@gmail.com</option>
        </select>

        <button id = "get_plain_html_btn" onclick = "$('#Msg').toggle()" style = "cursor: pointer;">Email Message</button>

        <?php include("msg.php"); ?>

    </div>

</div>

<div id = "html-preview" style = "border:1px dotted silver;">


</div>

<div id = "email-preview" style = "display:none;"></div>

<textarea id = "text-editor" style ="border:1px solid red; width: 100px; " onkeyup = "up()" onkeydown = "up()" rows = "100">

</textarea>

</div>

    <style>

        #PublishContainer { display: block; }

        /* p { font-size: 22px; }
        body { margin:64px; }
        .bold { font-weight: bold; }*/

        /* background-color: #444444; color: #ddd; */

        #text-editor { width: 600px; padding: 10px; margin-top: 0; }

        #html-preview { position: absolute; top: 97px; left: 680px; background:#fff; width: 600px; min-height: 600px; height:900px; overflow: auto; }

        #preview-options { position: absolute; top: 10px; left: 673px; background:#eee; width: 600px; /*min-height: 120px;*/ }

        #editor-options { position:relative;  background: #dedede; width: 630px; margin-top: -68px; }

        #editor-options div { padding: 4px; }

        #html { display:none; border-radius: 10px; position: absolute; top: 150px; left: 300px; width: 600px; height: 450px; margin: auto 0; background:#000; z-index:2147483640 }

    </style>

<div id = "schedule_history" style = "border-radius: 10px; position: absolute; top: 150px; left: 300px; width: 600px; height: 450px; margin: auto 0; background:#000; z-index:2147483640">
	<div style = "width: 500px; position: relative; margin: 0 auto;">
		Hello there http://www.learnjquery.org/plugins/list/scheduler_v2016/dispatch_due.php
	</div>
</div>

<br/>
<br/>

<!-- the raw HTML code //-->

<div id = "html">
    <div style = "padding: 10px;">
        <textarea id = "ta-html" style = "width: 500px; height: 320px; padding: 10px; font-family: Arial, sans-serif; font-size: 11px;"></textarea><br/>
        <input type = "button" value = "Close" onclick = "$('#html').hide();" />
        <input type = "button" value = "<code> to <pre>" onclick = "convert_code_to_pre()" />
        <input type = "button" value = "<pre> to <code>" onclick = "convert_pre_to_code()" />

    </div>
</div>

<?php include('article-settings.php'); ?>

<?php /*
    <div style = "position: absolute; top: 200px; left: 200px; background: gray; color: white; padding: 10px;z-index:100000000">
        <button id = "sendmcb" onclick = 'send_current_mailchimp_campaign()'>Send Mailchimp Campaign</button>
    </div> */ ?>
</div>

<div style = "display:none;position: fixed; top: 0; left: 0; width: 100%; height: 100%; text-align: center; margin-top: 280px" id = "saved_ctr">
    <div style = "position: relative; width: 200px; height: 200px; background: gray; border-radius: 16px; margin: auto; line-height: 190px; color: silver; opacity: 0.9" id = "saved">
        <p style = "font-size: 40px; font-weight: bold;">Saved</p>
    </div>
</div>
