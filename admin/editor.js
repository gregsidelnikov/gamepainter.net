// Template config types
					var types1 = ["ThemeHeader1","ThemeHeader2","ThemeHeader3","ThemeHeader4","ThemeHeader5"];
					var types2 = ["ThemeBody1","ThemeBody2","ThemeBody3"];
					var types3 = ["ThemeAd1","ThemeAd2","ThemeAd3"];
					var types4 = ["ThemeInvite1"]; 
					 
					function refresh_template_config_view(this_id,type_id,index) {
						var typeidx = [types1,types2,types3,types4];
						var arr = typeidx[type_id];
						$(this_id).removeClass().addClass(arr[index]);
						$('.apply_buttons').show();
						$('.apply_note').hide();
						$('#apply_to_all').html("Apply To All");
					}
  
function load_article_template_config(id) {
	console.log("Loading article template config... for " + id);
		$.ajax( { url: window.website.url + '/admin/load_artile_template_config.php',
				type : "post",
				data: { "id":id},
				success : function(msg) {
									
					if (msg == "")
						msg = "0,0,0,0";
						
					//console.log("Success!... got " + msg);
					
					var res = msg.split(","); 
					
					var t1 = res[0];
					var t2 = res[1];
					var t3 = res[2];
					var t4 = res[3];
										
					$("#ArticleTheme_Header").attr("type", t1);
					$("#ArticleTheme_Body").attr("type", t2);
					$("#ArticleTheme_BottomAd").attr("type", t3);
					$("#ArticleTheme_Invite3").attr("type", t4);
					
					$("#ArticleTheme_Header").removeClass().addClass(types1[t1]);
					$("#ArticleTheme_Body").removeClass().addClass(types2[t2]);
					$("#ArticleTheme_BottomAd").removeClass().addClass(types3[t3]);
					$("#ArticleTheme_Invite3").removeClass().addClass(types4[t4]);
					
				}
	});
}

function get_tmp_config() {
	var sec1_type = $("#ArticleTheme_Header").attr("type");
	var sec2_type = $("#ArticleTheme_Body").attr("type");
	var sec3_type = $("#ArticleTheme_BottomAd").attr("type");
	var sec4_type = $("#ArticleTheme_Invite3").attr("type");	
	var config_settings = sec1_type + "," + sec2_type + "," + sec3_type + "," + sec4_type;
	return config_settings;
}

function save_cfg_to_all()
{
	var cfg = get_tmp_config();
	
	$.ajax({
			'url' : website.url + '/admin/apply_theme_to_all_pages.php',
			'type' : 'POST',
			'data' : { 'config_text' : cfg },
			success : function(msg) { 
			    $('#apply_to_all').html('<b>Applied</b>');
			    $('#apply_to_all').css( { 'background' : 'green' } );
			    $('.apply_buttons').hide();
			    $('.apply_note').show();
			} 
	});
}

