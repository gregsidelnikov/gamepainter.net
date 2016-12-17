<?php /* Minimalist image function library */

  // Display an image from default images location
  function image($filename, $alt, $abs = "") {
      global $URL,$IMAGE_DIR_NAME;

      $abs_text = "";

      if (!empty($alt) && $alt != "" && strlen($alt) > 0)
          $alt_text = 'alt = "' . $alt  . '"';

      if (!empty($abs) && $abs!= "" && strlen($abs) > 0)
          $abs_text = " style='vertical-align:middle'";


      ?><img src = "<?php print $URL . "/" . $IMAGE_DIR_NAME . "/" . $filename; ?>" <?php print $alt_text; ?> <?php print $abs_text; ?> /><?php

  }

  // Print full image URL from filename without <img/> tag
  function imageurl($filename) {
      global $URL,$IMAGE_DIR_NAME;
      print $URL . "/" . $IMAGE_DIR_NAME . "/" . $filename;
  }

  function scale_to_height($filename, $targetheight) {

    chmod($filename, 0755);

    $size = getimagesize($filename);
    $targetwidth = $targetheight * ($size[0] / $size[1]);
    return $targetwidth;

  }

  function scale2width($filename, $targetwidth) {

    chmod($filename, 0755);

    $size = getimagesize($filename);
    $targetheight = $targetwidth * ($size[1] / $size[0]);
    return $targetheight;

  }

  // offsetx and offsety are used to shift the image to the center, when resampling to a square image
  // for square images, square must be set to the width/height of the square being created

  // 4/2/2010 - force save as jpg no matter original format

  function resampleimg($srcimg,$dstpath,$maxx,$maxy,$quality,$size,$chmod=0755,$offsetx=0,$offsety=0,$square=0) {

    if (chmod($srcimg,0755))
    {
    //    print "/Lib/function.Image.php = resampleimg: chmoded\r\n";
	//    print "1";
    }

    // error handler
    $err = array(); // error msg array
    $eri = 0;       // error msg index

    $create_width = $maxx;
    $create_height = $maxy;
    if ($square>0)
      $create_width = $create_height = $square;

    if ($size[2] == 2) { //jpeg,jpg
      if (($img = imagecreatefromjpeg($srcimg))) {
        if (($copy = imagecreatetruecolor($create_width, $create_height))) {
          if (imagecopyresampled($copy, $img, $offsetx, $offsety, 0, 0, $maxx, $maxy, $size[0], $size[1])) {
            imagedestroy($img);
            if (imagejpeg($copy, $dstpath, $quality)!=true)
              $err[$eri++] = "imagejpeg() failed";
                else
                  return true;
          } else $err[$eri++] = "imagecopyresampled() failed";
        } else $err[$eri++] = "imagecreatetruecolor() failed";
      } else $err[$eri++] = "imagecreatefromjpeg() failed";
    } else

    if ($size[2] == 1) { // gif
      if (($img = imagecreatefromgif($srcimg))) {
        if (($copy = imagecreatetruecolor($create_width, $create_height))) {
          if (imagecopyresampled($copy, $img, $offsetx, $offsety, 0, 0, $maxx, $maxy, $size[0], $size[1])) {
            imagedestroy($img);
            if (imagejpeg($copy, $dstpath)!=true)
              $err[$eri++] = "imagegif(_imgcopyresource_,$dstpath) failed!";
                else
                  return true;
          } else $err[$eri++] = "imagecopyresampled() failed";
        } else $err[$eri++] = "imagecreatetruecolor() failed";
      } else $err[$eri++] = "imagecreatefromgif() failed";
    } else

    if ($size[2] == 3) { // IMG_PNG=3
      if (($img = imagecreatefrompng($srcimg))) {
        // set transparency if needed
        imagealphablending($img, false);
        imagesavealpha($img, true);
        if (($copy = imagecreatetruecolor($create_width, $create_height))) {
          if (imagecopyresampled($copy, $img, $offsetx, $offsety, 0, 0, $maxx, $maxy, $size[0], $size[1])) {
            imagedestroy($img);
            if (imagejpeg($copy, $dstpath)!=true)
              $err[$eri++] = "imagepng() failed";
                else
                  return true;
          } else $err[$eri++] = "imagecopyresampled() failed";
        } else $err[$eri++] = "imagecreatetruecolor() failed";
      } else $err[$eri++] = "imagecreatefrompng() failed";

    } else
      $err[$eri++] = "format ".$size[2]." not currently supported ($srcimg)";

    if (file_exists($dstpath))
      chmod($dstpath, $chmod);

    return $err;
  }

  function save_image($srcimg, $dstpath, $maxwidth, $chmod=0755, $quality=75) {

    chmod($srcimg,0755);

    $maxx = $maxwidth;

    $maxy = scale2width($srcimg, $maxwidth);

    $size = getimagesize($srcimg);

    return resampleimg($srcimg,$dstpath,$maxx,$maxy,$quality,$size,$chmod);
  }

  function save_image_to_square($srcimg, $dstpath, $max_sq_width, $chmod="0755", $quality=75) {

    chmod($srcimg,0755);

    if ($max_sq_width <= 0)
      return false;

    $maxy = $max_sq_width;
    $maxx = scale_to_height($srcimg, $max_sq_width);
    $size = getimagesize($srcimg);
    $offsetx=$max_sq_width/2;

    //if ($maxx<$max_sq_width)
    //$offsetx++;

    $offsetx -= $maxx*0.5; // this will pad to exact middle of the image
    return resampleimg($srcimg,$dstpath,$maxx,$maxy,$quality,$size,$chmod,$offsetx,0,$max_sq_width);
  }

?>