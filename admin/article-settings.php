<?php

function collect_unique_newsletters()
{
    $ret = array();

    global $aweber_forms;

    //print "{" . count($aweber_forms) . "}";

    for ($i = 0; $i < count($aweber_forms); $i++) {
        $listname = $aweber_forms[$i]['listname'];
        if (!in_array($listname, $ret))
            array_push($ret, $listname);
    }

    return $ret;

}

function aweber_template_select($n) { global $aweber_forms; ?>
<select class = "aweber_template_submenus" id = "aweber_template_<?php print $n; ?>" style = "width: 150px; font-size:11px;">
<option value = "0">None</option>
    <?php
        for ($i = 0; $i < count($aweber_forms); $i++) {
            $form_name = $aweber_forms[$i]['form_name'];
            $meta_web_form_id = $aweber_forms[$i]['meta_web_form_id'];
            $listname = $aweber_forms[$i]['listname'];
            $img_src_id = $aweber_forms[$i]['img_src_id'];
            $form_title_text = $aweber_forms[$i]['form_title_text'];
            $form_note_text = $aweber_forms[$i]['form_note_text'];
            ?>
            <option
                index = "<?php print $i; ?>"
                listname = "<?php print $listname; ?>"
                meta_web_form_id = "<?php print $meta_web_form_id; ?>"
                img_src_id = "<?php print $img_src_id; ?>"
                form_title_text = "<?php print $form_title_text; ?>"
                form_note_text = "<?php print $form_note_text; ?>"

            ><?php print $form_name; ?></option>
    <?php } ?>
</select>
<?php } ?>

<script>

// Disable or enable newsletter (true|false)
function newsletter_state(n,state)
{
    var sel = $("#n" + n + " input, #n" + n + " select, #n" + n + " textarea");

    if (state == false)
        sel.css("opacity", 0.5);
    else
        sel.css("opacity", 1);

    sel.prop("disabled", !state);
}

function set_newsletter(n,i)
{
    $("#aweber_template_" + n + " option:eq('" + i + "')").prop("selected", "true");
}

// The id of the currently being edited article (for newsletter settings & "publish to.." pop up settings window)
var CURRENT_ARTICLE_ID_SETTINGS = 0;

// Currently selected aweber settings
var CURRENT_AWEBER_SETTINGS = 0;

var CURRENT_ARTICLE_TEMPLATE = "minimalist.php";

// Run every time the article editor opens
function start_newsletter_editor_for(n, title)
{
    // Update current article ID
    CURRENT_ARTICLE_ID_SETTINGS = n;

    // todo: get article's settings
    $.ajax({url: 'get-article-aweber-settings.php',
            type: 'post',
            data: { key: CURRENT_ARTICLE_ID_SETTINGS },
            success: function(msg)
            {
                // Update title
                $("#assh").text(title);

                // Get article's template file
                $("#article_web_template").val(template);

                // Get article's publish settings
                get_current_article_settings();

                var exp = msg.split('№');

                var key = exp[0];
                var foreground_popup = exp[1];
                var foreground_popup_timing = exp[2];
                var foreground_popup_wait_for_scrollbar = exp[3];
                var sidebar_form = exp[4];
                var bottom_form = exp[5];
                var settings_name = exp[6];
                var listname = exp[7];
                var template = exp[8];

                if (key == 1) /* First item is "No newsletter" */
                {
                    // Disable all by default
                    newsletter_state(1, false);
                    newsletter_state(2, false);
                    newsletter_state(3, false);

                    CURRENT_AWEBER_SETTINGS = 1; // key

                    $("#aweber_article_settings").val(0);

                }
                else
                {
                    newsletter_state(1, foreground_popup);
                    newsletter_state(2, sidebar_form);
                    newsletter_state(3, bottom_form);

                    set_newsletter(1, foreground_popup);
                    set_newsletter(2, sidebar_form);
                    set_newsletter(3, bottom_form);

                    // Choose core
                    $("#aweber_article_settings option:eq(" + (key-1) + ")").prop("selected", true);

                    var attr = $("#aweber_article_settings").val();

                    // Update currently selected aweber settings
                    CURRENT_AWEBER_SETTINGS = attr;

                    // Choose setting
                }

                // Update template
                CURRENT_ARTICLE_TEMPLATE = template;

                $("#article_web_template").val(CURRENT_ARTICLE_TEMPLATE);

                //alert(CURRENT_ARTICLE_TEMPLATE);

                $('#ArticleSettings').fadeIn(200);
            }
        });

}