function save_article_template_config(id) {

	var sec1_type = $("#ArticleTheme_Header").attr("type");
	var sec2_type = $("#ArticleTheme_Body").attr("type");
	var sec3_type = $("#ArticleTheme_BottomAd").attr("type");
	var sec4_type = $("#ArticleTheme_Invite3").attr("type");
	
	var config_settings = sec1_type + "," + sec2_type + "," + sec3_type + "," + sec4_type;

	$.ajax( { url: window.website.url + '/admin/save_artile_template_config.php',
				type : "post",
				data: { "id" : id,
				"config_settings" : config_settings },
				success : function(msg) {
					console.log(msg);
				}
	});
}

    function pad(n, p, c) {

        if (typeof p == 'undefined') {
            p = 2;
        }

        // defailt padding character is '0' unless otherwise specified in c variable.
        var pad_char = typeof c !== 'undefined' ? c : '0';

        
        var pad = new Array(1 + p).join(pad_char);

        return (pad + n).slice(-pad.length);

    }

    function dispatch_message()
    {
        var subject = $("#msg_subject").val();
        var message = get_html(true);
        if (subject == "")
        {
            $("#msg_subject").addClass("redBorder");
            $("#msg_status_send").text("Email subject cannot be empty.");
        }
        else
        {
            //alert($("#target").val());
            $.ajax( { url: window.website.url + '/plugins/list/send.php',
                      type: "post",
                      data: {
                          "target"  : $("#target").val(),
                          "subject" : subject,
                          "message" : message,
                          "msgid"   : $("#key").val()
                      },
                success: function(msg) {
                    $("#msg_status_send").text(msg);
                }
            });
        }
    }

    var publishingDestination = 0;

    function ui_hide_destinations() {
        for (var i = 1; i < 50; i++)
            if ($('#destination_' + i).length > 0)
                $('#destination_' + i).hide();
    }

    /* Cache all PHP/MySQL pages as HTML */
    function cache(func) { // func = callback
        $.ajax({url: window.website.url + "/plugins/php2html/rasterize-all.php",
            type: "post",
            data: {},
            success: function(msg) {
                if (func != undefined) {
                    func();
                }
            }
        });
    }
    
	/* Cache a single page */
    function cache_single(func, article_id) { // func = callback
        $.ajax({url: window.website.url + "/plugins/php2html/rasterize-single.php",
            type: "post",
            data: { "article_id" : article_id },
            success: function(msg) {
            	console.log("cache_single (" + article_id + ")= " + msg);
                if (func != undefined) {
                    func();
                }
            }
        });
    }

    function html5_storage() { try { return 'localStorage' in window && window['localStorage'] !== null; } catch (e) { return false; } }

	// re-update HTML view from changes typed in directly into preview
    function post_process_html() {
        var html = get_html(true);
        
        // post-processing back into source code
        
        // -- strip out <p> tags
        html = html.replace(/<p>/g, "").replace(/<\/p>/g, "");   
        
        // -- strip out empty b's and i's
        html = html.replace(/<b><\/b>/g, "").replace(/<i><\/i>/g, "");   
        
        // -- replace double spaces
        //html = html.replace(/\n\n/g, "\n");   
        
        // -- strip out space before first character
//        html = html.replace(/\n\n/g, "\n");   
        
        $("#text-editor").val(html);   
    }

    $(document).ready(function()
    {
        // Update rss
        $.ajax( { "url" : "/rss/generate.php", "success" : function(){ console.log('Updated RSS.'); } } );

        // Attach on change event to the main html preview area
        $("#html-preview").on("keyup", function(msg) {
			post_process_html();
        });
    
        $("#controls").show();
        ui_hide_destinations();

        if (html5_storage)
        {
            if (window.load_pane_position != undefined)
                window.load_pane_position();

            if (localStorage["adminView"] == 3)
            {
                $("#List").show();
                $("#Admin").hide();
                $("#Editor").hide();
                $("#VerticalPane").hide();
            }

            if (localStorage["adminView"] == 0)
            {
                $("#Admin").show();
                $("#List").hide();
                $("#Editor").hide();
                $("#VerticalPane").hide();
            }

            if (localStorage["adminView"] == 1)
            {
                $("#List").hide();
                $("#Admin").hide();
                $("#Editor").show();
                $("#VerticalPane").show();
            }

            //if ( == "day")
            //{
            if (localStorage["view_mode"] != undefined)
                set_view_mode(localStorage["view_mode"]);
            //}

        }

        // Update/memorize paragraph style
        if (html5_storage)
        {
            if (localStorage["paragraph_style"])
                $("#paragraph_style").val(localStorage["paragraph_style"]);
            $("#paragraph_style").keyup(function() {
                if ($("#paragraph_style").val().length > 0)
                    localStorage['paragraph_style'] = $("#paragraph_style").val();
                else
                    localStorage['paragraph_style'] = "";
            });

            // Font
            $("#paragraph_font option:contains('" + localStorage["paragraph_font"] + "')").attr("selected","selected");
            $("#paragraph_font").on("change", function(msg) {
                var value = $("#paragraph_font :selected").val();
                var text = $("#paragraph_font option:selected").text();
                localStorage['paragraph_font'] = text;
            });


            // Font size
            $("#paragraph_font_size option:contains('" + localStorage["paragraph_font_size"] + "')").attr("selected","selected");
            $("#paragraph_font_size").on("change", function(msg) {
                var value = $("#paragraph_font_size :selected").val();
                var text = $("#paragraph_font_size option:selected").text();
                localStorage['paragraph_font_size'] = text;
            });


            if (localStorage["paragraph_line_height"])
                $("#paragraph_line_height").val(localStorage["paragraph_line_height"]);
            $("#paragraph_line_height").keyup(function() {
                if ($("#paragraph_line_height").val().length > 0)
                    localStorage['paragraph_line_height'] = $("#paragraph_line_height").val();
                else
                    localStorage['paragraph_line_height'] = "";
            });

            //format_paragraphs();

        }



    });

    function clear_all_styles()
    {
        $("#paragraph_style").val("");
        $("#paragraph_font").val("");
        $("#paragraph_font_size").val("");
        $("#paragraph_line_height").val("");
        localStorage['paragraph_font'] = "";
        localStorage['paragraph_line_height'] = "";
        localStorage['paragraph_font_size'] = "";
        localStorage['paragraph_style'] = "";
    }

    function update_preview() { $('textarea#final').text($('#texteditor').html()); }
    function reformat(html)
    {
//        alert(html);

        // Replace with double break

        // var h = html.replace("a", "x");

        //alert(h);

        //return h;

    }

    function reset_dragup()
    {
        var new_y = parseInt($("#dragup").css("top"));
        $("#EditPage").css( { "height": new_y + "px","clip": "rect(0px, 655px, " + (new_y - 18) + "px, 0px)" } );
        $("#editor-options-pad").css( { "height": (new_y + 18) + "px" } );

        //$("#text-editor").css({height: "200"});
    }
    
    var filter_opts = [ 1, 1, 1, 0 ];
    function filter()
    {
        $.ajax( {
            url: "filter-exec.php",
            data: {
                o1: filter_opts[0],
                o2: filter_opts[1],
                o3: filter_opts[2],
                o4: filter_opts[3],
                query: $("#filter_q").val()
            },
            success: function(msg) {
                $("#scheduled").html(msg);
                // make articles draggable
                window.make_draggable();
            }
        });
    }

    $(document).ready(

        function() {
        
            // Attach toggle events to filter
            $(".FilterOption").on("click", function(msg) {
                var cl = $(this).hasClass("On");
                var index = $(this).attr("index");
                if (cl) {
                    $(this).removeClass("On");
                    filter_opts[index] = 0;
                } else {
                    $(this).addClass("On");
                    filter_opts[index] = 1;
                }
                
                // update
                filter();
            } );

            up();

            //reset_dragup();

            /* Adjust article properties view to its default dimensions */
            $("#EditPage").css( { "": "", "clip": "rect(0px 655px 212px 0px)" } );

            $("#editor-options-pad").css( { "height": "305px", background: "black" } );

            $("#dragup").draggable( { axis: "y", drag: function() {
                    reset_dragup();    
                }
            });

            /* Attach key events to the editor box */
            $("#text-editor").on("keypress", function(event)
            {

            });
            
            $("#text-editor").on("keydown", function(e){

                if (!event.which && ((event.charCode || event.charCode === 0) ? event.charCode: event.keyCode)) {
                    event.which = event.charCode || event.keyCode;
                }

                if (event.ctrlKey) {

                    if (event.which == 66) {
                        e.stopPropagation();
                        e.preventDefault();
                        ModifySelection('text-editor', '«', '»');
                    }
                }

            });

            window.OSX_CommandDownKey = false;
            $("#text-editor").on("keyup", function(e){
            if (!event.which && ((event.charCode || event.charCode === 0) ? event.charCode: event.keyCode)) {
                    event.which = event.charCode || event.keyCode;
                }
                
                if (event.which == 91) { // OSX Command key
                    window.OSX_CommandDownKey = false;
                }

                if (event.ctrlKey) {

                    if (event.which == 66) {
                        e.stopPropagation();
                        e.preventDefault();
                        // ModifySelection('text-editor', '«', '»');
                    }
                }
                // e.stopPropagation();
                // e.preventDefault();
            });

            /* Save document */
            $(window).on("keydown", function(e){
                if (!event.which && ((event.charCode || event.charCode === 0) ? event.charCode: event.keyCode)) {
                    event.which = event.charCode || event.keyCode;
                }

                if (event.which == 91) { // OSX Command key
                    window.OSX_CommandDownKey = false;
                }
                
                /*
                if (window.OSX_CommandDownKey) {
                    if (event.which == 83) { // S key
                        e.stopPropagation();
                        e.preventDefault();
                        save_article($("#key").val());
                        $("#saved_ctr").show();
                        $("#saved").css({"top":"0px",width: "200px",height: "200px", opacity: "0.8"});
                        $("#saved").stop().animate({"top": "-=100px", width: "500px", height: "500px", opacity: "0"}, 500, "easeOutExpo", function(){$("#saved_ctr").hide();});
                    }
                } */
                
                if (event.ctrlKey) {
                    if (event.which == 83) { // S key
                        e.stopPropagation();
                        e.preventDefault();
                        save_article($("#key").val());
                        $("#saved_ctr").show();
                        $("#saved").css({"top":"0px",width: "200px",height: "200px", opacity: "0.8"});
                        $("#saved").stop().animate({"top": "-=100px", width: "500px", height: "500px", opacity: "0"}, 500, "easeOutExpo", function(){$("#saved_ctr").hide();});
                    }
                }
            });

            $("#html-preview").on("scroll", function(e){

                var scrollPercentage = 100 * this.scrollTop / (this.scrollHeight-this.clientHeight);

                var offset = $('#text-editor').offset().top;

                $("#status22").html("<span style = 'color:yellow'>" + scrollPercentage + "," + offset + "</span>");

                $("#text-editor").scrollTop(scrollPercentage * (($("#text-editor")[0].scrollHeight)/100));

            });

            $("#text-editor").on("scroll", function(e) {
                var y = $("#text-editor").scrollTop();



                //$("#text-editor").css({border:"2px solid red"});

                //$("#html-preview").html(y + " of " + $("#text-editor")[0].scrollHeight );

                //$("#html-preview").css( { "margin-top": "-" + y + "px" } );
            });

            /* Shorten text selection */
            $("#text-editor").on("mouseup", function(){
                RemoveTrailingSpaceFromSelection();
            });
        }
    );

    // Insert paragraph style into <p>
    function format_paragraphs()
    {
        // Grab a fresh copy
        up();

        // Build style string
        build();

        var str = $("#html-preview").html();
        str = str.replace(/<p>/gi, "<p style = '" + $('#paragraph_style').val() + "'>");

        $("#html-preview").html(str);
    }

    // Create HTML copy to be used in email newsletters
    // <code> tags must be converted to <div>s with proper inline style
    // and spaces replaced with &nbsp;
    function get_email_newsletter_html()
    {
        var style = 'border:1px solid silver; padding: 16px; margin-top:10px; margin-bottom:10px; font-family:Courier new; font-size: 12px;';

        /*
        var h = $('#html-preview').html();
        h = h.replace(/<\/p>/gi, '</p>\r\n\r\n');
        h = h.replace(/<p(.*)?><\/p>\r\n\r\n/gi, "");
        h = h.replace(/<p><code>/gi, "<div style = '" + style + "'>");
        h = h.replace(/<\/code><\/p>/gi, "</div>");
        $('#ta-html').text("0" + h);
        // jquery
        $('body').prepend("<div id = 'html_processor'></div>");
        $('#html_processor').css( { position: 'absolute', top: '-5000px' } );
        */
        //alert($('#ta-html').html());
        //$('#html').show();



        var get = $("#text-editor").val();

        var matches = get.match(/<code>[\S\s]*?<\/code>/gi);
        get = get.replace(/<code>[\S\s]*?<\/code>/gi, "<code></code>");

        // alert(matches[0]);

        // Must be done as the first step (before paragraphs (or any HTML tags) are added.
        // Replace all instances of < and > into &lt; and &gt;
        get = get.replace(/</g, "&lt;");
        get = get.replace(/>/g, "&gt;");
        // But... return brackets around <code> tags back to life...
        get = get.replace(/&lt;code&gt;/g, "<code>");
        get = get.replace(/&lt;\/code&gt;/g, "</code>");
        get = get.replace(/&lt;(\/)?(script|tbody|form|input|select|option|textarea|img|div|div|figure|ul|li|b|i|u|span|table|th|tr|td|h1|h2|h3)(.*?)&gt;/g, '<$1$2$3>\r\n');
        get = get.replace(/&lt;(\/)?(a)(.*?)&gt;/g, '<$1$2$3>');



        // Replace double line breaks with a new paragraph
        get = "<p>" + get + "</p>";
        get = get.replace(/\n\n/g,"</p><p>");

        // Remove all empty paragraphs
        get = get.replace(/<p><\/p>/g, "");


        // Replace «» to with <b>
        get = get.replace(/\«/g, "<b>");
        get = get.replace(/\»/g, "</b>");

        // replace URLs
        get = get.replace(/\{\$URL\}/g,"http://www.learnjquery.org");


        $("#email-preview").html(get);

        var html = $("#email-preview");

        var m = 0;

        /* Newsletter preparation */

        var cssStyle = "<style type = 'text/css'>span.comment i { color: #53947a  !important; } #weblinks a{color:blue; font-style:normal; text-decoration:none;}</style>";
        var headerTitle = "<h2>" + $("#title").val() + "</h2>";
        var headerDonation = "";//"<p style = 'font-size:11px;'>Please <a href = 'http://www.learnjquery.org/newsletter/donate.html'>submit a PayPal donation</a>. I don't publish my books with major publishing companies nor do I write for wealth, recognition or inspiration. Your support has proven to be more meaningful in helping me write new tutorials this year. Thank you to everyone who has made their contributions. It is much appreciated.</p>";
        var articleDescription = "<p><b>Description:</b> <span style = 'color:gray;font-style:italic;'>" + $('#meta_description').val() + "</span></p>";
        var onTheWeb = "";//"<p id = 'weblinks' style = 'border:1px solid silver; padding: 4px; margin: 0; margin-top:7px; margin-bottom: 7px;'>Click to <a href = 'http://www.learnjquery.org/" + $('#article_type').val() + "/" + $('#location_uri').val() + "'>view this article on LearnjQuery.org</a> or alternatively you can <a href = 'http://www.learnjquery.org/email-to-a-friend/" + $('#key').val() + "'>share it with a friend</a>.</p>";
        // <p>I was able to write this article for free because <b><i>readers make PayPal donations</i></b>.</p><p>Please <a href = "http://www.learnjquery.org/newsletter/donate.html">submit a PayPal donation</a>. Your support is much appreciated. Thank you!</p>

        //var mailchimpRequired = '<p style="font-size: 11px;"><b>LearnjQuery.org</b> 14041 Skyline Blvd, Oakland CA 94619 | <a href="*|UNSUB|*">Unsubscribe</a></p>';
        var mailchimpRequired = '<p style="font-size: 11px;"><b>LearnjQuery.org</b> 14041 Skyline Blvd, Oakland CA 94619 | <a href = "http://www.learnjquery.org/newsletter/donate.html" target = "_blank">Donate</a> | <a href = "http://www.learnjquery.org/jscourses.html" target = "_blank">JavaScript Courses</a> | <a href="*|UNSUB|*">Unsubscribe</a></p>';

        var mailchimpBegin = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><div style="font-family:Arial,sans-serif; font-size:12px;">';
        var mailchimpEnd = '</div>';

        //if $("#")

        //
        $("code", html).each(
            function(index, object) {
                $(object).html(matches[m].substr(6,matches[m].length-13).replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/ /g, "&nbsp;").replace(/\n/g,"<br/>").replace(/\b(true|false|var|function|for|break|case|catch|continue|debugger|default|delete|do|else|finally|if|in|instanceof|new|return|switch|this|throw|try|typeof|void|while|with)\b/g, "<i style = 'color: blue; font-style:normal;'>$1</i>").replace(/(\/\/(.*?)(<br\/>|$))/g, '<span class="comment" style = "color: #53947a !important;">$1</span>').replace(/\/\*(.*?)\*\//g, "<i style = 'color: #53947a; font-style:normal;'>/* $1 */</i>"));
                m++;
            } );

        // Create final HTML for newsletter...
        $('#ta-html').text(mailchimpBegin + headerTitle + articleDescription + headerDonation + onTheWeb + html.html().replace(/<p><\/p>/g, '').replace(/<p><code>/g,'\n\n<div style = "' + style + '">').replace(/<\/code><\/p>/g, "</div>") + mailchimpRequired + mailchimpEnd + cssStyle);

        $('#html').show();
    }

    // update preview
    function up()
    {
        var get = $("#text-editor").val();

        if (get == undefined)
            return;

        get = get.replace(/{\$URL}/g, window.website.url);

        var matches = get.match(/<code>[\S\s]*?<\/code>/gi);
        get = get.replace(/<code>[\S\s]*?<\/code>/gi, "<code></code>");
        // Must be done as the first step (before paragraphs (or any HTML tags) are added.
        // Replace all instances of < and > into &lt; and &gt;
        get = get.replace(/</g, "&lt;");
        get = get.replace(/>/g, "&gt;");
        // But... return brackets around <code> tags back to life...
        get = get.replace(/&lt;code&gt;/g, "<code>");
        get = get.replace(/&lt;\/code&gt;/g, "</code>");
        // And... return brackets around <pre> tags back to life...
        //get = get.replace(/&lt;pre&gt;/g, "<pre>");
        //get = get.replace(/&lt;\/pre&gt;/g, "</pre>");
        // And.. return brackets around all of the tags below (this enables proper HTML for these selected tags)
        get = get.replace(/&lt;(\/)?(label|script|form|input|select|option|textarea|tbody|div|div|figure|img|ul|li|b|i|u|span|table|th|tr|td|h1|h2|h3|select|option)(.*?)&gt;/g, '<$1$2$3>');
        get = get.replace(/&lt;(\/)?(a)(.*?)&gt;/g, '<$1$2$3>');
        // Replace double line breaks with a new paragraph
        get = "<p>" + get + "</p>";
        get = get.replace(/\n\n/g,"</p><p>");
        // Remove all empty paragraphs
        get = get.replace(/<p><\/p>/g, "");
        // Replace «» to with <b>
        get = get.replace(/\«/g, "<b>");
        get = get.replace(/\»/g, "</b>");

        $("#html-preview").html(get);
        var html = $("#html-preview");
        var m = 0;



        // Reinsert code between <code> tags into empty code tags in same order
        $("code", html).each( function(index, object) { $(object).html(matches[m].substr(6,matches[m].length-13).replace(/</g,"&lt;").replace(/>/g,"&gt;")); m++; } );

        //alert($("#html-preview").html());
    }

    function RemoveTrailingSpaceFromSelection()
    {
        var textarea = document.getElementById("text-editor");
        var selected_string = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
        if (selected_string[selected_string.length-1] == " ") {
            var sel = window.getSelection();
            sel.modify("extend", "backward", "character");
        }
    }

    function ModifySelection (id,start,end) {
            var textarea = document.getElementById(id);
            if ('selectionStart' in textarea)
            {
                var selected_string = textarea.value.substring  (textarea.selectionStart, textarea.selectionEnd);

                // Trim last space as it often happens on double clicking a word
                var moveSpace = "";
                var one = 0;
                if (selected_string.substr(selected_string.length-1, selected_string.length) == " ") {
                    selected_string = textarea.value.substring  (textarea.selectionStart, textarea.selectionEnd - 1);
                    moveSpace = " ";
                    one = 1;
                }

                    // check whether some text is selected in the textarea
                if (textarea.selectionStart != textarea.selectionEnd) {
                    var newText = textarea.value.substring (0, textarea.selectionStart) +
                        start + selected_string + end +
                        textarea.value.substring (textarea.selectionEnd - one) + moveSpace;
                    textarea.value = newText;
                }
            }
            else {  // Internet Explorer before version 9
                    // create a range from the current selection
                var textRange = document.selection.createRange ();
                    // check whether the selection is within the textarea
                var rangeParent = textRange.parentElement ();
                if (rangeParent === textarea) {
                    textRange.text = start + textRange.text + end;
                }
            }

            // Update preview
            up();
        }

    function build()
    {
        if ($('#paragraph_font_size').val() == '') {$('#paragraph_font_size').val('12px');}
        if ($('#paragraph_line_height').val() == '') {$('#paragraph_line_height').val('14px');}
        $('#paragraph_style')[0].value = 'font-family:' + $('#paragraph_font').val() + ';' + 'font-size:' + $('#paragraph_font_size').val() + ';' + 'line-height:' + $('#paragraph_line_height').val();
        localStorage['paragraph_style'] = $('#paragraph_style').val();
        localStorage['paragraph_font_size'] = $('#paragraph_font_size').val();
        localStorage['paragraph_line_height'] = $('#paragraph_line_height').val();
        localStorage['paragraph_style'] = $('#paragraph_style').val();
    }

    function get_html(return_val)
    {
        // At this point,

        var h = $('#html-preview').html();

        // Replace trailing paragraph tags
        h = h.replace(/<\/p>/gi, '</p>\r\n\r\n');

        // Replace leading paragraph tags
        /* ~ I think this is a bug that used to be there but not longer is */
        //h = h.replace(/<p(.*)?><\/p>\r\n\r\n/gi, "");

        // Replace empty tags
        h = h.replace(/<p><\/p>/g, "");
        


        // Post processing,
        // Sometimes... (e-books especially) <pre> code is inside code tag.
        // And it's not that it is there, but that it's there formatted as &lt;pre&gt;
        // Replace <code>&lt;pre&gt; with <code><pre> and &lt;/pre&gt;</code> with </pre></code>
        // Most of the time for articles this is not there, but if writing an e-book this cleanup is required
        // Kindle DX format especially, does not obey the inline CSS rules of <code style = "..wordwrap..."> alone and needs <pre>'s
        // Other Kindle formats do, but we're doing this for lowest common denominator..
        h = h.replace(/<code>&lt;pre&gt;/g, "<code><pre>");
        h = h.replace(/&lt;\/pre&gt;<\/code>/g, "</pre></code>");

        // Also... remove <p><code> because <code> is a new block by itself
        h = h.replace(/<p><code>/g, "<code>");
        h = h.replace(/<\/code><\/p>/g, "</code>");

        // And... same for <pre> tags
        // Also... remove <p><code> because <code> is a new block by itself
        h = h.replace(/<p><pre>/g, "<pre>");
        h = h.replace(/<\/pre><\/p>/g, "</pre>");

        h = h.replace(/\r\n/g, "\n");

        if (return_val)
        {
            return h;
        }

        /* Pop box open, if it's not used as a return value */

        $('#ta-html').text(h);
        $('#html').show();

        return false;
    }



    // Either <code> or <pre> to be used, but not both
     // In some cases we need to use pre instead of code
    function convert_code_to_pre()
    {
        var h = $('#ta-html').text();
        h = h.replace(/<code>/g, "<pre>");
        h = h.replace(/<\/code>/g, "</pre>");
        $('#ta-html').text(h);
    }

    function convert_pre_to_code()
    {
        var h = $('#ta-html').text();
        h = h.replace(/<pre>/g, "<code>");
        h = h.replace(/<\/pre>/g, "</code>");
        $('#ta-html').text(h);
    }

    function clear_article()
    {
        if (confirm("Are you sure you want to clear all data?\nAll unsaved text will be lost.") == true)
        {
            $("#key").val("");
            //$("#html-preview").html("");
            //$("#text-editor").val("");
            $("#template-editor").val("");
            $("#article_cat").val("");
            $("#article_subcat").val("");
            $("#article_template").val("minimalist.php");
            $("#article_type").val("about");
            $("#browser_title").val("Draft");
            $("#title").val("Draft");
            $("#location_uri").val("text.html");
            $("#meta_description").val("");
            $("#meta_keywords").val("");
            $("#facebook_msg").val("");
            $("#twitter_msg").val("");
            $("#javascript").val("");
            $("#css").val("");

        }
    }

    /* Save Article */
    function save_article(key)
    {
          /* Update article HTML preview from source,
             before saving -- to ensure correct URLs from {$URL} */

             up();
             
          var noindex = $('#noindex:checked').val() == "on" ? 1 : 0;
          var article_data = { key: $("#key").val(),
                    article: $("#html-preview").html(),
                    article_plaintext: $("#text-editor").val(),
                    image: "",
                    image_description: "",
                    navi_name: $("#navi_name").val(),
                    type: $("#article_type").val(),
                    category: $("#article_cat option:selected").val(),
                    subcategory: $("#article_subcat option:selected").val(),
                    template: $("#article_template").val(),
                    browser_title:$("#browser_title").val(),
                    title:$("#title").val(),
                    location:$("#location_uri").val(),
                    description:$("#meta_description").val(),
                    keywords:$("#meta_keywords").val(),
                    facebook_msg:$("#facebook_msg").val(),
                    twitter_msg:$("#twitter_msg").val(),
                    javascript:$("#javascript").val(),
                    css:$("#css").val(),
                    noindexnofollow: noindex
                };

        $.ajax( {
                url: 'save-existing-article.php',
               type: 'post',
               data: article_data,
            success: function(msg) {
            
            	/* Save current article settings */
            	save_article_template_config(article_data.key);

                var title = article_data.title.substr(0,28) + "...";

                /* Update article name on schedule list */
                $("#scheduled #sched_link_" + article_data.key).html(title);

                /* Article was saved */
                $("#article_save_status").html("<img style = 'vertical-align: top; margin-top:1px;' src = '" + website.url + "/" +website.img_dir_name + "/save_ic.png'> " + msg);
                setTimeout(function(){$("#article_save_status").fadeOut(300, function(){$("#article_save_status").html(""); $("#article_save_status").show();});},1500);
                
                /* Update message on main panel... */
                $("#panel-msg").html("Document saved on " + (new Date()).toString());


                /* DONE! 5/22/2016 --cache this page -- todo: reduce cacher to a single article id */
                // cache(undefined);
                cache_single( undefined, article_data.key ); // Caches only 1 article instead of whole database!
                
                // Play "Saved" animation
				$("#saved_ctr").show();
                $("#saved").css({"top":"0px",width: "150px",height: "150px", opacity: 1});
            	$("#saved").stop().animate({"top": "-=100px", width: "500px", height: "500px", opacity: "0"}, 500, "easeOutExpo", function(){$("#saved_ctr").hide();});
                        
                        
            }
        });
    }

    function filename_rnd(ext) // ext=hmtl
    {
        /* Create new random draft filename */
        var x = Array("a","b","c","d","e","f", "g")[parseInt(Math.random() * 7)];
        var y = Array("a","b","c","d","e","f", "g")[parseInt(Math.random() * 7)];
        var filename = "draft-" + x + y + (Math.random() * 100) + "." + ext;
        return filename;
    }

    /* Start Fresh Draft - From Scratch */
    function start_fresh_draft(type, filename, template, browser_title)
    {
        var new_random_draft_name = filename;
    
        var fresh = { key: "",
            article: "My new draft on " + (new Date()).toString(),
            article_plaintext: "My new draft on " + (new Date()).toString(),
            image: "",
            image_description: "",
            "type": type, /* article type is about (about folder) */
            category: "",
            subcategory: "",
            "template": template,
            "browser_title": browser_title,
            "title": browser_title,
            location: new_random_draft_name,
            description:"meta",
            keywords:"keywords",
            facebook_msg:"",
            twitter_msg:"",
            javascript:"",
            navi_name:"",
            css:"",
            publish_settings: 0,
            scheduled: "No", /* by default new drafts are not scheduled */
            noindexnofollow: 0
        };

        // Memorize last type of content that was created
        // So it can be reloaded next time for convenience.
        dbjs.table = "settings";
        dbjs.set( { "previous_content_type" : type }, "", 1, function(){} );
        
        save_as_draft(fresh);
    }


    /* Save As New Draft */
    function save_as_draft(p_article_data)
    {
//        var noindex = $('#noindex:checked').val() == "on" ? 1 : 0;

        /* Create new random draft filename */
        var x = Array("a","b","c","d","e","f", "g")[parseInt(Math.random() * 7)];
        var y = Array("a","b","c","d","e","f", "g")[parseInt(Math.random() * 7)];
        var z = Array("a","b","c","d","e","f", "g")[parseInt(Math.random() * 7)];
        var new_random_draft_name = "draft-" + x + y + z + (Math.random() * 10000) + ".html";

		article_data = p_article_data;
        if (p_article_data == undefined)
            article_data = { key: "",
            article: $("#html-preview").html(),
            article_plaintext: $("#text-editor").val(),
            image: "",
            image_description: "",
            type: $("#article_type").val(), /* article type is about (about folder) */
            category: $("#article_cat option:selected").val(),
            subcategory: $("#article_subcat option:selected").val(),
            template: $("#article_template").val(),
            browser_title:$("#browser_title").val(),
            title:$("#title").val(),
            location:new_random_draft_name,
            description:$("#meta_description").val(),
            keywords:$("#meta_keywords").val(),
            facebook_msg:$("#facebook_msg").val(),
            twitter_msg:$("#twitter_msg").val(),
            javascript:$("#javascript").val(),
            css:$("#css").val(),
            publish_settings: 0,
            navi_name: "",
            scheduled: "No", /* by default new drafts are not scheduled */
            noindexnofollow: $('#noindex:checked').val() == "on" ? 1 : 0
        };

        

        $.ajax( {
            url: 'save-as-new-draft.php',
            type: 'post',
            data: article_data,
            success: function(msg) {

                //alert(msg);

                /* Draft was saved */
                if ($.isNumeric(msg))
                {
                    $("#article_save_status").html("<b>New draft created.</b>");

                    // Replaec article key id with new generated one
                    $("#key").val(msg);

                    // Candy
                    blinkArticleKey();

                    var draft_key_id = msg;

                    // Add the draft to the scheduled list
                    $.ajax(
                    {
                        url: 'add-new-draft.php',
                        type: 'post',
                        data: {
                            "add_draft": "1",
                            "key" : msg,
                            "type": article_data.type,
                            "title": article_data.title,
                            "template": article_data.template,
                            "draft": "1",
                            "scheduled": "", /* what will display after draft name? */
                            "location": new_random_draft_name
                        },
                        success: function(block) {

                            load_article(draft_key_id, true);
                
                            $("#start_new_draft").html('Start New Draft');
                            $("#start_new_draft").prop('disabled', false);
                            
                            // Slide editor back to top
                            reveal(97);

                            $("#scheduled").prepend(block);

                            // Update rss
                            $.ajax( { "url" : "/rss/generate.php", "success" : function(){ console.log('save_as_draft(): Updated RSS.'); } } );
                        }
                    });

                    /* cache this page -- todo: reduce cacher to a single article id */
    	            /* DONE! 5/22/2016 --cache this page -- todo: reduce cacher to a single article id */
	                // cache(undefined);
        	        cache_single( undefined, draft_key_id ); // Caches only 1 article instead of whole database!
                    // was: cache(undefined);
                }
                setTimeout(function(){$("#article_save_status").fadeOut(300, function(){$("#article_save_status").html(""); $("#article_save_status").show();});},1500);
            }
        });
    }

    function is_json(str) { try { JSON.parse(str); } catch (e) { return false; } return true; }

    function load_article(key, select_title)
    {
        //alert("loading article =[" + key + "]");  

        $.ajax( {

                url: 'load-article.php',

                type: 'post',

                data:{ 'key': key },

                success: function(msg) { /* successfully loaded*/

                    //var msg = '{"key":"100", "browser_title":"Web page title"}';

                    //alert(msg);

                    if (is_json(msg))
                    {
                        
                        // Update template config layout
                        load_article_template_config( key );

                        var data = JSON.parse(msg);//[0];

                        $("#key").val(data.key);
                        $("#article_cat").val(data.category);
                        $("#article_subcat").val(data.subcategory);
                        $("#browser_title").val(data.browser_title);
                        $("#title").val(data.title);
                        $("#navi_name").val(data.navi_name);
                        $("#location_uri").val(data.location);
                        $("#meta_description").val(data.description);
                        $("#meta_keywords").val(data.keywords);
                        $("#tags").val(data.tags);
                        $("#facebook_msg").val(data.facebook_msg);
                        $("#twitter_msg").val(data.twitter_msg);
                        $("#article_template").val(data.template);
                        $("#article_type").val(data.type);
                        $("#javascript").val(data.javascript);
                        $("#css").val(data.css);
                        $("#noindex").attr("checked", data.noindexnofollow == 0 ? false : true );

                        // update article control (draft|publish) dialog
    //                    alert(data.draft);
                        $("input[value=" + data.draft + "]").prop("checked", true);

                        var html_rasterized = data.article;

                        // slide back, unless details controls are opened
                        //alert(window.file_details);
                        if (window.file_details != true)
                            reveal(97);

                        //alert(data.template);
                        //alert(html_rasterized );

                        $("#text-editor").val(data.article_plaintext);
                        $("#html-preview").html(html_rasterized);

                        // candy
                        blinkArticleKey();

                        if (select_title)
                            $("#title").select();

                        $("#message_title").text(data.title);

                        //
                        var message = "Content page loaded: #" + data.key + " '" + data.title + "'";
                        console.log(message);
                        $("#panel-msg").html(message);

                        // Update rss
                        $.ajax( { "url" : "/rss/generate.php", "success" : function(){ console.log('load_article(): Updated RSS.'); } } );

                    }
                    else
                    {
                        console.log("Notice: no default article was loaded because load-article.php returned msg=empty");
                    }
                }
            });
    }

    function delete_article(id)
    {
        $.ajax(
        {
            url: 'delete-article.php',
            type: 'post',
            data: { 'key': id },
            success: function(msg)
            {
                var sched = "sched_" + msg;
                $("#sched_" + id).fadeOut(200);
                // Update rss
                $.ajax( { "url" : "/rss/generate.php", "success" : function(){ console.log('delete_article(): Updated RSS.'); } } );
            }
        });

    }

    function get_publish_settings(id)
    {
        $.ajax( { url: 'get-publish-settings.php',
                 type: 'post',
                 data: { key: id },
              success: function(m)
                       {
                            if (m != "")
                                $('#ScheduleDate').show();
                            return m;
                       }
            } );
    }

    function set_publish_settings(id, settings)
    {
        $.ajax( { url: 'save-publish-settings.php',
                 type: 'post',
                 data: { key: id, settings: settings },
                 success: function(m)
                 {
                     /* */
                     //alert(m);
                 }
            } );
    }

    function include_in_navigation(id)
    {
        $.ajax({ url: 'toggle-incl-in-navi.php',
            type: 'post',
            data: { key: id },
            success: function(icon) {
                $("#incl_navi" + id + " img").attr("src", "../Images/" + icon);
            }
        });
    }

    // Set this as draft (no rss, no publish)
    function article_todraft(id)
    {
        $.ajax( { url: 'draft-live-switcher.php',
                 type: 'post',
                 data: { key: id },
                 success: function(icon) {
                     $("#draft_icon_" + id + " img").attr("src", "../Images/" + icon);
                     
                     // update sub controls
                     reveal(97);

                     // Update rss
                    $.ajax( { "url" : "/rss/generate.php", "success" : function(){ console.log('article_to_draft(): Updated RSS.'); } } );
                     
                 }
            } );
    }

    function type_double() { if ($('#title').val().toLowerCase() == $('#browser_title').val().substr(0, $('#browser_title').val().length - 1).toLowerCase()) { var bt = $('#browser_title'); $('#title').val( bt.val().substr(0, 1) + bt.val().substr(1, bt.val().length - 1).toLowerCase() ) } }


    function blinkArticleKey()
    {
        $("div[custom=key_container]").animate( { backgroundColor: 'blue', color: 'yellow' }, 300 );
        setTimeout(
            function()
            {
                $("div[custom=key_container]").animate( { color: 'silver', backgroundColor: '#555' }, 700 );
            }, 300);
    }

    //window.alert = function(sMessage) { $('body').append(sMessage); return false; };

    //alert("hello dfg dfg");

    function send_mc_campaign(id)
    {
        $.ajax( {
            url: "http://www.learnjquery.org/api/mcapi/send.php",
            type: "post",
            data: { "cid": id },
            success: function(msg) {
                /* Success */
                $("#sendmcb").text("Campaign Created & Sent!");
            },
            error: function(msg) {
                /* For localhost, this will actually be a success message */
                $("#sendmcb").text("Campaign Created & Sent!");
            }
        });
    }

    function load_most_recent_article_id(page_type)
    {
        //alert("loading most recent article...pagetype="+page_type);
        $.ajax( {
            url: "get_most_recent_article_id.php",
            type: "post",
            data: { "type": page_type },
            success: function(msg) { //            alert(msg);
                window.load_article(msg);
                // Experiment: add this id to calendar
               // window.CURRENT_ARTICLE_ID_SETTINGS = msg;
                //$('#calendarArea').show();
               // $('#cal_sched_article_name').html('<img style = \'vertical-align:middle;\' src = \'' + window.website.url + '/Images/draft.png\'> <span id = \'nm\'>' + $('#sched_link_' + data.key).text() + '</span>' + $('#sched_link_' + data.key).text());
                //$('#sched_article_name').html($('#sched_link_' + data.key).text());
            }
        });
    }

    function send_current_mailchimp_campaign()
    {
        get_email_newsletter_html();
        $("#html").hide();
        $.ajax(
        {
            url: "http://www.learnjquery.org/api/mcapi/create.php",
            type: "post",
            data: {
                subject: "bebebebe",
                html: $("#ta-html").val(),
                text: "text based body\r\nof email",
                list_id: "f1001c1146" /* this is the list ID */
            },
            error: function(msg){ alert("failed...");},
            done: function(msg){ alert("done...");},
            success: function(msg) {
                var campaign = JSON.parse(msg);
                send_mc_campaign(campaign.id);
            }
        })
    }

    function load_pane_position()
    {
         if (html5_storage) {
            $("#VerticalPane").css( { "left" : localStorage["pane_y_x"] } );
        }
    }

    function save_pane_position()
    {
        if (html5_storage) {
            localStorage["pane_y_x"] = $("#VerticalPane").css("left");
        }
    }

    function set_view_mode(type) {

        /* Memorize screen view mode */
        if (html5_storage) localStorage["view_mode"] = type;

        if (type == "day") {
            $("body").removeClass("night");

        } else {
            $("body").removeClass("night").addClass("night");
        }
    }
    
    var selection;
    
    function hyperlink() {
        var html = getSelectionHtml();
        $("#link_anchor").val(html);        
        selection = saveSelection();
		$("#faded").css( { "display" : "block" } ).animate( { "opacity": "0.75" }, 100);
		$("#faded_2").css( { "display" : "block" } ).animate( { "opacity": "1" }, 100, function() {
    		$("#hyperlink_ctrl").css( { "display" : "block" } ).animate( { "opacity": "1" }, 250 );
		});
    }
    
    function hyperlink_ok() {
        var url = $("#link_url").val();
        var title = $("#link_title").val();
        var anchor = $("#link_anchor").val();
        restoreSelection(selection);
        pasteHtmlAtCaret('<a href = "' + url + '" title = "' + title + '">' + anchor + '</a>');
        hyperlink_off();
        // update code editor with new hyperlink
        post_process_html();
    }
    
    function hyperlink_cancel() {
        hyperlink_off();
    }
    
    function hyperlink_off() {
  		$("#hyperlink_ctrl").animate( { "opacity": "0" }, 100, function() {
  		    $("#hyperlink_ctrl").css( { "display" : "none" } );
  		    $("#faded").animate( { "opacity": "0" }, 100);
    		$("#faded_2").animate( { "opacity": "0" }, 100, function() {
		  	    $("#faded").css( { "display" : "none" } );
		  	    $("#faded_2").css( { "display" : "none" } );
    		});
  		});
    }
    
    function grid(cols) {
    
        if (cols == 25) {
            var html = "<table class = 'grid' style = 'width:100%'><tr>";
            html += "<td style = 'min-height: 32px; width: 50%'>Column 1</td>";
            html += "<td style = 'min-height: 32px; width: 8px; min-width: 8px;'></td>";
            html += "<td style = 'min-height: 32px; width: 50%'>Column 2</td>";
            html += "</tr></table>";
        } else {
            var html = "<table class = 'grid' style = 'width:100%'><tr>";
            var w = parseInt(100 / cols);
            for (var i = 0; i < cols; i++) html += "<td style = 'min-height: 32px; width: " + w + "%'>Column " + i + "</td>";
            html += "</tr></table>";
        }
         
        pasteHtmlAtCaret(html);
    }
    
    function bold()
    {
        var html = getSelectionHtml();
        pasteHtmlAtCaret("<b>" + html + "</b>");
        post_process_html();
    }
    
    function italic()
    {
        var html = getSelectionHtml();
        pasteHtmlAtCaret("<i>" + html + "</i>");
        post_process_html();
    }
    
function getSelectionHtml() {
    var html = "";
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var container = document.createElement("div");
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                container.appendChild(sel.getRangeAt(i).cloneContents());
            }
            html = container.innerHTML;
        }
    } else if (typeof document.selection != "undefined") {
        if (document.selection.type == "Text") {
            html = document.selection.createRange().htmlText;
        }
    }
    return html;
}

