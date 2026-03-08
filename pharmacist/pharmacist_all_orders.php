<?php
session_start();
include "../config/db.php";

// Only Pharmacist Access
if(!isset($_SESSION['uid']) || $_SESSION['role'] != "pharmacist"){
    header("Location: login.php");
    exit;
}

$filter = "";
$where = "";

if(isset($_GET['status']) && $_GET['status'] != "all"){
    $status = $_GET['status'];
    $where = "WHERE sh.status = '$status'";
}

// Fetch all orders with shipment details
$query = "
SELECT 
    s.sale_id, s.sale_date, s.total_amount,
    m.med_name,
    u.name AS customer_name,
    sh.status, sh.expected_date, sh.shipment_address,
    sh.agent_id
FROM sales s
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
LEFT JOIN shipment sh ON sh.sale_id = s.sale_id
$where
ORDER BY s.sale_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>All Orders - Pharmacist</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
.order-card {
    background: #fff;
    border-radius: 10px;
    padding: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}
.badge-status {
    font-size: 14px;
    padding: 5px 10px;
}
</style>
</head>

<body class="p-4">

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Orders</h2>
        <a href="pharmacist_dashboard.php" class="btn btn-dark">Back</a>
    </div>

    <!-- FILTER BUTTONS -->
    <div class="mb-3">
        <a href="pharmacist_all_orders.php?status=all" class="btn btn-secondary btn-sm">All</a>
        <a href="pharmacist_all_orders.php?status=Pending" class="btn btn-warning btn-sm">Pending</a>
        <a href="pharmacist_all_orders.php?status=In Transit" class="btn btn-info btn-sm">In Transit</a>
        <a href="pharmacist_all_orders.php?status=Delivered" class="btn btn-success btn-sm">Delivered</a>
        <a href="pharmacist_all_orders.php?status=Failed" class="btn btn-danger btn-sm">Failed</a>
    </div>

    <hr>

    <?php
    if(mysqli_num_rows($result) == 0){
        echo "<p>No orders found.</p>";
    }

    while($row = mysqli_fetch_assoc($result)){ ?>

        <div class="order-card">

            <h5>Order #<?php echo $row['sale_id']; ?></h5>
            <p><b>Medicine:</b> <?php echo $row['med_name']; ?></p>
            <p><b>Customer:</b> <?php echo $row['customer_name']; ?></p>
            <p><b>Total:</b> ₹<?php echo number_format($row['total_amount'],2); ?></p>
            <p><b>Address:</b> <?php echo $row['shipment_address'] ?: "Not Assigned"; ?></p>
            <p><b>Expected Delivery:</b> <?php echo $row['expected_date'] ?: "Not Assigned"; ?></p>

            <p><b>Status:</b>
                <span class="badge badge-status 
                    <?php 
                        if($row['status'] == 'Delivered') echo 'bg-success';
                        else if($row['status'] == 'Pending') echo 'bg-warning';
                        else if($row['status'] == 'Failed') echo 'bg-danger';
                        else echo 'bg-info';
                    ?>">
                    <?php echo $row['status'] ?: "Not Assigned"; ?>
                </span>
            </p>

            <p><b>Assigned Agent:</b> 
                <?php 
                if($row['agent_id']){
                    $a = mysqli_query($conn, "SELECT name FROM users WHERE UID = {$row['agent_id']} LIMIT 1");
                    $ar = mysqli_fetch_assoc($a);
                    echo $ar['name'];
                } else {
                    echo "Not Assigned";
                }
                ?>
            </p>

        </div>

    <?php } ?>

</div>

</body>
</html>
