<?php
include "db.php";


if (!isset($_SESSION['loggedin'])) {
    header("location:index.php");
    exit;
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

//mysqli_query($db, "UPDATE orders SET status='$status' WHERE order_id='$order_id'");
update($db,"orders",array("status"=>"$status"),"WHERE order_id='$order_id'");
header("Location: view_orders.php"); 
exit;
?>