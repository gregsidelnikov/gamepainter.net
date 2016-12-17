<html>
<head>
<meta itemprop="name" content=""/>
<meta itemprop="description" content=""/>
<audio preload src="music.mp3" id="mus"></audio>
<audio preload src="scream.mp3" id="scream"></audio>
<audio preload src="scream2.mp3" id="scream2"></audio>
<audio preload src="bullet.mp3" id="bullet"></audio>
<title>T</title>
<script type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script>
var hours = 0;
var minutes = 0;
var seconds = 0;
var lasthour = 0;
var lastminute = 0;
var real_minutes = 0;
function gettime()
{
    var pm = 'PM';
    var currentTime = new Date();
    hours = currentTime.getHours();
    real_minutes = minutes = currentTime.getMinutes();
    seconds = currentTime.getSeconds();
    if (minutes < 10)
        minutes = "0" + minutes;
    if (seconds < 10)
        seconds = "0" + seconds;
    if(hours > 11)
        pm = "PM";
    else
        pm = "AM";
    $("#timenow").text(hours + ":" + minutes + ":" + seconds + pm);
        
    if (minutes != lastminute)
    {
        lastminute = minutes;
        if (  $('#minute' + (real_minutes-1)).hasClass('red')  )
        {
            // Remove marker
            $('#minute' + (real_minutes-1)).removeClass('red'); 
            // Just in case. . .
            $('#minute' + (real_minutes-2)).removeClass('red'); 
            // Dispatch the tweet...
            tweet();
        }
    }
    
    $('table tr td div').removeClass('green');
    $('table tr td:nth-child(' + hours + ') div.hour').addClass('green'); 
    $('table tr td:nth-child(' + real_minutes + ') div.minute').addClass('green'); 
    
    // Reschedule every hour
    if (hours != lasthour)
    {
        lasthour = hours;
        reschedule(hours);
    }
}
function RandomNumberExcept ( max, ar_except ) { var r = except; while (true) { r = Math.floor(Math.random() * max); for(var i=0;i<ar_except.length;i++){ if (ar_except[i] == r) continue; } } return r; }
function reschedule(x,y)
{
    var already_done = [];
    var total_num = $('#knobn' + (x - 1)).html();
    $('td div').removeClass('red');

    var rsc = 0;
    if (y)
        rsc = real_minutes;

    for (var t=0;t<total_num;t++) {
        var new_pos = randomInt(rsc, 60);
        already_done[t] = new_pos; 
    }
    //alert(already_done);
    for (var i=0;i<already_done.length;i++)
        $('#minute' + already_done[i]).addClass('red');
}
function redrawlines(t)
{
    var id = parseInt(t.replace('knob',''));
    $('#knobn' + id).text(Math.round((parseInt($('#' + t).css('top')))));
    var vals = '';
    for (var i = 0; i < 24; i++)
    {
        vals += '' + parseInt($('#knob' + i).css('top')) + ',';
    }
   $('#schmsg').val(vals);
}
function setschedule(sc)
{
    var times = sc.split(',');
    for (var i=0;i<24;i++)
    {
        var tm = times[i];
        $('#knob' + i).stop().animate({'top': tm + 'px'},500);
        $('#knobn' + i).text(parseInt(  parseInt(tm) )  );
    }
}
function tweet()
{
    var fro = $('#Queue :first').html();
    
    if (fro == 'null' || fro == null)
        return;
    
    var mes = encodeURIComponent( fro );
    
    if (mes == 'null' || mes == null || mes == "" || mes == undefined)
    {
        return;
    }

    // Tweet!
    $.ajax({url:'tweet.php?msg=' + mes,type:'post'});
    
    // queue up next message..
    if ($('#requeue').is(':checked'))
        $('#Queue').html(   $('#Queue').html() + '<div class = \'message\'>' + $('#Queue :first').html() + '</div>'   );
    
    $('#Queue :first').remove();
    $('#Queue :first').css('background-color','yellow');
    
    send.play();
}
function randomInt(min, max)
{
    return Math.round(min + Math.random()*(max-min));
}
function twitch()
{
    for (var i=0;i<24;i++)
    {
        var twit = randomInt(1,3);
        var mult = 1;
        if (randomInt(0,1)==1)
            mult = -mult;
        twit = twit * mult;
        if ((parseInt( $('#knob' + i).css('top') ) + twit) > 0)
        {
            $('#knob' + i).stop().animate({top: '+=' + twit + 'px'}, 500);
            $('#knobn' + i).html( parseInt( $('#knob' + i).css('top') ) );
        }
    }
}

