<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

// require codebird
require_once('../../Migration/Composition.php');
require_once('../../Lib/function.JSON.php');
require_once('src/codebird.php');

\Codebird\Codebird::setConsumerKey("AaQ6y0Xw2kdR4c1WeWD7BJot4", "EvrbDaRmcyU34rCExd8WpSZXmMUkgKZLIm2TNHc2y68RbC4d0p");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("441271748-pysNAeE4fh13wntA2MjzDGdVqR9zrLwV1DowiGJf", "qJ8meJZQIyCvKjVqNTpKcQ7FoYQg4FZy0Lpbu5LOiZohv");

$params = array("screen_name"=>"js_tut", "count"=>5000, "cursor"=>-1);
//statuses_destroy_ID
$reply = $cb->followers_ids($params);

?><hr><?php

print_g($reply->ids);

?>

