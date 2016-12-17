<?php

    require_once("../Migration/Composition.php");

    $article_key = $_POST['key'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $article_template = $_POST['template'];
    $draft = $article_draft = $_POST['draft'];
    $article_location = $_POST['location'];

    $article_scheduled = ""; /* Do this later... if needed */

    include("scheduled_article.php");

    // Update RSS
    //include("../rss/generate.php");

?>