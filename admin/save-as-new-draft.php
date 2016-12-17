<?php include('../Migration/Composition.php');

    $Connection = new db();

    $arr1 = array("type",
                  "location",
                  "article",
                  "article_plaintext",
                  "navi_name",
                  "title",
                  "browser_title",
                  "keywords",
                  "description",
                  "time",
                  "last_updated_time",
                  "image",
                  "image_description",
                  "template",
                  "category",
                  "subcategory",
                  "publish_settings",
                  "facebook_msg",
                  "twitter_msg",
                  "javascript",
                  "css",
                  "scheduled",
                  "noindexnofollow",
                  "last_saved_time");

    $arr2 = array($_POST['type'],
                  $_POST['location'],
                  addslashes($_POST['article']),
                  addslashes($_POST['article_plaintext']),
                  addslashes($_POST['navi_name']),
                  addslashes($_POST['title']),
                  addslashes($_POST['browser_title']),
                  $_POST['keywords'],
                  addslashes($_POST['description']),
                  time(),
                  time(),
                  $_POST['image'],
                  addslashes($_POST['image_description']),
                  $_POST['template'],
                  $_POST['category'],
                  $_POST['subcategory'],
                  $_POST['publish_settings'],
                  addslashes($_POST['facebook_msg']),
                  addslashes($_POST['twitter_msg']),
                  addslashes($_POST['javascript']),
                  addslashes($_POST['css']),        
                  $_POST['scheduled'],
                  $_POST['noindexnofollow'],
                  time());

    if (db::insert("`content`", $arr1, $arr2) != FALSE) {

        print db::getLastInsertID();

        // Update RSS
        //include("../rss/generate.php");

    }
    else                      
        print "<b>Error creating new draft.</b>" . mysql_error();

?>