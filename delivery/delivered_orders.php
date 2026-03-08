<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'delivery_agent'){
    header("Location: login.php");
    exit;
}

$agent_id = intval($_SESSION['uid']);

// Fetch delivered orders
$query = "
SELECT 
    sh.shipment_id, sh.sale_id, sh.shipment_address, sh.expected_date, sh.status,
    s.total_amount, m.med_name, u.name AS customer_name
FROM shipment sh
JOIN sales s ON sh.sale_id = s.sale_id
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
WHERE sh.agent_id = $agent_id AND sh.status = 'Delivered'
ORDER BY sh.shipment_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delivered Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Delivered Orders</h2>
        <div>
            <a href="delivery_dashboard.php" class="btn btn-secondary">⬅ Back</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <?php
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<p>No completed deliveries yet.</p>";
    } 
    else {
        while($row = mysqli_fetch_assoc($result)) {
    ?>

        <div class="card p-3 mb-3">
            <h5><?php echo htmlspecialchars($row['med_name']); ?></h5>

            <p><b>Customer:</b> <?php echo htmlspecialchars($row['customer_name']); ?></p>
            <p><b>Delivery Address:</b> <?php echo htmlspecialchars($row['shipment_address']); ?></p>
            <p><b>Total Amount:</b> ₹<?php echo htmlspecialchars($row['total_amount']); ?></p>
            <p><b>Delivered On:</b> <?php echo htmlspecialchars($row['expected_date']); ?></p>

            <span class="badge bg-success fs-6">Delivered</span>
        </div>

    <?php 
        } 
    } 
    ?>

</div>
</body>
</html>
