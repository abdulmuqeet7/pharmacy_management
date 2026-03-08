<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

$pharmacist_id = intval($_SESSION['uid']);

$success = "";
if(isset($_GET['success']) && $_GET['success'] == 1){
    $success = "Delivery assigned successfully.";
}

/* Fetch pending shipments for ACTIVE customers */
$query = "
SELECT sh.shipment_id, sh.sale_id, sh.shipment_address, sh.status, sh.expected_date,
       s.total_amount, m.med_name, u.name AS customer_name
FROM shipment sh
JOIN sales s ON sh.sale_id = s.sale_id
JOIN medicine m ON s.med_id = m.med_id
JOIN users u ON s.customer_id = u.UID
WHERE sh.agent_id IS NULL
AND u.status = 'active'
ORDER BY sh.shipment_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Delivery - Pharmacist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pending Delivery Assignments</h2>
        <a href="pharmacist_dashboard.php" class="btn btn-outline-secondary">Back</a>
    </div>

    <!-- NEW BUTTON -->
    <a href="pharmacist_previous_assignments.php" class="btn btn-warning mb-3">
        Previous Assignments
    </a>

    <?php if($success){ ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<p>No pending shipments to assign.</p>";
    } else {

        while($row = mysqli_fetch_assoc($result)){ ?>

            <div class="card p-3 mb-3 shadow-sm">

                <h5 class="text-primary"><?php echo htmlspecialchars($row['med_name']); ?></h5>

                <p><b>Customer:</b> <?php echo htmlspecialchars($row['customer_name']); ?></p>
                <p><b>Address:</b> <?php echo htmlspecialchars($row['shipment_address']); ?></p>
                <p><b>Amount:</b> ₹<?php echo number_format($row['total_amount'],2); ?></p>
                <p><b>Expected Delivery:</b> <?php echo htmlspecialchars($row['expected_date']); ?></p>

                <form method="POST" action="assign_delivery.php">
                    <input type="hidden" name="shipment_id" value="<?php echo intval($row['shipment_id']); ?>">

                    <label><b>Select Delivery Agent</b></label>
                    <select name="agent_id" class="form-select" required>
                        <option value="" disabled selected>Choose agent</option>

                        <?php
                        /* Fetch ACTIVE delivery agents only */
                        $agents = mysqli_query($conn, "
                            SELECT da.AGENT_ID, da.agent_name
                            FROM delivery_agent da
                            JOIN users u ON da.AGENT_ID = u.UID
                            WHERE u.status = 'active'
                            ORDER BY da.agent_name ASC
                        ");

                        while($a = mysqli_fetch_assoc($agents)){
                            echo "<option value='{$a['AGENT_ID']}'>
                                    {$a['AGENT_ID']} - ".htmlspecialchars($a['agent_name'])."
                                  </option>";
                        }
                        ?>
                    </select>

                    <button class="btn btn-success mt-3">Assign Delivery</button>
                </form>

            </div>

    <?php } 
    } ?>

</div>
</body>
</html>
