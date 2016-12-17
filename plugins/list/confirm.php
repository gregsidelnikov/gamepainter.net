<?php include("../../Migration/Composition.php"); ?>
<h2>Success.</h2>
<p>Your subscription has been confirmed!</p>
<p>You will start receiving messages shortly.</p>
<?php
    $Connection = new db();
    $TableName = "subscribers";
    if ($Connection->isReady()) {

    }
?>