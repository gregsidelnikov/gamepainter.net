    var prev_text = "#text1";
    var prev_image = null;
    var images = ["#slide1","#slide2","#slide3","#slide4","#slide5"];
    var texts = ["#text1","#text2","#text3","#text4","#text5"];
    var z = 2;
    var idx = 0;
    var SLIDESHOW_FIRST_DELAY = 1000; /* Wait until going to slide #2*/
    var SLIDESHOW_TIMEDELAY_BETWEEN_TRANSITIONS = 1000; /* Wait between consequent slides*/
    function NextSlide()
    {
        // Fade out previous text
        //$(prev_text).animate({opacity:'0'}, 800, function() {
            NextImage();
        //});
    }

    function NextImage()
    {
        //setTimeout(function() {
        $("#slide_navi .clicker").css({'opacity': '0.4'});
        $("#slide_navi .clicker:nth-child(" + (idx+1) + ")").css({'opacity': '0.9'});
        $(images[idx]).css( { 'display':'block', opacity: '0', 'z-index': z } ).animate( { opacity: 1 }, 400, function() {
            $(texts[idx]).css({'display':'block',opacity:'0','z-index': z+1}).animate({opacity:'0.9'}, 800);

                // Wait 4 seconds
                setTimeout(function() {

                    prev_text = texts[idx];
                    prev_image = images[idx];

                    z++;
                    idx++;

                    if (idx == images.length)
                    {
                        idx = 0;
                    }

                    NextSlide();

                }, SLIDESHOW_TIMEDELAY_BETWEEN_TRANSITIONS );

            } );

        //}, 100);
    }

    $(document).ready(function()
    {
        setTimeout(function(){NextSlide()}, 1);
    });