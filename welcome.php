<?php
//FirePHP Debugger
        require('../FirePHPCore/fb.php');
        ob_start();

//display errors independent of FirePHP
        ini_set('display_errors',1);
        error_reporting(E_ALL|E_STRICT);
 
//open file to append user for userlog
//create short variable names for userlog file
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
$username = $_POST['username'];
$useremail = $_POST['email'];
$logintime = date("F j, Y g:i a",time());
     
//formatting for record file
$outputstring = $username." \t".$useremail." \t".$logintime."\n";
       
//open file for appending
@ $fp = fopen("$DOCUMENT_ROOT/posters/media/guestbook.txt", 'ab');//make sure file has permissions to write and path correct!

       
flock($fp, LOCK_EX);//locks file for writing
        
if (!$fp) {
        echo "<p><strong>Your login couldn't be processed. Try again.</strong></p></body></html>";
        exit;
    }
fwrite($fp, $outputstring, strlen($outputstring));
flock($fp, LOCK_UN);//unlocks file after writing
fclose($fp);
//end write login file  code      

//if (array_key_exists('login', $_POST)) {

//initiate session
session_start();
//get session username
//set session variables
$_SESSION['name'] = $_POST['username'];
$_SESSION['email'] = $_POST['email'];

//check that form is submitted and name is not empty
//if ($_POST && !empty($_POST['username'])){//redundant?maybe...
       
      
   // }

$textfile = $DOCUMENT_ROOT.'/posters/media/guestbook.txt';
   if (file_exists($textfile) && is_readable($textfile)) {
    // read the file into an array called $users
    $users = file($textfile);
   

    // loop through the array to process each line
    for ($i = 0; $i < count($users); $i++) {
      // separate each element and store in a temporary array
      $tmp = explode(' ', $users[$i]);
        
           
      // assign each element of the temp array to a named array key
      
      $users[$i] = array('name' => $tmp[0], 'email' => $tmp[1]);  //troubleshoot here
      echo $tmp[0];
      /*
      echo "HERE is the START";
      echo $tmp[0].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       echo "HERE is the SPLIT";
      echo $tmp[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      */
	  // check for a matching record
	  if ($users[$i]['name'] == $_POST['username'] /*&& $users[$i]['email'] == $_POST['email']*/) {
	    $_SESSION['authenticated'] = 'Allowed User';//could use additional namecheck for more security 
		break;
		}
      }
	// if the session variable has been set, redirect
	if (isset($_SESSION['authenticated'])) {
                
        echo '<script type="text/javascript">alert("Authenticated!")</script>';
               /* Redirect to a different page in the current directory that was requested 
         $host  = $_SERVER['HTTP_HOST'];
         $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
         $welcome = 'welcome.php'; 
	  header("Location: http://$host/$uri/$welcome");
	  exit;*/
	  }
	// if the session variable hasn't been set, refuse entry
	else {
	  $error = 'Access restricted to authenticated users only...';
          echo '<script type="text/javascript">alert("Not Authenticated!")</script>';
	  }
    }
  // error message to display if text file not readable
  else {
    $error = 'Login facility unavailable. Please try later.';
    }
  
  fb('$textfile');//firephp
  fb('$users');
  //echo $textfile;
   
?>
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
    <h3> <?php
        // check session variable is set
            if (isset($_SESSION['name'])) {
            // if set, greet by name
                echo 'Welcome, '.$_SESSION['name'].'...';
            }
                else {
                // if not set, send back to login
                echo 'Hi, GUEST Please <a href="index.php">Login</a>';
            }          
            ?></h3>
        <p>You now have access to my free PHP GD image converter which allows you to upload an image and apply effects to it. </p>
        <p>There are several operations available in the "Processes" menu above. You can use the filters on a jpeg image of up to 2MB. Upload an image multiple times to process it with more than one effect.</p>
        <p>Each effect creates a version of the image which is the same size as the original, as well as a thumbnail image. If you want to simply make a thumbnail image with no filters applied, use the thumbnailer. </p>
        
    </div><!-- end side column -->   
    <div id="content"><!--main page content section -->
        <div id="pictureFrame"><!--container for random image -->
        <img src="<?php echo $selectedImage; ?>" alt="Random image" />
        <p class="caption"><?php echo $caption; ?></p>
        </div>
        <p class="picTitle">Here is a recent random image</p>
    </div><!-- end content -->
    
    <div id="footer"><!--bottom of page address box -->
        <?php include('includes/footer.inc.php');  ?>
       <?php
       
       ?>
    </div><!-- end footer -->
</div><!-- end wrapper -->
</body>
</html>

