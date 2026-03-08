<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$query = "
SELECT s.sale_id, s.sale_date, s.total_amount, 
       m.med_name, u.name AS customer_name
FROM sales s
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
ORDER BY s.sale_id DESC
";

$result = mysqli_query($conn, $query);

$total_earnings = 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>All Medicine Orders</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>

<h2>All Medicine Orders</h2>
<hr>

<?php 
if(mysqli_num_rows($result) == 0){
    echo "<p>No orders found.</p>";
} else { ?>

<table class="table table-bordered">
    <tr>
        <th>Sale ID</th>
        <th>Customer</th>
        <th>Medicine</th>
        <th>Date</th>
        <th>Amount</th>
    </tr>

<?php 
while($row = mysqli_fetch_assoc($result)){
    $total_earnings += $row['total_amount'];
?>
    <tr>
        <td><?= $row['sale_id'] ?></td>
        <td><?= $row['customer_name'] ?></td>
        <td><?= $row['med_name'] ?></td>
        <td><?= $row['sale_date'] ?></td>
        <td>₹<?= number_format($row['total_amount'], 2) ?></td>
    </tr>
<?php } ?>

</table>

<h3 class="mt-4">Total Earnings from Medicines: 
    <span class="text-success">₹<?= number_format($total_earnings,2) ?></span>
</h3>

<?php } ?>

</body>
</html>
