<?php
function generateFeedMessageOptions($idx, $suppress_comments_link = false)
{
    global $FavsExistingIDs, $TrakExistingIDs, $j, $URL, $qsession, $Feed;
    // Is $i tracked? Is $i favorited?
    $is_trk = false;
    $is_fav = false;
    //print "idx = $j";
    //print_g($FavsExistingIDs);
    //print_g($TrakExistingIDs);
    for ($ii=0;$ii<count($FavsExistingIDs);$ii++)
        if ($FavsExistingIDs[$ii] == $j)
            { $is_fav = true; break; }
    for ($ii=0;$ii<count($TrakExistingIDs);$ii++)
        if ($TrakExistingIDs[$ii] == $j)
            { $is_trk = true; break; } ?>
    <div>
        <?php if ($is_fav) { /*This item is already favorited, display "unfavorite" link */ ?>
        <div class = "feed_icon" id = "heart_icon_<?php print $j; ?>"><img src = "<?php print $URL; ?>/Images/CrossedHeart.png" alt = "Favorite" align = "absmiddle" /></div>
            <div class = "feed_option" id = "fav_link_feed_<?php print $j; ?>">
                <a href = 'javascript:void(0)' onclick = "parent.Favorite(<?php print $qsession['user']; ?>, <?php print $j; ?>, false); return false;" class = "purp_link">Unfavorite</a>
            </div>
        <?php } else { /*This item is not favorited, display "favorite" link*/?>
        <div class = "feed_icon" id = "heart_icon_<?php print $j; ?>"><img src = "<?php print $URL; ?>/Images/Heart.png" alt = "Favorite" align = "absmiddle" /></div>
            <div class = "feed_option" id = "fav_link_feed_<?php print $j; ?>">
                <a href = 'javascript:void(0)' onclick = "parent.Favorite(<?php print $qsession['user']; ?>, <?php print $j; ?>, true); return false;">Favorite</a>
            </div>
        <?php } ?>
        <?php if ($is_trk) { /*This item is already being tracked, display "untrack" link */ ?>
        <div class = "feed_icon" id = "bino_icon_<?php print $j; ?>"><img src = "<?php print $URL; ?>/Images/CrossedBinoculars.png" alt = "Untrack" align = "absmiddle" /></div>
            <div class = "feed_option" id = "trk_link_feed_<?php print $j; ?>">
                <a href = 'javascript:void(0)' onclick = "parent.Track(<?php print $qsession['user']; ?>, <?php print $j; ?>, false); return false;">Untrack</a>
            </div>
        <?php } else { /*This item is not being tracked, display "untrack" link*/?>
        <div class = "feed_icon" id = "bino_icon_<?php print $j; ?>"><img src = "<?php print $URL; ?>/Images/Binoculars.png" alt = "Track" align = "absmiddle" /></div>
            <div class = "feed_option" id = "trk_link_feed_<?php print $j; ?>">
                <a href = 'javascript:void(0)' onclick = "parent.Track(<?php print $qsession['user']; ?>, <?php print $j; ?>, true); return false;">Track</a>
            </div>
        <?php } ?>
        <div class = "feed_option <?php if ($Feed[$idx]["vote_up"] == 0) print "gray"; else print "green"; ?>" id = "pos_thumb_<?php print $j; ?>"><?php if ($Feed[$idx]["vote_up"] == 0) print "0"; else { print "+" . $Feed[$idx]["vote_up"]; } ?></div> <div class = "feed_icon"><a href = 'javascript:void(0)' onclick = "parent.Vote(<?php print $qsession['user']; ?>, <?php print $j; ?>, true, 0)"><img src = "<?php print $URL; ?>/Images/ThumbUp.png" border = "0" alt = "vote up" align = "absmiddle"/></a></div>
        <div class = "feed_option <?php if ($Feed[$idx]["vote_down"] == 0) print "gray"; else print "red"; ?>" id = "neg_thumb_<?php print $j; ?>"><?php if ($Feed[$idx]["vote_down"] == 0) print "0"; else { print "-" . $Feed[$idx]["vote_down"]; } ?></div> <div class = "feed_icon"><a href = 'javascript:void(0)' onclick = "parent.Vote(<?php print $qsession['user']; ?>, <?php print $j; ?>, false, 0)"><img src = "<?php print $URL; ?>/Images/ThumbDown.png" border = "0" alt = "vote down" align = "absmiddle"/></a></div>

        <?php if (!$suppress_comments_link) { ?>
            <img src = "<?php print $URL; ?>/Images/Comment.png" alt = "Post Comment" align = "absmiddle" /> <a href = 'javascript:void(0)' onclick = 'parent.OpenComments(<?php print $qsession['user']; ?>, <?php print $j; ?>)'>Comments »</a>
        <?php } else { ?><img src = "<?php print $URL; ?>/Images/void.png" /><?php } ?>

    </div>
    <?php
    return false;
}
?>