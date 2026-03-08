<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

$query = "
SELECT 
    lr.report_id,
    lt.test_name,
    u.name AS customer_name,
    p.pathologist_name,
    p.lab_name,
    lr.report_date,
    lr.result
FROM lab_report lr
JOIN lab_test lt ON lr.test_id = lt.test_id
JOIN users u ON lr.customer_id = u.UID
JOIN pathologist p ON lr.pathologist_id = p.PATH_ID
ORDER BY lr.report_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Previous Pathologist Assignments</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h2>Previous Pathologist Assignments</h2>
        <a href="pharmacist_dashboard.php" class="btn btn-outline-secondary">Back</a>
    </div>

    <?php 
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<p>No previous assignments found.</p>";
    } else {

        while($row = mysqli_fetch_assoc($result)){ ?>
        
            <div class="card p-3 mb-3 shadow-sm">
                <h5 class="text-primary"><?php echo htmlspecialchars($row['test_name']); ?></h5>

                <p><b>Customer:</b> <?= htmlspecialchars($row['customer_name']) ?></p>
                <p><b>Pathologist:</b> <?= htmlspecialchars($row['pathologist_name']) ?> (<?= htmlspecialchars($row['lab_name']) ?>)</p>

                <p><b>Report Date:</b> <?= $row['report_date'] ?: "Pending" ?></p>
                <p><b>Result:</b> <?= $row['result'] ?: "Awaiting result" ?></p>
            </div>

    <?php } } ?>

</div>
</body>
</html>
