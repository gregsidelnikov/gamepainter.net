<?php
    include(__DIR__ . '/../../Migration/Composition.php');
    $db = new db();
    function ExplodeFileAtExtention($Filename) { $len = strlen($Filename); for ($i=0;$i<$len;$i++) { $curidx = $len-($i+1); if ($Filename[$curidx] == '.') { return array(substr($Filename, 0, $curidx), substr($Filename, $curidx + 1)); } } }
    $ok = 1;
    $FinalFilename = $_REQUEST['fkid'].".jpg";
    $fkid = $_REQUEST['fkid'];
    
    if (!is_numeric($fkid)) {
    	print "Image upload failed, error id#unknown";
    	exit;
    }
    
    $status = "File is being prepared for an upload";
    /* ------------ upload folder ---------------- */    
	    $UploadFolder = "/user/sub";
    /* ------------------------------------------- */
        
    // Delete all previous ones
	unlink($FILESYSTEM . $UploadFolder . "/original/" . $FinalFilename);
	unlink($FILESYSTEM . $UploadFolder . "/16/" . $FinalFilename);
	unlink($FILESYSTEM . $UploadFolder . "/32/" . $FinalFilename);
	unlink($FILESYSTEM . $UploadFolder . "/64/" . $FinalFilename);
	
//	exit;
        
    if (move_uploaded_file($_FILES['file']['tmp_name'], $FILESYSTEM . $UploadFolder . "/original/" . $FinalFilename)) { $ok = 2;
    
//		print "File uploaded. --";
    
        $path1 = $FILESYSTEM . $UploadFolder . '/original/' . $FinalFilename;
        $path2 = $FILESYSTEM . $UploadFolder . '/16/' . $FinalFilename;
        $path3 = $FILESYSTEM . $UploadFolder . '/32/' . $FinalFilename;
        $path4 = $FILESYSTEM . $UploadFolder . '/64/' . $FinalFilename;
        // resize original to minimum width -- but only if its bigger than 325px in width
        $imgsize = getimagesize($path1); if ($imgsize[0] > 325) save_image($path1, $path1, 325, 0755, 75);

//        chmod($FILESYSTEM . $UploadFolder . '/original/' . $FinalFilename, 0755);
        
        // create micro tiny picture
        if (save_image_to_square($FILESYSTEM . $UploadFolder . "/original/" . $FinalFilename,
                                 $FILESYSTEM . $UploadFolder . "/16/" . $FinalFilename , 16, 0755, 75)) {
            if (save_image_to_square($FILESYSTEM . $UploadFolder . "/original/" . $FinalFilename,
                                     $FILESYSTEM . $UploadFolder . "/32/" . $FinalFilename, 32, 0755, 75)) { // icon
                if (save_image_to_square($FILESYSTEM . $UploadFolder . "/original/" . $FinalFilename,
                                         $FILESYSTEM . $UploadFolder . "/64/" . $FinalFilename, 64, 0755, 75)) { // profile
                    $status = "<span style = 'color: green;'>The file has been uploaded successfully!</span>"; $ok = 3;
                } else { $ok = 0; $status = "A"; }
            } else { $ok = 0; $status = "B"; }
        } else { $ok = 0; $status = "C"; } 
                
    }
    else { $ok = 0; $a = error_get_last(); $status = $a[0]."|".$a[1]."|".$a[2]."|".$a[3]; }
    if ($ok == 0) $status = "<span style = 'color: red;'>Sorry, there was a problem uploading your file err#".$status."</span>"; else $status = "all done";
    if ($ok == 3) // Update in database
        $db->set("subscribers", array("empty_pic"), array("1"), "`key` = $fkid");
?>
<script language  = "javascript">
	console.log("Pic uploaded ok..");
	console.log(window.parent.$);
    <?php $FinalImage16 = $URL . $UploadFolder . "/16/" . $FinalFilename;
        $FinalImage32 = $URL . $UploadFolder . "/32/" . $FinalFilename;
        $FinalImage64 = $URL . $UploadFolder . "/64/" . $FinalFilename; ?>
    var parDoc = window.parent.document;
//    window.parent.$('#upload_status').html("Ok!---<?php print $status; ?>");
//    window.parent.$('#img_prev<?php print $fkid; ?>').css( { "background" : "url(<?php echo $URL; ?>'/<?php echo $UploadFolder; ?>/32/<?php echo $FinalFilename; ?>')" } );
    window.parent.$('#ppic_prev').css( { "background" : "url('<?php print $FinalImage64; ?>?v=A<?php print time(); ?>')" } );
//    window.parent.$('#ppic_prev').css( { "border" : Math.ceil( Math.random() * 10 ) + "px" } );

</script>
