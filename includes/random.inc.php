<?php
/*
$filters = array(
                array('effect' => IMG_FILTER_MEAN_REMOVAL,
                      'caption' => 'Mean Removal'),
                array('effect' => IMG_FILTER_EDGEDETECT,
                      'caption' => 'Edge Detect'),
                array('effect' => IMG_FILTER_NEGATE,
                      'caption' => 'Negate'),
                array('effect' => IMG_FILTER_SMOOTH, 100,
                      'caption' => 'Smooth'),
                array('effect' => IMG_FILTER_GRAYSCALE, 100,
                      'caption' => 'Grayscale')
               );
               
$i = rand(0, count($filters)-1);
$output = $filters[$i]['effect'];
$caption = $filters[$i]['caption'];
*/
$filters = array(
                IMG_FILTER_MEAN_REMOVAL,
                IMG_FILTER_EDGEDETECT,
                IMG_FILTER_NEGATE,
                IMG_FILTER_SELECTIVE_BLUR,
                IMG_FILTER_GRAYSCALE              
               );
               
$i = rand(0, count($filters)-1);
$output = $filters[$i];

imagefilter($poster, $output);
imagejpeg($poster, UPLOAD_DIR.'poster.jpg');//save processed image
imagedestroy($poster);
?>