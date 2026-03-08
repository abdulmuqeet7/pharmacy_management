<?php
session_start();
if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<div class="d-flex justify-content-between mb-3">
    <h2>Admin Dashboard</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<hr>

<div class="container">

    <div class="row g-3">

        <div class="col-md-4">
            <a href="admin_add_pharmacist.php" class="btn btn-primary w-100 p-3">
                ➕ Add Pharmacist
            </a>
        </div>

        <div class="col-md-4">
            <a href="admin_add_pathologist.php" class="btn btn-secondary w-100 p-3">
                ➕ Add Pathologist
            </a>
        </div>

        <div class="col-md-4">
            <a href="admin_add_delivery_agent.php" class="btn btn-success w-100 p-3">
                ➕ Add Delivery Agent
            </a>
        </div>

        <div class="col-md-4">
            <a href="admin_add_supplier.php" class="btn btn-warning w-100 p-3">
                🏬 Add Supplier
            </a>
        </div>

        <div class="col-md-4">
            <a href="admin_view_staff.php" class="btn btn-info w-100 p-3">
                👥 View / Remove Staff
            </a>
        </div>

        <div class="col-md-4">
            <a href="admin_total_earnings.php" class="btn btn-dark w-100 p-3">
                💰 Pharmacy Total Earnings
            </a>
        </div>

        <!-- ⭐ NEW BUTTON – VIEW ALL ORDERS -->
        <div class="col-md-4">
            <a href="admin_all_orders.php" class="btn btn-outline-primary w-100 p-3">
                📦 View All Medicine Orders
            </a>
        </div>

        <!-- ⭐ NEW BUTTON – VIEW LAB TEST BOOKINGS TOTAL -->
        <div class="col-md-4">
            <a href="admin_lab_tests.php" class="btn btn-outline-success w-100 p-3">
                🧪 View All Lab Test Bookings
            </a>
        </div>

        <!-- ⭐ NEW BUTTON – VIEW ALL LAB TESTS PER CUSTOMER -->
        <div class="col-md-4">
            <a href="admin_lab_tests_by_customer.php" class="btn btn-outline-dark w-100 p-3">
                👤 Lab Tests by Customer
            </a>
        </div>

    </div>

</div>

</body>
</html>
