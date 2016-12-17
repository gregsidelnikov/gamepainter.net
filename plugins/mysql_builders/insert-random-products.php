<?php

    $FILESYSTEM = "";
    $LOCALHOST = false;
    if (preg_match("/localhost/", $_SERVER["HTTP_HOST"]) > 0) {
	    $LOCALHOST = true;
	    $FILESYSTEM ="C://Program Files (x86)//Apache Software Foundation//Apache2.2//htdocs//leonart.com"; // __your__ Apache path
	    $URL = $HOMEPAGE = "http://localhost/leonart.com";
    } else
        $FILESYSTEM = str_replace("/Migration", "", dirname(__FILE__));     // Linux path, autodetect

    include($FILESYSTEM . "/Lib/function.Database.php");// Used by class.MysqlDatabase.php
    include($FILESYSTEM . "/Classes/Common/class.MysqlDatabase.php"); // Enable MySQL database library

    $DatabaseName = "master";
    $TableName = "leonart_cart";

    $db_ok = true;

    $con = mysql_connect("localhost", "root", "55723105");

    function random_index($array) {
        $len = count($array);
        $r = rand(0,$len-1);
        return $array[$r];////print ">".$array[$r]."<br/>";
    }

    if (!$con) {
        echo "Failed to connect to MySQL.<br/>";
        exit;
    } else {
        echo "Connected to db<br/>";

        if (!mysql_select_db($DatabaseName)) {
            echo "Database <b>$DatabaseName</b> does not exist.";
        } else {
            if ($db_ok)
            {
                $DATE_ADDED = 1400545018;

                for ($j=0;$j<10;$j++)
                {
                    $NAME = "Persistence of Memory";
                    $DESC = "Description";
                    $PRICE = rand(25,200).".".rand(10,99);
                    $CATEGORY = "Impressionism";
                    $DATE_ADDED += 1000;
                    $ITEMS_LEFT = 10;
                    $IMAGE_URL = "image1.jpg";
                    $CATEGORY = random_index(array("Impressionism", "Surrealism", "Portrait", "Expressionism", "Landscape", "Nature", "Print", "Animals"));
                    $NAME = random_index(array("A Conglomerate 1943","All Saints Picture 1911","Around the Circle","At Rest 1008","Autumn in Bavaria 1908","Beach Baskets in Holland 1904","Black and Violet 1923","Black Forms in White 1934","Black Spot 1912","Brown with Supplement 1935","Cemetery & Vicarage in Kochel 1909","Church in Marnau 1910","Circle and Square 1943","Colorful Ensemble 1938","Colorful Life, 1907","Composition 44","Composition 6 1913","Composition IV 1911","Composition IX 1936","Composition V 1911","Composition V 1911","Composition VI 1913","Composition VI 1913","Composition VI 1913","Composition VIII 1923","Composition X 1939","Composition XII","Composition XIII","Composition XIV","Composition VII 1913","Contrasting Sounds 1924","Contrasting Sounds I","Division Unity 1943","Dominant Curve 1936","Farbstudie Quadrate","Farbstudie Quadrate","First Abstract Watercolor 1010","Fixed Points 1908","Flood Improvisation, 1913","Flood Improvisation 1913","Fragment 2 for Composition VII 1913","Green Figure 1936","Horses 1909","Improvisation 26 1926","Improvisation 30 1913","Improvisation 31 Sea Battle 1913","Improvisation 35","Improvisation 6 (African) 1909","Improvisation 7 1910","Improvisation Klamm Ravine 1914","In Gray 1916","In the Black Circle 1923","In the Blue 1925","Interior (My Dining Room) 1909","Kleine Welten III 1922","Kleine Welten I 1922","Kleine Welten IV 1922","Landscape with Rain","Layers 1932","Moscow I 1916","Moscow I, 1916","Murnau Grungasse 1909","Murnau Grungasse 1909","Murnau with Church I 1910","Murnau with Rainbow 1909","Night 1907","On White II 1923","Painting with Green Center 1913","Painting with Houses 1090","Picture with Three Spots 1914","Pinting on a Light Ground 1916","Portrait of Gabriele Munter, 1905","Ravine Improvisation 1914","Ravine Composition 1914","Relations 1934","Riding Couple 1906-07","Romantic Landscape 1911","Russian beauty in a landscape 1905","Saint George 1911","Sant Mergherita 1906","Scarcely 1929","Seven 1943","Silent 1937","Small Dream in Red 1925","Small Dream in Red 1925","Small Pleasures 1913","Small Worlds II, 1922","Small Worlds 1922","Softened Construction 1927","Street in Murnau with Women 1908","Study of Autumn 1009","Tensions Relaxed 1937","The Blue Rider 1903","The Elephant 1908","The Flood 1921","Transverse Line 1923","Transverse Lines","Untitled","Untitled II","Untitled Improvisation III 1914","Various Actions 1941","White Balancing Act 1944","White Line No 232 1920","With Black Arch 1912","Women in Moscow 1912","Yellow Red Blue, 1925","Yellow Red and Blue 1925","Yellow, Red, Blue 1925"));
                    $DESC = random_index(array("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                            "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from divs 1.10.32 and 1.10.33",
                            "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.",
                            "All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.",
                            "Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.",
                            "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
                            "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.",
                            "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?",
                            "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus."));

                    print $NAME."-".$DESC."<br/>";

                    $images = array();
                    for ($i = 0; $i < 25; $i++) { $images[$i] = "image" . $i . ".jpg"; }
                    $IMAGE_URL = random_index($images);
                    $sql = 'INSERT INTO `'.$TableName.'` (`name`,`description`,`price`,`category`,`date_added`,`items_left`,`image_url`,`json`) '.
                           'VALUES ("'.$NAME.'","'.$DESC.'","'.$PRICE.'","'.$CATEGORY.'","'.$DATE_ADDED.'","'.$ITEMS_LEFT.'","'.$IMAGE_URL.'","{}")';
                    if (mysql_query($sql, $con))
                    {
                        echo "Items inserted!<br/>";
                    }
                    echo mysql_error();
                }
            }
        }
    }

?>