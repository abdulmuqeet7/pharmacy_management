<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

$success = "";
if(isset($_GET['success'])){
    $success = "Pathologist successfully assigned!";
}

// Fetch pending reports
$query = "
SELECT 
    lr.report_id,
    lr.customer_id,
    lt.test_name,
    u.name AS customer_name
FROM lab_report lr
JOIN lab_test lt ON lr.test_id = lt.test_id
JOIN users u ON lr.customer_id = u.UID
WHERE lr.pathologist_id IS NULL
ORDER BY lr.report_id DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Pending Lab Reports | Pharmacist</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<h2>Pending Pathologist Assignments</h2>
<hr>

<?php if($success){ ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<?php 
if(mysqli_num_rows($result) == 0){
    echo "<p>No pending reports.</p>";
}

while($row = mysqli_fetch_assoc($result)) { ?>

<div class="card p-3 mb-3">
    <h4><?= htmlspecialchars($row['test_name']) ?></h4>
    <p><b>Customer:</b> <?= htmlspecialchars($row['customer_name']) ?></p>

    <form method="POST" action="assign_pathologist.php">

        <input type="hidden" name="report_id" value="<?= $row['report_id'] ?>">

        <label><b>Select Pathologist:</b></label>
        <select name="pathologist_id" class="form-select" required>
            <option disabled selected>-- Select Pathologist --</option>

            <?php
            // Only ACTIVE pathologists
            $pathologists = mysqli_query($conn, "
                SELECT p.PATH_ID, p.pathologist_name, p.lab_name
                FROM pathologist p
                JOIN users u ON p.PATH_ID = u.UID
                WHERE u.status = 'active'
                ORDER BY p.pathologist_name ASC
            ");

            while($p = mysqli_fetch_assoc($pathologists)){
                echo "<option value='{$p['PATH_ID']}'>
                        {$p['PATH_ID']} - " . htmlspecialchars($p['pathologist_name']) . " - " . htmlspecialchars($p['lab_name']) . "
                      </option>";
            }
            ?>
        </select>

        <button class="btn btn-success mt-3">Assign Pathologist</button>
    </form>
</div>

<?php } ?>

</body>
</html>
