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

    $localhost_host = $_REQUEST["localhost_host"];
    $localhost_user = $_REQUEST["localhost_user"];
    $localhost_pw = $_REQUEST["localhost_pw"];
    $localhost_cat = $_REQUEST["localhost_cat"];
    $prod_host = $_REQUEST["prod_host"];
    $prod_user = $_REQUEST["prod_user"];
    $prod_pw = $_REQUEST["prod_pw"];
    $prod_cat = $_REQUEST["prod_cat"];

    $content =
        '<?php if ($LOCALHOST) { /* Development */
    class MysqlConfig2 {
    public static $HOST     = "'.$localhost_host.'";
    public static $USER     = "'.$localhost_user.'";
    public static $PASSWORD = "'.$localhost_pw.'";
    public static $CATALOG  = "'.$localhost_cat.'";
    } } else /* Production */ {
    class MysqlConfig2 {
    public static $HOST     = "'.$prod_host.'";
    public static $USER     = "'.$prod_user.'";
    public static $PASSWORD = "'.$prod_pw.'";
    public static $CATALOG  = "'.$prod_cat.'";
    }} ?>';

    write_file($content, "Migration/Database.php");

?>