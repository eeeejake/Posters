<?php
//display errors independent of FirePHP
        ini_set('display_errors',1);
        error_reporting(E_ALL|E_STRICT);

//for FirePHP fb function
require('../FirePHPCore/fb.php');//needs path to FirePHPCore/fb.php file
ob_start();	
?>
<?php
//include MySQL connector function
if(! @include('includes/connection.inc.php')){
    echo 'Sorry, database unavailable';
    exit;
}
//define number of columns in thumbnail table
define('COLS', 2);
//set maximum number of records per page
define('SHOWMAX', 4);

    //create a connection to MySQL
    $conn = dbConnect('query');
    //prepare SQL to get total records
    $getTotal = 'SELECT COUNT(*) FROM images';
    //submit query and store result in $totalPix
    $total =$conn->query($getTotal);
    $row = $total->fetch_row();
    $totalPix = $row[0];
    //set the current page
    $curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 0;
    //calculate the start row of the subset
    $startRow = $curPage * SHOWMAX;
    
    
    //prepare SQL to retrieve image details
    $sql = "SELECT * FROM images LIMIT $startRow,".SHOWMAX;
    
    //submit the query (MySQL improved version)
    $result = $conn->query($sql) or die(mysqli_error());
    //extract the first record as an array
    $row = $result->fetch_assoc();//stores MySQL data extracted as an array ($row)
    
    //get the name and caption for the main image
    if (isset($_GET['image'])) {
	$mainImage= $_GET['image'];
    }
    else{
    $mainImage=$row['filename'];
    }
    
    //get the name and caption for the thumbnail image (need to get dynamic name for each one)
    // strip the extension off the image filename and replace it with "_thumb.jpg"
    function thumbnameIt($thumbname){
	$imagetypes = array('/\.gif$/', '/\.jpg$/', '/\.jpeg$/', '/\.png$/');
	$thumbname = preg_replace($imagetypes, '', basename($thumbname));
	$thumbname .= "_thumb.jpg";
	return $thumbname;
    }
    
    //get the dimensions of the main image
    $imageSize = getimagesize('media/images/sample_images/'.$mainImage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Posterize Your Face</title>
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
    <h3>Poster Gallery</h3>
        <p>Here are some posters created with the Posterizer. </p>
        <p><strong>Click A Thumbnail to View the Image:</strong></p>
        
     <p id="picCount">Displaying
	<?php echo $startRow+1;
	if ($startRow+1 < $totalPix) {
	    echo ' to ';
	    if ($startRow+SHOWMAX < $totalPix) {
		echo $startRow+SHOWMAX;
	    }
	    else {
		echo $totalPix;
	    }
	}
	echo " of $totalPix";	
	?>
	<table id="thumbs">
	    <caption class="caption">Before:</caption>
                <tr>
		<!--This row needs to be repeated-->
		<?php
		//initialize cell counter outside loop
		$pos = 0;
		do { //loops through database to retrieve rows for image names and captions
		     //set caption if thumbnail is same as main image
		    if ($row['filename'] == $mainImage) {
		    $caption =$row['caption'];
		    }
		    ?>
                    <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?image=<?php echo $row['filename']; ?>&amp;curPage=<?php echo $curPage; ?>"><img src="media/thumbs/<?php echo thumbnameIt($row['filename']); ?>" alt="<?php echo $row['caption']; ?>" width="" height="100" /></a></td>
                <?php $row =$result->fetch_assoc();
		//increment counter after next row extracted
		$pos++;
		//if at end of row and records remain, insert tags
		if($pos%COLS === 0 && is_array($row)){
		    echo '</tr><tr>';
		}
		} while ($row);
		//loops through database to retrieve rows for image names and captions
		//new loop to fill final row;
		echo '<td>&nbsp;</td>';
		$pos++;
		?>
		</tr>
		<!-- Navigation link needs to go here -->
		<tr><td>
		 <tr>
                <td><?php
		    // create a back link if current page greater than 0
		    if ($curPage > 0) {
		        echo '<a href="'.$_SERVER['PHP_SELF'].'?curPage='.($curPage-1).'">&lt; Prev</a>';
			}
		     // otherwise leave the cell empty
		        else {
		        echo '&nbsp;';
			}
		        ?>
                    </td>
                    <?php
		            // pad the final row with empty cells if more than 2 columns
		            if (COLS-2 > 0) {
		            for ($i = 0; $i < COLS-2; $i++) {
			          echo '<td>&nbsp;</td>';
			          }
			        }
		            ?>
                    <td>
		    <?php
		        // create a forwards link if more records exist
		        if ($startRow+SHOWMAX < $totalPix) {
			    echo '<a href="'.$_SERVER['PHP_SELF'].'?curPage='.($curPage+1).'">Next &gt;</a>';
			          }
		            // otherwise leave the cell empty
		            else {
		              echo '&nbsp;';
			          }
		            ?>
                    </td>
                </tr>
            </table>
    
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
         <p><img src="media/images/sample_images/<?php echo $mainImage; ?>" alt="<?php echo $caption; ?>" <?php echo $imageSize[3]; ?></p>
                <p class="caption"><?php echo $caption; ?></p>
		<h4>After</h4>
        </div>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php'); ?>
    </div><!-- end footer -->
    
</div><!-- end wrapper -->
</body>
</html>