// Save current aweber settings (might need to update them)
function save_aweber_settings()
{

}

/* Get currently set publish settings in the Settings Screen (non-db) */
function gather_publish_settings()
{
    var i = 0;
    var json = "{";
        $(".ps_container select").each(function(obj)
        {
            var val = $('#destination_' + obj + ' option:selected');
            var value_attr = $('#destination_' + obj + ' option:selected').attr('value');
            var kind = $(val).attr('kind');
            var url = $(val).attr('url');
            var email_address = $(val).attr('email_address');
            var keyid = $(val).attr('keyid');
            var text = $(val).text();
            if (keyid != 0)
            {
                if (i != 0)
                    json += ",";
                json += '"' + i + '":{"type":"' + kind + '", "url":"' + url + '", "email":"' + email_address + '", "value_attr": "' + value_attr  + '"}';
                i++;
            }
        });
        if (i != 0)
            json += ',';
        json += '"length":' + i;
        json += "}";        

        return json;
}

/* Save thepublish configuration for future use */
function save_this_configuration_as()
{
    var json = gather_publish_settings();

     $.ajax({ url: 'set-saved-publish-settings.php',
             type: 'post',
    data: {'name': $('#pconfig_name').val(),
           'json': json }, success: function(msg) { alert(msg); /**/ } } );
}

/* Save current publish settings for the article whose keyid is...*/
function save_publish_settings_for(json_str, keyid)
{
    //var json_obj = JSON.parse(json_str);

    $.ajax( { url: 'save-publish-settings.php',
             type:'post',
             data: { key: keyid, settings: json_str },
                success: function(msg)
                {
                    //alert(msg);
                }

            });
}

function retrieve_publish_settings(key)
{
    if (key == -1)
    {
        json_to_settings("{}")
    }
    else
        $.ajax( { url: 'get-saved-publish-settings.php',
             type: 'post',
             data: { 'key': key },
             success: function(m) {
                 json_to_settings(m);
             }
        } );
}

/* Get current article's json and set them into settings editor */
function get_current_article_settings()
{
    $.ajax({ url: 'get-publish-settings.php',
             type: 'post',
             data: { key: CURRENT_ARTICLE_ID_SETTINGS },
              success: function(json_str) {
                  json_to_settings(json_str);
              }
          });
}

function json_to_settings(json_str)
{
    var json = JSON.parse(json_str);
    $('select.publish_to_sel').val("-1");
    $('select.publish_to_sel').parent().parent().hide();
    publishingDestination = 0;
    for (var i = 0; i < 50; i++) {
        var ji = json[i];
        if (ji) {
            // Populate it
            $('#destination_' + publishingDestination + ' select').val(ji.value_attr);
            // Show it
            $('#destination_' + publishingDestination++).show();
        }
    }

}

// Update article's settings ID
function save_article_settings()
{
    CURRENT_ARTICLE_TEMPLATE = $("#article_web_template").val();

    var jsonPublishSettings = gather_publish_settings();

    $.ajax( { url: 'save-article-settings.php',
             type: "post",
             data: {
                     'article_id': CURRENT_ARTICLE_ID_SETTINGS,
                    'settings_id': CURRENT_AWEBER_SETTINGS,
              'template_filename': CURRENT_ARTICLE_TEMPLATE

              },

              success: function(m)
              {
                   /* Update article publish settings */

                   save_publish_settings_for(jsonPublishSettings, CURRENT_ARTICLE_ID_SETTINGS);

                   $("#save_article_settings_info").html(m);

                   setTimeout(function() {
                       $("#save_article_settings_info").fadeOut(200,
                       function() {
                           $("#save_article_settings_info").html("");
                           $("#save_article_settings_info").fadeIn(1);
                       } );
                   }, 2000);
               }
           } );
}

