<?php
session_start();
include "../config/db.php";

// Only logged-in customer
if (!isset($_SESSION['uid']) || $_SESSION['role'] != "customer") {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['uid'];

$query = "
SELECT 
    s.sale_id, s.med_id, s.total_amount, s.sale_date, s.payment_method,
    m.med_name, m.image_url,
    sh.status, sh.expected_date, sh.shipment_address
FROM sales s
JOIN medicine m ON s.med_id = m.med_id
LEFT JOIN shipment sh ON sh.sale_id = s.sale_id
WHERE s.customer_id = $customer_id
ORDER BY s.sale_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body {
        background: #f5f5f5;
        font-family: "Segoe UI";
    }
    .order-card {
        background: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 15px;
    }
    .order-img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border-radius: 8px;
        background: #fff;
        border: 1px solid #eee;
        padding: 5px;
    }
    .order-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .order-info {
        font-size: 14px;
        margin-bottom: 3px;
    }
    .badge {
        font-size: 12px;
        padding: 6px 10px;
    }
</style>
</head>

<body class="p-3">

<div class="container">

    <!-- BACK BUTTON -->
    <a href="index.php" class="btn btn-dark mb-3">
        ← Back
    </a>

    <h3 class="mb-4">My Orders</h3>

    <?php 
    if (mysqli_num_rows($result) == 0) {
        echo "<div class='alert alert-info'>You have no orders yet.</div>";
    }

    while($row = mysqli_fetch_assoc($result)) { 
    ?>
        <div class="order-card">

            <div class="row">

                <!-- IMAGE -->
                <div class="col-3 col-md-2">
                    <img src="images/<?php echo $row['image_url']; ?>" 
                         class="order-img"
                         onerror="this.src='images/default.jpg';">
                </div>

                <!-- DETAILS -->
                <div class="col-9 col-md-10">

                    <div class="order-title"><?php echo htmlspecialchars($row['med_name']); ?></div>

                    <div class="order-info"><b>Sale ID:</b> <?php echo $row['sale_id']; ?></div>
                    <div class="order-info"><b>Date:</b> <?php echo $row['sale_date']; ?></div>
                    <div class="order-info"><b>Payment:</b> <?php echo $row['payment_method']; ?></div>
                    <div class="order-info"><b>Amount:</b> ₹<?php echo number_format($row['total_amount'],2); ?></div>
                    <div class="order-info"><b>Address:</b> <?php echo $row['shipment_address'] ?: "Not Assigned"; ?></div>
                    <div class="order-info"><b>Expected:</b> <?php echo $row['expected_date'] ?: "Not Assigned"; ?></div>

                    <div class="order-info">
                        <b>Status:</b> 
                        <span class="badge 
                            <?php 
                                echo ($row['status'] == 'Delivered') ? 'bg-success' : 
                                     (($row['status'] == 'Failed') ? 'bg-danger' : 'bg-warning');
                            ?>">
                            <?php echo $row['status'] ?: "Pending"; ?>
                        </span>
                    </div>

                    <!-- REORDER BUTTON -->
                    <a href="medicine_detail.php?id=<?php echo $row['med_id']; ?>" 
                       class="btn btn-primary btn-sm mt-2">
                        Reorder
                    </a>

                </div>

            </div>
        </div>
    <?php } ?>

</div>

</body>
</html>
