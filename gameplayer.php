<style style = "text/css">
    #GamePlayer { width: 855px }
    #Game { width: 855px; height: 480px; background: black; }
    #GameDescription { width: 855px; background: white; margin-top: 0px; }
    #GamePlayer { position: relative; width: 855px; margin: 32px auto; height: auto; background: #fff; margin-bottom: 10px; }
    #GameDetails { position: relative; width: 855px; margin: 32px auto; margin-bottom: 0; height: auto; background: #fff; }

    #GameDescription { position: relative; width: 855px; margin: 32px auto; margin-top: 10px; height: auto; background: #fff; }
    .CommentsBlock { position: relative; width: 855px; margin: 32px auto; margin-top: 0px; margin-bottom: 5px; height: auto; background: #fff; color: #777; }

    .Authorship { position: relative; }
    .AuthorImage { }
    .AuthorInfo { position: absolute; top: 0; left: 60px; }
    .AuthorInfo a { text-decoration: none; }

    #GameName { margin-bottom: 8px; font-size: 17px;font-family: Arial,sans-serif; }
    #GameInfo { position: relative; width: 100%; height: 32px; border-top: 1px solid #ddd; height: 48px; padding-top: 4px; margin-top: 6px;}
    #GameLikes { width: auto; height; 32px; position: absolute; top: 8px; right: 0; font-size: 11px; color: gray; }
    #GameLikes img { vertical-align: middle; margin-top: -2px; }
    #GameOptions { }
    #PlayOverlay { position: absolute; top: 0; left: 0; width: 855px; height: 480px; z-index: 1; }
    #PlayButton { position: relative; width: 113px; margin: 200px auto; z-index: 2; cursor: pointer; }

    #moreinfo { display: none; }

</style>

<div id = "GamePlayer">
    <div id = "Game"></div>
    <div id = "PlayOverlay">
        <div id = "PlayButton">
            <img src = "<?php print $URL; ?>/playbutton.png" alt = "Play"
         onmouseover = "this.src = '<?php print $URL; ?>/playbuttonover.png'"
          onmouseout = "this.src = '<?php print $URL; ?>/playbutton.png'" />
        </div>
    </div>
</div>

<div id = "GameDetails" style = "margin-top:0;" class = "Brightest">
<div style = "padding: 20px; padding-top: 12px;">
        <div id = "GameName"><?php print $GAME_TITLE; ?></div>
        <div class = "Authorship">
            <div class = "AuthorImage"><img style = "width: 48px; height: 48px;" src = "https://yt3.ggpht.com/-BnCILJwNTdM/AAAAAAAAAAI/AAAAAAAAAAA/FJVZ5YqcdgI/s88-c-k-no-mo-rj-c0xffffff/photo.jpg" alt = "Game Author Photo"/></div>
            <div class = "AuthorInfo">
                <a href = "#">Dev Tigris</a>
                <div style = "margin-top: 4px;">Game Developer</div>
            </div>
        </div>
        <div id = "GameInfo" style = "height: 8px; margin-bottom:0">
            <div id = "GameOptions" style = " padding-top:4px; color: gray;">add to, share, ... more</div>
            <div id = "GameLikes">
                <img src = "<?php print $URL; ?>/upvote.png" alt = "Up vote"/> 17 &nbsp;&nbsp;&nbsp;
                <img src = "<?php print $URL; ?>/downvote.png" alt = "Down vote"/> 1
            </div>
            <div style = "position: absolute; top: -24px; right: 0; font-size: 15px;">1296 views</div>
        </div>
    </div>
</div>

<div id = "GameDescription" class = "Brightest" style = "margin-bottom: 8px">
<div style = "padding: 20px; padding-top: 8px; padding-bottom: 8px">
        <p><b>Published on Dec 3, 2016</b></p>
        <p style = "font-size:11px; color: gray;">This is a game where you do this and that and collect power ups, jump, yes attack enemies and avoid their attacks, run out of lives, collect lives, customize your character, find hidden levels, fly, run, swim like Donkey Kong and much more, if you just try it you will see for yourself how amazing this game is.
        <span id = "moreinfo">This is a game where you do this and that and collect power ups, jump, yes attack enemies and avoid their attacks, run out of lives, collect lives, customize your character, find hidden levels, fly, run, swim like Donkey Kong and much more, if you just try it you will see for yourself how amazing this game is. This is a game where you do this and that and collect power ups, jump, yes attack enemies and avoid their attacks, run out of lives, collect lives, customize your character, find hidden levels, fly, run, swim like Donkey Kong and much more, if you just try it you will see for yourself how amazing this game is.</span></p>
    </div>
    <div onclick = "$('#moreinfo').toggle()" style = "text-align: center; padding-bottom:4px; font-size: 11px; color: gray; border-top: 1px solid #eee; padding-top: 3px;">Show More</div>
</div>

<div class = "CommentsBlock Brightest">
    <div style = "padding: 20px; padding-top: 8px; padding-bottom: 8px">

        2 Comments

        <div style = "clear:both; height: 9px;"></div>

        <div class = "Authorship">
            <div class = "AuthorImage"><img style = "width: 48px; height: 48px;" src = "https://yt3.ggpht.com/-BnCILJwNTdM/AAAAAAAAAAI/AAAAAAAAAAA/FJVZ5YqcdgI/s88-c-k-no-mo-rj-c0xffffff/photo.jpg" alt = "Game Author Photo"/></div>
            <div class = "AuthorInfo">
                <a href = "#">Dev Tigris</a> <span style = "font-size: 11px; color: gray;">1 week ago</span>
                <div style = "margin-top: 4px;">This is a great game. You knew I would say that, didn't you. No, but seriouosly good game. Nice black screen that does nothing while the site is still in development. Overall, this is good progress good not luck with it!</div>
            </div>
        </div>
    </div>
</div>

<div class = "CommentsBlock Brightest">
    <div style = "padding: 20px; padding-top: 8px; padding-bottom: 8px">
        <div class = "Authorship">
            <div class = "AuthorImage"><img style = "width: 48px; height: 48px;" src = "https://yt3.ggpht.com/-BnCILJwNTdM/AAAAAAAAAAI/AAAAAAAAAAA/FJVZ5YqcdgI/s88-c-k-no-mo-rj-c0xffffff/photo.jpg" alt = "Game Author Photo"/></div>
            <div class = "AuthorInfo">
                <a href = "#">Dev Tigris</a> <span style = "font-size: 11px; color: gray;">1 week ago</span>
                <div style = "margin-top: 4px;">This is a great game. You knew I would say that, didn't you. No, but seriouosly good game. Nice black screen that does nothing while the site is still in development. Overall, this is good progress good not luck with it!</div>
            </div>
        </div>
    </div>
</div>

