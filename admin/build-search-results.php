<?php require_once('../Migration/Composition.php');
    $Connection = new db();
    $Articles = db::get("content", get_all_from("content"), "`draft` != 1 AND `deleted` != 1 AND `hidden` != 1", "", "1000");
?><ul id = "Collection" style = "position: absolute; top:-10000px;"><?php for ($i = 0; $i < count($Articles); $i++) { ?><li><a href = '<?php print $URL . "/" . $Articles[$i]['type'] . "/" . $Articles[$i]['location']; ?>'><?php print $Articles[$i]['title']; ?></a></li><?php } ?>
</ul>