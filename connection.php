<?php
    $server ="localhost";
    $user = "root";
    $psw = "";
    $db="db_cv.tekad_maju_jaya";

    $con = new mysqli($server,$user,$psw,$db);
    if($con->connect_error)
    {
      die("error con ".$con->connect_error);
    }
    
?>