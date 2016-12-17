<?php
  // classes in this file:
// final class Session               the main session class, may not be overriden
final class Session                  // the session class may not be overriden
    {
    public $m_user;

    public $m_displayName;

    public $m_emailAddress;

    public $m_status;

    public $m_expiresOn;

    public $m_lastPageURL;

    public $m_lastPageTimeSince;

    public $m_loggedInTimes;

    public $m_isLoggedIn;

    // Boolean

    // Load session
    function __construct()
    {
        // We must release database connection object if user is logging out (it is possible to execute logout from any page)
        //global $selfURL;
        if (strpos(Utility::GetSelfUrl(), "log=out") != false)
        {
            q_session_clear();
            setcookie("asid", "pending delete", time()-10000000, "/", false);
        }
        else
        {
            if ( q_session_login_sequence() )
                $m_isLoggedIn = true;
        }
    }

    // Interface:
    function Disconnect()
    {
        q_session_clear();
    }
}

?>