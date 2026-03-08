<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

$pharmacist_id = $_SESSION['uid'];

$query = "
SELECT sh.shipment_id, sh.sale_id, sh.shipment_address, sh.status, sh.expected_date,
       s.total_amount, m.med_name, u.name AS customer_name,
       da.agent_name
FROM shipment sh
JOIN sales s ON sh.sale_id = s.sale_id
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
JOIN delivery_agent da ON sh.agent_id = da.AGENT_ID
ORDER BY sh.shipment_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Previous Delivery Assignments</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h2>Previous Delivery Assignments</h2>
        <a href="pharmacist_delivery_assignments.php" class="btn btn-outline-secondary">Back</a>
    </div>

    <?php 
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<p>No previous assignments.</p>";
    } else {
        while($row = mysqli_fetch_assoc($result)){ ?>
    
            <div class="card p-3 mb-3 shadow-sm">
                <h5 class="text-primary"><?php echo htmlspecialchars($row['med_name']); ?></h5>

                <p><b>Customer:</b> <?= htmlspecialchars($row['customer_name']) ?></p>
                <p><b>Address:</b> <?= htmlspecialchars($row['shipment_address']) ?></p>
                <p><b>Amount:</b> ₹<?= number_format($row['total_amount'],2) ?></p>
                <p><b>Expected Delivery:</b> <?= htmlspecialchars($row['expected_date']) ?></p>
                <p><b>Delivery Agent:</b> <span class="text-info"><?= htmlspecialchars($row['agent_name']) ?></span></p>
                <p><b>Status:</b> <?= htmlspecialchars($row['status']) ?></p>
            </div>

    <?php } } ?>

</div>

</body>
</html>
