<?php
//ob_start();
    // $con = mysqli_connect("localhost","troplokj_user","EH=YNw(xYo2f","troplokj_db");
    $con = mysqli_connect("localhost","root","","troplokj_db");
    if (!$con){
        die("Database Connection Failed" . mysqli_error($con));
    }
    date_default_timezone_set('Africa/Lagos');
    ?>