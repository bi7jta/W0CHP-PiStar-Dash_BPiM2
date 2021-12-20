<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config

if (constant("TIME_FORMAT") == "24") {
    $local_time = date('H:i:s M. jS');
} else {
    $local_time = date('g:i:s A M. jS');
}

echo $local_time;

 ?>
