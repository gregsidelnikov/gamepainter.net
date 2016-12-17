<style>.sc { color:#777777; font-weight:bold; padding:0 !important;margin: !important; border:0; background: Transparent; font-size: 11px; padding:0 !important; margin:0 !important; line-height:14px !important;;}</style>

<?php //include('../Migration/Composition.php');

    //$Connection = new db();

    $CAT = db::get("`categories`", get_all_from("categories"), "", "");

    $CAT2 = db::get("`categories`,`categories2`,`content`", get_all_from("categories,categories2,content"),

    "categories2.key = content.subcategory AND categories2.category_id = categories.key AND " .

    "content.draft != 1 AND content.deleted != 1 AND content.hidden != 1",

    "content.key ASC");

    $subcategory = array();

    if (!empty($CAT2))
        {
            for ($j = 0; $j < count($CAT2); $j++)
            {
                //print "categories2.key=" . $CAT2[$j]["categories2.dir"] . ", content.location=" . $CAT2[$j]["content.location"] . "<hr/>";
                //print_g($CAT2[$j]);
                $index = $CAT2[$j]['categories.key'];
                $subcategory[$index]["key"] = $CAT2[$j]['categories.key'];
                $subcategory[$index]["dir"] = $CAT2[$j]['categories2.dir'];
                $subcategory[$index]["nam"] = $CAT2[$j]['categories2.name'];
            }
        }
    for ($i = 0; $i < count($CAT); $i++) {
        $article_count = 0;
        if (isset($ct[0]['COUNT(*)']))
            $article_count = $ct[0]['COUNT(*)'];
        if ($article_count == 0)
            $article_count = ""; ?>
            <li style = "z-index:7777777777777 !important;"><a href = "<?php print $URL; ?>/category/<?php print $CAT[$i]['dir']; ?>"><?php print $CAT[$i]['name']; ?></a><?php /*  */

                if (false == true && !empty($subcategory[$i+1]) && is_numeric($subcategory[$i+1]["key"]))
                {
                    $name = $subcategory[$i + 1]["nam"];
                    $dir = $subcategory[$i + 1]["dir"];

                    ?>

                    <li>
                        <?php print $name; ?>
                    </li>

                    <?php
                }

            ?></li>
        <?php
        
    }

?>