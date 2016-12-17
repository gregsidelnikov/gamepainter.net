<?php
    function article_display_list( $data, $dir = "about", $backlink = false, $max_characters = 100000000 )
    {
        global $URL;
        for ($i = 0; $i < count( $data ); $i++)
        {
            $key   = $data[ $i ][ 'key' ];
            $url = $data[ $i ][ 'location' ];
            $title = $data[ $i ][ 'title' ];
    //        print_g($data);
            if ($url)
                $key = $url;
            $final_url = "<a href = '$URL/$dir/$key'>$title</a>";
            $display_name = $data[ $i ][ 'author_username' ];
            $timestamp = tval(time(), $data[ $i ][ 'timestamp' ]);
            if (strlen( $data[ $i ][ 'article' ] ) > $max_characters)
                $append_readmore = true;
            $body = substr(stripslashes(str_replace("\r\n","<br/>", str_replace("[GoogleAd UpperLeft]", "", strip_tags($data[ $i ]['article'])))), 0, $max_characters);
            $username = $data[ $i ][ 'author_username' ];
            if ($backlink == false)
            {
                /*
                */ ?>

                <h4 style = "text-align: left;"><?php $backlink ? print $final_url : print $title; ?></h4>

                <?php
            }
            else
            {
    //            $icons = { 0,0,0 };

                if ($data[$i][6] == "forex_intentionally_false_xxx") // icon if start
                { ?>
                <table><tr><td rowspan = "2"><img src = "<?php print $URL; ?>/Images/Icons/currency_icon.gif"></td><td><h3><?php $backlink ? print $final_url : print $title; ?></h3></td></tr><tr><td>Posted on <?php print date("F j, Y, g:i a", $data[ $i ][ 2 ]); ?> (<i><?php print $timestamp; ?> ago</i>) by <a href = "$URL/~<?php print $username; ?>" style = "text-decoration:none;font-style:none;color:gray;"><?php print $display_name; ?></a></td></tr></table>
                <?php
                } else { ?>
                <h4 class="ss_desc" style = "text-align: left; margin:0;"><?php $backlink ? print $final_url : print $title; ?></h4>
                <?php } // icon if end
            }
            if ($backlink)
                $body = strip_tags($body);
            if ($append_readmore)
                $body = trim($body) . "...";
            print $body;
            ?>
            <br/>
            <?php

            if ($append_readmore)
            {
                ?><div style = "width: 300px; float: left; display: none;"><i><a href = "$URL/<?php print $dir; ?>/<?php print $key; ?>">Read entire story</a></i></div><?php
            }

            ?>
            <div style = "float: right; width: 300px; text-align: right; display:none;"><a href = "#">18 Comments</a></div>
            <?php
            if ($backlink == false)
            { } ?>
            <br/>
            <?php
        }
    }

    // ~todo: This is too slow to be used for multiple items, replace it eventually
    function url_exists($url)
    {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
    }

    // Build a column of images and title text underneath
    // $Article must be available
    // $DataSourceArray must have 'key', 'location', and 'title' items
    // ~todo: url_exists must be replaced with something fast, perhaps a direct db lookup (that means creating a new column)
    // ~todo: implement functionality based on $MacItemperRow and $MaxColumns
    function DisplayImageColumnFromSource($Article, $DataSourceArray, $ColumnTitle, $MaxLinkTextLength, $Sector = "about", $MaxItemPerRow = 0, $MaxColumns = 0)
    {
        global $URL;
        $LinksNum = count($DataSourceArray);
        if (!empty($DataSourceArray) && $LinksNum > 0) 
        {
            ?>

            <div style = "width:280px; padding:5px; border-bottom:1px solid silver; margin-bottom: 5px; color: gray">Related Articles:</div>

            <div class = "toc" style = "width:280px;">

                <div style = "padding:4px; padding-left:6px;"><?php

                    for ($i = 0; $i < $LinksNum; $i++)
                    {
                        $LinkTitle = $ShortenedLinkTitle = $DataSourceArray[$i]["title"];

                        if (strlen($ShortenedLinkTitle) > $MaxLinkTextLength)
                            $ShortenedLinkTitle = trim(substr($ShortenedLinkTitle, 0, $MaxLinkTextLength)) . "...";

                        $LinkLocation = $DataSourceArray[$i]["location"];
                        $AtomKey = $DataSourceArray[$i]["key"];

                        if ($Sector == 'about')
                            $Timestamp = $DataSourceArray[$i]["time_created"];
                        else
                            $Timestamp = $DataSourceArray[$i]["timestamp"];

                        if ($Sector == "blog")
                            $AtomKey = "b" . $AtomKey;

                        // print "</br></br>";

                        $SupposedPreviewImage = "$URL/Preview/" . $AtomKey . "/preview.jpg";
                        $a_href_already_opened = false;
                        $open_a_href = "<a href = '$URL/" . $Sector . "/" . $LinkLocation . "' title = '" . $LinkTitle . "' class = 'ArticleMoreLink'>";
                        $a_href_already_opened = true;

                        if ($Article['preview_image'] != "")
                        {
                            //print $open_a_href;
                            //print "<img src = '$URL/Preview/" . $DataSourceArray[$i]['key'] . $Article['preview_image'] . "' style = 'width:64px' border = '0' alt = '$LinkTitle (preview picture)' align = 'left'/>";
                        }
                        else
                        {
                            //print $open_a_href;
                            //print "<img src = '$URL/Images/NeedsAnIcon.png' border = '0' alt = '$LinkTitle (preview picture)' style = 'width:64px' align = 'left'/>";
                        }
                        //print ">".$Timestamp;
                        ?>


                        <div style = "width: 280px; height: 70px;">
                            <div style = "float: left; width: 64px; height:64px; background: url('<?php print $URL; ?>/Images/Icons/Article64x64.png') no-repeat;"></div>
                            <div style = "float: left; width: 180px; height:64px;">
                                <div style = "margin-left:10px">
                                    <span style = 'font-size: 12px; color: #ff0000;'><?php print $open_a_href; print $ShortenedLinkTitle; print '</a>'; ?></span><br/>
                                    <span style = "color:#555555; font-size:11px;">by Greg Sidelnikov</span><br/>
                                    <?php if (is_numeric($Timestamp)) { ?><span style = "color:#555555; font-size:11px;">Added <?php print tval(time(),$Timestamp); ?> ago</span><?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php

                    }

            ?></div></div><?php
        }
    }

    /* For bottom of page only */
    function DisplayImageColumnFromSource_BOTTOMONLY($Article, $DataSourceArray, $ColumnTitle, $MaxLinkTextLength, $Sector = "about", $MaxItemPerRow = 0, $MaxColumns = 0)
    {
        global $URL;
        $LinksNum = count($DataSourceArray);
        if (!empty($DataSourceArray) && $LinksNum > 0)
        {
            ?>

            <div style = "width:100%; padding:5px; border-bottom:1px solid silver; margin-bottom: 5px; color: gray">Related Articles:</div>

            <div class = "toc" style = "height: auto;">

                <div style = "padding:4px; padding-left:6px;"><?php

                    if ($LinksNum > 5)
                        $LinksNum = 5;

                    for ($i = 0; $i < $LinksNum; $i++)
                    {
                        $LinkTitle = $ShortenedLinkTitle = $DataSourceArray[$i]["title"];

                        if (strlen($ShortenedLinkTitle) > $MaxLinkTextLength)
                            $ShortenedLinkTitle = trim(substr($ShortenedLinkTitle, 0, $MaxLinkTextLength)) . "...";

                        $LinkLocation = $DataSourceArray[$i]["location"];
                        $AtomKey = $DataSourceArray[$i]["key"];

                        if ($Sector == 'about')
                            $Timestamp = $DataSourceArray[$i]["time_created"];
                        else
                            $Timestamp = $DataSourceArray[$i]["timestamp"];

                        if ($Sector == "blog")
                            $AtomKey = "b" . $AtomKey;

                        // print "</br></br>";

                        $SupposedPreviewImage = "$URL/Preview/" . $AtomKey . "/preview.jpg";
                        $a_href_already_opened = false;
                        $open_a_href = "<a href = '$URL/" . $Sector . "/" . $LinkLocation . "' title = '" . $LinkTitle . "'>";
                        $a_href_already_opened = true;

                        if ($Article['preview_image'] != "")
                        {
                            //print $open_a_href;
                            //print "<img src = '$URL/Preview/" . $DataSourceArray[$i]['key'] . $Article['preview_image'] . "' style = 'width:64px' border = '0' alt = '$LinkTitle (preview picture)' align = 'left'/>";
                        }
                        else
                        {
                            //print $open_a_href;
                            //print "<img src = '$URL/Images/NeedsAnIcon.png' border = '0' alt = '$LinkTitle (preview picture)' style = 'width:64px' align = 'left'/>";
                        }
                        //print ">".$Timestamp;
                        ?>

                        <div style = "width: 100%; height: 70px;">
                            <div style = "float: left; width: 64px; height:64px; background: url('<?php print $URL; ?>/Images/Icons/Article64x64.png') no-repeat;"></div>
                            <div style = "float: left; width: 280px; height:64px;">
                                <div style = "margin-left:10px">
                                    <span style = 'font-size: 12px; color: #ff0000;' class = "ArticleMoreLinkBlue"><?php print $open_a_href; print $ShortenedLinkTitle; print '</a>'; ?></span><br/>
                                    <span style = "color:#555555; font-size:11px;">by Greg Sidelnikov</span><br/>
                                    <?php if (is_numeric($Timestamp)) { ?><span style = "color:#555555; font-size:11px;">Added <?php print tval(time(),$Timestamp); ?> ago</span><?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php

                    }
        }
    }

  // return a total number of articles in the table
  function a_get_number() {
    $q = mysql_query("SELECT COUNT(*) FROM article");
    if ($q != FALSE) {
      $r = mysql_fetch_row($q);
      if ($r != FALSE) {
        if ($r[0])
          return $r[0];
      }
    }
    return false;
  }

  // get article ip address
  function a_get_ip($a_id) {
    $q = mysql_query("SELECT `ip` FROM `article` WHERE `key`='$a_id' LIMIT 1");
    if ($q != FALSE) {
      $r = mysql_fetch_row($q);
      if ($r != FALSE) {
        if ($r[0])
          return $r[0];
      }
    }
    return false; /* couldn't get article ip */
  }

  // get number of owner article visitors
  function u_get_visitor_number($u_id) {
    if (!is_numeric($u_id))
      return false;
    $q = mysql_query("SELECT `stats_article_visitors` FROM `user` WHERE `key`='$u_id' LIMIT 1");
      if ($q != FALSE) {
        $r = mysql_fetch_row($q);
          if ($r != FALSE)
            return $r[0];
      }
    }

  // get number of owner article visitors
  function a_get_visitor_number($a_id) {
    if (!is_numeric($a_id))
      return false;
    $q = mysql_query("SELECT `visitors` FROM `article` WHERE `key`='$a_id' LIMIT 1");
      if ($q != FALSE) {
        $r = mysql_fetch_row($q);
          if ($r != FALSE)
            return $r[0];
          else print mysql_error();
      } else print mysql_error();
    }

  // increase number of article visitors written by this user
  function u_increase_article_visitors($article_owner) {
  //return false;
   //print "u_increase_article_visitors($article_owner)<br>";

    if (!is_numeric($article_owner))
      return false;

    $av = 0;
    $q = mysql_query("SELECT `stats_article_visitors` from `user` WHERE `key`='$article_owner' LIMIT 1");
    if ($q != FALSE) {
      if (($r = mysql_fetch_row($q)) != FALSE) {
        if (is_numeric($r[0])) {
          $av = $r[0] + 1;
          $q = mysql_query("UPDATE `user` SET `stats_article_visitors` = '$av' WHERE `key`='$article_owner' LIMIT 1");
          if ($q != FALSE) { return $av; } else { print mysql_error(); }

        }
      }
    } else { print mysql_error(); }

    return false;
  }

  function a_get_ip_list($article_id) {
    if (!is_numeric($article_id)) {
      print "article id ($article_id) is not numeric<br>";
      return false;
    }
    $ip_list = "";
    if (($q = mysql_query("SELECT `ip_haystack` FROM `article` WHERE `key` = $article_id LIMIT 1")) != FALSE) {
      if (($r = mysql_fetch_row($q)) != FALSE) {
        //print "Returning : value = ".$r[0]."<br>";
        return $r[0];
      } else {
        print mysql_error();
        return false;
      }
    } else {
        print mysql_error();
        return false;
      }
      return false;
  }

  // returns the new number of visitors, if increased
  function a_parse_ip_list($haystack_list, $needle_ip, $article_key, $article_owner) {

  //print "running a_parse_ip_list<br>";

    if (!is_numeric($article_owner) || !is_numeric($article_key))
      return false;

    $f = false;
    $x = explode(":", $haystack_list);
    for ($i=0;$i<count($x);$i++) {
      if ($x[$i] == $needle_ip) {
        $f = true;
        break;
      }
    }

    if ($f) { // found ip, don't do anything, return true;
      return true;
    } else { // ip wasn't found on the list, add ip to the list

      $haystack_list .= "$needle_ip:";

      $v = count($x) - 1;

      $q = "UPDATE `article` SET `ip_haystack` = '$haystack_list', `visitors` = $v WHERE `key` = '$article_key' LIMIT 1";

      if (mysql_query($q) != FALSE)
      { /* ok, now add one point to the owner of the article */

        //print "running query $q<br>";
        //print "adding a visitor to $article_owner<br>";

        return u_increase_article_visitors($article_owner);
      } else { print "a_parse_ip_list(): ".mysql_error(); }
    }

  }

  // increases the number of unique visitors to this article
  // and returns the new number of visitors
  function a_increase_visitors($article_owner, $article_id) {

//    print "a_increase_visitors($article_owner, $article_id)<br>";

    global $qsession;

    if (!is_numeric($article_owner) || !is_numeric($article_id)) {
      print "either article_owner($article_owner) or article_id($article_id) is not numeric<br>";
      return false;
    }

    //print "logged in as: ".$qsession['user'].", vs. article owner = $article_owner<br>";

    // currently logged in user is also the author of this article, do not increase count
    if (q_isLoggedIn()) {



      if ($qsession['user'] == $article_owner) {
        //print "this article is being viewed by its owner (user compare)<br>";
        return false;
      }
    }

    $needle = $_SERVER["REMOTE_ADDR"];
    $aip    = a_get_ip($article_id);

    // ip matches ip the article was created from, do not increase count
    if ($needle == $aip)
      //print "this article is being viewed by its owner (ip compare)<br>";
      return false;

    $res = a_get_ip_list($article_id);

    if ($res == "" || $res != false) { /* return value can still be "" for new articles (no visitors) */
      return a_parse_ip_list($hay,$needle,$article_id,$article_owner);
    } else {
      print "Warning: unable to fetch ip haystack for this article<br>";
    }
  }

  function a_fetch_children($of_id) {
    if (!is_numeric($of_id))
      return false;
    $a = array();
    $q = mysql_query("SELECT `key`,`title` FROM `article` WHERE `attached_to` = '$of_id' LIMIT 200");
    if ($q != FALSE) {
      $i = 0;
      while ($r=mysql_fetch_row($q)) {
        $a[$i] = array($r[0], $r[1]);
        $i++;
      }
    }
    return $a;
  }

  function a_add($author_id, $cat, $title, $tags, $commentary, $filename, $article, $image=0, $approved = 1, $featured = 0, $attached_id = 0, $cluster = "") {
    $time_created = time();
    $time_edited  = 0;
    $visitors     = 0;
    $parent_title = "";
    $ip           = $_SERVER["REMOTE_ADDR"];

    if (is_numeric($attached_id) && $attached_id != 0) {

      // grab the title of the article this article is being attached to
      $q = mysql_query("SELECT `title` from `article` where `key`='$attached_id' LIMIT 1");
      if ($q != FALSE) {
        // ok
        if (($r = mysql_fetch_row($q)) != FALSE) {
          $parent_title = $r[0];
          if ($parent_title)
            print "This article has been attached to the parent article '<a href='$URL/article/$attached_id'>$parent_title</a>' and is now a part of its contents<br>";
        }
      } else {
        // unable to get parent article title
        print mysql_error();
      }
    }

    //$approved     = 1;
    $q = mysql_query("INSERT into `article` (author_id, cat, commentary, time_created, time_edited, visitors, article, title, tags, filename, approved, image, featured, attached_to, parent_title, ip, ip_haystack, cluster) values ('$author_id', '$cat', '$commentary', '$time_created', '$time_edited', '$visitors', '$article', '$title', '$tags', '$filename', '$approved', '$image', '$featured', '$attached_id', '$parent_title', '$ip', '', '$cluster')");
    if ($q!=FALSE) {
      print "inserted query id: ".mysql_insert_id()."<br>";
      return mysql_insert_id();
    }
    print mysql_error();
    return false;
  }

  function a_publish($key) {

  }

  function a_set($key, $author_id, $article) {
    if (($q = mysql_query("UPDATE `article` set `article` = '$article' WHERE author_id='$author_id' and `key`='$key' LIMIT 1"))!=FALSE)
      return true;
    return false;
  }

  function a_get($key,$limit=1000) {
    if (($q = mysql_query("SELECT author_id,title,cat,filename,article,time_created,time_edited,approved FROM article WHERE `key`='$key' LIMIT $limit"))!=FALSE) {
      if (($r=mysql_fetch_row($q))!=FALSE)
        return $r;
    }
    return false;
  }

  // parse article body for separate <h3> divs and return an array of title texts
  function a_return_page_divs($article, &$total_matches, $chapter = -1) {


      //    <a index="2.0" name="Meaning"><h3>The Persistence of Memory Meaning</h3></a>

      if ($chapter == -1) // grab all headers (default)
      //([0-9]).([0-9])\" name=\"(.*)\"><h1>(.*)</h1>}i
          $pattern = "{(a index[ ]?=[ ]?\"([0-9]*).([0-9]*)\") name[ ]?=[ ]?\"(.*)\"><h3>(.*)</h3>}i";
      else // grab sub-chapters only
          $pattern = "{(a index[ ]?=[ ]?\"(" . $chapter . ").([0-9]*)\") name[ ]?=[ ]?\"(.*)\"><h3>(.*)</h3>}i";

      //$article = "<a index=\"3.1\" name = \"nameabc\"><h1>artkle title</h1></a>";
      $total_matches = preg_match_all($pattern, $article, $matches);
      return $matches;
  }

  function replace_urls($text)
  {
      global $URL;

      $pattern = "URL";

      $replacement = "$URL";



        $string = 'April 15, 2003';
        $pattern = '/(\w+) (\d+), (\d+)/i';
        $replacement = '${1}1,$3';
        echo preg_replace($pattern, $replacement, $string)    ;

        return preg_replace("\a\i", "b", "abc");
  }

?>