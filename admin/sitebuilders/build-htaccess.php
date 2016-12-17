<?php

    include("../../Migration/Composition.php");

    function write_file($content, $fn) {
        global $FILESYSTEM, $LOCALHOST;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $XF = $FILESYSTEM . "//" . $fn; else $XF = $FILESYSTEM . "/" . $fn;
        $f = fopen($XF, 'w+') or die("fopen: can't open file [content] [$XF]");
        if (fwrite($f, $content) != FALSE) {
            print "fwrite: success - file written!<br/>";
        }
        fclose($f);
    }

    $content = $_REQUEST['htaccess'];

    write_file($content, ".htaccess");

?>