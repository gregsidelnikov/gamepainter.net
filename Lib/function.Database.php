<?php

  /* functions:
   connect_to_database();           - starts session, connects to the database
   calcLoadTime();                  - calculates page load time
   stop();                          - disconnects from the database
   get_table_data(table,columns,order,limit)    - set colums of a table; returns an array, query parameters are specified in the function
   insert_table_data(...);          - update columns of a table
   array_to_list(...);              - convert a number of array values to a string (separated by comma)
   print_g();						- outputs an array enclosed in <pre> tags for clarity
   print_w();						- print warning (red border);
   clerr();                         - error tracking functions
   adderr();
   iserr();
   printerr();
  */

  // debug vars

  $PRINT_WARNINGS = 0;

  // user enums used with get_table_data(); and insert_table_data();
  // get..
  $USER_GET_SEC = array_to_list(array('key','email_address','password'), "`");
  $USER_GET_ALL = array_to_list(array('key','email_address','password','birthdate','gender','first_name','last_name','display_name','country','state','bio','prefs'), "`");
  $USER_GET_PRE = array_to_list(array('prefs'),"`");
  // set..
  $USER_SET_ALL = array(
    'email_address',
    'password',
    'birthdate',
    'gender',
    'first_name',
    'last_name',
    'display_name',
    'country',
    'state',
    'relationship',
    'occupation',
    'creation_time',
    'bio',
    'personality_type',
    'prefs',
    'last_login',
    'authenticity',
    'stats_article_visitors',
    'wish_had_more',
    'before_i_die',
    'community_list',
    'mana');
  $COMMENT_SET_ALL = array(
    'parent_type',
    'parent_id',
    'parent_secondary_id',
    'author_id',
    'author_username',
    'comment',
    'need_approve',
    'flag',
    'vote_up',
    'vote_down',
    'time');
  $COMMENT_GET_ALL = array_to_list(array(
    'key',
    'parent_type',
    'parent_id',
    'parent_secondary_id',
    'author_id',
    'author_username',
    'comment',
    'need_approve',
    'flag',
    'vote_up',
    'vote_down',
    'time'));
  $COMMENT_UPD = array('comment', 'time');

  // database connection, etc.

  $Connectionlink = "";
  $ltStart = 0;	// load time
  $ltTotal = 0;

  $err = array();
  $erc = 0;

  function clerr() { global $err; global $erc; $err = array(); $erc=0; }
  function adderr($msg) { global $err; global $erc; $err[$erc++] = $msg; }
  function iserr() { global $err; if (count($err) > 0) return true; else return false; }
  function printerr() { global $err; ?><pre><?php print_r($err); ?></pre><?php }

  function get_all_from($table_name)
  {
      $final_string = "";

      $table_names = explode(",", $table_name);

      $parts = count($table_names);

      //print_g($table_names);

      for ($q = 0; $q < $parts; $q++)
      {
          $i = 0;

          $a = array();

          $specialQuote = '`';

          if ($parts > 1)
              $specialQuote = '';

          $Result = mysql_query('SHOW COLUMNS FROM ' . $specialQuote . trim($table_names[$q]) . $specialQuote);

          while(($r = mysql_fetch_row($Result)) != FALSE)
          {
              if ($parts > 1)
                  $a[$i++] = trim($table_names[$q] . '.' . $r[0]);
              else
                  $a[$i++] = $r[0];
          }

          $final_string .= array_to_list($a, $specialQuote);

          if ($q + 1 < $parts)
              $final_string .= ",";
      }

      //print ">".$final_string . "<<hr>";

      return $final_string;
  }

  function connect_to_database() { global $Connectionlink;  global $ltStart; global $ltStop; global $ltTotal;

    // Set Timezone
    date_default_timezone_set("America/Los_Angeles");

    $ltStart = microtime();

    // connect
    if (($Connectionlink = mysql_connect("---", "---", "---")) == FALSE) {
      print "mysql_connect(); error; " . mysql_error();
      exit;
    }
    // select
    if (!mysql_select_db("---"))
      die(mysql_error());
  }

  function calcLoadTime() { global $ltStart; global $ltTotal;

    $ltStop = microtime();
    $ltTotal = $ltStop - $ltStart;

  }

  function stop() { global $Connectionlink;

    if ($Connectionlink)
      mysql_close($Connectionlink);
  }

  function striptext($document) {
    $search = array ('@<script[^>]*?>.*?</script>@si',   // strip out javascript
                     '@<[\/\!]*?[^<>]*?>@si',            // strip out HTML tags
                     '@([\r\n])[\s]+@'                   // strip out white space
                     ); // evaluate as php
    $replace = array ('','',' ');
    return preg_replace($search, $replace, $document);
  }

  function get_table_data($table, $columns, $where="", $order="", $limit="") {

    $query = "SELECT $columns FROM $table";

    if ($where) $query .= " WHERE $where";
    if ($order) $query .= " ORDER BY $order";
    if ($limit) $query .= " LIMIT $limit";

    //print_g("query string = ".$query);

    $q=mysql_query($query);
    if ($q!=FALSE) {
      $a = array();
      $i = 0;

      while(($r=mysql_fetch_row($q))!=FALSE)
         $a[$i++] = $r;

      return $a;
    } else { print "get_table_data($query): ".mysql_error(); return false; }
  }

  function delete_table_row($table, $where) {
    $q = "DELETE FROM $table WHERE $where";
    if (mysql_query($q) != FALSE)
      return true;
    print "Query: {$q} resulted in: ".mysql_error();
    return false;
  }

  // columns and values are arrays
  function insert_table_data($table, $columns, $values) {

    if (!$table || !$columns || !$values) {
      print "insert_table_data($table, $columns, $values); has failed! insufficient parameters";
      return false;
    }

    $cols = array_to_list($columns,"`");
    $vals = array_to_list($values,"'");

    $query = "INSERT INTO $table ($cols) VALUES ($vals)";

    //print "<b>executing query</b>: ".$query."<br>";

    if (mysql_query($query) != FALSE)
      return mysql_insert_id();

    return false;
  }

  function combine_columns_and_values($columns,$values,$cq="`",$vq="'") {
    $pairs = "";
    $cols = count($columns);
    for ($i=0;$i<$cols;$i++) {
      $pairs .= $cq.$columns[$i].$cq."=".$vq.$values[$i].$vq;
      if ($i+1 < $cols)
        $pairs .= ",";
    }
    return $pairs;
  }

  function set_table_data($table, $columns, $values, $where="", $limit="") {

    $pair = combine_columns_and_values($columns, $values);

    $query = "UPDATE $table SET $pair";

    if ($where) $query .= " WHERE $where";
    if ($limit) $query .= " LIMIT $limit";

    //print $query;

    $q = mysql_query($query);

    if ($q != FALSE)
      return true;

    print "set_table_data($query): ".mysql_error();

    return false;
  }

  // adds a new bio to the database, setting user preferences to 0
  // used at new user sign up only (execbio.php)
  // this function automatically assumes bio information to be passed with $_POST array from execbio.php
  function addbio($addslashes = 1, $personality_type = 127) {

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
  // correct syntax;
//     if (mysql_query("insert into user (`email_address`) values ('stuff')") != FALSE)
      return true;
  }

  // erases user from the database
  function deletebio() {

  }

  // Formatted array output
  function print_g( $ar ) {
    ?><div style = "z-index:77;"><pre><?php print_r( $ar ); ?></pre></div><?php
  }

  // print debug info
  function print_debug( $class, $message ) {
    global $ENABLE_DEBUG_OUTPUT;
    global $debugClassList;
    if ( $ENABLE_DEBUG_OUTPUT )
    {
      foreach ( $debugClassList as $key => $value )
      {
        if ($class == $key && $value) {
          ?><div style = "z-index:77;"><pre><?php print $class . ":</ br>"; print_r( $message ); ?></pre></div><?php
        }
      }
    }
  }

  // convert values of an array to a list "quoted" with a character specified in $quote
  function array_to_list($ar,$quote="`") {
    $l = "";
    if (is_array($ar)) { $ac = count($ar);
      if ($ac>0)
        for ($i=0; $i<$ac; $i++) {
          $l .= $quote.$ar[$i];
          if ($i + 1 < $ac)
            $l .= "$quote,";
          else
            $l .= "$quote";
        }
        return $l;
    }
    return false;
  }

  // calculate difference between two timestamps
  function tval($time1, $time2) {

    if ($time1 == $time2)
        return "0 seconds";

    if ($time1 < $time2) {
      $swap = $time1;
      $time1 = $time2;
      $time2 = $swap;
    }

    $SECONDS = $time1 - $time2;

    $iv_table = array("s","min","h","d","mo","y","s","min","h","d","mo","y");
    $iv = array($SECONDS,
      ($SECONDS-($SECONDS%60))/60,
      ($SECONDS-($SECONDS%3600))/3600,
      ($SECONDS-($SECONDS%(3600*24)))/(3600*24),
      ($SECONDS-($SECONDS%(3600*24*30)))/(3600*24*30),
      ($SECONDS-($SECONDS%(3600*24*30*12)))/(3600*24*30*12));
    for ($i=5;$i>=0;$i--) {
      $r = $iv[$i];
      if ($r>0) {
        if (($r>1||$r==0))
          $i += 6;
        return $r . "" . $iv_table[$i];
      }
    }
  }
  
 // calculate difference between two timestamps
  function tval_full($time1, $time2) {

    if ($time1 == $time2)
        return "0 seconds";

    if ($time1 < $time2) {
      $swap = $time1;
      $time1 = $time2;
      $time2 = $swap;
    }

    $SECONDS = $time1 - $time2;

    $iv_table = array("second","minute","hour","day","month","year",
                      "seconds","minutes","hours","days","months","years");
    $iv = array($SECONDS,
      ($SECONDS-($SECONDS%60))/60,
      ($SECONDS-($SECONDS%3600))/3600,
      ($SECONDS-($SECONDS%(3600*24)))/(3600*24),
      ($SECONDS-($SECONDS%(3600*24*30)))/(3600*24*30),
      ($SECONDS-($SECONDS%(3600*24*30*12)))/(3600*24*30*12));
    for ($i=5;$i>=0;$i--) {
      $r = $iv[$i];
      if ($r>0) {
        if (($r>1||$r==0))
          $i += 6;
        return $r . " " . $iv_table[$i];
      }
    }
  }

  function age_from_birthdate($birthdate) {
    if (!is_numeric($birthdate)) $birthdate = strtotime($birthdate);  //converts to unix if not already
    $sub_yr = 1970;
    while ($birthdate < 0) {    //workaround for dates before 1970
      $birthdate = strtotime((__date('Y',$birthdate)+10).__date('-m-d',$birthdate));
      $sub_yr -= 10;
    }
    return __date('Y',time()-$birthdate)-$sub_yr;
  }

  function isuser($e,&$regdate) {
    if (($q = mysql_query("SELECT `creation_time` FROM user WHERE email_address='$e' LIMIT 1")) != FALSE) {
      if (($r=mysql_fetch_row($q))!=FALSE) {
        $regdate = $r[0];
        return true;
      } else {
        $regdate = "an unknown date";
        return false;
      }
    } print mysql_error();
  }

  function selfURL() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://www." . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
  }

  function strleft($s1, $s2) {
    return substr($s1, 0, strpos($s1, $s2));
  }

  function __date($a,$b)
  {
    return 0;
  }

  function split_array($array, $add_shashes = 1)
  {
      $names = array();
      $values = array();
      foreach($_POST as $key => $value) {
          $names[count($names)] = $key;
          if ($add_shashes == 1)
              $values[count($values)] = addslashes($value);
          else
              $values[count($values)] = $value;
      }
      return array($names,$values);
  }

?>