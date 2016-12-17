<?php
    function blog_display_list( $data, $backlink = false, $max_characters = 100000000 )
    {
        for ($i = 0; $i < count( $data ); $i++)
        {
            $key   = $data[ $i ][ 'key' ];
            $url = $data[ $i ][ 'location' ];
            $title = $data[ $i ][ 'title' ];
    //        print_g($data);
            if ($url)
                $key = $url;
            $final_url = "<a href = 'http://localhost/AuthenticSociety/blog/$key'>$title</a>";
            $display_name = $data[ $i ][ 'author_username' ];
            $timestamp = tval(time(), $data[ $i ][ 'timestamp' ]);
            if (strlen( $data[ $i ][ 'article' ] ) > $max_characters)
                $append_readmore = true;
            $body = substr(stripslashes(str_replace("\r\n","<br/>", strip_tags($data[ $i ]['article']))), 0, $max_characters);
            $username = $data[ $i ][ 'author_username' ];
            if ($backlink == false)
            {
                /*
                */ ?>

                <h1 style = "text-align: left;"><?php $backlink ? print $final_url : print $title; ?></h1>

                <?php
            }
            else
            {
    //            $icons = { 0,0,0 };

                if ($data[$i][6] == "forex") // icon if start
                { ?>
                <table><tr><td rowspan = "2"><img src = "http://localhost/AuthenticSociety/Images/Icons/currency_icon.gif"></td><td><h3><?php $backlink ? print $final_url : print $title; ?></h3></td></tr><tr><td>Posted on <?php print date("F j, Y, g:i a", $data[ $i ][ 2 ]); ?> (<i><?php print $timestamp; ?> ago</i>) by <a href = "http://localhost/~<?php print $username; ?>" style = "text-decoration:none;font-style:none;color:gray;"><?php print $display_name; ?></a></td></tr></table>
                <?php
                } else { ?>
                <h1 class="ss_desc" style = "text-align: left"><?php $backlink ? print $final_url : print $title; ?></h1>
                <?php } // icon if end
            }
            if ($backlink)
                $body = strip_tags($body);
            if ($append_readmore)
                $body = trim($body) . "...";
            print $body;
            ?>
            <br/><br/>
            <?php

            if ($append_readmore)
            {
                ?><div style = "width: 300px; float: left; display: none;"><i><a href = "http://localhost/AuthenticSociety/blog/<?php print $key; ?>">Read entire story</a></i></div><?php
            }

            ?>
            <div style = "float: right; width: 300px; text-align: right; display: none;"><a href = "#">18 Comments<a/></div>
            <?php
            if ($backlink == false)
            { } ?>
            <br/><br/>
            <?php
        }
    }

    function blog_display_similar_list( $data, $cut_string_by = 38 )
    {
        for ($i = 0; $i < count( $data ); $i++)
        {
            $key   = $data[ $i ][ 0 ];
            $url   = $data[ $i ][ 2 ];
            $title = $data[ $i ][ 1 ];

            if (strlen($title) > $cut_string_by)
                $title = substr($title, 0, $cut_string_by) . "...";

            if ($url)
                $key = $url;
            $final_url = "<a href = 'http://localhost/blog/$key'>$title</a>";
            if ($title)
                print "<li>" . $final_url . "</li>";
        }
    }

    /*not used anywhere*/
    function blog_display_byid( $id, $backlink = false )
    {
       $data = blog_get_entry( $id );

       for ($i = 0; $i<count($data); $i++)
       {
           $key   = $data[0][0];
           $display_name = $data[0][1];
           $timestamp = tval(time(), $data[0][2]);
           $body = stripslashes(str_replace("\r\n","<br/>", $data[0][3]));
           $title = $data[0][4];
           $username = $data[0][5];
       ?>
           <h2><?php $backlink ? print "<a href = 'http://localhost/blog/$key'>$title</a>" : print $title; ?></h2>
           Posted on <?php print date("F j, Y, g:i a", $data[0][2]); ?> (<i><?php print $timestamp; ?> ago</i>) by <a href = "http://localhost/~<?php print $username; ?>"><?php print $display_name; ?></a><br/><br/>
           <?php print $body; ?>
           <br/><br/>
           <?php
       }
    }

?>