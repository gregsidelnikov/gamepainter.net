/* Library that bridges PHP mysql and JavaScript */
window.url = window.website.url;
window.mysql = new Object();
window.mysql.length = 0;
function is_json(str) { try { JSON.parse(str); } catch (e) { return false; } return true; }
var dbjs = function() {

    this.table = ''; // table context
    this.got = null;
    //this.out = '';
    this.get = function(item_array, where, order, limit, callback, index_param) {
        if (index_param == undefined || index_param == "")
            index_param = 0;
        var action = { "action": "get", "table": this.table, "order": order, "where": where, "limit": limit, "index_param": index_param };

        //alert(JSON.stringify(action));

        $.ajax( { 'url' : window.url + '/plugins/jsdb/lib.php', data: { "payload": item_array, "action": action }, success: function(msg) {
            //alert(JSON.stringify(window.msg));
            //alert(msg);
            //alert(msg);            
            if (is_json(msg))
                window.mysql = JSON.parse(msg); 
            else
                console.log("jsdb.js: get() - msg failed json test: msg content is -->\r\n" + msg);
                
            // Count number of results
			var i = 0; 
            while (window.mysql[i++] != undefined)
                window.mysql.length++;
                
            if (callback != undefined)
                callback.call();
        }});
    };
    this.set = function(json, where, limit, callback) {
        var action = { "action": "set", "table": this.table, "where": where, "limit": limit };
        $.ajax( { 'url' : window.url + '/plugins/jsdb/lib.php', data: { "payload": json, "action": action }, success: function(msg) {
            //alert(msg);
             window.mysql = msg;
             if (callback != undefined)
                callback.call();
        }});
    };
    this.insert = function(json, callback) {
        var action = { "action": "insert", "table": this.table, "where": "", "limit": 0 };
        $.ajax( { 'url' : window.url + '/plugins/jsdb/lib.php', data: { "payload": json, "action": action }, success: function(msg) {
            //alert("dbjs.insert = " + msg);
            window.dbjs.last_id = msg;
            if (callback != undefined)
                callback.call();
        }});
    };
    this.remove = function(where, limit, callback) {
        var action = { "action": "remove", "table": this.table, "where": where, "limit": limit };
        $.ajax( { 'url' : window.url + '/plugins/jsdb/lib.php', data: { "payload": null, "action": action }, success: function(msg) {
            if (callback != undefined)
                callback.call();
        }});
    };
};

$(document).ready(function() {
    window.dbjs = new dbjs();
    //alert(window.dbjs);
    window.dbjs.last_id = 0;
});