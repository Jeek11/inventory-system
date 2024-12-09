<?php

$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "yandb";
$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

if(!$conn)
{
    die("Something went wrong");
}
echo "Hello Coding";

?>