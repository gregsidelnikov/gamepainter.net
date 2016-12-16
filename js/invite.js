var InviteEmailArray = [];

var InviteNameArray = [];

var TotalInvitations = 0;

var CurrentInvitation = 0;

var friendinvitecount = [1];

function correctemail(e)
{
    if (/^([\w]+)(.[\w]+)*@([\w]+)\.([\w]{2,3}){1,3}$/.test(e))
        return true;
    return false;
}

function AddNextFriendInvite()
{
    var IDX = friendinvitecount.length;
    friendinvitecount[IDX] = 1;
    var invitetext = '<div class = "EnterName"><input type = "text" style = "width:50px;" id = "finvna' + friendinvitecount.length + '" /></div><div class = "EnterEmail"><input type = "text" style = "width:100px;" id = "finvem' + friendinvitecount.length + '" onkeyup = "AddFriendInvite(' + (friendinvitecount.length) + ',this)" /></div><div class = "LoadingIcon" id = "LoadingIcon' + (friendinvitecount.length-1) + '"></div><div style = "clear:both;"></div><div id = "AddMoreInvites' + (friendinvitecount.length) + '"></div>';
    $('#AddMoreInvites' + IDX).html( invitetext );
}
function AddFriendInvite(next, email)
{
    var IDX = friendinvitecount.length;
    if (correctemail(email.value)) {
        if (next == 0 || IDX == next) {
            friendinvitecount[IDX] = 1;
            var invitetext = '<div class = "EnterName"><input type = "text" style = "width:50px;" id = "finvna' + friendinvitecount.length + '" /></div><div class = "EnterEmail"><input type = "text" style = "width:100px;" id = "finvem' + friendinvitecount.length + '" onkeyup = "AddFriendInvite(' + (friendinvitecount.length) + ',this)" /></div><div class = "LoadingIcon" id = "LoadingIcon' + (friendinvitecount.length-1) + '"></div><div style = "clear:both;"></div><div id = "AddMoreInvites' + (friendinvitecount.length) + '"></div>';
            //alert('Adding to ' + IDX);
            $('#AddMoreInvites' + IDX).html( invitetext );
        }
    }
}
function SendInvitations(senderid,sendername)
{
    TotalInvitations = friendinvitecount.length;

    for (var i = 0; i < TotalInvitations + 1; i++)
    {
        $('#LoadingIcon' + i).html('<div style = "position:absolute;top:1px;left:8px;width:150px;height:16px; color:silver;"><img src = \'http://www.authenticsociety.com/Images/Icons/loadinfo.net.gif\' align = "top" /> Sending</div>');
        InviteEmailArray[i] = $('#finvem' + i).val();
        InviteNameArray[i] = $('#finvna' + i).val();

        // make sure we remove all divs containing empty email
        if (InviteEmailArray[i] == '')
        {
            $('#AddMoreInvites' + (i-1)).hide();
        }
    }

    // Send first invitation
    ajax.httpExecute(SuccessEvent_SendEmailInvitation, SENDEMAILINVITATION, [$('#finvna0').val(), $('#finvem0').val()]);


    //
}