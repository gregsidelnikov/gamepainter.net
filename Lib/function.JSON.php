<?php

//print "adding";

if (!function_exists('json_decode')) {

/* ?><div style = 'background:red;'>json_decode is not installed in your PHP setup.</div><?php */

        require_once('lib.json.php');
        function json_decode($var) {
            $JSON = new Services_JSON;
            return $JSON->decode($var);
        }
        //print "Added json_decode";
    }
else
{
    //print "json wasnt added";
}

    if (!function_exists('json_encode')) {
      require_once('lib.json.php');
      function json_encode($var) {
          $JSON = new Services_JSON;
          return $JSON->encode($var);
      }
    }
?>