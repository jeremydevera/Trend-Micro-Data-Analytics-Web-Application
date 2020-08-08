<?php 
    $file = fopen("settings.ini", "r");
    $line = fgets($file);
    $saved_interval = fgets($file);
    $saved_interval = rtrim($saved_interval,"\n");
    $vidname = fgets($file);
    $duration = fgets($file);
    fclose($file)
?>