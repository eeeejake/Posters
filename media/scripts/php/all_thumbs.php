<?php //uploads selected file to specified directory as original and thumbnail

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
    
     //switch to pick process for current page
    $currentPage = basename($_SERVER['SCRIPT_NAME']);//get name of current page to determine image processing
    switch($currentPage) {
      case 'thumbnailer.php':
	    //use regular thumbnail code
	    break;
      case 'posterize.php':
        //use posterize code
	    include('includes/posterize.inc.php');
	    break;
      case 'halftone.php':
        //use halftone code
	    include('includes/halftone.inc.php');
	    break;
      case 'interlace.php':
        //use interlace code
	    include('includes/interlace.inc.php');
	    break;
      case 'duotone.php':
        //use duotone code
	    include('includes/duotone.inc.php');
	    break;
      case 'random.php':
        //use random code
	    include('includes/random.inc.php');
	    break;
      default:
        $currentPage = NULL;
	    $result = 'Not a valid Process';
      }
      if ($currentPage == 'thumbnailer.php'){	//either save as thumbnail with name, or poster.jpg
     // move the temporary file to the upload folder
	$moved = move_uploaded_file($original, UPLOAD_DIR.$_FILES['image']['name']);//copies original with original name to upload dir
      }
      else {
	$poster = UPLOAD_DIR.'poster.jpg';//retrieves posterized file for processing
	$moved = $poster;
      }
	if ($moved) {
	  $result = $_FILES['image']['name'].' successfully uploaded; <br />Poster saved as poster.jpg';
	  $original = UPLOAD_DIR.$_FILES['image']['name'];
	  
	  }
	else {
	  $result = 'Problem uploading '.$_FILES['image']['name'].'; ';
	  }
	
      if ($currentPage == 'thumbnailer.php'){
	  // create an image resource from the original
	  switch($type) {
      case 1:
        $source = @ imagecreatefromgif($original);//for normal thumbnail from original
	    if (!$source) {
	      $result = 'Cannot process GIF files. Please use JPEG or PNG.';
	      }
	    break;
      case 2:
        $source = imagecreatefromjpeg($original);//for normal thumbnail from original
	    break;
      case 3:
        $source = imagecreatefrompng($original);//for normal thumbnail from original
	    break;
      default:
        $source = NULL;
	    $result = 'Cannot identify file type.';
      }
	}
	else{
	// create an image resource from the posterized version
	switch($type) {
      case 1:
	$source = @ imagecreatefromgif($poster);//for poster thumbnail
	    if (!$source) {
	      $result = 'Cannot process GIF files. Please use JPG or PNG.';
	      }
	    break;
      case 2:
	$source = imagecreatefromjpeg($poster);//for poster thumbnail
	    break;
      case 3:
	$source = imagecreatefrompng($poster);//for poster thumbnail
	    break;
      default:
        $source = NULL;
	    $result = 'Cannot identify file type.';
      }
      }
	// make sure the image resource is OK
	if (!$source) {
	  $result = 'Problem copying original';
	  }
	else {
	   if ($currentPage == 'thumbnailer.php'){//for regular thumbnail
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
	   }
	   else{
	   //for poster thumbnail
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
	        $success = imagegif($thumb, THUMBS_DIR.'poster_thumb.gif');
	        $thumb_name = 'poster_thumb.gif';
		    }
	      else {
	        $success = imagejpeg($thumb, THUMBS_DIR.'poster_thumb.jpg', 50);
		    $thumb_name = 'poster_thumb.jpg';
		    }
	      break;
	    case 2:
	      $success = imagejpeg($thumb, THUMBS_DIR.'poster_thumb.jpg', 100);
	      $thumb_name = 'poster_thumb.jpg';
	      break;
	    case 3:
	      $success = imagepng($thumb, THUMBS_DIR.'poster_thumb.png');
	      $thumb_name = 'poster_thumb.png';
	    }
	   }
	    //output message
		if ($success) {
		  if ($currentPage == 'thumbnailer.php'){//for regular thumbnail creator
		  $result = "$name original saved in ".UPLOAD_DIR." <br /><br />$thumb_name created, saved in ".THUMBS_DIR."<br /><br />";
		  }
		  else {//for poster creator
		  $result = "poster.jpg created, $name poster.jpg saved in ".UPLOAD_DIR." <br /><br />$thumb_name created, saved in ".THUMBS_DIR."<br /><br />";  
		  }
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