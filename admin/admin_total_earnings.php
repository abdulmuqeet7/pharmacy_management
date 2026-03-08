<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$q = mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM sales");
$data = mysqli_fetch_assoc($q);
$total = $data['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>Total Earnings</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-dark mb-3">⬅ Back</a>

<h3>Total Earnings</h3>
<hr>

<div class="alert alert-info fs-4">
    💰 Total Revenue Earned: <b>₹<?php echo number_format($total, 2); ?></b>
</div>

</body>
</html>
