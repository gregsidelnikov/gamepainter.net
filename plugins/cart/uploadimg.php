<?php
    include('../../Migration/Composition.php');

    $Connection = new db();



    //$FeedID = $_GET['a'];

    //$feed_message_id = $_GET['b'];

    /*
    if (isset($Connection) && $Connection->isReady())
    {
        q_session_login_sequence();

        if (!q_isLoggedIn())
        {
             exit;
        }
    }*/

    function ExplodeFileAtExtention($Filename)
    {
        $len = strlen($Filename);
        for ($i=0;$i<$len;$i++)
        {
            $curidx = $len-($i+1);
            if ($Filename[$curidx] == '.')
            {
                return array(substr($Filename, 0, $curidx), substr($Filename, $curidx + 1));
            }
        }
    }
    $ok = 1;


    $UploadFolder = "plugins/cart";
    $FinalFilename = $_REQUEST['fkid'].".jpg";
    $fkid = $_REQUEST['fkid'];

    $status = "File is being prepared for an upload";
    

    chmod($FILESYSTEM.'/plugins', 0755);
    chmod($FILESYSTEM.'/plugins/cart', 0755);
    chmod($FILESYSTEM.'/plugins/cart/Original', 0755);
    

    if(move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $FILESYSTEM . "/plugins/cart/pictures/Original/".$FinalFilename))
    {

        $ok=2;

        $path1 = $FILESYSTEM . '/plugins/cart/pictures/Original/' . $FinalFilename;
        $path2 = $FILESYSTEM . '/plugins/cart/pictures/16/' . $FinalFilename;
        $path3 = $FILESYSTEM . '/plugins/cart/pictures/32/' . $FinalFilename;
        $path4 = $FILESYSTEM . '/plugins/cart/pictures/64/' . $FinalFilename;

        // resize original to minimum width -- but only if its bigger than 325px in width
        $imgsize = getimagesize($path1);
        
        //print_r($imgsize);
        
        if ($imgsize[0] > 325)
            save_image($path1, $path1, 325, 0755, 75);

        chmod($FILESYSTEM.'/plugins/cart/Original/'.$FinalFilename, 0755);

        // create micro tiny picture
        if (save_image_to_square($FILESYSTEM."/plugins/cart/pictures/Original/" . $FinalFilename,
                                 $FILESYSTEM."/plugins/cart/pictures/16/" . $FinalFilename , 16, 0755, 75))
        {
            if (save_image_to_square($FILESYSTEM."/plugins/cart/pictures/Original/" . $FinalFilename,
                                     $FILESYSTEM."/plugins/cart/pictures/32/" . $FinalFilename, 32, 0755, 75)) // icon
            {
                if (save_image_to_square($FILESYSTEM."/plugins/cart/pictures/Original/" . $FinalFilename,
                                         $FILESYSTEM."/plugins/cart/pictures/64/" . $FinalFilename, 64, 0755, 75)) // profile
                {
                    $status = "<span style = 'color: green;'>The file has been uploaded successfully!</span>";
                    $ok = 3;
                }
                else
                {
                    $ok = 0;
                    $status = "A";
                }
            }
            else
            {
                $ok = 0;
                $status = "B";
            }
        }
        else
        {
            $ok = 0;
            $status = "C";
        }



/*

  $FILE = $FILESYSTEM . "/plugins/cart/pictures/Original/1.jpg";

  $FILE2 = $FILESYSTEM . "/plugins/cart/pictures/64/1.jpg";

  if (chmod($FILE, 0755))
  {
      print "cmod for $FILE success";
  }
  else
  {
      print "chmod for $FILE failure";
  }

  $srcimg = $FILE;

  $dstimg = $FILE2;

  $create_width = 100;

  $create_height = 100;

  $offsetx = 0;

  $offsety = 0;

  $maxx = 200;
  $maxy = 200;

  $size = getimagesize($srcimg);

  $quality = 70;

  $err = array(); $eri = 0;

  $dstpath = $dstimg;

          if (($img = imagecreatefromjpeg($srcimg))) {
            if (($copy = imagecreatetruecolor($create_width, $create_height))) {
              if (imagecopyresampled($copy, $img, $offsetx, $offsety, 0, 0, $maxx, $maxy, $size[0], $size[1])) {
                imagedestroy($img);
                if (imagejpeg($copy, $dstpath, $quality)!=true)
                  $err[$eri++] = "imagejpeg() failed";

              } else $err[$eri++] = "imagecopyresampled() failed";
            } else $err[$eri++] = "imagecreatetruecolor() failed";
          } else $err[$eri++] = "imagecreatefromjpeg() failed";
        */



    }
    else
    {

        $ok = 0;
        $a = error_get_last();
        $status = $a[0]."|".$a[1]."|".$a[2]."|".$a[3];//count($a);//implode("|",$a);
    }

    if ($ok == 0)
        $status = "<span style = 'color: red;'>Sorry, there was a problem uploading your file err#".$status."</span>";
        else
        $status = "all done ";
    //print "$ok<br/>$FILESYSTEM";
?>

<script language  = "javascript">
//alert("<?php print $URL . "/plugins/cart/pictures/64/" . $FinalFilename; ?>");
    var parDoc = window.parent.document;
    window.parent.$('#upload_status').html("Ok!<?php print $status; ?>");
    window.parent.$('#img_prev<?php print $fkid; ?>').css( { "background" : "url(<?php echo $URL; ?>'/plugins/cart/pictures/32/<?php echo $FinalFilename; ?>')" } );
    window.parent.$('#ppic_prev').css( { "border":"1px transparent white","background" : "url(''<?php echo $URL; ?>/plugins/cart/pictures/64/<?php echo $FinalFilename; ?>')" } );
//    parDoc.getElementById("upload_status").innerHTML = "<?php print $status; ?>";
//    parDoc.getElementById("upload_status").disabled = false; 
    //parDoc.getElementById("filebtn").disabled = false;

    <?php
        //$Expl = ExplodeFileAtExtention($Filename);
        //$FilenameThumb = $Expl[0] . '.tn.' . $Expl[1];
        $FinalImage16 = $URL . "/plugins/cart/16/" . $FinalFilename;
        $FinalImage32 = $URL . "/plugins/cart/32/" . $FinalFilename;
        $FinalImage64 = $URL . "/plugins/cart/64/" . $FinalFilename;
    ?>
    
   // parDoc.getElementById("upload_status").innerHTML = "<?php print $FinalImage16; ?>";

    // Update image icons
//    window.parent.$('#TinyImage').css("background-image", "url(<?php print $FinalImage16; ?>)");
//    window.parent.$('#Icon').css("background-image", "url(<?php print $FinalImage32; ?>)");
//    window.parent.$('#ProfileImage').css("background-image", "url(<?php print $FinalImage64; ?>)");

    //var arr = ['<?php print $qsession['user']; ?>'];
//     var arr = ['1'];
//    window.parent.ajax.httpExecute(window.parent.SuccessEvent_UserSetHasImage, window.parent.USERSETHASIMAGE, arr);

</script>
