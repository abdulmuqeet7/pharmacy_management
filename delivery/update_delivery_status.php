<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'delivery_agent'){
    header("Location: login.php");
    exit;
}

if(!isset($_POST['shipment_id']) || !isset($_POST['status'])){
    die("Invalid request.");
}

$shipment_id = intval($_POST['shipment_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

$update = "UPDATE shipment SET status = '$status' WHERE shipment_id = $shipment_id";
if(mysqli_query($conn, $update)){
    header("Location: delivery_dashboard.php?updated=1");
    exit;
} else {
    echo "Error updating status: " . mysqli_error($conn);
}
