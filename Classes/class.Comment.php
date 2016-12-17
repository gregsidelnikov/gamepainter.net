<?php

// the comment type enumeration
$PC_TYPE = array(
    "PROFILE_THREAD" => 0,
    "PROFILE_REPLY"  => 1,
    "PICTURE"        => 2,
    "ATOM"           => 3, // article OR blog
    "BLOG"           => 4,
    "OPINION"        => 5,
    "COMMUNITY"      => 6);

class comment {

    // post profile comment
    function post_profile_comment($author_id,
    $author_username,
    $comment,
    $parent_type = 0,
    $need_approve = 0,         // requiers owner approval
    $parent_secondary_id = -1, // original comments don't have secondary id's, only comments of comments
    $parent_id = -1) {
        // ( only replies do )
        global
        $COMMENT_SET_ALL;
        $flag        = 0;
        $vote_up     = 0;
        $vote_down   = 0;
        $time        = time();
        $VALUES      = array(
            $parent_type,
            $parent_id,
            $parent_secondary_id,
            $author_id,
            $author_username,
            $comment,
            $need_approve,
            $flag,
            $vote_up,
            $vote_down,
            $time);

            //print "post_profile_comment():<br>";
            //print_g($VALUES);

            // ~todo: Check if the 3 most recent comments already contain the same exact text - to prevent double posting

        $ret = insert_table_data("comment",
        $COMMENT_SET_ALL,
        $VALUES);

        if (is_numeric($ret))
            return $ret;
        return false;
    }

    function update_profile_comment($key_id, $comment) {
        global
        $COMMENT_UPD;
        $time = time();
        $columns = $COMMENT_UPD;
        $values = array ($comment, $time);
        if (set_table_data("comment", $columns, $values, "`key` = '$key_id'", "1"))
            return true;
        return false;
    }

    function r_sort_comments(&$c, &$attached_n) {
        print "r_sort_comments($c,$attached_n)<br>";
        for ($i=0; $i < count($c); $i++) {
            $state       = $c[$i]["attached"];
            $key         = $c[$i][0];
            $parent      = $c[$i][2];
            if ($parent != 0)
                print "parent > $parent<br>";
            if ($state == false && $parent != 0) {
                $n = $c[$parent]["cildren"];
                $c[$parent]["attached"] = true;
                $t = "$child$n";
                $c[$parent][$t] = $c[$i];
                $c[$i] = null;
                $attached_n++;
                print "attached_n = $attached_n<br>";
                if ($attached_n > 10)
                    return;
                else
                $this->r_sort_comments($c,$attached_n);
            }
        }
    }

    function load_profile_comment_node($c, $node, $level) {
        for ($i=0;$i<count($c);$i++) {
            $key       = $c[$i][0];
            $typ       = $c[$i][1];
            $parent_id = $c[$i][2];
            $n         = $c[$i][3];
            $id        = $c[$i][4];
            $un        = $c[$i][5];
            $cm        = $c[$i][6];
            if ($n == $node && $c[$i]["leafed"] != true) {
                for ($j=0;$j<$level;$j++)
                print "....";
                print "$cm by $un($id)<br>";
                $c[$i]["leafed"] = true;
                $this->load_profile_comment_node($c, $key, $level + 1);
            }
        }
    }

