<?php
    include("../../Migration/Composition.php");
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);
    print "URL=" . $URL . "<br/>";
    print "PATH=" . $SERVER_PATH . "</br>";
    $article_id = $_REQUEST['article_id'];
    if (!is_numeric($article_id)) { print "article_id=[$article_id] is not numeric! <b>Exiting</b>"; exit; }
    
    function rasterize_v2($page_url, $dir, $content, $type) {
    	global $SERVER_PATH, $URL;
    	$filename = basename($page_url);
        $mkdir = $SERVER_PATH . $type;
        $dir_ok = false; if (!is_dir($mkdir)) { if (mkdir($mkdir)) { $dir_ok = true; print "<span style = 'color:blue'>" . $mkdir . " created!</span><br/>"; } else { echo "<span style = 'color:red'>mkdir &gt;$mkdir&lt; failed</span><br>"; } } else { print "<span style = 'color: blue'>$mkdir already exists! ok.</span><br>"; $dir_ok = true;  }
        if ($dir_ok) { // directory created; write the file
            if ($type == "homepage" || $type == "nodir" || $type == "no_dir") $fh = fopen($SERVER_PATH . '' . $filename, 'w'); else $fh = fopen($mkdir . '/' . $filename, 'w');
            $data = file_get_contents($page_url);
//            print $data;
//            exit;
        	$ret = fwrite($fh, $data);
	       	print "$ret bytes written to $mkdir [$filename]...<br/>";
        }
    }
    
    // Begin -------------------------------

    $db = new db();
    $mkdir = "../../cache";
    if (!is_dir($mkdir)) { // Force making cache directory
        if (mkdir($mkdir)) { $dir_ok = true; print "<span style = 'color:blue'>" . $mkdir . " created!</span><br/>"; } else { echo "<span style = 'color:red'>mkdir &gt;$mkdir&lt; failed</span>"; }
    } else { print "<span style = 'color: blue'>$mkdir already exists! ok.</span>"; $dir_ok = true;  }
    if ($db->isReady()) {
        $C = $db->get("content", "*", "`key` = $article_id AND `deleted` != 1", "", "1");
        for ($i=0;$i<count($C);$i++) {
            print $C[$i]["location"] . " | " . $C[$i]["type"];
            print "<br/>";
            $url = $URL . "/cacheexec/" . $C[$i]["type"] . "/" . $C[$i]["location"];
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
            print "target_dir=$target_dir<br/>";
            print "type=".$C[$i]["type"]."<br/>";
            rasterize_v2($url, $target_dir, $content, $C[$i]["type"]);
        }
    }
    else
        print "!db";
?>