<?php
function dbConnect($type) {
    if($type == 'query') {
        $user = 'posterquery';
        $pwd = 'credit';
    }
    elseif ($type == 'admin') {
        $user = 'posteradmin';
        $pwd = 'credit';
    }
    else {
        exit('Unrecognized connection type');
    }
    //database connection function using MySQL Improved for PHP5
    $conn = new mysqli('localhost', $user, $pwd, 'posterdb')//takes hostname, username, pwd, and db name as arguments
    or die('Cannot open database');
    return $conn;
}
?>