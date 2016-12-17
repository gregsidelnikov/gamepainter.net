<?php include('../Migration/Composition.php');

    $Connection = new db();

    $SearchResults = db::get("search_results", "*", "", "", "1");
    print $SearchResults['listing']; 

?>