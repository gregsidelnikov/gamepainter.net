function timenow() { return new Date().getTime() / 1000; } // seconds
window.navigation = {};
window.navigation_num = 0;
window.navigation_ix = 0;
window.navigation_key = 0;
window.navigation_db_id = 0;
window.nix = 0;
window.nt = 0;
window.NAV_URL = 0;
window.NAV_SUB = 1;
window.NAV_NAM = 2;
var activity_time = 0;
var save_timer = [null,null];
var save_timer_last_time = [0, 0];
var nav_ix = 0;
function delay_save(i) {
    if (i == window.NAV_NAM)
        $("#nav-" + window.nt).html($("#nevigation-name").text());
    if (i == window.NAV_SUB) {
        var subitems = $("#nevigation-ta").val();    
        update_ddn_arrow(window.nt, subitems.length > 0 ? 1 : 0);
    }
    clearTimeout(save_timer[i]);
    save_timer[i] = null;
    save_timer[i] = setTimeout(function() {
        if (i == 0) update_nav_url();
        if (i == 1) update_nav_subitems();
        if (i == 2) update_nav_name();
    }, 500);
}

function select_navi(nav_ix) {
    nav_deselect_all();
    
    var kid = window.navigation[nav_ix].id;
    var t = $("#nav-" + kid);
    
    t.addClass("sel");
    window.nt = t.attr("keyid");
    window.nix = t.attr("index");
    
    //console.log("window.navigation[" + window.nix + "].subitems = " + window.navigation[window.nix].subitems);


    if (window.nix != undefined)
    {    
        $("#nevigation-url").text(window.navigation[window.nix].url);
        $("#nevigation-ta").val(window.navigation[window.nix].subitems);
        $("#nevigation-name").text(window.navigation[window.nix].name);
    }

}
function nav_deselect_all() {
    $(".nav-item").removeClass("sel");
}

// update name of the tab
function update_nav_name() {
    var name = window.navigation[window.nix].name = $("#nevigation-name").text();
    dbjs.table = "navigation";
    dbjs.set( { "name" : name }, "`id` = '" + window.nt + "'", 1, function(msg) {  
    } );   
}

// update sub menu items
function update_nav_subitems() {
    var subitems = window.navigation[window.nix].subitems = $("#nevigation-ta").val();    
    dbjs.table = "navigation";
    dbjs.set( { "subitems" : subitems }, "`id` = '" + window.nt + "'", 1, function(msg) {  
    } );
} 

// update main tab url
function update_nav_url() {
    var url = window.navigation[window.nix].url = $("#nevigation-url").text(); 
    dbjs.table = "navigation";
    dbjs.set( { "url" : url }, "`id` = '" + window.nt + "'", 1, function(msg) { } );
}

function update_ddn_arrow(nav_ix, state) {
    if (state == 1)
        $(".drop-down", "#nav-" + nav_ix).addClass("on");
    else
        $(".drop-down", "#nav-" + nav_ix).removeClass("on");
    dbjs.table = "navigation";
    dbjs.set( { "is_dropdown" : state }, "`id` = '" + window.nt + "'", 1, function(msg) { } );
}

// load navi tab details (secondary options)
function nav_load_details(nav_ix) {
    select_navi(nav_ix);
    /* dbjs.table = "navigation";
    dbjs.get( "*", "`nav_id` = '" + nav_ix + "'", "", 1, function(msg) {
        var id = mysql[0].id;
        var nav_id = mysql[0].nav_id;
        var name = mysql[0].name;
        alert(name);
    }); */
    // alert(JSON.stringify(window.navigation));
    // var name = window.navigation[nav_ix].name;
    var url = window.navigation[nav_ix].url;
    var subitems = window.navigation[nav_ix].subitems;
    // alert(url);
    $("#nevigation-url").html(url);
    $("#nevigation-ta").html(subitems);
}
$(document).ready(function() {

    window.navigation_num = 0;
 
	$.ajax( { url: "getnavigation.php", success: function(msg) {
		var j = JSON.parse(msg);		
		var i = 0;
		while (j[i]) {
			var id = j[i].id;
			var name = j[i].name;
			var priority = j[i].priority;
			var subitems = j[i].subitems;
			var is_dropdown = j[i].is_dropdown;
			var url = j[i].url;
			var special_bg = j[i].special_bg;
            ins_navi(id, name, priority, subitems, is_dropdown, url, special_bg);
            project_navi(i, name, id, i, priority,is_dropdown);
            i++;
        }
        select_navi(0);
        nav_load_details(0);
    }});
    
    // make draggable
    $("#navi-pool").sortable( {
            stop : function(event, ui) {
                var list = $("#navi-pool").sortable('toArray');
                //alert(list);
                var arr = [];
                var txt = "";
                for(var i = 0; i < list.length; i++) {
                    if (list[i] != "") {
                        arr[arr.length] = list[i];
                        if (i > 0) txt += "|";
                        txt += list[i].split("-")[1];
                    }
                }
                $.ajax( {
                    url : "reorder-navi-items-2.php",
                    type : "POST",
                    data : { "txt" : txt },
                    success : function(msg) {
                    //alert(msg);
                    
//                    console.log("reorder-navi-items-2.php: " + msg);
                    
                        var ix = 0;
                        $("#navi-pool li").each(function(msg) {
                            $(this).attr("order", ix++);
                        } );
                    }
                } );
    } } );
    
} );

function add_navi_item() {
var p = window.navigation_num + 1;
	dbjs.table = "navigation";
	dbjs.insert( { name: "Sample", priority: p, subitems: "", is_dropdown: "0", url: "http://www.sample.com/page.html", special_bg:"",nav_id:0 },
	function(msg) {
	    var key_id = dbjs.last_id;
	    project_navi(window.navigation_num, "Sample", key_id, 0, p);
        ins_navi(key_id, "Sample", p, "", 0, "http://www.sample.com/page.html", 0);
	} );
}

function remove_nav_item(index) {
    var key = window.navigation[index].id;
    dbjs.table = "navigation";
    dbjs.remove("`id` = '" + key + "'", 1, function(msg) { } );
	$("#nav-" + key).remove();
}

function project_navi(id, name, keyid, order, priority, is_dropdown) {
    var on = "";
    if (is_dropdown == 1) on = " on";
    $("#navi-pool").append('<li style = "position:relative;" index = "'+id+'" priority = "' + priority + '" keyid = "'+keyid+'" class = "nav-item" id = "nav-'+keyid+'" onclick = "nav_load_details('+id+')">'+name+'<div class = "minus" onclick = "remove_nav_item(' + id + ')"></div><div class = "drop-down' + on + '"></div></li>');
}

function ins_navi(id,name,priority,subitems,is_dropdown,url,special_bg) {
    window.navigation[window.navigation_num++] = {
        "id" : id,
        "name" : name,
        "priority" : priority,
        "subitems" : subitems,
        "is_dropdown" : is_dropdown,
        "url" : url,
        "special_bg" : special_bg
    };
}