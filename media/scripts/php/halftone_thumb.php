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
     
     function screen(&$halftone) { //function screens image to halftone
	$imagex = imagesx($halftone);
	$imagey = imagesy($halftone);
	GLOBAL $black;

	for($x = 1; $x <= $imagex; $x += 2) {
	  imageline($halftone, $x, 0, $x, $imagey, $black);
	}

	for($y = 1; $y <= $imagey; $y += 2) {
	  imageline($halftone, 0, $y, $imagex, $y, $black);
	}
      }
      screen($poster);
      imagefilter($poster, IMG_FILTER_CONTRAST, -50);
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