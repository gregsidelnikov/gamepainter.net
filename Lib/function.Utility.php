<?php
    function url()
    {
        $pageURL = 'http';

        if ($_SERVER["HTTPS"] == "on")
            $pageURL .= "s";

        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

        } else

            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

        return $pageURL;
    }

    function host()
    {
        return $_SERVER['HTTP_HOST'];
    }

    function AddSmileys($m)
    {
       //$val = str_replace("<3", "<img src = 'http://www.authenticsociety.com/Smileys/smiley-heart.gif' align='top'/>", $m);

       return 1;
    }

 
    function autolink($str, $dont_convert_images = 0, &$linkdetail)
    {
        //$str = ' ' . $str;

        $store = array();


        //if ($dont_convert_images == 1)

        //    $num = preg_match_all( '{([^"=\'>])((www\.|http://|https://|ftp://)[^\s<]+[^\s<\.)])}i', $str, $store );

        //else

        $num = preg_match_all( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', $str, $store );

        //print_g( $store );

        // Do this for first link only

        if ($store[0] != '' && !isset($store[0][1]))
        {
            //print "ONE LINK";
            $domain_name = $store[2][0];//"www.websitehomework.com";
            $url         = $store[0][0];

            //print "URL is $url";

            $homepage = file_get_contents( $url );
            preg_match('/<title>(.*)<\/title>/i', $homepage, $title);
            preg_match('/<meta(.*)description(.*)content(.*)\"(.*)\"/i', $homepage, $desc);
            //$SEPARATOR = "asc_sep_73";
            $linkdetail[0] = $domain_name;
            $linkdetail[1] = $title[1];
            $linkdetail[2] = substr($desc[4], 0, 64) . "...";
            $linkdetail[3] = $url;
        }

        if ($store[0] != '' && isset($store[0][1]))
        {
            //print "MORE THAN ONE LINK";

            $LINK_INDEX = 0; // later can get more than 1....

            $domain_name = $store[2][$LINK_INDEX];//"www.websitehomework.com";
            $url         = $store[0][$LINK_INDEX];
            $homepage = file_get_contents( $url );
            preg_match('/<title>(.*)<\/title>/i', $homepage, $title);
            preg_match('/<meta(.*)description(.*)content(.*)\"(.*)\"/i', $homepage, $desc);
            //$SEPARATOR = "asc_sep_73";
            $linkdetail[0] = $domain_name;
            $linkdetail[1] = $title[1];
            $linkdetail[2] = substr($desc[4], 0, 64) . "...";
            $linkdetail[3] = $url;
        }


        $str = str_replace("[asui]","<br/><a href = 'http://www.authenticsociety.com/UI' target = '_blank'><img src = 'http://www.authenticsociety.com/ui.png' style = 'border:0' target = '_blank'/></a>",$str);


        //$str = substr($str, 1, strlen($str) - 1);

        for ($i = 0; $i < $num; $i++)
        {
            if (substr(trim($store[0][$i]),0,4) == 'www.')
            {
                $str = str_replace($store[0][$i], " <a href = 'http://" . trim($store[0][$i])  .  "' target = '_blank'>Link</a>[" . ($i + 1) . "] ", $str);
            }
            else
            {
                $str = str_replace($store[0][$i], " <a href = '" . $store[0][$i]  .  "' target = '_blank'>Link</a>[" . ($i + 1) . "] ", $str);
            }
        }

        return $str;
    }

?>