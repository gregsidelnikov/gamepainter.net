var save_timer_2 = [null,null];
function delay_save_s(i) {
    clearTimeout(save_timer_2[i]);
    save_timer_2[i] = null;
    save_timer_2[i] = setTimeout(function() {
        slideshow_dim_save();
    }, 500);
}
window.slideshow_num = 0;
window.slideshow = { };
window.slide_ix = 0;
var slide_z = 1000;
var slide_timer = null;
var slide_is_playing = false;
function scale2height($image_width, $image_height, $target_height) {
    var $target_width = $target_height * ($image_width / $image_height);
    return $target_width;
}
function scale2width($image_width, $image_height, $target_width) {
    var $target_height = $target_width * ($image_height / $image_width);
    return $target_height;
}
var new_width = 0;
var new_height = 0;
function resizer_setup() {
    $("#resizer").draggable( {
        start: function() {  }, 
        drag: function() {
            var x = $("#resizer").offset().left + 16;
            var y = $("#resizer").offset().top + 16;
            var wx = $(".slideshow-container").offset().left;
            var wy = $(".slideshow-container").offset().top;
            var w = new_width = x - wx;
            var h = new_height = y - wy;
			$("#slideshow-parent").css( { width: (x - wx) + "px", height: (y - wy) + "px" } );
			$(".slideshow-container").css( { width: (x - wx) + "px", height: (y - wy) + "px", clip: "rect(0px, " + w + "px, " + h + "px, 0px)" } );
            calc_image_resize();
            $("#slideshow_width").val(w);
            $("#slideshow_height").val(h);
            // Re-size text description
            $("#slideshow_desc_bg").css( "height", $("#slideshow_desc_tx").css("height") );
            delay_save_s(0);
        },
        stop: function() {  }
    } );
}
// update in slideshow view and j-son
function update_picture(slide_id) {
    var url = $("#slide-url").val();
    $("#slide-image-" + slide_id).attr("src", url);
    window.slideshow[slide_id].url = url; 
    dbjs.table = "slideshow";
    dbjs.set( { "url" : url }, "`slide_id` = '" + slide_id + "'", 1, function(msg) { } );
}
// update href url in slideshow
function update_href(slide_id) {
    var href = $("#slide-href").val();
    window.slideshow[slide_id].href = href; 
    dbjs.table = "slideshow";
    dbjs.set( { "href" : href }, "`slide_id` = '" + slide_id + "'", 1, function(msg) { } );
}
// update in slideshow view and j-son
function update_text(slide_id) {
    var text = $("#slide-text").val();
    window.slideshow[slide_id].text = text; 
    dbjs.table = "slideshow";
    dbjs.set( { "text" : text }, "`slide_id` = '" + slide_id + "'", 1, function(msg) { } );
}
function slideshow_dim_load() {
    var w = 0;
    var h = 0;
    dbjs.table = "slideshow";
    dbjs.get( "*", "`slide_id` = 'w'", "", 1, function(msg) { w = mysql.href;
    dbjs.get( "*", "`slide_id` = 'h'", "", 1, function(msg) { h = mysql.href;

    // we got w and h, do the rest....
        $("#slideshow_width").val(w);
        $("#slideshow_height").val(h);
        new_width = w;
        new_height = h;
        
        // alert(w+","+h);
        $("#slideshow-parent").css( { width: w + "px", height: h + "px" } );
        $(".slideshow-container").css( { width: w + "px", height: h + "px", clip: "rect(0px, " + w + "px, " + h + "px, 0px)" } );
        
        
        
      },1);
    },1);
}
function slideshow_dim_save() {
    dbjs.table = "slideshow";
    dbjs.set( { "href" : $("#slideshow_width").val() }, "`slide_id` = 'w'", 1, function(msg) { } );
    dbjs.set( { "href" : $("#slideshow_height").val() }, "`slide_id` = 'h'", 1, function(msg) { } );
}
// update in slideshow view and j-son
function update_url(slide_id) {}
// clear db and re-save entries to the database
function db_save_slides() {

}

