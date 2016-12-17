<?php

    //include('../Migration/Composition.php');

    //$Connection = new db();

    $Articles   = db::get("content", "*", "`deleted` != 1", "`time` DESC", "");

    ?>

    <style>
        .article_list { width: 430px; height: 200px; font-size: 12px; }
    </style>
    <select multiple class = "article_list"><?php

    for ($i = 0; $i < count($Articles); $i++) {
        $key = $Articles[$i]["key"];
        $title = $Articles[$i]["title"];
        print $key . "<br/>";
        print $title . "<br/>";

        ?><option key = "<?php print $key; ?>" title = "<?php print $title; ?>" <?php if ($i==0) print "selected "; ?> value = "<?php print $key; ?>"><?php print $title; ?></option><?php
    }

?>
</select>