function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}

//window.sel = new Object();
window.sel_sel = null;
window.sel_range = null;
window.sel_frag = null;
function get_caret_range() {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            
//            alert(sel);
            
            window.sel_frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = window.sel_frag.appendChild(node);
            }
            
            window.sel_sel = sel;
            window.sel_range = range;
            window.sel_frag = frag;            
            
//            range.insertNode(frag);
//            window.sel.range.insertNode(window.sel.frag);
            
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        //document.selection.createRange().pasteHTML(html);
    }
}

function get_caret_paste(url, anchor, title) {
//alert(window.sel.frag);
//    window.sel.range.insertNode('<a href = "#">');
    window.sel.frag.appendChild("<b>asdsd</b>");
//    get_caret_range
    window.sel.range.insertNode(window.sel.frag);
  //  window.sel.range.insertNode('</a>');
}

function saveSelection() {
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                ranges.push(sel.getRangeAt(i));
            }
            return ranges;
        }
    } else if (document.selection && document.selection.createRange) {
        return document.selection.createRange();
    }
    return null;
}

function restoreSelection(savedSel) {
    if (savedSel) {
        if (window.getSelection) {
            sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i) {
                sel.addRange(savedSel[i]);
            }
        } else if (document.selection && savedSel.select) {
            savedSel.select();
        }
    }
}