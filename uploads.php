<?php
$uploadsDirectory = 'uploads';

// Check if the directory doesn't exist, then create it
if (!is_dir($uploadsDirectory)) {
    mkdir($uploadsDirectory, 0777, true); // Ensure permissions are set appropriately
}
?>
