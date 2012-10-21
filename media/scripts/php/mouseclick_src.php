<?php
    session_start();

    if (!isset($_SESSION['points'])) $_SESSION['points'] = array();

    $image = imagecreatetruecolor(250, 250);
    $green = imagecolorallocate($image, 0, 255, 0);
    $pointcount = count($_SESSION['points']) / 2;

    switch($pointcount) {
        case 0:
            break;
        case 1:
            imagesetpixel($image, $_SESSION['points'][0], $_SESSION['points'][1], $green );
            break;
        case 2:
            imageline($image, $_SESSION['points'][0], $_SESSION['points'][1], $_SESSION['points'][2], $_SESSION['points'][3], $green );
            break;
        default:
            imagefilledpolygon($image, $_SESSION['points'], $pointcount, $green );
    }

    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
?> 