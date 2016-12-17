<style type = "text/css">
.NotScheduled { opacity:0.4; }
</style>

<?php

/* Precautions.. */

if (!isset($article_scheduled)) $article_scheduled = "";
if (!isset($in_navigation)) $in_navigation = 0;


?>
<li id = "item-<?php print $article_key; ?>">
    <div id = "sched_<?php print $article_key; ?>" style = "padding-bottom: 2px; font-size: 12px; line-height:7px; font-family:Arial,sans-serif; position: relative;" class = "ArticleTab">

        <?php if ($type == "homepage") {

            ?><img src = "<?php print imageurl("homepage-ic.png", "homepage"); ?>" style = "vertical-align: middle; margin-top:-2px;" alt = "Website Homepage." /><?php

        } else { ?>

            <?php if ($draft == 0) { ?>
                <a href = "#" style = "" id = "draft_icon_<?php print $article_key; ?>" onclick = "article_todraft(<?php print $article_key; ?>)"><img src = "<?php print imageurl("live.png", "settings"); ?>" style = "vertical-align:middle"/></a><?php } ?>
            <?php if ($draft == 1) { ?>
                <a href = "#" style = "" id = "draft_icon_<?php print $article_key; ?>" onclick = "article_todraft(<?php print $article_key; ?>)"><img src = "<?php print imageurl("draft.png", "settings"); ?>" style = "vertical-align:middle"/></a><?php } ?>

        <?php } ?>

        <a style = "position: absolute; right: 0; z-index: 10000000;" href = "#" onclick = "delete_article(<?php print $article_key; ?>);"><img src = "<?php print $URL . '/Images/delete1.png'; ?>" border = "0" onmouseover = "$(this).attr('src', '<?php imageurl('delete2.png'); ?>');" onmouseout = "$(this).attr('src', '<?php imageurl('delete1.png'); ?>');"
           style = "border:0; vertical-align: middle;"
             alt = "delete"/></a>
    
        <?php if ($in_navigation == 0) { ?>
            <a href = "#" id = "incl_navi<?php print $article_key; ?>" onclick = "include_in_navigation(<?php print $article_key; ?>)"><img src = "<?php print imageurl("incl-navi-0.png", "do not include it in site navigation"); ?>" style = "vertical-align: middle;"/></a><?php } ?>
        <?php if ($in_navigation == 1) { ?>
            <a href = "#" id = "incl_navi<?php print $article_key; ?>" onclick = "include_in_navigation(<?php print $article_key; ?>)"><img src = "<?php print imageurl("incl-navi-1.png", "include it in site navigation"); ?>" style = "vertical-align: middle;"/></a><?php } ?>

        <?php
            if ($type == "nodir" || $type == "webpage" || $type == "homepage")
                $folder = "";
            else
                $folder = $type . "/";
        ?>

        <a href = "<?php print $URL . "/" . $folder . $location; ?>" target = "_blank"><img src = "<?php print imageurl("icon-view.png", "settings"); ?>" style = "vertical-align: middle;"/></a>

        <?php /* Article Title */ ?>

        <style>#nm{display:none;}</style>

        <a href = "#" onmouseover = "this.style.color='blue'" onmouseout = "this.style.color='gray'"
            style = "color: gray; text-decoration:none; font-size: 11px;"
          onclick = "window.CURRENT_ARTICLE_ID_SETTINGS = parseInt('<?php print $article_key; ?>'); $('#cal_sched_article_name').html('<img style = \'vertical-align:middle;\' src = \'<?php print imageurl("draft.png"); ?>\'> <span id = \'nm\'>' + $('#sched_link_<?php print $article_key; ?>').text() + '</span>'); $('#sched_article_name').html($('#sched_link_<?php print $article_key; ?>').text()); load_article(<?php print $article_key; ?>); return false;" id = "sched_link_<?php print $article_key; ?>"><?php print substr($title, 0, 25) . "..."; ?></a>
            <span class = "timeleft"><?php print $article_scheduled; ?></span>

        <div class = "ScheduleStatus" style = "position: relative; display: inline; width: 49px; height: 20px;">

        <img onclick = "window.CURRENT_ARTICLE_ID_SETTINGS = parseInt('<?php print $article_key; ?>'); $('#calendarArea').show(); $('#cal_sched_article_name').html('<img style = \'vertical-align:middle;\' src = \'<?php print imageurl("draft.png"); ?>\'> <span id = \'nm\'>' + $('#sched_link_<?php print $article_key; ?>').text() + '</span>' + $('#sched_link_<?php print $article_key; ?>').text()); $('#sched_article_name').html($('#sched_link_<?php print $article_key; ?>').text());"
                 src = "<?php print imageurl("sched_sched.png", ""); ?>"
               style = "border-bottom:4px; vertical-align: middle; cursor: pointer;"
                  id = "image_cal_<?php print $article_key; ?>"
               class = "NotScheduled"
               />
        <?php /*
        <img src = "<?php print imageurl("sched_sent.png", ""); ?>" style = "border-bottom:4px; vertical-align: middle; cursor: pointer;"/>
        */ ?>

        <?php /*<img src = "<?php print imageurl("sched_twitter.png", ""); ?>" style = "border-bottom:4px; vertical-align: middle; opacity:0.5"/>*/ ?>
        <?php /*<img src = "<?php print imageurl("sched_rss.png", ""); ?>" style = "border-bottom:4px; vertical-align: middle; opacity:0.5"/>*/ ?>

        </div>

    </div>
</li>