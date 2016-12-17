var poem = { /*"gallery5.jpg": { "title" : "Poem Title", "text": "poem<br/>text" }*/ }
function show_image(src)
{
	$("#current img").attr("src", src);
	$("#viewer").fadeIn(300);
	if (poem[src])
		$("#viewer table td:nth-child(2)").html("<b>" + poem[src].title + "</b>" + "<p>" + poem[src].text + "</p>");
	else
		$("#viewer table td:nth-child(2)").html("");
}
var arrimi = 0;
var arrimg = [];
$(document).ready(function() {
	$("#Main .image img").each(function(obj) {
	    arrimg[arrimg.length] = $(this).attr("src");
	    $(this).attr("index", arrimg.length - 1);
	});
	$("#Main .image img").on("click", function(obj) {
	    var src = $(this).attr("src");
	    show_image(src);
	    arrimi = parseInt($(this).attr("index"));
	});
});

function prev() {
    if (arrimi > 0) {
        arrimi--;
	show_image(arrimg[arrimi]);
    }
}

function next() {
    if (arrimi < arrimg.length) {
        arrimi++;
	show_image(arrimg[arrimi]);
    }
}