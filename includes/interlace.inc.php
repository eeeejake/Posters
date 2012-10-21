<?php
     // process image with gd library to posterize it     
     function interlace (&$image) {
        $imagex = imagesx($image);
        $imagey = imagesy($image);
        GLOBAL $black;
        // loop through all rows in the image

        for ($y = 0; $y < $imagey; ++$y) {
            // if it is even...
            if ($y % 2) {
                // loop through all pixels in this row
                for ($x = 0; $x < $imagex; ++$x) {
                    // set them to black
                    ImageSetPixel($image, $x, $y, $black);
                }
            }
        }
    }
      interlace($poster);
      imagefilter($poster, IMG_FILTER_CONTRAST, -50);
      //header("content-type: image/jpeg");//not needed in html page
      imagejpeg($poster, UPLOAD_DIR.'poster.jpg');//save processed image
      imagedestroy($poster);
      //process image
?>