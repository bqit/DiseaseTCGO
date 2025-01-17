<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "dtcgo_login_db";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
    header("Location: ./connection_failed.php");
}