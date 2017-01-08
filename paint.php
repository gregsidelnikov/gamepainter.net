<script type = "text/javascript">

    /** ----- Custom objects ----- **/

    var FrameView = new Rectangle(0,0,720,405);

    var Player = new PlayerClass();

    var Celestial = new CelestialManager(0,0);

    var Timeline = new TimelinePanel(0, 0, $(window).width(), 200);

    var grid = new Grid(64, 64); // Initialize grid

    var toolbox = new Toolbox();

    var fox = new Sprite("fox.png");

    var des = new Sprite("des.png");

    // var bug = new Sprite("bug.png");

    var Enemy = new Array();

    for (var i = 0; i < 10; i++) Enemy[i] = new EnemyClass();

    var H2 = 0;
    var A1 = 169;

    var ta = new TextArea(100, 100, "Hello from textarea... 2134734$#%#@");

    function IsMobile() { if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { window.mobile = true; $("body *").addClass("IncreaseFontSize"); } }
    function Resize() {
        if (w < 900) { $("body").addClass("MiniSite"); } else { $("body").removeClass("MiniSite"); }
        /* Collapse all grid view tables in smaller views */
        if (w < 600) { $(".grid td").addClass("CollapseBlock"); } else { $(".CollapsibleSide").removeClass("CollapseBlock"); }
        /* Hide vertical mid point separators (or rather turn them into vertical with height=16px) */
        if (w < 600) { $(".MidPointSeparator").addClass("Hide"); } else { $(".MidPointSeparator").removeClass("Hide"); }
        /* When width is too small; center content in "MiniMiddle" cells */
        if (w < 600) { $(".MiniMiddle").addClass("Center"); } else { $(".MiniMiddle").removeClass("Center"); }
    }
    $(window).resize(function() { Resize(); });
    $(window).load(function() { Resize(); }); window.alreadyScrolled = false;
    $(window).on("scroll", function() { /*if (!alreadyScrolled) { $.scrollTo("#game", 500); alreadyScrolled = true; } */ } );

    window.mobileWidth = 375;//$(window).width();
    window.mobileHeight = 650;//$(window).height();

    var LoadingBarRect = new Rectangle(0,0,0,0);

    $(document).ready(function() {

        // Center welcome loading bar dialog
        $("#WelcomeToolbar").css( { "top" : "200px", "left": ($(window).width()/2 - $("#WelcomeToolbar").width()/2) + "px" } );

        IsMobile();
        Resize();

        game.width = $(window).width();
        game.height = $(window).height();

        if (window.mobile) {
            window.mobileWidth = $(window).width();
            window.mobileHeight = $(window).height();
            if (mobileWidth == 375) Context = new HTML("game", mobileWidth, mobileHeight); else

            if (mobileWidth == 480) Context = new HTML("game", mobileWidth, mobileHeight); else
                Context = new HTML("game", game.width, game.height); // default-development machine

        } else {
            Context = new HTML("game", game.width, game.height); // default-development machine
        }

        window.gfx = Context.context;

        gfx.globalAlpha = 1;
        gfx.beginPath();
        gfx.rect(0, 0, game.width, game.height);
        gfx.fillStyle = 'white';
        gfx.fill();

        InitializeKeyboard();
        InitializeOnscreenKeyboard();
        Mouse.Initialize("#game");
        Touch.Initialize("#game");
        DisableScrollbars();
        Sound.Initialize();
        //InitializeLongevityMap();

        // make toolbox draggable
        $("#Tools").draggable({
            stop : function(){
                localStorage.setItem("toolbarx", $("#Tools").offset().left);
                localStorage.setItem("toolbary", $("#Tools").offset().top);
            }
        });

        game.engineReady = true;

        setTimeout(function() {
            //game.displayLoadingBar = true;

            /* Statistics logging
             $.ajax( { "url" : "http://www.tigrisgames.com/property_stealth/Tig_jsGE/addTester.php",
             type : "POST",
             data: { "width" : mobileWidth, "height" : mobileHeight },
             success: function(msg) { }
             });  */

            // Load graphics resources
            $.ajax({"url" : "getResourceList.php", type : "POST", success: function(msg) {
                console.log("Loading graphics resources from getReourceList.php");
                if (JSON.parse(msg) != undefined) {
                    var json = JSON.parse(msg);
                    game.resourceNumber = json.length;
                    var span_width = $("#ProgressBar").width() / game.resourceNumber;
                    //console.log("span width = " + span_width);
                    $("#a").text(0);
                    $("#b").text(game.resourceNumber);
                    $("#ProgressBarCounter").show();
                    for (var i = 0; i < game.resourceNumber; i++) {
                        var appropriateName = json[i].split(".")[0];
                        window.LoadingFileName = json[i];
                        window[appropriateName] = new Sprite("resources/" + window.LoadingFileName);
                        // console.log(i + " loaded... (" + appropriateName + ")");
                        var barwidth = 0;
                        //if (i != 0) {
                        barwidth = (i) * ($("#ProgressBar").width()) / (game.resourceNumber);
                        //console.log("barwidth = " + barwidth);
                        //}
                        $("#a").text(i + 1);
                        $("#ProgressBarPercent").css( { "width" : (barwidth + 5) + "px" } );
                        if (i + 1 == game.resourceNumber) {
                            $("#MakeGamesButtonOn").fadeIn();
                            game.ResourcesLoaded = true;
                            sfxbubble.play();
                        }
                    }
                }

                // Graphics resources finished loading
                // Graphics resources finished loading

                BoxManager.load(); // Load box objects
            }});

            // Load sound resources
            /*
             $.ajax({"url" : "http://www.learnjquery.org/games/gem/getSfxList.php", type : "POST", success: function(msg) {
             if (JSON.parse(msg) != undefined) {
             var json = JSON.parse(msg);
             game.resourceNumber = json.length;
             for (var i = 0; i < json.length; i++) {
             var appropriateName = json[i].split(".")[0];
             window.LoadingFileName = json[i];
             window[appropriateName] = new Sprite("http://www.learnjquery.org/games/gem/resources/" + window.LoadingFileName);
             console.log(i + " loaded... ("+appropriateName+")");
             }
             }
             }}); */
//		        $("#animator").css({"left" : game.width/2 + "px", "top" : game.height/2 + "px", "padding-left" : "1px"});

        }, 500);

    });

    function ClearCanvas() {
        gfx.globalAlpha = 1;
        gfx.beginPath();
        gfx.rect(0, 0, $(window).width(), $(window).height());
        gfx.fillStyle = 'black';
        gfx.fill();
    }

    var LogoRot = 0;
    var sub_beam_rot = 0;
    var panorama_y = 400;
    var panorama_y_target = 0;
    var panorama_s = 0;

    var dust_counter = 0;
    var bub_counter = 0;

    zoomPointX = game.width/2;
    zoomPointY = game.height/2;

    InitializeAnimationCounters();

    function draw_gemini_loading_logo() { }

    // Enemy[0].spawn(200,200);

    setInterval(function() {

        ResetAnimationCounter();

        Press.capture(Mouse, Touch); // Press stores either mouse or touch (whichever was done)

        //scalechange = scalefactor - 1; // calculate camera zoom in real time

        ClearCanvas();


        if (game.ResourcesLoaded) {
            //if (window.Gemgrid == null) { // Grid is resource dependent, because it needs gem icons loaded
            //  window.Gemgrid = new Grid(game.boardWidth, game.boardHeight, game.boardCellSize);
            //InitializeGalaxy(); // Create galaxy simulator
//					Sound.play(7); // delune music
            //}
            //if (game.state == -1)
            //geminilogo.rotscale(mobileWidth/2, 135, 1,1, 0);
        }

        switch (game.state) {
            // case 0: wam_menu(); break;
            case -1:

                grid.draw();

                // Draw celestial objects
                //Celestial.process();
                //Celestial.draw();

                // Drag cursor
                // if (game.ResourcesLoaded)
                // cursorhand1.draw(Mouse.x, Mouse.y);

                // Process grid
                toolbox.process();
                toolbox.draw();

                // Draw rain (background layer)
                for (var i = 0; i < RainArea.length; i++) {
                    RainArea[i].process();
                    RainArea[i].draw();
                }

                // Draw all created objects (rectangles)
                if (BoxManager.objectsLoaded) {
                    BoxManager.draw();
                }

                // Draw player
                Player.process();
                Player.draw();
                Player.collide(); // Collide player with the world

                // Draw enemies
                Enemy[0].process();
                Enemy[0].draw();
                Enemy[0].collide();

                var PlayerSize = 64;
                var PlayerYAdjusted = -30;

                if (game.ResourcesLoaded) {
                    if (Player.dirx == RIGHT) {
                        if (Player.controlKeysPressed) {
                            dust_counter++;
                            //if (dust_counter > 10) { add_dustparticle(Player.drawx, Player.y + 24); dust_counter = 0; }
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [0, 1, 2, 3], 1, PlayerSize, 4, 10);
                        }  else {
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [0], 1, PlayerSize, 8, 10);
                        }

                        if (Player.firing) { /* Fire button pressed */
                            Player.x -= 0.5;
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [8], 1, PlayerSize, 4, 10);
                            bub_counter++;
                            //if (bub_counter > 10) { add_bubbleparticle(Player.drawx, Player.y - 8, 1); bub_counter = 0; }
                        }

                    }
                    if (Player.dirx == LEFT) {
                        if (Player.controlKeysPressed) {
                            dust_counter++;
                            //if (dust_counter > 10) { add_dustparticle(Player.drawx, Player.y + 24); dust_counter = 0; }
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [4, 5, 6, 7], 1, PlayerSize, 4, 10);
                        }
                        else {
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [4], 1, PlayerSize, 4, 10);
                        }
                        if (Player.firing) { /* Fire button pressed */
                            Player.x += 0.5;
                            girl2.rotAnim(Player.drawx, Player.drawy + PlayerYAdjusted, [9], 1, PlayerSize, 4, 10);
                            bub_counter++;
                            //if (bub_counter > 10) { add_bubbleparticle(Player.drawx, Player.y - 8, -1); bub_counter = 0; }
                        }
                    }
                }

                if (key.left) { Player.x -= 1; Player.momx = -1; Player.controlKeysPressed = true; Player.dirx = LEFT; }
                if (key.right) { Player.x += 1; Player.momx = 1; Player.controlKeysPressed = true; Player.dirx = RIGHT; }
                if (key.up) { }
                if (key.down) { }
                if (key.w) { /* ... */ }
                if (key.s) {
                    Player.firing = true;
                    BubbleMeter.width -= 0.01;
                } else {
                    Player.firing = false;
                }
                if (key.a) { /* ... */ }
                if (key.d) {

                    Player.jumping = true;
                }

                if (!key.left && !key.right && !key.top && !key.down) {
                    Player.controlKeysPressed = false;
                }

                // Draw timeline panel
                Timeline.process();
                Timeline.draw();

                // Draw on-screen text
                // ta.draw(100,100);

                break;

            case 1: break;
            case 2: break;
            case 3: break;
            case 4: break;
            case 5: break;
            case 6: break;
            case 7: break;

            default: break;
        }

        if (!game.ResourcesLoaded) {

            // Do something while game is loading

        } else {
            if (game.state == -1) {
                //if (LoadingPercent >= 100) {
//                        text("Gemini requires a Tigris game account.", game.width/2, 350, "silver", "center", "13px", "Verdana");
//                        if (Press.ed && debug_nextLvl.pressed()) { game.start(game.level + 1); }
                //}
            }
        }

        window.touched = false;		// reset touch
        window.released = false;	// release touch
        window.clicked = false;		// reset click
        Press.ed = false;			// reset main Press object
        Mouse.down = false;         // reset single frame mouse click
        Mouse.reset();              // reset all mouse clicks

        gfx.globalAlpha = 1;

    }, 0);

</script>

    <canvas id = "game"></canvas>

    <?php include("toolbar.php"); ?>