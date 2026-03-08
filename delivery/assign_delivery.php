<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

if(!isset($_POST['shipment_id']) || !isset($_POST['agent_id'])){
    die("Invalid request.");
}

$shipment_id = intval($_POST['shipment_id']);
$agent_id = intval($_POST['agent_id']);
$pharmacist_id = intval($_SESSION['uid']);

// Update shipment: assign agent and pharmacist, set status
$update = "
UPDATE shipment
SET agent_id = $agent_id,
    pharmacist_id = $pharmacist_id,
    status = 'Assigned'
WHERE shipment_id = $shipment_id
";

if(mysqli_query($conn, $update)){
    header("Location: pharmacist_delivery_assignments.php?success=1");
    exit;
} else {
    echo "Error assigning delivery: " . mysqli_error($conn);
}