function less()
{
    for (var i=0;i<24;i++)
    {
        var twit = 1;
        if ((parseInt( $('#knob' + i).css('top') ) - twit) > 0)
        {
            $('#knob' + i).stop().animate({top: '-=' + twit + 'px'}, 500);
            $('#knobn' + i).html( parseInt( $('#knob' + i).css('top') ) );
        }
    }
}

function more()
{
    for (var i=0;i<24;i++)
    {
        var twit = 1;
        if ((parseInt( $('#knob' + i).css('top') ) + twit) > 0)
        {
            $('#knob' + i).stop().animate({top: '+=' + twit + 'px'}, 500);
            $('#knobn' + i).html( parseInt( $('#knob' + i).css('top') ) );
        }
    }
}
var send = null;
$(document).ready(function()
{
    send = document.getElementById("send");
    setInterval("gettime()", 500);
    $( ".knob" ).draggable( { containment: "parent", grid: [ 1, 1 ], axis: "y", drag: function() { redrawlines($(this).attr('id')); } } ); // make knobs draggable...
    $('#Queue :first').css('background-color','yellow');
    $('.message div').bind('onclick', function(){ $(this).parent().remove(); });
    setschedule('9,5,3,0,0,0,3,4,7,12,14,17,18,18,15,9,5,2,0,1,1,6,8,11');
    reschedule(real_minutes, true);
});
function skip()
{
    // queue up next message..
    $('#Queue').html( $('#Queue').html() + '<div class = \'message\'>' + $('#Queue :first').html() + '</div>' );
    $('#Queue :first').remove();
    $('#Queue :first').css('background-color','yellow');
}
function delete_next()
{
    // queue up next message..
    $('#Queue :first').remove();
    $('#Queue :first').css('background-color','yellow');
}
</script>
</head>
<body>
<style>
#msg { width: 300px; height: 80px; border: 1px solid gray; font-size: 16px; }
.message { position: relative; width: 300px; border: 1px solid gray; border-top: 0;  padding: 5px; font-family: Arial, sans-serif; font-size: 12px; }
.message div { position: absolute; top: 0; right: 0; width: 8px; height: 8px; padding: 4px;}
#time { position: absolute; top: 10px; padding: 16px; left: 350px; border: 1px solid gray; }
.hour { position: relative; float: left; width: 20px; height: 5px; background-color: silver; border-right: 2px solid gray; }
.minute { position: relative; float: left; width: 8px; height: 7px; background-color: silver; border-right: 2px solid gray; }
.green { background-color: green !important; }
.green .vert { position: absolute; top:-6px; left: 3px; height: 20px; width: 2px; background-color: green; }
.red { background-color: #ff3200 !important; }
.knobcontainer { position: relative; width: 20px; height: 100px; margin-top: 5px; }
.knob { cursor: pointer; position: absolute; top: 0; left: 5px; width: 10px; height: 10px; background: url('knob.png') no-repeat }
.knobn { position: absolute; top: 20px; color: #000000; font-size: 13px; text-align: center; width: 10px; }
</style>
<audio preload src="tweet.mp3" id="send"></audio>
<div id = "Container">
    <div id = "Message"><textarea id = "msg" onclick = "this.select()"
    onkeydown = "$('#Length').html('Characters left: <b>' + (140 - this.value.length) + '</b>');"></textarea></div>
    <div id = "Length">Characters left: <b>140</b></div>
    <div>
        <input type = "button" value = "Add to Queue" onclick = "$('#Queue').html('<div class = \'message\'>' + $('#msg').val() + '</div>' + $('#Queue').html())">
        <input type = "button" value = "Move next tweet to bottom" onclick = "skip()"/><br/>
        <input type = "button" value = "Delete next tweet" onclick = "delete_next()">
        <input type = "button" value = "Send Next" onclick = "tweet()">        <br/>
        <input type = "checkbox" id = "requeue"> send to bottom again
    </div>
    <div style = "margin-top:16px;"><b>Coming Up Next:</b></div>
    <div id = "Queue" style = "">
        <div class = "message">The difference between a successful person and others is not a lack of strength, not a lack of knowledge, but rather a lack in will.</div>
    </div>
</div>
<div id = "time">
    <b>Time Now:</b> <span id = "timenow"></span><br/>
    <br/>
    <b>Hours</b><br/><br/>
    <div id = "Timeline">
        <table cellspacing = "0" cellpadding = "0">
        <tr>
        <?php
            for ($i = 0; $i < 24; $i++) 
            {
                ?><td style = 'color:gray; text-align: center;'><?php print $i + 1; ?></td><?php
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($i = 0; $i < 24; $i++) 
            {
                ?><td><div class = "hour"></div></td><?php
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($i = 0; $i < 24; $i++) 
            {
                ?><td><div class = "knobcontainer"><div id = "knob<?php print $i; ?>" class = "knob"><div class = "knobn" id = "knobn<?php print $i; ?>">0</div></div></div></td><?php
            }
        ?>
        </tr>

        </table>
    </div>
    <div id = "howoften">
        <input type = "button" value = "Level" onclick = "setschedule($(this).attr('schedule'))" schedule = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0">
        <input type = "button" value = "Organic" onclick = "setschedule($(this).attr('schedule'))" schedule = "0,0,0,0,0,0,0,0,0,2,0,0,3,2,1,1,0,1,1,0,3,0,3,2">
        <input type = "button" value = "1/hr." onclick = "setschedule($(this).attr('schedule'))" schedule = "1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1">
        <input type = "button" value = "2/hr." onclick = "setschedule($(this).attr('schedule'))" schedule = "2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2">
        <input type = "button" value = "Average Joe" onclick = "setschedule($(this).attr('schedule'))" schedule = "0,0,0,0,0,4,3,5,0,3,6,9,9,2,1,0,4,10,0,7,10,10,7,3">
        <input type = "button" value = "Night Owl" onclick = "setschedule($(this).attr('schedule'))" schedule = "3,3,3,3,3,2,1,1,1,0,0,0,0,0,1,2,3,3,3,3,3,3,3,3">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type = "button" value = "Earthquake!" onclick = "twitch()">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type = "button" value = "Lower" onclick = "less()">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type = "button" value = "Higher" onclick = "more()">  
        <textarea id = "schmsg" style = "width: 400px; border:0;" onclick = "this.select()"></textarea>
    </div>
    <b>Tweet schedule for this hour <u>by minute</u></b>:<br/><br/>
    <div id = "Timeline">
        <table cellspacing = "0" cellpadding = "0">
        <tr>
        <?php
            for ($i = 0; $i < 60; $i++) 
            {
            if (($i % 5)/5 == 1) {
                ?><td style = 'color:gray; text-align: center; font-size: 10px'><?php print $i + 1; ?></td><?php }
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($i = 0; $i < 60; $i++) 
            {
                ?><td><div id = "minute<?php print $i; ?>" onclick = "$(this).toggleClass('red')" class = "minute"><div class = "vert"></div></div></td><?php
            }
        ?>
        </tr>
        </table>
        <br/>
        <input type = "button" value = "Reschedule" onclick = "reschedule(hours)"/>
        <input type = "button" value = "Reschedule to remaining time only" onclick = "reschedule(hours,true)"/>
    </div>
</div>
</body>
</html>