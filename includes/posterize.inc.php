<?php
// process image with gd library to posterize it
        set_time_limit(0);
        imagetruecolortopalette($poster, true, 15);
        imagefilter($poster, IMG_FILTER_CONTRAST, -150);
        imagefilter($poster, IMG_FILTER_COLORIZE, 100, 0, 100);
        //header("content-type: image/jpeg");//not needed in html page
        imagejpeg($poster, UPLOAD_DIR.'poster.jpg');//save processed image
        imagedestroy($poster);
        //process image
?>