$(document).ready(function()
{

    // On page loaded:
    $("#aweber-list-type").ready(function(m)
    {


    });

    // When user updates it
    $("#aweber-list-type").on("change", function(m) {

        var attr = $(this).attr("value");

        if (attr == "0")
        {
            $("#NewsletterAweberID").val("all");

            $("#aweber_article_settings option:first").prop("selected",true);
            $("#aweber_article_settings option").show();

            // Enable all newsletters (custom design mode)
            newsletter_state(1, true);
            newsletter_state(2, true);
            newsletter_state(3, true);

            $("#aweber_article_settings option").show();
            $(".aweber_template_submenus option").show();
            $(".aweber_template_submenus").val(0);

            return;
        }

        $("#NewsletterAweberID").val(attr);

        $("#aweber_article_settings option").show();
        $("#aweber_article_settings option[listname!='" + attr + "']").hide();
        $("#aweber_article_settings option[listname='all']").show();
        $("#aweber_article_settings option[listname='" + attr + "']:first").prop("selected", true);

        // Now toggle the newsletter-related sub-menus
        $(".aweber_template_submenus option").show();
        $(".aweber_template_submenus option[listname!='" + attr + "']").hide();
        $(".aweber_template_submenus option[value=0]").show();
        for (var j = 1; j < 4; j++)
            $("#aweber_template_" + j + " option[listname='" + attr + "']:first").prop("selected", true);

    });

    $("#aweber_article_settings").on("change", function(m) {

        var attr = $(this).val();

        CURRENT_AWEBER_SETTINGS = attr;

        var foreground_popup = $(":selected",this).attr("foreground_popup");
        var foreground_popup_timing = $(":selected",this).attr("foreground_popup_timing");
        var foreground_popup_wait_for_scrollbar = $(":selected",this).attr("foreground_popup_wait_for_scrollbar");
        var sidebar_form = $(":selected",this).attr("sidebar_form");
        var bottom_form = $(":selected",this).attr("bottom_form");
        var settings_name = $(":selected",this).attr("settings_name");

        newsletter_state(1, foreground_popup);
        newsletter_state(2, sidebar_form);
        newsletter_state(3, bottom_form);

        set_newsletter(1, foreground_popup);
        set_newsletter(2, sidebar_form);
        set_newsletter(3, bottom_form);

    });

});

</script>

<!-- Article Settings Dialog //-->

<style type = "text/css">

    #ArticleSettings { display:none; -moz-box-shadow:0 0 5px #777; position: absolute; top: 150px; left: 440px; width: 1000px; height: 640px; z-index: 100000000; background: #333; }

    #ArticleSettings div { width: 290px; float: left; color:white; padding: 5px; font-family:Arial, sans-serif; }

    #ArticleSettings div#save { text-align: right; width: 900px; height: 50px; bottom:20px; position: absolute; color: white; }

    #ArticleSettings div h2 { font-size: 17px; font-weight:bold; margin-top:0; color: #aaa }

    #ArticleSettings .close { z-index: 100000; position: absolute; top: -50px; left: 930px; }

    #ArticleSettings .close a { color: red; background: yellow; }

    #aweber_article_settings { width: 330px; }

    #ArticleSettings .SettingsHeader { position: absolute; top: -64px; width: 990px; height: 58px; background:#333; }

    #ArticleSettings .SettingsHeader h1 { margin-top:0; }

</style>

<div id = "ArticleSettings" style = "">


    <div class = "SettingsHeader">

        article settings

    </div>

    <div class = "close">[<a href = "#" onclick = "$('#ArticleSettings').fadeOut()">Close</a>]</div>





</div>





