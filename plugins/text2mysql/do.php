<?php
   include("../../Migration/Composition.php");

   $db = new db();




   //set_time_limit ( 60 * 60 ); /* hour*/
   set_time_limit ( 60 * 60 ); /* "forever" */



   $handle = fopen("mailing_list_14000.txt", "r");

    $ar = array();

   if ($handle) {
      while (($buffer = fgets($handle, 4096)) !== false) {

          $ar[count($ar)] = trim($buffer); 

      }
      if (!feof($handle)) {
          echo "Error: unexpected fgets() fail\n";
      }
      fclose($handle);
   }


    $DEFAULT_SUBSCRIBER_LIST_ID = 100; /* LearnjQuery.org list */


        foreach($ar as $k=>$v)
        {
            if ($v != "") {
              if (($db->insert("subscribers", array("email_address", "list_id", "timestamp", "date"),
                 array(trim($v), $DEFAULT_SUBSCRIBER_LIST_ID, time(), date("m-d-y"))))!=NULL) {
                 print "$k -> $v added<br/>";
                 //time_nanosleep(0, 50000000);
              }
          }
        }


?>