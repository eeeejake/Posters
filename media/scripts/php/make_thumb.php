<?php
if (array_key_exists('create', $_POST)) {
    //define constants
    define('SOURCE_DIR', '/var/www/posters/media/uploads/');
    define('THUMBS_DIR', '/var/www/posters/media/thumbs/');
    define('MAX_WIDTH', 120);
    define('MAX_HEIGHT', 90);
  
//get image name and build full pathname
if (!empty($_POST['pix'])) {
        $original = SOURCE_DIR.$_POST['pix'];
    }
    else {
        $original = NULL;
    }
    //abandon processing if no image is selected
    if(!$original){
    $result = 'No image selected';
    }
    //otherwise resize the image
    else {
    //begin by getting the details of the original
    list($width, $height, $type) = getimagesize($original);
    //calculate the scaling ratio
    if ($width <= MAX_WIDTH && $height <= MAX_HEIGHT) {
        $ratio=1;
        }
    elseif ($width > $height) {
        $ratio= MAX_WIDTH/$width;
        }
    else {
        $ratio = MAX_HEIGHT/$height;
    }
   
    //strip extension off of filename
    $imagetypes = array('/\.gif$/','/\.jpg$/','/\.jpeg$/','/\.png$/');
    $name = preg_replace($imagetypes, '', basename($original));
    
    // create an image resource for the original
    switch($type) {
        case 1:
        $source = @ imagecreatefromgif($original);
	    if (!$source) {
	      $result = 'Cannot process GIF files. Please use JPEG or PNG.';
	      }
	    break;
        case 2:
        $source = imagecreatefromjpeg($original);
	    break;
        case 3:
        $source = imagecreatefrompng($original);
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
	        $success = imagegif($thumb, THUMBS_DIR.$name.'_thb.gif');
	        $thumb_name = $name.'_thb.gif';
		    }
	    else {
	        $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thb.jpg', 50);
		    $thumb_name = $name.'_thb.jpg';
		    }
	    break;
	case 2:
	    $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thb.jpg', 100);
	    $thumb_name = $name.'_thb.jpg';
	    break;
	case 3:
	    $success = imagepng($thumb, THUMBS_DIR.$name.'_thb.png');
	    $thumb_name = $name.'_thb.png';
            }
	    if ($success) {
		  $result = "$thumb_name created";
		  }
            else {
                $result ='Problem creating thumbnail';
            }
	  // remove the image resources from memory
            imagedestroy($source);
            imagedestroy($thumb);
	}
    }
}
?>