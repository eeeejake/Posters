<?php //turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Process an Uploaded Image</title>
<!-- CSS here -->
<link rel="stylesheet" href="media/css/poster.css" type="text/css" media="screen" />
<link rel="stylesheet" href="media/css/menus.css" type="text/css" media="screen" />
<!-- JS Scripts here -->
<script src="media/scripts/js/jquery.js" type="text/javascript"></script>
<script src="media/scripts/js/dropdown.js" type="text/javascript"></script>
</head>
<bodygt;
<?php
    session_start();

    if (isset($_GET['clear'])) {
        unset($_GET['clear']);
        unset($_SESSION['points']);
    }

    if (count($_GET)) {
        $click = array_keys($_GET);
        $click = explode(',', $click[0]);
        $_SESSION['points'][] = $click[0];
        $_SESSION['points'][] = $click[1];
    }  
?>

<div id="wrapper"><!-- wrapper for entire page -->

    <div id="header"><!-- container for top banner and page headline -->
     <div id="ticker"><?php echo date("F j, Y g:i a",time()); ?><!-- right corner date and login -->
    <br /><p class="required">
        <?php
        // check session variable is set
            if (isset($_SESSION['name'])) {
            // if set, greet by name
                echo 'Logged in as: <span class="blue">'.$_SESSION['name'].'</span>&nbsp;&nbsp;<a href="media/scripts/php/logout.php">logout</a>';
            }
                else {
                // if not set, send back to login
                echo 'Hi, <span class="blue">GUEST</span> Please <a id="loglink" href="#">Login</a>';
            }          
            ?>
        </p></div>
        <h1>Posterize Your Face</h1>
    </div><!-- end header -->
    
    <?php include('includes/menu.inc.php'); ?>
    <!-- end navbar -->
<br />       
    <div id="column"><!--side column for layout -->
      
<h3>Mouseclick Picture</h3>
<p>This simple GD code allows you to click a path to create a picture.</p>
<p>Each click sets a point for the path to fill according to an array sent from the session $_GET variable.
The coordinates are passed because the image is set to "ismap", and the browser reads it as an image map.
Here are the coordinates for each click:</p>
<?php if (isset($_SESSION['points']) && count($_SESSION['points'])) {
    var_export($_SESSION['points']);//shows points plotted coordinates
}
?>
    
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
         <a href="mouseclick.php"><img src="media/scripts/php/mouseclick_src.php" ismap="ismap" /></a><br />
         <a class="caption" href="mouseclick.php?clear=true">Clear image</a>
        </div>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php'); ?>
    </div><!-- end footer -->
</div><!-- end wrapper -->
</body>
</html>

