/* goldenize text */
window.logotext = [];
window.linktext = [];
var basecolor = "#45302c";
var goldenmap1 = ["#45302c", "#50342f", "#5f3933", "#694c2a", "#7e6031", "#907238", "#d6a341", "#e9c225", "#fffb77", "#e9c225", "#e9c225", "#d6a341", "#907238", "#7e6031", "#694c2a", "#5f3933", "#50342f", "#45302c"];
var goldenmap2 = ["#5c7e66", "#509865", "#55bb72", "#80de6e", "#c9f2a5", "#80de6e", "#55bb72", "#509865", "#5c7e66" ];
var goldenizer_ctr = [];
window.goldenized = [];
$.fn.goldenize = function(obj, goldmap, speed, delay, forever) { /* pass empty logotext = [] array, or any other fresh var-obj */

    if (forever == undefined) forever = false;    
    var text = $(this).text();
    var prepared = "";
    for (var i = 0; i < text.length; i++) {
        obj[i] = text[i];
        prepared += "<span style = 'color: " + basecolor + "'>" + text[i] + "</span>";
    }
    $(this).html(prepared);
    var cg = window.goldenized.length;
    window.goldenized[cg] = new Object();
    window.goldenized[cg] = { "id":  $(this).attr("id"), "obj" : obj, "offset": 0, "timer": null, "speed" : speed, "delay" : delay, "map": goldmap, "forever": forever };
    goldenizer_ctr[cg] = text.length;
};
/* Call once to set up timers for prepared texts */
$.fn.goldenize.run = function() {
        for (var i = 0; i < goldenized.length; i++) {
            var goldenized_delay = goldenized[i].delay;
            window.goldenized[i].timer = setInterval("goldenize_proc(" + i + ")", goldenized[i].speed);
        }
};
function goldenize_proc(i) {
    var gci = goldenizer_ctr[i];
    var goldenized_id = goldenized[i].id;
    var goldenized_obj = goldenized[i].obj;
    var goldenized_speed = goldenized[i].speed;
    var goldenized_map = goldenized[i].map;
    //var goldenized_forever = goldenized[i].forever;
    var final = "";
    goldenized[i].offset = gci;
    for (var j = 0; j < goldenized[i].obj.length; j++) {
        var thiscolor = goldenized_map[17-goldenized[i].offset];
        final += "<span style = 'color: " + thiscolor + "'>" + goldenized[i].obj[j] + "</span>";
        goldenized[i].offset++;
    }
    $("#" + goldenized_id).html(final);
    goldenizer_ctr[i]--;
    if (goldenizer_ctr[i] < -goldenized[i].obj.length) {
        goldenizer_ctr[i] = goldenized[i].obj.length;
        clearTimeout(window.goldenized[i].timer);
        /* Restart timer for this effect after specified delay*/
        window.goldenized[i].timer = null;
        if (window.goldenized[i].forever) {
            setTimeout(function() {
                window.goldenized[i].timer = setInterval("goldenize_proc(" + i + ")", goldenized[i].speed);
            }, window.goldenized[i].delay);
        }
    }
}