function image_resize(slide_id, img_width, img_height) {
    var i = slide_id;
    var VIEW_WIDTH = new_width;
    var VIEW_HEIGHT = new_height;
    
    var pic = $("#slide-image-" + i);
    
    
    // FAVOR VERTICAL (TALL) IMAGES
    /*
    var target_height = scale2width(img_width, img_height, VIEW_WIDTH);
    if (target_height > 0)    
        pic.css( { height: target_height + "px", top: (VIEW_HEIGHT/2) - (target_height/2) + "px" } );
    */
        
    // FAVOR HORIZONTAL (WIDE) IMAGES
    var target_width = scale2height(img_width, img_height, VIEW_HEIGHT);
    if (target_width > 0)
        pic.css( { width: target_width + "px", left: (VIEW_WIDTH/2) - (target_width/2) + "px", top: 0 } );
        
    
    if (img_height > VIEW_HEIGHT) {
        //var target_width = scale2height(img_width, img_height, VIEW_HEIGHT);
        //pic.css( { width: target_width + "px", height: 50 + "px", left: (VIEW_WIDTH/2) - (target_width/2) + "px", top: 0 } );
        //var target_height = scale2width(img_width, img_height, VIEW_WIDTH);
        //pic.css( { height: target_height + "px", top: (VIEW_HEIGHT/2) - (target_height/2) + "px" } );
    }
    if (img_width > VIEW_WIDTH) {
        //var target_height = scale2width(img_width, img_height, VIEW_WIDTH);
        //if (target_height > 0)    
         //   pic.css( { height: target_height + "px", top: (VIEW_HEIGHT/2) - (target_height/2) + "px" } );
    }
} 

// Resize all images dynamically on re-size action
function calc_image_resize() {
//var i = 0;
    $(".slideshow-container div img").each(function(msg) {
        var id = $(this).attr("id");
        var iw = $(this).attr("w");
        var ih = $(this).attr("h");
        var ix = id.split("-")[2];
        image_resize(ix, iw, ih);
        ///i++;
    });
    
//    alert(i);
}

// Resize slideshow images initially on load
function calc_image_size(href, i) {
    var img = new Image();
    img.src = href;
    img.onload = function() {
        $("#slide-image-" + i).attr("w", img.width);
        $("#slide-image-" + i).attr("h", img.height);
        image_resize(i, img.width, img.height);
    }
}

function load_slideshow() {
    window.slideshow_num = 0;
	$.ajax( { url : window.url + "/admin/getslides.php", success : function(msg) {
		var j = JSON.parse(msg);
		var i = 0;
		while (j[i]) {
			var url = j[i].url;
			var text = j[i].text;
			var href = j[i].href;
            ins_slide(url,text,href);
            project_slide(i, url, text);
            calc_image_size(url, i);
            i++;
        }
        select_slide(0);
    }});
}

