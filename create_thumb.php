<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create Thumbnail Image</title>
<!-- PHP Scripts here -->
<?php //include('media/scripts/php/random_image.php');?>
<?php include('media/scripts/php/make_thumb.php');?>
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
        <h1>Make a Thumbnail</h1>
    </div><!-- end header -->
    
    <?php include('includes/menu.inc.php'); ?>
    <!-- end navbar -->
<br />       
    <div id="column"><!--side column for layout -->
        <p>Choose an uploaded picture to create a Thumbnail</p>
        <p><strong>Choose a Picture to Thumbnail:</strong></p>
        
     <form id="form1" name="form1" method="post" action="">
        <p>
        <select name="pix" id="pix">
            <option value="">Select an image</option>
            <?php
            include('media/scripts/php/buildFileList.php');
            buildFileList('media/uploads');
            ?>
        </select>
        </p>
        <p>
         <input name="create" id="create" type="submit" value="Create Thumbnail"   
        </p>
        <?php
        if (isset($result)) {
        echo "<p>$result</p>";
        }
        ?>
        </form>
    
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
        <img src="" alt="image" />
        <p class="caption"></p>
        </div>
        <p class="picTitle">Here is a recent random image</p>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php'); ?>
    </div><!-- end footer -->
</div><!-- end wrapper -->
</body>
</html>

