<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "pharmacist"){
    header("Location: login.php");
    exit;
}

$pharmacist_id = $_SESSION['uid'];

// Fetch pharmacist name
$q = mysqli_query($conn, "SELECT name FROM users WHERE UID = $pharmacist_id LIMIT 1");
$row = mysqli_fetch_assoc($q);
$pharmacist_name = $row['name'] ?? "Pharmacist";
?>
<!DOCTYPE html>
<html>
<head>
<title>Pharmacist Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    .dashboard-buttons a {
        min-width: 220px;
    }
</style>
</head>

<body class="p-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Pharmacist Dashboard</h2>
        <h5 class="text-muted">Welcome, <?php echo htmlspecialchars($pharmacist_name); ?></h5>
    </div>

    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<hr>

<!-- BUTTON ROW -->
<div class="dashboard-buttons d-flex flex-wrap gap-3">

    <a href="pharmacist_pending_reports.php" class="btn btn-primary">
        Assign Pathologist
    </a>

    <!-- ⭐ NEW BUTTON -->
    <a href="pharmacist_previous_pathologist_assignments.php" class="btn btn-outline-primary">
        Previous Pathologist Assignments
    </a>

    <a href="pharmacist_delivery_assignments.php" class="btn btn-secondary">
        Delivery Assignments
    </a>

    <a href="order_medicines.php" class="btn btn-success">
        Order Medicines
    </a>

    <a href="pharmacist_all_orders.php" class="btn btn-warning">
        View All Orders
    </a>

    <a href="pharmacist_all_medicines.php" class="btn btn-info text-white">
        View All Medicines
    </a>

</div>

</body>
</html>
