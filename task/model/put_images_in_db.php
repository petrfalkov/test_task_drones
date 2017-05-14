<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"save_img.css\"><div class=\"loader\"></div>";
session_start();
require_once "db/connection.php";
try {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'temp_files/') === 0) {
            $descr = $_POST[$key];
            $name = substr($key, 0, strrpos($key, '_', -1));
            $img = "UPDATE `photos` SET `photo_dscr`='".$descr."' WHERE photo_name ='".$name."'";
            mysql_query($img);
        }
    }
    //clear temp directory
    //attempt to Load files into base... failure
    //not loading files bigger then 1mb
//    $files = glob('temp_files/*'); // get all file names
//    foreach ($files as $file) { // iterate files
//        if (is_file($file))
//            unlink($file); // delete file
//    }
    //relocating on main page
    header( "refresh:2;url=../view/index.php" );
} catch (ErrorException $errorException)
{
    //if catch some error
    //clear temp directory
    //attempt to Load files into base... failure
    //not loading files bigger then 1mb
//    $files = glob('temp_files/*'); // get all file names
//    foreach ($files as $file) { // iterate files
//        if (is_file($file))
//            unlink($file); // delete file
//    }
    //send a message in logfile
    error_log($errorException->getMessage());
    header( "refresh:1;url=../view/upload.php" );
}