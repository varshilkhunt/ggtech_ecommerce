<?php
session_start();
include "admin/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "login_required"
    ]);
    exit;
}

$uid = $_SESSION['user_id'];
$pid = (int)$_POST['product_id'];

// Check if exists
$check = mysqli_query($db, "SELECT id FROM wishlist WHERE user_id = $uid AND product_id = $pid");

if (mysqli_num_rows($check) > 0) {

    mysqli_query($db, "DELETE FROM wishlist WHERE user_id = $uid AND product_id = $pid");
    $status = "removed";

} else {

    mysqli_query($db, "INSERT INTO wishlist (user_id, product_id) VALUES ($uid, $pid)");
    $status = "added";
}

// get updated count
$count = mysqli_num_rows(mysqli_query($db,"SELECT id FROM wishlist WHERE user_id=$uid"));

echo json_encode([
    "status" => $status,
    "count"  => $count
]);
?>
