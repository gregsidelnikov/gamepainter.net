/* Update Social Button Counters */
function get_social_counts() {
    //var twitter_html = $("iframe.twitter-share-button.twitter-count-horizontal").contents();//.find("body");

    //alert(twitter_html.text());

    $(".twitter_count").text(1);
}

$(document).ready(function(){get_social_counts()});