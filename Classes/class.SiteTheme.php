<?php
  // Matching Google ad themes, ideally needs to be "encapsulated" in the SiteTheme class
$cssGoogleAdid     = 0;
$cssGoogleAdcolors = array( //border //bg,    //link   //text   //url
    array( "ffffff","ffffff","3333FF","000000","6600FF"),
    array( "343839","000000","ffffff","eeeeee","ffffff"),
    array( "343839","000000","ffffff","eeeeee","ffffff"),  // starcraft 1
    array( "303030","303030","E0E0E0","E0E0E0","FF7E00"),  // zBrush
);

final class SiteTheme
    {
    static public function applySiteTheme()
    {
        global $PROJECT_PATH, $URL;
            // was: $siteURL = "http://localhost/root";// localhost/root, or net = "http://www.authenticsociety.com";

        $CSS_DEFAULT_STYLE = 0;
            // this is the array index into the default stylesheet (when there is no stylesheet id in the cookie)
        $CSS_STYLESHEET    = "stylesheet";
        $CSS_ALTERNATE     = "alternate stylesheet";
            /*
            Site theme definition, style0-n must have corresponding file named style0-n.css
            Add new stylessheets here
            */
        $StylesheetEnumeration = array( "generic.css", //-- default stylesheet must be included here too 
                                        "generic2.css",
                                        "generic3.css",
                                        "generic4.css",
                                        "generic5.css",
                                        "generic6.css" );

            // Count the number of site theme styles
        $CSS_STYLE_COUNT = count($StylesheetEnumeration);


            // Forced default css style

        ?><link rel = "stylesheet" type = "text/css" href = "<?php print $URL; ?>/css/generic.css" title = "Default Stylsheet" /><?php

        /*return;*/


        if ($_COOKIE['style'])
            $s = $_COOKIE['style'];
            // get style from a cookie

            // Display stylesheet enumeration
        if ($s == "") {
            // cookie/style doesn't exist, display default css ($CSS_DEFAULT_STYLE)
            $cssGoogleAdid = 0;
            for ($i = 0; $i < $CSS_STYLE_COUNT; $i++) {
                /* Select default CSS style */
                ?><link rel = "<?php if ($i == $CSS_DEFAULT_STYLE) print $CSS_STYLESHEET; else print $CSS_ALTERNATE; ?>" type = "text/css" href = "<?php print $PROJECT_PATH; ?>/css/<?php print $StylesheetEnumeration[$i]; ?>" title = "<?php print $StylesheetEnumeration[$i]; ?>" />
<?php

            }
        } else {
            // choose the current stylesheet type, load others as alternate
            for ($i = 0; $i < $CSS_STYLE_COUNT; $i++) {
                if ($StylesheetEnumeration[$i] == $s) {
                    $cssGoogleAdid = $i;
                    $type = $CSS_STYLESHEET;
                } else
                $type = $CSS_ALTERNATE;
                ?><link rel = "<?php print $type; ?>" type = "text/css" href = "<?php print $PROJECT_PATH; ?>/css/<?php print $StylesheetEnumeration[$i]; ?>" title = "<?php print $StylesheetEnumeration[$i]; ?>" />
<?php

            }
        } // else
    }

    // function applySiteTheme()
}

// class SiteTheme
?>