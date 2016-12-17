<style>
.InputName { border: 0; }
.InputValue { border: 0; width: 332px !important; }
.InputValue input { width: 320px !important; }
#ArticleTheme { position: absolute; top: 0; left: 550px; }
#ArticleThemeBase { position: relative; width: 103px; height: 188px; background: #e2e2e2; }
#ArticleTheme_Header { position: relative; width: 103px; height: 40px; }
.ThemeHeader1 { background: url('header_1.png'); }
.ThemeHeader2 { background: url('header_2.png'); }
.ThemeHeader3 { background: url('header_3.png'); }
.ThemeHeader4 { background: url('header_4.png'); }
.ThemeHeader5 { background: url('header_5.png'); }
#ArticleTheme_Body { position: relative; width: 103px; height: 80px; }
.ThemeBody1 { background: url('body_1.png');  }
.ThemeBody2 { background: url('body_2.png');  }
.ThemeBody3 { background: url('body_3.png');  }
#ArticleTheme_BottomAd { position: relative; width: 103px; height: 20px; }
.ThemeAd1 { background: url('ad_1.png'); }
.ThemeAd2 { background: url('ad_2.png'); }
.ThemeAd3 { background: url('ad_3.png'); }  
#ArticleTheme_Invite3 { position: relative; width: 103px; height: 48px; }
#ArticleThemeBase * { border: 1px solid transparent; cursor: pointer; }
#ArticleThemeBase *:hover { border: 1px solid orange !important; }
.ThemeInvite1 { background: url('invite_3.png'); } 

</style>  

<div style = "position: absolute; top:-10000px;left:-5000px;">
<img src = "header_1.png"/>
<img src = "header_2.png"/>
<img src = "header_3.png"/>
<img src = "header_4.png"/>
<img src = "header_5.png"/>
</div>

	<div id = "ArticleTheme">
		<div id = "ArticleThemeBase">
			<div id = "ArticleTheme_Header" onclick = "var tt = parseInt($(this).attr('type'));   tt++; if (tt>4)tt=0; $(this).attr('type', tt); refresh_template_config_view(this,0,tt)" type = "0" class = "ThemeHeader1"></div>
			<div id = "ArticleTheme_Body" onclick = "var tt = parseInt($(this).attr('type'));     tt++; if (tt>2)tt=0; $(this).attr('type', tt); refresh_template_config_view(this,1,tt)" type = "0" class = "ThemeBody1"></div>
			<div id = "ArticleTheme_BottomAd" onclick = "var tt = parseInt($(this).attr('type')); tt++; if (tt>2)tt=0; $(this).attr('type', tt); refresh_template_config_view(this,2,tt)" type = "0" class = "ThemeAd1"></div>
			<div id = "ArticleTheme_Invite3" onclick = "var tt = parseInt($(this).attr('type'));  tt++; if (tt>0)tt=0; $(this).attr('type', tt); refresh_template_config_view(this,3,tt)" type = "0" class = "ThemeInvite1"></div>
		</div>
		<div style = "height: 16px;"></div>
		<div style = "padding: 8px; font-family: Verdana; font-size: 11px; background: #1f75b2; color: yellow; text-align: center;" onclick = "$('.apply_buttons').fadeIn(300);" id = "apply_to_all">Apply To All</div>
		<div style = "height: 4px;"></div>
		<div class = "apply_buttons" style = "display: none; float: left; padding: 8px; width: 33px; font-family: Verdana; font-size: 11px; background:silver; color: #333; text-align: center; cursor: pointer;">No</div>
		<div class = "apply_buttons" onclick = "save_cfg_to_all()" style = "display: none; float: left; padding: 8px; width: 33px; font-family: Verdana; font-size: 11px; background:silver; color: #333; text-align: center; margin-left: 5px; cursor: pointer;">Yes</div>
		<div class = "apply_note" style = "padding: 8px; font-family: Verdana; font-size: 11px; background: silver; color: #333; text-align: center; display:none;" id = "apply_note">Save All to Set</div>
	</div>

	    <!-- Article Key ID //-->
        <div class = "InputName" custom = "key_container"><p>Article ID</p></div>
        <div class = "InputValue" custom = "key_container"><input type = "text" id = "key" style = "opacity: 1; width: 48px !important;" />
        
        <table style = "position: absolute; top: 0; right: 0; width: 150px; color: white; margin-top:5px;">
            <tr>
            <td style = "width:24px;"><input type = "checkbox" id = "noindex" style = "width: 16px !important; height: 16px !important; vertical-align: middle; margin-top: -3px; cursor: pointer;" /></td>
            <td style = "font-size: 11px !important; font-family: Verdana, sans-serif;"><label for = "noindex" alt = "asd" style = "cursor:pointer; margin-top:-3px;">no-index</label></td>
            </tr>
        </table>
        
        </div>

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
                <option value = "newsletter">newsletter</option> <!-- legacy support for learnjquery.org //-->
                <option value = "blog">blog</option>
                <option value = "webpage">webpage</option>
                <option value = "homepage">homepage</option>
                <option value = "article">article</option> <!-- legacy support //-->
                <option value = "about">about</option> <!-- legacy support //-->
                <option value = "content">content</option> <!-- legacy support //-->
                <option value = "none">none</option>
            </select>
        </div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>JavaScript</p></div>
        <div class = "InputValue" style = "height: auto; z-index:1000000000000 !important">
            <textarea id = "javascript" value = "" style = "border: 0; width: 320px; min-height: 90px !important; z-index:1000000000001 !important; margin-left:1px"/></textarea>
        </div>
        <div class = "LineBreak"></div>

        <div class = "InputName"><p>css</p></div>
        <div class = "InputValue" style = "height: auto; z-index:1000000000000 !important">
            <textarea id = "css" value = "" style = "border: 0; width: 320px; min-height: 90px; z-index:1000000000001 !important; margin-left:1px"/></textarea>
        </div>
        <div class = "LineBreak"></div>