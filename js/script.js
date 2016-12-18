function view(id) {
    $(".MenuOption").removeClass("Selected");
    var idd = $(id).attr("id");
    var uid = $(id).attr("ui");
    $("#Browse, #RegisterAccount, #Login").hide();
    $(uid).show();
    $("#" + $(id).attr("id")).addClass("Selected");
}
function ValidateEmail( email ) {
    if( /(.+)@(.+){2,}\.(.+){2,}/.test( email ) ){ return true; } else { return false; }
}
function ValidateUsername( username ) {
    if( /^[a-zA-Z][a-z\.A-Z\-]+$/.test( username ) ) { return true; } else { return false; }
}
function Id() {
    var token = localStorage.getItem("token");
    if (token == 0) return token;
    $.ajax( { "url" : website.url + "/ajax/getuserid.php",
        "data" : { "token" : token },
        "method" : "post",
        success: function(msg) {
            localStorage.setItem("id", msg);
            return msg;
        } } );
}
function UpdateUserUI(msg) {
    if (msg == null) msg = 0;
    if (msg != 0 && msg.length > 8) {
        $("#loggedin_email").show();
        $("#loggedin_email").text(localStorage.getItem('email'));
        $("#loggedin_status").text("Logged in as");
        $("#logout_button").show();
    } else {
        $("#loggedin_email").hide();
        $("#loggedin_email").text("");
        $("#loggedin_status").text("Log in to make games");
        $("#logout_button").hide();
    }
}
function LogOut() {
    localStorage.setItem("token", 0);
    localStorage.setItem("email", "");
    UpdateUserUI(0);
    location.href = '<?php print $URL; ?>';
}
function SignIn() {
    var email = $("#login_email_address").val();
    var pass = $("#login_password").val();
    $("#signin_button").prop("disabled", true);
    $.ajax( { "url" : website.url + "/ajax/login.php",
        "data" : {
            "email" : email,
            "password" : pass,
        }, "method" : "post",
        success: function(msg) {
            //console.log(msg);
            if (msg == 0) {
                $("#msg").html('No such email and password combination. Note, your account must be verified in order to validate a sign in attempt.');
                $("#signin_button").prop("disabled", false); }
            else
            if (msg == 1)  {
                $("#msg").html("Please wait... Logging in...");
                $.ajax( { "url" : website.url + "/ajax/makepasswordtoken.php",
                    "data" : { "email" : email, "password" : pass },
                    "method" : "post",
                    success: function(msg) {
                        localStorage.setItem("token", msg);
                        localStorage.setItem("email", email);
                        UpdateUserUI(msg);
                        if (msg != 0 && msg.length > 8)
                            location.href = website.url;
                    } } );
                $("#msg").html('You\'ve successfully logged in. Go make games now! <a href = "<?php print $URL; ?>/create">Create New Game</a>');
            }  else $("#msg").html(msg);
        }
    });
}
function RegisterUser() {
    if (!ValidateEmail($('#email_address').val())) {
        $("#msg").html("Email address must be in correct format.");
        return;
    }
    if (!ValidateUsername($('#username').val())) {
        $("#msg").html("Username must be alphanumeric, must start with a letter, and can only contain (A-z0-9._- )");
        return;
    }
    if ($("#password").val().length <= 4) {
        $("#msg").html("Passwords must be greater than 4 characters.");
        return;
    }
    if ($("#password").val() != $("#password2").val()) {
        $("#msg").html("Passwords do not match.");
        return;
    }
    $("#register_button").prop("disabled", true);
    $.ajax( { "url" : website.url + "/ajax/createuser.php",
        "data" : {
            "email" : $("#email_address").val(),
            "password" : $("#password").val()
        },
        "method" : "post",
        success: function(msg) {
            $("#msg").html(msg);
            $("#register_button").prop("disabled", false);
        }
    } );
}
function CreateGame() {
    $("#GameList").hide();
    $("#CreateGame").show();
}
function ToggleSidebar() {
    if (window.sidebar == "true") {
        localStorage.setItem('sidebar', "false");
        window.sidebar = "false";
        $('body').removeClass("Sidebar");
        return;
    }
    if (window.sidebar == "false")  {
        localStorage.setItem('sidebar', "true");
        window.sidebar = "true";
        $('body').addClass("Sidebar");
        return;
    }
}
function Sidebar() {
    console.log("window.sidebar=" + window.sidebar);
    $('body').removeClass("Sidebar");
    window.sidebar = localStorage.getItem('sidebar');
    if (window.sidebar == "true") {
        $('body').addClass("Sidebar");
    } else {
        localStorage.setItem('sidebar', "false");
    }
}
function IsMobile() { if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { window.mobile = true; $("body *").addClass("IncreaseFontSize"); } }
function Resize() {
    var w = $(window).width();
    if (w < 800) {
        localStorage.setItem('sidebar', "false");
        window.sidebar = "false";
        $('body').removeClass("Sidebar");
    }
}
$(window).resize(function() { Resize(); });
$(window).load(function() { Resize(); });
$(document).ready(function() {
    UpdateUserUI(localStorage.getItem('token'));
    IsMobile();
    Resize();
    Sidebar();
});