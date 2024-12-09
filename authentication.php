<?php

session_start();

if(!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Please login to access user dashboard.!";
    header('location: login.php');
    exit(0);
}

?>