    // is not limited to just profile comments, as the function name suggests
    function display_profile_comments($parent_id, $parent_type = 0) {
        global
        $COMMENT_GET_ALL, $qsession;
        $c = get_table_data("`comment`", $COMMENT_GET_ALL, "`parent_type` = '$parent_type' and `parent_secondary_id` = -1 and `parent_id` = '$parent_id'", "`time` DESC");
        $numc = count($c);
        if ($numc > 0) {
            $n = get_table_data("`comment`", $COMMENT_GET_ALL, "`parent_type` = '$parent_type' and `parent_secondary_id` != -1 and `parent_id` = '$parent_id'");
            $level = 1;
            $numn = count($n); ?>
      <div id = "newComment"></div>
<script language="javascript"><!--
      <?php for ($i=0; $i<$numc; $i++) {
                ?>var cs<?php print $i; ?>=false;<?php
            } ?>
//--></script>
      <?php
      for ($i=0; $i<$numc; $i++) {
                $key       = $c[$i][0];
                $typ       = $c[$i][1];
                $parent_id = $c[$i][2];
                $node      = $c[$i][3];
                $id        = $c[$i][4];
                $un        = $c[$i][5];
                $cm        = $c[$i][6];
                $v_up      = $c[$i][9];
                $v_dn      = $c[$i][10];
                $t         = $c[$i][11];
                $voteScore = $v_up - $v_dn;
                ?>
                      <div style="position: relative; border: 1px solid #666666; margin-bottom: 4px;">
      <table border=0 cellspacing=0>
       <tr>
        <td style="width:100%; padding:10px;">
        <div style='width:auto;'>
        <table>
         <tr>
          <td width="100%">
            <?php print $cm; ?><p> <?php /* Comment Body */ ?>
                <?php

                print "by "; ?>
                  
                  <span style="border:1px solid blue"><a href="http://localhost/root/bio.php?u=<?php print $id; ?>"><?php print $un; ?></a></span><?php

                print " posted " . tval(time(),$t) . " ago";

                ?>
                          </td>
            <td valign = "top">
                
             <table border="0" class = "cellspacing0">
             <tr>
             <td style = "align: center; text-align: center; padding-top: 14px; padding-right:4px;">
             
              <?php
              $iVal = $voteScore;
                $sVal = "";
                if ($iVal >= 0)
                    $sVal = "+";
                else
                $sVal = "-";
                $normalPositive = "#0F0";
                $normalNegative = "#F00"; ?>              
              <div style="font-size: 10px; text-align:right; color:<?php if ($iVal >= 0) print $normalPositive; else print $normalNegative ?>;" id="valOriginal<?php print $i; ?>"><?php if ($sVal == "+" && $iVal != 0) print "+";
                print $iVal; ?></div>
              <div style="font-size: 10px; display:none; text-align:right; color:<?php if (($iVal + 1) >= 0) print $normalPositive; else print $normalNegative ?>;" id="valPlus<?php print $i; ?>"><?php if ($iVal + 1 > 0) print "+";
                print $iVal + 1; ?></div>
              <div style="font-size: 10px; display:none; text-align:right; color:<?php if (($iVal - 1) >= 0) print $normalPositive; else print $normalNegative ?>;" id="valMinus<?php print $i; ?>"><?php if ($iVal - 1 > 0) print "+";
                print $iVal - 1; ?></div>

             </td><td style = "padding-top: 15px">
             
             <div id = "auth<?php print $i; ?>yes"
                  class = "comParagraphInvisibleYes"
                  style = "cursor: pointer;"
                onclick = "this.className='comParagraphOk';
                             if (ajax.httpAsyncRequest('POST',
                                                       'http://localhost/root/ajax/ratecomment.php',
                                                       'a=<?php print $key; ?>&b=1&c=<?php print $id; ?>&d=<?php print $v_up; ?>&e=<?php print $v_dn; ?>&f=1')) {
                                                       
                                                        this.className = 'comParagraphOk';
                                                        cs<?php print $i; ?> = true;

                                                        setdivdisplay('valOriginal<?php print $i; ?>', 'none');
                                                        setdivdisplay('valPlus<?php print $i; ?>', 'block');
                                                        setdivvis('auth<?php print $i; ?>no', 'hidden'); }" 
             onmouseover = "if (this && this.className != 'comParagraphOk') this.className = 'comParagraphIdleYes'"
             onmouseout = "if (this && this.className != 'comParagraphOk') { this.className = 'comParagraphInvisibleYes'; }">
             
             </td><td style = "padding-top: 15px">
             
             <div id = "auth<?php print $i; ?>no"
                  class = "comParagraphInvisibleNo"
                  style = "cursor: pointer;"
                onclick = "this.className='comParagraphOk';
                if (ajax.httpAsyncRequest('POST',
                                               'http://localhost/root/ajax/ratecomment.php',
                                               'a=<?php print $key; ?>&b=-1&c=<?php print $id; ?>&d=<?php print $v_up; ?>&e=<?php print $v_dn; ?>&f=1')) {
                                               
                                               this.className = 'comParagraphOk';
                                               cs<?php print $i; ?> = true;

                                               setdivdisplay('valOriginal<?php print $i; ?>', 'none');
                                               setdivdisplay('valMinus<?php print $i; ?>', 'block');
                                               setdivvis('auth<?php print $i; ?>yes', 'hidden'); }"
             onmouseover = "if (this && this.className != 'comParagraphOk') this.className = 'comParagraphIdleNo'"
             onmouseout = "if (this && this.className != 'comParagraphOk') { this.className = 'comParagraphInvisibleNo'; }">
             
             </td>
             </tr>
             </table>                

            </td>
            
           </tr>
           
          </table>          
          
        </div>
        
      <?php /* $this->load_profile_comment_node($n, $key, $level); */ ?>
       </td>
          <td style="vertical-align: top; width:64px;">
          <?php if (q_isLoggedIn() && $id == $qsession['user'] && $comment_del_isEnabled) {
                    ?>
                                <div class="div-0" onmouseover = "this.className='div-1';"
                               onmouseout  = "this.className='div-0';"
                               onclick     = "comments.delete('id');"
                               style       = "cursor:pointer;">
                               <img src="http://localhost/authenticsociety.com/img/closequestion.gif" alt="Delete this comment">
            <?php
                } ?>
          </td>
        </tr>
      </table>
      </div>
      <?php

            }
        }
        else
        {
            //print "<i>There are no public comments on this page</i>";
        }
        return array($numc, $numn);
    }
}

?>