<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$query = "
SELECT u.name AS customer_name, lt.test_name, lt.test_cost
FROM lab_report lr
JOIN lab_test lt ON lr.test_id = lt.test_id
JOIN users u ON lr.customer_id = u.UID
ORDER BY u.name ASC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Lab Tests by Customer</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>

<h2>Lab Tests by Customer</h2>
<hr>

<table class="table table-bordered">
    <tr>
        <th>Customer</th>
        <th>Test Name</th>
        <th>Cost</th>
    </tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['customer_name'] ?></td>
        <td><?= $row['test_name'] ?></td>
        <td>₹<?= number_format($row['test_cost'],2) ?></td>
    </tr>
<?php } ?>

</table>

</body>
</html>
