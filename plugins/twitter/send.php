<?php
include("../../Migration/Composition.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../Lib/function.JSON.php');
require_once('src/codebird.php');

\Codebird\Codebird::setConsumerKey("AaQ6y0Xw2kdR4c1WeWD7BJot4", "EvrbDaRmcyU34rCExd8WpSZXmMUkgKZLIm2TNHc2y68RbC4d0p");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("441271748-pysNAeE4fh13wntA2MjzDGdVqR9zrLwV1DowiGJf", "qJ8meJZQIyCvKjVqNTpKcQ7FoYQg4FZy0Lpbu5LOiZohv");
 
$params = array( 'status' => $_REQUEST['msg'] ); // . $final);
$reply = $cb->statuses_update($params);



?><hr><?php
var_dump($cb);
?>

