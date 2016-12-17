<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

// require codebird
require_once('../../Lib/function.JSON.php');
require_once('src/codebird.php');

\Codebird\Codebird::setConsumerKey("AaQ6y0Xw2kdR4c1WeWD7BJot4", "EvrbDaRmcyU34rCExd8WpSZXmMUkgKZLIm2TNHc2y68RbC4d0p");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("441271748-pysNAeE4fh13wntA2MjzDGdVqR9zrLwV1DowiGJf", "qJ8meJZQIyCvKjVqNTpKcQ7FoYQg4FZy0Lpbu5LOiZohv");

/* Delete Last Message Posted By This Script */ 
$last_id = file_get_contents("last_id.txt");
print "<hr/>";
print $last_id;
print "<hr/>";
if (strlen($last_id) > 8 )
    $cb->statuses_destroy_ID(array('id' => $last_id));

sleep(1);

$hash = array("#php", "#jquery", "#java", "#webdev", "#html");

$three_keywords = array();
$total = 2;
$final = "";

while ($total < 3) {
    $rand = rand(0,count($hash));
    $kw = $hash[$rand];
    if (in_array($kw, $three_keywords) == false) {
    
        if (strlen($kw) >= 12)  // skip 1 keyword if too long
            $total++;
    
	$three_keywords[$total] = $kw;
        $final .= "$kw";
        if ($total <= 2)
            $final .= " ";
        $total++;
    }
}

$params = array( 'status' => 'One of the best low-cost ($3.25) books to get up to speed with #jQuery: http://www.amazon.com/dp/B00GW7Q9DW #javascript ' . $final);

$reply = $cb->statuses_update($params);

file_put_contents("last_id.txt", $reply->id_str);

?><hr><?php

var_dump($reply);

?>

