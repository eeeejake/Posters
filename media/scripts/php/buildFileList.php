<?php
function buildFileList($theFolder) {
  // Execute code if the folder can be opened, or fail silently
  if ($contents = @ scandir($theFolder)) {
    // initialize an array for matching files
    $found = array();
    // Create an array of file types
    $fileTypes = array('jpg','jpeg','gif','png');
    // Traverse the folder, and add filename to $found array if type matches
	$found = array();
    foreach ($contents as $item) {
      $fileInfo = pathinfo($item);
      if (array_key_exists('extension', $fileInfo) && in_array($fileInfo['extension'],$fileTypes)) {
        $found[] = $item;
        }
      }

    // Check the $found array is not empty
    if ($found) {
      // Sort in natural, case-insensitive order, and populate menu
      natcasesort($found);
      foreach ($found as $filename) {
        echo "<option value='$filename'>$filename</option>\n";
        }
      }
    }
  }
?>