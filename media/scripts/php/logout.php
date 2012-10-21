<?php
session_start();
//empty the session array
$_SESSION = array();
// invalidate the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
}
//end session and redirect
session_destroy();

//redirect here;
header('Location: ../../../index.php');
exit;
?>