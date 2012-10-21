<?php
// process the uploaded image
  $image = imagecreatefrompng($selectedImage);
  set_time_limit(0);
  imagetruecolortopalette($image, true, 15);
  imagefilter($image, IMG_FILTER_CONTRAST, -150);
  //imagefilter($image, IMG_FILTER_COLORIZE, 100, 0, 100); 
  //imagefilter($image, IMG_FILTER_EDGEDETECT);
  //imagefilter($image, IMG_FILTER_NEGATE);
  imagefilter($image, IMG_FILTER_GRAYSCALE);
  imagefilter($image, IMG_FILTER_SMOOTH, 20);
  header("content-type: image/png");
  imagejpeg($image);
  imagedestroy($image);
?>