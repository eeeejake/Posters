<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Process an Uploaded Image</title>
<!-- PHP Scripts here -->
<?php include('media/scripts/php/random_image.php');?>
<?php include('media/scripts/php/process_upload.php');?>
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
        <h1>Posterize Your Face</h1>
    </div><!-- end header -->
    
    <?php include('includes/menu.inc.php'); ?>
    <!-- end navbar -->
<br />       
    <div id="column"><!--side column for layout -->
        <p>This is a php gd image converter which allows you to upload an image and transform it. Images must be in ".jpg" or ".png" format.</p>
        <p><strong>Upload a Picture to convert:</strong></p>
        
     <form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                <p class="compact"><label for="Title">Title:</label>&nbsp;&nbsp;&nbsp;
                <input type="text" name="title" id="title" />
                </p>
                <p class="compact"><label for="image">Image:</label>
                <input type="hidden" name="MAX_FILE_SIZE" value=<?php echo MAX_FILE_SIZE; ?>
                <input type="file" name="image" id="image" />
                </p>                
                <p class="compact">
                <input type="submit" name="upload" value="Upload" /></td>
                <input type="reset" name="reset" value="Clear" /></td>
                </p>                  
        </form>
    <?php
    //if the form has been submitted, display the result
    if (isset($result)){
            echo "<p><strong>$result</strong></p>";       
        } 
    ?>
    
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

