<?php

  // QSession - PHP session handling
  // Copyright Greg Sidelnikov

  // function.Session.php 
  // *Important - SERVER PATH IS MODIFIED from server to server*

  // Where :  10 : $login_page (possibly deprecated)
  // Where : 200 : setcookie("asid", $key, time() + $logoutafter, "/", false); // false should be a server http/URL for non localhost setups
  // the login_page is the only page on the site that allows a user to log in
  // for added security, this session script tests for this url on log in sequence to prevent attempts to log in from other pages
  // the login page string should be stored in the "Migration/Composition.php" file

  /* INFO: connection pooling -- perhaps not a significant improvement after all
                              -- number of persistent connections is limited by MySQL

     One of the advantages over CGI is that a Servlet can keep information between requests and share common resources.
     One common use of this feature is a database connection pool.
     Connection pooling is a technique used to avoid the overhead of making a new database connection every time an application or
     server object requires access to a database. A dynamic web site often generates HTML pages from information stored in a database.
     Each request for a page results in a database access. The database access itself is not the bottleneck, but setting up a new connection
     for each request often is. A database connection pool avoids this bottleneck. The overhead time for establishing a database connection is typically around 1 to 3 seconds.
     This is the time it takes to locate the database server, establish a communication channel with it, exchange information.
     For many web applications the database connect time can become the dominant factor in its usability,
     especially if it is used over the internet versus a corporate network.
  */

  // functions in this file:
  // q_isLoggedIn                      checks to see if the current user is logged in
  // q_session_count_online            checks how many sessions were active within past 900 seconds (or 15 minutes)
  // q_session_get                     get information about a session, return false if session doesn't exist
  // q_session_load                    loads a session by id
  // q_session_save
  // q_session_login_sequence          called on user login
  // q_session_clear                   clear current user information (used to log out)
  // q_session_force_delete            removes session row from mysql database

  $qsession = array("user"                 => 0, // this is user "key" id
                    "display_name"         => 0,
                    "email_address"        => 0,
                    "status"               => 0, // current online status; 0 = offline, 1 = online
                    "expires_on"           => 0, // time this session expires on
                    "last_page_url"        => 0, // last page user was visiting
                    "last_page_opened_on"  => 0, // time when user opened the page specified in last_page_url
                    "seconds_spent_online" => 0, // total seconds spent online
                    "logged_in_times"      => 0  // number of successful logg-ins
                   );

  function q_isLoggedIn() {
    global $qsession;
    $asid = $qsession["user"];
    if ($qsession['status'] == 3)
        return false; // 3 is the code for Forced Logout
    if (is_numeric($asid) && $asid > 0)
      return true;
    return false;
  }

  function q_session_count_online() {
    $t = time();
    if (($q = mysql_query("SELECT COUNT(*) FROM `session` WHERE ($t - last_page_opened_on) < 900 LIMIT 1")) != FALSE) {
      if (($r = mysql_fetch_row($q)) != FALSE) {
        return $r;
      }
    }
    return false;
  }

  function q_session_get($asid) {
    if (($q = mysql_query("SELECT email_address, status, expires_on, last_page_url, last_page_opened_on, seconds_spent_online, logged_in_times, display_name FROM `session` WHERE user='$asid' LIMIT 1")) != FALSE) {
      if (($r = mysql_fetch_row($q)) != FALSE) {
        return $r;
      }
    }
    return false;
  }

  function q_session_load($asid) {

    global $qsession;
    if (($q = mysql_query("SELECT email_address,status,expires_on,last_page_url,last_page_opened_on,seconds_spent_online,logged_in_times,display_name FROM `session` WHERE user='$asid' LIMIT 1")) != FALSE) {
      if (($r = mysql_fetch_row($q)) != FALSE) {
        $qsession["user"] = $asid;
        $qsession["email_address"] = $r[0];
        $qsession["status"] = $r[1];
        $qsession["expires_on"] = $r[2];
        $qsession["last_page_url"] = $r[3];
        $qsession["last_page_opened_on"] = $r[4];
        $qsession["seconds_spent_online"] = $r[5];
        $qsession["logged_in_times"] = $r[6];
        $qsession["display_name"] = $r[7];
      }
    }

    if (mysql_error())
    {
      print mysql_error();
      return false;
    }

    //print "q session load:<br>" . print_g($qsession);
    return true;

  }

  function q_session_save($current_user = -1) { // current_user has no function
    global $qsession;

    //if ($current_user == -1)
      $sess_user = $qsession["user"];
  //  else
//    $sess_user = $current_user;

    $sess_email_address = $qsession["email_address"];
    $sess_status = $qsession["status"];
    $sess_expires_on = $qsession["expires_on"];
    $sess_last_page_url = $qsession["last_page_url"];
    $sess_last_page_opened_on = $qsession["last_page_opened_on"];
    $sess_seconds_spent_online = $qsession["seconds_spent_online"];
    $sess_logged_in_times = $qsession["logged_in_times"];
    $sess_display_name = $qsession["display_name"];

    if ($sess_user == 0)
      return false;

    if (($q = mysql_query("SELECT `key` FROM `session` WHERE `user`='$sess_user' LIMIT 1")) != FALSE)
      if (($r = mysql_fetch_row($q)) != FALSE) {
        //print "q_session_save:<br>"; print_g($qsession);
        $q = mysql_query("update `session` set email_address='$sess_email_address', user='$sess_user', status='$sess_status', expires_on='$sess_expires_on', last_page_url='$sess_last_page_url', last_page_opened_on='$sess_last_page_opened_on', seconds_spent_online='$sess_seconds_spent_online', logged_in_times='$sess_logged_in_times', display_name='$sess_display_name' WHERE `user`='$sess_user' LIMIT 1");
      } else { // session never existed, attempt inserting session data
        $q = mysql_query("insert into `session` (email_address,user,status,expires_on,last_page_url,last_page_opened_on,seconds_spent_online,logged_in_times,display_name,ip_haystack) VALUES ('$sess_email_address','$sess_user','$sess_status','$sess_expires_on','$sess_last_page_url','$sess_last_page_opened_on','$sess_seconds_spent_online','$sess_logged_in_times', '$sess_display_name','')");
      }

    // Do we have an error?
    if (mysql_error())
    {
      print mysql_error();
      return false;
    }

    return true;
  }

  // this function is called to 1. authenticate a new log in, or 2. update currently logged in status, if already logged in
  // this function must be called on all pages
  // this is for a non-persistent database connection design
  // in other words, it assumes no pooling
  function q_session_login_sequence() {
    global $qsession;
    global $login_page;
    global $siteUrl;
    global $err;
    global $erc;

    if (isset($_COOKIE['asid']))
        $asid = $_COOKIE['asid'];

    //print_g($_COOKIE); // output here is not allowed, since we are using setcookie below, and it needs to be sent before any other data/headers
                         // apparently headers are auto-inserted

    if (is_numeric($asid))
      q_session_load($asid);

    $status = $qsession["status"];

    //print "status = $status<br>";

    if ($status == 3)
    {
        //return false;
         $status = 0;
    }

    if ($status == 0) { // not yet logged in, so log in if there was a request to log in

    //print "q_session_login_sequence: not yet logged in...<br>";

      //$ref = getenv('HTTP_REFERER');

      //print "<hr>ref=$ref<br>login_page=$login_page<br>";

      if (true/*$login_page == $ref || $ref == "http://localhost/root/index.php"*/)
      {
        if ($_REQUEST['action'] == "login")
        {
            //print "action = login<br>";

            //$id = strtolower($_REQUEST['id']); // login id
            $id = strtolower($_REQUEST['a']); // login id

            //$entered_password = strtolower($_REQUEST['password']); // password
            $entered_password = $_REQUEST['b'];

            clerr(); /*clear error descriptors in preparation for error handling for a new unique case*/

            //print "id=$id.";

               if ($id == '')
                   adderr("ID field cannot be empty.");
               if (strlen($entered_password) < 8)
                   adderr("Password must be at least 8 characters in length.");
               // identify the type of id handle (email,username or chatcake id)
               if (is_numeric($id)) // ID
                   $qlid = "`key` = '$id'";
               else // email address?
               if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $id))
                   $qlid = "`email_address` = '$id'";

            //print ">>>".$id."<<<";

               $query = "SELECT `email_address`,`password`,`key`,`display_name` FROM `user` WHERE $qlid AND `password` = '" . md5($entered_password) . "' LIMIT 1";

               // run a mysql query to match user id with password
               if (($q = mysql_query( $query ))!=FALSE)
               {
                   if (($r = mysql_fetch_row( $q ))!=FALSE)
                   {
                       $email_address = strtolower($r[0]);
                       $password      = strtolower($r[1]);
                       $key           = $r[2];
                       $display_name  = $r[3];

                       //print_r($r[2] . "," . $entered_password);

                       if ($password != md5($entered_password))
                           adderr("Wrong login credentials, check your username and password (3)" . mysql_error());
                   } else
                       adderr("Wrong login credentials, check your username and password (2) " . mysql_error());
               } else
                  adderr("Wrong login credentials, check your username and password (1)" . mysql_error());

          if (iserr())
          {
              // There has been an error...
              print "Bad Login Initiation№\r\nThere were " . $erc . " problem(s) with the login credentials you submitted:<p>";
              for ($i=0;$i<$erc;$i++)
                  print "- ".$err[$i]."<p>";
              exit;

          } else {

              // login ok

              $logoutafter = 10000000;//$_POST['logoutcondition'];

              // Keep cookie for whatevers in logout condition

              // Already logged in?

              // This is done to avoid writing more than one cookie with the same name when a user is trying to log in when already logged in
              // This is commonly fired when a user is signing on for the first time without a cookie
              if (!is_numeric($_COOKIE["asid"]))
                  setcookie("asid", $key, time() + $logoutafter, "/", false);

              q_session_load( $key );

              $qsession["user"]                   = $key;
              $qsession["status"]                 = 1;
              $qsession["email_address"]          = $email_address;
              $qsession["expires_on"]             = 0; // 0 = never expire? //time() + 1000000; // expire in a while...
              $qsession["last_page_url"]          = Utility::GetSelfUrl();//$siteUrl + $PHP_SELF;
              $qsession["last_page_opened_on"]    = time();
              $qsession["logged_in_times"]        = $qsession["logged_in_times"] + 1;
              $qsession["display_name"]           = $display_name;

              //print_g($qsession);

              if ( q_session_save() )
              {
                  // for ajax - 1 == logged in
                  print "<loggedin>1</loggedin>";
                  return true;
              }
          }
        }
      }

      // at this point, if referer isn't the login page, and status = 0
      // there is no logged in user, so, nothing to load

    } else { // process logged in information, user is already logged in

    //print "q_session_login_sequence: already logged in (status = $status) ...<br>";

    //~~~~~~TODO: if status in db is 4 (Expired) or 3 (Force Sign Out) then do not consider the following steps and sign out!
    //     ~TODO: also here might want to check if the session has expired as well, but this is questionable and not sure how would affect other functionality...

      if ($_COOKIE['asid']) {

        if (is_numeric($_COOKIE['asid'])) {

        q_session_load($_COOKIE['asid']);

        $last_page_url = $qsession["last_page_url"];
        $last_page_opened_on = $qsession["last_page_opened_on"];

        // store the time when current page has been opened
        $qsession["last_page_opened_on"] = time();

        // if last current page is accessed within last 15 minutes from previous page, add the difference to seconds_spent_online
        if ($last_page_opened_on == 0)
          $qsession["seconds_spent_online"] = time(); // first time
        else
          if (is_numeric($last_page_opened_on)) {
            $timediff = time() - $last_page_opened_on;
            if ($timediff > 0 && $timediff <= 900)
              $qsession["seconds_spent_online"] += $timediff;
            else { } // do nothing if user is "away" for over 15 minutes
          }

          q_session_save();

          } // end is cookie numeric ?

        } else { // session cookie has expired, so sign off

        q_session_clear();

      }

    } // end if (status == 0)

    //print_g($qsession); // display session status, at the bottom of this file (important), because we're using setcookie(...) above
    //print_g($_POST);
  }

  function q_session_clear() {

    global $qsession;

    $current_user = $qsession["user"];

    $qsession["user"] = 0;
    $qsession["email_address"] = "pending delete";
    $qsession["status"] = 0;
    $qsession["expires_on"] = time()-100000000;
    $qsession["display_name"] = "anonymous";

    q_session_save($current_user);
  }

  function q_session_force_delete($u_id) {

      // Status 3 is FORCED LOG OUT, authentication must be ignored.
      if (mysql_query("UPDATE `session` SET `status` = '3', `expires_on` = '1' WHERE `user`= '$u_id' LIMIT 1") !=  FALSE)
      {
          q_session_clear();
          //print "mysql logout successful";
      }
      else
      {
          print "mysql failed with" . mysql_error();
      }
  }

  function ensure_logged_in_state($u_id) {
      mysql_query("UPDATE `session` SET `status` = '1' WHERE `user`= '$u_id' LIMIT 1");
  }

?>