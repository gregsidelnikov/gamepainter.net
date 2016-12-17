<?php

    include("../../Migration/Composition.php");

    print "URL=" . $URL . "<br/>";

    function rasterize($page_url, $dir, $content, $type) {
        global $URL, $FILESYSTEM;
        if (!isset($page_url)) {
            echo "rasterize(): page_url is not provided<br/>";
            return;
        }
        if (!isset($dir)) {
            echo "rasterize(): target directory is not set.<br/>";
        } else {

            //$t = "[cached]" . file_get_contents($page_url);
            $t = file_get_contents($page_url);
            //print $t;
            //exit;

            // Uncomment next line and comment the one after it to ENABLE CACHE DIR--
            // mkdir = "../../cache/" . $type;


            // RAW
            $root = $FILESYSTEM . "/";//"../../";
            $mkdir = $root . $type;

            $dir_ok = false;
            if (!is_dir($mkdir)) {
                if (mkdir($mkdir)) { $dir_ok = true; print "<span style = 'color:blue'>" . $mkdir . " created!</span><br/>"; } else { echo "<span style = 'color:red'>mkdir &gt;$mkdir&lt; failed</span>"; }
            } else { print "<span style = 'color: blue'>$mkdir already exists! ok.</span>"; $dir_ok = true;  }

            /* Write file */
            if ($dir_ok) {

                /* Write index file into main directory */
                if ($type == "homepage" || $type == "nodir" || $type == "no_dir" || $type == "webpage") {
                    $fn = $root . "" . basename($page_url);
                } else {
                    $fn = $mkdir . "/" . basename($page_url);
                }

				chmod($fn, 0775);
				chown($fn, "www-data");
				chgrp($fn, "www-data");

                $f = fopen($fn, 'w') or die("fopen: can't open file [content] [$fn]");
                if (fwrite($f, $t) != FALSE)
                    print "fwrite: success - file $fn written!<br/>";
                fclose($f);
            }

            /* Write index file into main directory */
            if ($type == "homepage") {
                print "<b>building index.html on root</b><br/>";
                $fn = $FILESYSTEM . "/index.html";
                $f = fopen($fn, 'w') or die("fopen: can't open file [content] [$fn]");
                if (fwrite($f, $t) != FALSE)
                    print "fwrite: success - file $fn written!<br/>";
                fclose($f);
            }

            print "<hr/>";
        }
    }

    $db = new db();

    $mkdir = "../../cache";
    if (!is_dir($mkdir)) {
        if (mkdir($mkdir)) { $dir_ok = true; print "<span style = 'color:blue'>" . $mkdir . " created!</span><br/>"; } else { echo "<span style = 'color:red'>mkdir &gt;$mkdir&lt; failed</span>"; }
    } else { print "<span style = 'color: blue'>$mkdir already exists! ok.</span>"; $dir_ok = true;  }

    if ($db->isReady()) {

        $C = $db->get("content", "*", "`deleted` != 1");
        
//        print_g($C);

        for ($i=0;$i<count($C);$i++)
        {
            print $C[$i]["location"] . " | " . $C[$i]["type"];
            print "<br/>";

            $url = $URL . "/cacheexec/" . $C[$i]["type"] . "/" . $C[$i]["location"];

            switch ($C[$i][""]) {

            }

            switch ($C[$i]["type"]) {
                case "email": {
                    //$target_dir = $FILESYSTEM . "/archive";
                    continue;
                    break;
                }
                case "homepage": {
                    $target_dir = $FILESYSTEM . "/";
                    break;
                }
                case "nodir": {
                    $target_dir = $FILESYSTEM . "/";
                    break;
                }
                default: {
                    $url = $URL . "/cacheexec/" . $C[$i]["type"] . "/" . $C[$i]["location"];
                    $target_dir = $FILESYSTEM . "/" . $C[$i]["type"];
                }
            }

            print "<span style = 'color:#dd0000'>rasterizing $url...</span></br>";

            rasterize($url, $target_dir, $content, $C[$i]["type"]);
        }
    }
    else
        print "!db";
?>