<?php //uploads selected file to specified directory as original and thumbnail
//turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

    //define constants
    define('THUMBS_DIR', '/var/www/posters/media/thumbs/');
    define('MAX_WIDTH', 120);
    define('MAX_HEIGHT', 90);
  
  // process the uploaded image
  if (is_uploaded_file($_FILES['image']['tmp_name'])) {
    $original = $_FILES['image']['tmp_name'];
    // begin by getting the details of the original
    list($width, $height, $type) = getimagesize($original);
	// calculate the scaling ratio
    if ($width <= MAX_WIDTH && $height <= MAX_HEIGHT) {
      $ratio = 1;
      }
    elseif ($width > $height) {
      $ratio = MAX_WIDTH/$width;
      }
    else {
      $ratio = MAX_HEIGHT/$height;
      }
	// strip the extension off the image filename
	$imagetypes = array('/\.gif$/', '/\.jpg$/', '/\.jpeg$/', '/\.png$/');
    $name = preg_replace($imagetypes, '', basename($_FILES['image']['name']));
    
    // process image with gd library to posterize it
    $poster =imagecreatefromjpeg($original);
     
    function duotone (&$image, $rplus, $gplus, $bplus) {
    $imagex = imagesx($image);
    $imagey = imagesy($image);

    for ($x = 0; $x <$imagex; ++$x) {
        for ($y = 0; $y <$imagey; ++$y) {
            $rgb = imagecolorat($image, $x, $y);
            $red = ($rgb >> 16) & 0xFF;
            $green = ($rgb >> 8) & 0xFF;
            $blue = $rgb & 0xFF;
            $red = (int)(($red+$green+$blue)/3);
            $green = $red + $gplus;
            $blue = $red + $bplus;
            $red += $rplus;

            if ($red > 255) $red = 255;
            if ($green > 255) $green = 255;
            if ($blue > 255) $blue = 255;
            if ($red < 0) $red = 0;
            if ($green < 0) $green = 0;
            if ($blue < 0) $blue = 0;

            $newcol = imagecolorallocate ($image, $red,$green,$blue);
            imagesetpixel ($image, $x, $y, $newcol);
        }
    }
    } 
      duotone($poster, rand(0, 255), rand(0, 255),rand(0, 255));//generates three random number parameters for color
      set_time_limit(0);
      imagetruecolortopalette($poster, true, 2);
      header("image/jpg");
      imagejpeg($poster, UPLOAD_DIR.'poster.jpg');//save processed image
      imagedestroy($poster);
      //process image
		
     // move the temporary file to the upload folder
	$moved = move_uploaded_file($original, UPLOAD_DIR.$_FILES['image']['name']);
	
	$poster = UPLOAD_DIR.'poster.jpg';//retrieves posterized file for processing
	if ($moved) {
	  $result = $_FILES['image']['name'].' successfully uploaded; <br />Poster saved as poster.jpg';
	  $original = UPLOAD_DIR.$_FILES['image']['name'];
	  
	  }
	else {
	  $result = 'Problem uploading '.$_FILES['image']['name'].'; ';
	  }
	
	// create an image resource for the original
	switch($type) {
      case 1:
        //$source = @ imagecreatefromgif($original);//for normal thumbnail from original
	$source = @ imagecreatefromgif($poster);//for poster thumbnail
	    if (!$source) {
	      $result = 'Cannot process GIF files. Please use JPEG or PNG.';
	      }
	    break;
      case 2:
        //$source = imagecreatefromjpeg($original);//for normal thumbnail from original
	$source = imagecreatefromjpeg($poster);//for poster thumbnail
	    break;
      case 3:
        //$source = imagecreatefrompng($original);//for normal thumbnail from original
	$source = imagecreatefrompng($poster);//for poster thumbnail
	    break;
      default:
        $source = NULL;
	    $result = 'Cannot identify file type.';
      }
	// make sure the image resource is OK
	if (!$source) {
	  $result = 'Problem copying original';
	  }
	else {
	  // calculate the dimensions of the thumbnail
      $thumb_width = round($width * $ratio);
      $thumb_height = round($height * $ratio);
	  // create an image resource for the thumbnail
      $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	  // create the resized copy
	  imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
	  // save the resized copy
	  switch($type) {
        case 1:
	      if (function_exists('imagegif')) {
	        $success = imagegif($thumb, THUMBS_DIR.$name.'_thumb.gif');
	        $thumb_name = $name.'_thumb.gif';
		    }
	      else {
	        $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thumb.jpg', 50);
		    $thumb_name = $name.'_thumb.jpg';
		    }
	      break;
	    case 2:
	      $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thumb.jpg', 100);
	      $thumb_name = $name.'_thumb.jpg';
	      break;
	    case 3:
	      $success = imagepng($thumb, THUMBS_DIR.$name.'_thumb.png');
	      $thumb_name = $name.'_thumb.png';
	    }
		if ($success) {
		  $result = "poster.jpg created, $name original & poster.jpg saved in ".UPLOAD_DIR." <br /><br />$thumb_name created, saved in ".THUMBS_DIR."<br /><br />";
		  }
		else {
		  $result = 'Problem creating thumbnail';
		  }
	  // remove the image resources from memory
	  imagedestroy($source);
      imagedestroy($thumb);
	  }
	}
?>