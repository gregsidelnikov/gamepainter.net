<?php

	include("../Migration/Composition.php");
	
	$db = new db();
	
	$o1 = $_REQUEST["o1"]; // pages (article, no-dir, webpage)
	$o2 = $_REQUEST["o2"]; // blogs
	$o3 = $_REQUEST["o3"]; // drafts
	$o4 = $_REQUEST["o4"]; // deleted
	
	$where = "";
	$keyword = $_REQUEST["query"];
	if ($keyword == "") {

	} else {
        $where .= "(`title` LIKE '%" . $keyword . "%'";
    	$where .= " OR `keywords` LIKE '%" . $keyword . "%'";
	    $where .= " OR `description` LIKE '%" . $keyword . "%'";
	    $where .= " OR `browser_title` LIKE '%" . $keyword . "%') AND ";
	}
	
	$PAGES_ONLY = 0;
	if ($o1 == 1 && $o2 == 0)
	    $PAGES_ONLY = 1;
	
	$BLOG_DRAFT_ONLY = 0;
	if ($o2 == 1 && $o3 == 1) {
	    $BLOG_DRAFT_ONLY = 1;
	}
	
	if ($o1 == 0 && $o2 == 1) {
		$where .= "`type` = 'blog'";
	} else {
	    if ($PAGES_ONLY == 0)
        	$where .= "(`type` = 'homepage' OR `type` = 'nodir' OR `type` = 'no_dir' OR `type` = 'content' OR `type` = 'webpage' OR `type` = 'article' OR `type` = 'about' OR `type` = 'none' OR `type` = 'blog')";
        else
            $where .= "(`type` = 'homepage' OR `type` = 'nodir' OR `type` = 'no_dir' OR `type` = 'content' OR `type` = 'webpage' OR `type` = 'article' OR `type` = 'about' OR `type` = 'none')";
    }

    if ($o3 == 1)
    {
        $where .= " AND `draft` = 1";
    }
    else
    {
        // If "blog" but no "draft", still display drafts (more intuitive)
        if ($BLOG_DRAFT_ONLY == 0)
        {
        
        }
        else
        {
            $where .= " AND `draft` != 1";
        }    
    }

   	if ($o4 == 1) $where .= " AND `deleted` = 1"; else $where .= " AND `deleted` != 1";  
  	
  	$Articles = db::get("content", "*", $where, "`navi_order` DESC", "");
  	
  	$c = count($Articles);
  	
    ?><ul class = "q_a"><?php
	
	if (!empty($Articles))
	for ($i = count($Articles) - 1; $i >= 0 ; $i--) {
        $type = $Articles[$i]["type"];
        $title = $Articles[$i]["title"];
        $article_key = $Articles[$i]['key'];
        $article_template = $Articles[$i]['template'];
        $draft = $Articles[$i]['draft'];
        $location = $Articles[$i]['location'];
        $in_navigation = $Articles[$i]['navi'];
        
        include("scheduled_article.php");
    }
    
    ?></ul><?php

?>