<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$db=mysqli_connect("localhost","root","","ggtech_php")or die("Server Not Found" . mysqli_error($db)); 
include_once 'config.php';
?>