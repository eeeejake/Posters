<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Posterize Your Face</title>
<!-- PHP Scripts here -->
<?php include('media/scripts/php/random_image.php');?>
<!-- CSS here -->
<link rel="stylesheet" href="media/css/poster.css" type="text/css" media="screen" />
<link rel="stylesheet" href="media/css/menus.css" type="text/css" media="screen" />
<!-- JS Scripts here -->
<script src="media/scripts/js/jquery.js" type="text/javascript"></script>
<script src="media/scripts/js/dropdown.js" type="text/javascript"></script>
<script type="text/javascript">//validate form with js
$(document).ready(function() {//because href won't form field focus
  // Handler for .ready() called.
    $("#loglink").click(function() {
    $("#username").focus();
    return false;
});
});
function checkForm() {//validates login form
	var uEmail=document.getElementById("email");
        var uName = document.getElementById("username");
	var regX=/^[^@]+@[^\s\r\n\'";,@%]+$/ //email RegX
	if(document.userlog.username.value.length < 3)
		{
                alert("Please enter your name");
                uName.focus();
                return false;
                }
	else if ((Email.value.length == 0) || (regX.test(Email.value)==false))
		{
                alert("Please enter a valid email address");
                uEmail.focus();
                return false;
                }
	else return true;
}
</script>
</head>
<body>
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
    <h3>PHP GD Image Processor</h3>
        <p>This is a PHP GD image converter which allows you to upload an image and apply effects to it. There are several operations available in the "Processes" menu above.</p>
        <p><strong>Please login to the guestbook to access the program.</strong></p>
        
     <form action="welcome.php" method="post" name="userlog" id="userlog" onsubmit="return checkForm()">
                <p class="compact"><label for="username">User Name:</label>&nbsp;&nbsp;&nbsp;
                <input type="text" name="username" id="username" />&nbsp;&nbsp;&nbsp;<span class="required">*</span>
                </p>
                <p class="compact"><label for="email">User Email:</label>&nbsp;&nbsp;&nbsp;
                <input type="text" name="email" id="email" />&nbsp;&nbsp;&nbsp;<span class="required">*</span>
                </p>              
                <p class="compact">
                <input type="submit" name="login" id="login" value="Log In" /></td>
                <input type="reset" name="reset" id="reset" value="Clear" /></td>
                &nbsp;&nbsp;&nbsp;<span class="required">*Required Fields</span>
                </p>                  
        </form>    
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
        <img src="<?php echo $selectedImage; ?>" alt="Random image" />
        <p class="caption"><?php echo $caption; ?></p>
        </div>
        <p class="picTitle">Here is a recent random image</p>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php'); ?>
    </div><!-- end footer -->
</div><!-- end wrapper -->
</body>
</html>

