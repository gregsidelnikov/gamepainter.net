<?php
  // Adds a new bio to the database, setting user preferences to 0
  // used at new user sign up only (execbio.php)
  // this function automatically assumes bio information to be passed with $_POST array from execbio.php

  function add_biography($addslashes = 1, $personality_type = 127)
  {
    global $passwordtype,
           $email,
           $password,
           $first_name,
           $last_name,
           $display_name,
           $country,
           $state,
           $gender,
           $birthdate,
           $bio,
           $creation_time,
           $relationship,
           $occupation,
           $USER_SET_ALL;

           $prefs = 0; // reset preferences

           if ($addslashes == 1)
               $bio = addslashes($bio);

           $vals = array($email,$password,$birthdate,$gender,$first_name,$last_name,$display_name,$country,$state,$relationship,$occupation,$creation_time,$bio,$personality_type,$prefs,0,0,0,'','','',0);

           if (insert_table_data("user", $USER_SET_ALL, $vals))
               return true;
  }

?>