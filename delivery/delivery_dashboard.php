<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'delivery_agent'){
    header("Location: login.php");
    exit;
}

$agent_id = intval($_SESSION['uid']);
$updated = isset($_GET['updated']) ? true : false;

// FETCH DELIVERY AGENT NAME
$nameQuery = mysqli_query($conn, "SELECT name FROM users WHERE UID = $agent_id LIMIT 1");
$agent = mysqli_fetch_assoc($nameQuery);
$agent_name = $agent ? $agent['name'] : "Delivery Agent";

// Fetch ONLY active shipments
$query = "
SELECT 
    sh.shipment_id, sh.sale_id, sh.shipment_address, sh.status, sh.expected_date,
    s.total_amount, m.med_name, u.name AS customer_name
FROM shipment sh
JOIN sales s ON sh.sale_id = s.sale_id
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
WHERE sh.agent_id = $agent_id
AND sh.status != 'Delivered'
ORDER BY sh.shipment_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delivery Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?php echo htmlspecialchars($agent_name); ?> 👋</h2>

        <div>
            <a href="delivered_orders.php" class="btn btn-success me-2">Delivered Orders</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <?php if($updated): ?>
        <div class="alert alert-success">Status updated successfully.</div>
    <?php endif; ?>

    <?php
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<p>No active deliveries assigned.</p>";
    } 
    else {
        while($row = mysqli_fetch_assoc($result)) {
    ?>

        <div class="card p-3 mb-3">
            <h5><?php echo htmlspecialchars($row['med_name']); ?></h5>

            <p><b>Customer:</b> <?php echo htmlspecialchars($row['customer_name']); ?></p>
            <p><b>Address:</b> <?php echo htmlspecialchars($row['shipment_address']); ?></p>
            <p><b>Expected:</b> <?php echo htmlspecialchars($row['expected_date']); ?></p>

            <p><b>Status:</b> 
                <span class="badge bg-warning">
                    <?php echo htmlspecialchars($row['status']); ?>
                </span>
            </p>

            <!-- UPDATE STATUS FORM -->
            <form method="POST" action="update_delivery_status.php">
                <input type="hidden" name="shipment_id" value="<?php echo intval($row['shipment_id']); ?>">

                <label><b>Update Status</b></label>
                <select name="status" class="form-select" required>
                    <option value="In Transit">In Transit</option>    
                    <option value="Delivered">Delivered</option>
                    <option value="Failed">Failed</option>
                </select>

                <button class="btn btn-primary mt-2">Update</button>
            </form>
        </div>

    <?php 
        } 
    } 
    ?>

</div>
</body>
</html>
