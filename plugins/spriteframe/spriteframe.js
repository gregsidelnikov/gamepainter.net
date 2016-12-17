/* Pass id of the sprite image as "sprite" */
/* Sprite image must be preloaded, this method only works on window.load event */
/* Image __must have__ "position:absolute; top:0; left:0;" */
$.fn.extend( {
    frame: function(sprite_id, image_container_id, ortho_flag, long_border_flag) {

        if (!sprite_id || sprite_id==undefined)
        {
            $(".img_frame_plg").remove();
            return;
        }

        var imgw = parseInt($(this).css("width"));
        var imgh = parseInt($(this).css("height"));
        /* Get sprite image filename */
        var ssrc = $("#" + sprite_id).attr("src");
        /* Frame sprite is always square, so we only need 1 dimension for both sides */
        var sprd = parseInt($("#" + sprite_id).css("width"));
        /* Calculate frame square */
        var sprs = parseInt(sprd / 3);
        var topborder = "";
        var botborder = "";
        var leftborder = "";
        var rightborder = "";
        var blocksw = parseInt(imgw/sprs) + 3;
        var blocksh = parseInt(imgh/sprs) + 3;

        var ortho_x = 0;
        var ortho_y = 0;

        if (ortho_flag) {
            ortho_x = sprs;
            ortho_y = sprs;
        }

        for (var i = 0; i < blocksw; i++) {
            if (!ortho_flag) /* Ortho frame has no upper frame */
                topborder  += '<div class = "img_frame_plg" style = "left:'+(i*sprs)+'px; top: 0px; position: absolute; display: block; width: ' + sprs + 'px; height:' + sprs + 'px; background: url(' + ssrc + ') -' + sprs + 'px 0 no-repeat;"></div>';
            botborder += '<div class = "img_frame_plg" style = "left:'+(i*sprs)+'px; top: 0px; position: absolute; display: block; width: ' + sprs + 'px; height:' + sprs + 'px; background: url(' + ssrc + ') -' + sprs + 'px -' + sprs*2 + 'px no-repeat;"></div>';
        }
        for (var i = 0; i < blocksh; i++) {
            if (!ortho_flag) /* Ortho frame has no left frame */
                leftborder += '<div class = "img_frame_plg" style = "left:0; top: ' + (i*sprs) + 'px; position: absolute; display: block; width: ' + sprs + 'px; height:' + sprs + 'px; background: url(' + ssrc + ') 0px -' + sprs + 'px no-repeat;"></div>';
            rightborder += '<div class = "img_frame_plg" style = "left:0; top: ' + (i*sprs) + 'px; position: absolute; display: block; width: ' + sprs + 'px; height:' + sprs + 'px; background: url(' + ssrc + ') -' + sprs*2 + 'px -' + sprs + 'px no-repeat;"></div>';
        }
        /* Add in the 8 frame sprite DIVs */
        var divs = '';

        if (!ortho_flag)
            divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'ul" style = "position: absolute; top:-' + sprs + 'px; left:-' + sprs + 'px; width: ' + sprs + 'px; height: ' + sprs + 'px; background: url(' + ssrc + ') no-repeat;"></div>';

        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'top" style = "clip: rect(0px,' + imgw + 'px,'+sprs+'px,0px);overflow:hidden; position: absolute; top:-' + sprs + 'px; left: 0; width: ' + imgw + 'px; height: ' + sprs + 'px;">' + topborder + '</div>';
        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'right" style = "clip: rect(0px,'+sprs+'px,' + imgh + 'px,0px); overflow:hidden; position: absolute; top:0; left: '+imgw+'px; width: ' + sprs + 'px; height: ' + imgh + 'px;">' + rightborder + '</div>';
        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'br" style = "position: absolute; top:' + imgh + 'px; left:' + imgw + 'px; width: ' + sprs + 'px; height: ' + sprs + 'px; background: url(' + ssrc + ') -' + sprs * 2 + 'px -' + sprs * 2 + 'px no-repeat;"></div>';
        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'bottom" style = "clip: rect(0px,' + imgw + 'px,'+sprs+'px,0px); overflow: hidden; position: absolute; top:' + imgh + 'px; left: 0; width: ' + imgw + 'px; height: ' + sprs + 'px;">' + botborder + '</div>';
        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'left" style = "clip: rect(0px,'+sprs+'px,' + imgh + 'px,0px); overflow:hidden; position: absolute; top:0; left: -'+sprs+'px; width: ' + sprs + 'px; height: ' + imgh + 'px;">' + leftborder + '</div>';

        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'ur" style = "position: absolute; top:-' + (sprs - ortho_y) + 'px; left:' + imgw + 'px; width: ' + sprs + 'px; height: ' + sprs + 'px; background: url(' + ssrc + ') -' + sprs*2 + 'px 0px no-repeat;"></div>';
        divs += '<div class = "img_frame_plg" id = "' + sprite_id + 'bl" style = "position: absolute; top:' + imgh + 'px; left:-' + (sprs - ortho_x) + 'px; width: ' + sprs + 'px; height: ' + sprs + 'px; background: url(' + ssrc + ') 0px -' + sprs * 2 + 'px no-repeat;"></div>';

        /* Clear previous frame */
        $(".img_frame_plg").remove();

        $("#" + image_container_id).prepend(divs);

    }
});