// Insert a slide into the j-son
function ins_slide(url, text, href) {

    window.slideshow[window.slideshow_num++] = { "url" : url, "text" : text, "href": href };

}
// ?
function save_slideshow() {

}
function regenerate_slide_tabs() {
	// remove all current tabs
	$("#slides").html("");
	// Populate slideshow
	var backslide = 0;
	window.slideshow_num = 0;
	var obj = {};
	var ix = 0;
	for (i in window.slideshow) {
	    if (window.slideshow[i] != null) {
    	    var url  = window.slideshow[i].url;
	        var text = window.slideshow[i].text;
	        var href = window.slideshow[i].href;
	        obj[ix++] = { "url" : url, "text" : text, "href" : href };
	        project_slide(i - backslide, url, text);     
	        	window.slideshow_num++;
	    } else { backslide++; }
	}
	window.slideshow = obj;
	if (slide_is_playing)
        hide_exes();
}
function remove_slide(slide_id) {
	window.slideshow[slide_id] = null;
    regenerate_slide_tabs();
    dbjs.table = "slideshow";
    dbjs.remove("`slide_id` = '" + slide_id + "'", 1, function(msg) {  } );
}
function select_slide(slide_id) {
    slide_ix = slide_id;
    if (window.slideshow[slide_id]) {
        // alert("select_slide("+slide_id+")=" + JSON.stringify(window.slideshow[slide_id]));
        $("#slide-url").val(window.slideshow[slide_id].url);
        $("#slide-text").val(window.slideshow[slide_id].text);
        $("#slide-href").val(window.slideshow[slide_id].href);
        $(".slideshow-item").removeClass("sel");
        $("#slide-" + slide_id).addClass("sel");
        // Show slide on the preview
        show_slide(slide_id);
    }
}
function project_slide(slide_id, url, text)
{
    $("#slides").append('<div id = "slide-' + slide_id + '" class = "slideshow-item" onclick = "select_slide(' + slide_id + ')"> Slide ' + slide_id + '<div class = "minus" onclick = "remove_slide(' + slide_id + ')"></div></div>');
    $(".slideshow-container").append("<div class = 'ssh_image_contaners' id = 'ssh_container_"+slide_id+"' style = 'position: absolute; top: 0; left:0;width: 100%; height:100%;background:#000;'><img id = 'slide-image-" + slide_id + "' src = '" + url + "' style = 'position: absolute; top: 0; left: 0; ' /></div>");
    // $(".slideshow-container").append("<img class = 'slide-images' id = 'slide-image-" + slide_id + "' src = '" + url + "' style = 'position: absolute; top: 0; left: 0; z-index:" + 1 + "' />");
}
function add_slide_db(slide_id, url, text, href) {
    add_slide(slide_id, url, text, href);
    dbjs.table = "slideshow";
    dbjs.insert( { "slide_id" : slide_id,"url" : url, "text" : text, "href" : href }, function(msg) { } );
}
function add_slide(slide_id, url, text, href) {
	project_slide(slide_id, url, text);
    ins_slide(url, text, href);
    if (slide_is_playing) {
        hide_exes();
    }
    regenerate_slide_tabs();
}
function show_slide(id) {

    //$("#slide-image-" + id).parent().css( { "z-index":slide_z } ); 

	$("#ssh_container_" + id).css( { "z-index" : slide_z, "display" : "none" } );
	$("#slide-image-" + id).css( { "z-index" : slide_z + 1, "display" : "none" } );
 	$("#ssh_container_" + id).fadeIn(300); // fadeIn(300); // bg
	$("#slide-image-" + id).fadeIn(300); // fadeIn(300);  // pic
	
	$("#slideshow_desc_tx").fadeOut(50, function() {
        $("#slideshow_text").text(window.slideshow[id].text);
	    $("#slideshow_desc_tx").fadeIn(150);
	    	// adjust text bg height
	    	console.log($("#slideshow_desc_tx").css("height"));
	    $("#slideshow_desc_bg").css( "height", $("#slideshow_desc_tx").css("height") );
	});
	

	
	slide_z++;
} 

window.SLIDESHOW_PAUSE_BETWEEN_PICTURES = 1500;
function slideshow_play() {
    hide_exes();
    slide_timer = setInterval(function() {
        slide_ix++;
        if (slide_ix > window.slideshow_num - 1)
            slide_ix = 0;
        select_slide(slide_ix);
        show_slide(slide_ix);
    }, window.SLIDESHOW_PAUSE_BETWEEN_PICTURES);
    slide_is_playing = true;
}
function slideshow_stop() {
    
    clearTimeout(slide_timer);
    slide_timer = null;
    //slide_ix = 0;
    // back to slide 1
    //select_slide(0);
    //show_slide(0);
    // display x's again
    show_exes();
    slide_is_playing = false;
}
function slideshow_toggle_play() {
    var cl = $("#slideshow_play_button").hasClass("play_on");
    if (cl) {
        $("#slideshow_play_button").removeClass("play_on");
        $("#slideshow_play_button").attr("src", "play-2.png");
        slideshow_play();
    } else {
        $("#slideshow_play_button").addClass("play_on");
        $("#slideshow_play_button").attr("src", "play-1.png");
        slideshow_stop();
    }
}
function hide_exes() {
    $(".minus").fadeOut(150);
}
function show_exes() {
    $(".minus").fadeIn(150);
}

function test(){
    calc_image_resize();
}

// Calculate slideshow image dimensions
$(window).load(function() {
    setTimeout("test()",2000);
} );

// Slideshow processing
$(document).ready(function() {

    slideshow_dim_load();
      
    resizer_setup();
    
    load_slideshow();
    

} );