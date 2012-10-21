<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Thumbnail an Uploaded Image</title>
<!-- PHP Scripts here -->
<?php include('media/scripts/php/random_image.php');?>
<?php include('media/scripts/php/upload_src.php');?>
<!-- CSS here -->
<link rel="stylesheet" href="media/css/poster.css" type="text/css" media="screen" />
<link rel="stylesheet" href="media/css/menus.css" type="text/css" media="screen" />
<!-- JS Scripts here -->
<script src="media/scripts/js/jquery.js" type="text/javascript"></script>
<script src="media/scripts/js/dropdown.js" type="text/javascript"></script>
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
    <h3>Thumbnailer</h3>
        <p>This form allows you to upload a picture and convert it to a thumbnail image. </p>
        <p><strong>Upload a Picture to convert:</strong></p>
        
     <form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                <p class="compact"><label for="image">Image:</label>
                <input type="hidden" name="MAX_FILE_SIZE" value=<?php echo MAX_FILE_SIZE; ?>
                <input type="file" name="image" id="image" />
                </p>                
                <p class="compact">
                <input type="submit" name="upload" value="Upload" /></td>
                <input type="reset" name="reset" value="Change"/></td>
                <input type="button" onClick="window.location.href=window.location.href" value="Clear">
                </p>                  
        </form>
    <?php
    //if the form has been submitted, display the result
    if (isset($result)){
            echo "<p class='caption'>Here is the Thumbnail:<br /></p>";
            echo "<p class='caption'><img src='media/thumbs/$thumb_name' /><br />$thumb_name </p>";
            echo "<p><strong>$result</strong></p>";
        } 
    ?>
    
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
        <?php
    //if the form has been submitted, display the result
    if (isset($result)){
            echo "<img src='media/uploads/$name.jpg' />";
            echo "<p class='caption'>Original $name</p>";   
        }
        else{
           echo "<img src=$selectedImage alt='Random image' />";
           echo "<p class='caption'>Here's a recent Random Picture</p>"; 
        }
        
    ?>
    </div>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php'); ?>
    </div><!-- end footer -->
</div><!-- end wrapper -->
</body>
</html>

