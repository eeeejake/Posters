<?php
  $images = array(
                array('file' => 'django',
                      'caption' => 'Django Reinhardt'),
                array('file' => 'mug',
                      'caption' => 'My Face'),
                array('file' => 'rasputin',
                      'caption' => 'Rasputin'),
                array('file' => 'suit',
                      'caption' => 'Me in a suit'),
                array('file' => 'Franklin',
                      'caption' => 'Benjamin Franklin')
               );

    $folder= "/var/www/posters/media/images/";//the path to directory containing images
    $i = rand(0, count($images)-1);
    $selectedImage = "$folder{$images[$i]['file']}.jpg";
    $caption = $images[$i]['caption'];
    
    $image = imagecreatefromjpeg($selectedImage);
    set_time_limit(0);
    imagetruecolortopalette($image, true, 15);
    imagefilter($image, IMG_FILTER_CONTRAST, -150);
    imagefilter($image, IMG_FILTER_COLORIZE, 100, 0, 100); 
    header("content-type: image/jpeg");
    imagejpeg($image);
    imagedestroy($image);
    
    /*
    function posterize($img){
      imagecreatefromjpeg($img);
      set_time_limit(0);
      imagetruecolortopalette($img, true, 15);
      imagefilter($img, IMG_FILTER_CONTRAST, -150);
      imagefilter($img, IMG_FILTER_COLORIZE, 100, 0, 100); 
      header("content-type: image/jpeg");
      imagejpeg($img);
      imagedestroy($img);
    }
    posterize($selectedImage)
    
    /*
  foreach ( $images as $key => $value ) {
    $image = imagecreatefromjpeg($value.".jpg");
    set_time_limit(0);
    imagetruecolortopalette($image, true, 15);
    imagefilter($image, IMG_FILTER_CONTRAST, -150);
    imagefilter($image, IMG_FILTER_COLORIZE, 100, 0, 100); 
    header("content-type: image/jpeg");
    imagejpeg($image);
  // Do stuff with $value
  }
  */
    /*$totalElements = count( $images );
    for ( $j=0; $j < $totalElements; $j++ ) {
    $processedImage ="$folder{$images[$i]['file']}.jpg";*/
?>