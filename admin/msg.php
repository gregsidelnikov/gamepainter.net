<style>
#Msg { background: white; display:none;border:1px dotted silver; position: absolute; top: 58px; left: 150px; width: 450px; height: 200px;z-index: 100000000;padding:5px;}
#Msg #msg_subject { width: 445px; height: 18px; }
.redBorder { border:1px solid red !important; }
</style>

<div id = "Msg">
    <b id = "message_title"></b>
    <br/><br/>
    Email Subject Line:<br/>
    <span id = "msg_title"></span>
    <input type = "text" id = "msg_subject" /><br/>
    <input onclick = "dispatch_message()" type = "button" value = "Send" style = "width: 451px; background: gray !important; color: yellow !important; cursor:pointer;"/>
    <div id = "msg_status_send">
        Waiting...
    </div>
</div>
