<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = intval($_SESSION['uid']);

// Fetch all sales for this customer with shipment info
$query = "
SELECT s.sale_id, s.sale_date, s.total_amount, m.med_name,
       sh.shipment_id, sh.status, sh.expected_date, sh.shipment_address
FROM sales s
JOIN medicine m ON s.med_id = m.med_id
LEFT JOIN shipment sh ON s.sale_id = sh.sale_id
WHERE s.customer_id = $customer_id
ORDER BY s.sale_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders & Shipments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2>My Orders</h2>
    <hr>

    <?php if(!$result || mysqli_num_rows($result) == 0){ ?>
        <p>You have no orders yet.</p>
    <?php } else {
        while($row = mysqli_fetch_assoc($result)){ ?>
            <div class="card p-3 mb-3">
                <h5><?php echo htmlspecialchars($row['med_name']); ?></h5>
                <p><b>Order ID:</b> <?php echo intval($row['sale_id']); ?> &nbsp; <b>Date:</b> <?php echo htmlspecialchars($row['sale_date']); ?></p>
                <p><b>Amount:</b> ₹<?php echo number_format($row['total_amount'],2); ?></p>

                <?php if($row['shipment_id']) { ?>
                    <p><b>Shipment ID:</b> <?php echo intval($row['shipment_id']); ?></p>
                    <p><b>Status:</b> <?php echo htmlspecialchars($row['status']); ?></p>
                    <p><b>Expected:</b> <?php echo htmlspecialchars($row['expected_date']); ?></p>
                    <p><b>Ship To:</b> <?php echo htmlspecialchars($row['shipment_address']); ?></p>
                <?php } else { ?>
                    <p><i>Shipment not created yet.</i></p>
                <?php } ?>
            </div>
        <?php }
    } ?>
</div>
</body>
</html>
