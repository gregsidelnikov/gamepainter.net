<?php include("../../../Migration/Composition.php"); ?>

<?php
    $Connection = new db();

    if ($Connection->isReady())
    {
        for ($i = 0; $i < 1000; $i++) {
            $Connection->insert("subscribers", array("name", "email_address", "timestamp"), array("John Smith", "navesele@gmail.com", time()));
            $Connection->insert("subscribers", array("name", "email_address", "timestamp"), array("Tigris Games", "tigrisgame@gmail.com", time()));
            $Connection->insert("subscribers", array("name", "email_address", "timestamp"), array("Greg Sidelnikov", "greg.sidelnikov@gmail.com", time()));
            $Connection->insert("subscribers", array("name", "email_address", "timestamp"), array("Greg Sometimes", "gregsometimes@gmail.com", time()));
            $Connection->insert("subscribers", array("name", "email_address", "timestamp"), array("Greg jQuery", "greg@learnjquery.org", time()));


        }

        print mysql_error();

    }
?>