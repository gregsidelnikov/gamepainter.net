<?php include('../Migration/Composition.php');

    $Connection = new db();

    $key = $_POST["key"];

    if (is_numeric($key))
    {

        $arr1 = array("type",
                      "location",
                      "article",
                      "article_plaintext",
                      "title",
                      "navi_name",
                      "browser_title",
                      "keywords",
                      "description",
                      "last_updated_time",
                      "image",
                      "image_description",
                      "template",
                      "category",
                      "subcategory",
                      "facebook_msg",
                      "twitter_msg",
                      "javascript",
                      "css",
                      "noindexnofollow",
                      "last_saved_time"
                    );


        $arr2 = array($_POST['type'],
                      $_POST['location'],
                      addslashes($_POST['article']),
                      addslashes($_POST['article_plaintext']),
                      addslashes($_POST['title']),
                      addslashes($_POST['navi_name']),
                      addslashes($_POST['browser_title']),
                      addslashes($_POST['keywords']),
                      addslashes($_POST['description']),
                      time(),
                      $_POST['image'],
                      $_POST['image_description'],
                      $_POST['template'],
                      $_POST['category'],
                      $_POST['subcategory'],
                      $_POST['facebook_msg'],
                      $_POST['twitter_msg'],
                      addslashes($_POST['javascript']),
                      addslashes($_POST['css']),
                      $_POST['noindexnofollow'],
                      time());

        if (db::set("`content`", $arr1, $arr2, "`key` = '$key'") != FALSE) {
            // Update RSS
            //include("../rss/generate.php");
            print "<b>Article was updated!</b>";
        } else {
            print "<b>Error updating article.</b>";
        }
    }
    else
        print "Key {$key} is not a numeric value. Error updating article.";

?>