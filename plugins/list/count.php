<?php
    include("../../Migration/Composition.php");
    $db = new db();
    if ($db->isReady()) {
        $SUBSCRIBER_COUNT = 0;
        $s = $db->count("subscribers", "list_id = 700");
        $SUBSCRIBER_COUNT = $s[0][0];
        if (is_numeric($SUBSCRIBER_COUNT))
            print $SUBSCRIBER_COUNT;
        else
            print "n/a";
    }
    else
        print "!db";
?>