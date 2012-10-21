<?php
 // process image with gd library to posterize it
 
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
      //header("content-type: image/jpeg");//not needed in html page
      imagejpeg($poster, UPLOAD_DIR.'poster.jpg');//save processed image
      imagedestroy($poster);
      //process image
?>