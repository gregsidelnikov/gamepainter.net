<style style = "text/css">
    #GamePlayer { width: 855px }
    #Game { width: 855px; height: 480px; background: black; }
    #GameDescription { width: 855px; background: white; margin-top: 0px; }
    #GamePlayer { position: relative; width: 855px; margin: 32px auto; height: auto; background: #fff; margin-bottom: 10px; }
    #GameDetails { position: relative; width: 855px; margin: 32px auto; margin-bottom: 0; height: auto; background: #fff; }
    #GameDescription { position: relative; width: 855px; margin: 32px auto; margin-top: 10px; height: auto; background: #fff; }
    #Authorship { position: relative; }
    #AuthorInfo { position: absolute; top: 0; left: 60px; }
    #GameName { margin-bottom: 8px; font-size: 17px;font-family: Arial,sans-serif; }
    #GameInfo { position: relative; width: 100%; height: 32px; border-top: 1px solid #ddd; height: 48px; padding-top: 4px; margin-top: 6px;}
    #GameLikes { width: auto; height; 32px; position: absolute; top: 8px; right: 0; font-size: 11px; color: gray; }
    #GameLikes img { vertical-align: middle; margin-top: -2px; }
    #GameOptions { }
    #PlayOverlay { position: absolute; top: 0; left: 0; width: 855px; height: 480px; z-index: 1; }
    #PlayButton { position: relative; width: 113px; margin: 200px auto; z-index: 2; cursor: pointer; }
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
        <div id = "Authorship">
            <div id = "AuthorImage"><img style = "width: 48px; height: 48px;" src = "https://yt3.ggpht.com/-BnCILJwNTdM/AAAAAAAAAAI/AAAAAAAAAAA/FJVZ5YqcdgI/s88-c-k-no-mo-rj-c0xffffff/photo.jpg" alt = "Game Author Photo"/></div>
            <div id = "AuthorInfo">
                <a href = "#">Dev Tigris</a>
                <div id = "" style = "margin-top: 4px;">Game Developer</div>
            </div>
        </div>
        <div id = "GameInfo" style = "height: 8px; margin-bottom:0">
            <div id = "GameOptions">add to, share, ... more</div>
            <div id = "GameLikes">
                <img src = "<?php print $URL; ?>/upvote.png" alt = "Up vote"/> 17 &nbsp;&nbsp;&nbsp;
                <img src = "<?php print $URL; ?>/downvote.png" alt = "Down vote"/> 1
            </div>
            <div style = "position: absolute; top: -24px; right: 0; font-size: 15px;">1296 views</div>
        </div>
    </div>
</div>

<div id = "GameDescription">
    <div style = "padding: 20px; padding-top: 8px; padding-bottom: 8px">
        <p><b>Published on Dec 3, 2016</b></p>
        <p style = "font-size:11px; color: gray;">This is a game where you do this and that and collect power ups, jump, yes attack enemies and avoid their attacks, run out of lives, collect lives, customize your character, find hidden levels, fly, run, swim like Donkey Kong and much more, if you just try it you will see for yourself how amazing this game is.</p>
    </div>
</div>

<div id = "CommentsBlock">
</div>