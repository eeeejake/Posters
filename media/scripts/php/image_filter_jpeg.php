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
  $i = rand(0, count($images)-1);
  $selectedImage = "/var/www/posters/media/images/{$images[$i]['file']}.jpg";
  $caption = $images[$i]['caption'];
  //$image = imagecreatefromjpeg('/var/www/posters/media/images/django.jpg');
  $image = imagecreatefromjpeg($selectedImage);
  set_time_limit(0);
  imagetruecolortopalette($image, true, 15);
  //imagefilter($image, IMG_FILTER_MEAN_REMOVAL);
  imagefilter($image, IMG_FILTER_CONTRAST, -150);
  imagefilter($image, IMG_FILTER_COLORIZE, 100, 0, 100); 
  //imagefilter($image, IMG_FILTER_EDGEDETECT);
  //imagefilter($image, IMG_FILTER_NEGATE);
  //imagefilter($image, IMG_FILTER_GRAYSCALE);
  //imagefilter($image, IMG_FILTER_SMOOTH, 20);
  header("content-type: image/jpeg");
  imagejpeg($image);
  imagedestroy($image);
?>