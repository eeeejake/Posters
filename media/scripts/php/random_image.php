<?php
$images = array(
                array('file' => 'django',
                      'caption' => 'Django Reinhardt'),
                array('file' => 'mug',
                      'caption' => 'My Face'),
                array('file' => 'rasputin',
                      'caption' => 'Rasputin'),
                array('file' => 'suit',
                      'caption' => 'Me in a suit')
               );
$i = rand(0, count($images)-1);
$selectedImage = "media/images/{$images[$i]['file']}.jpg";
$caption = $images[$i]['caption'];
?>