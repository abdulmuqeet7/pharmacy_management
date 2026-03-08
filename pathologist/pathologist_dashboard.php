<?php
session_start();
include "../config/db.php";

// Only pathologist can access
if (!isset($_SESSION['uid']) || $_SESSION['role'] != 'pathologist') {
    header("Location: login.php");
    exit;
}

$pathologist_id = $_SESSION['uid'];

// Fetch assigned reports (only those not completed)
$query = "
SELECT 
    lr.report_id,
    lt.test_name,
    u.name AS customer_name,
    lr.result
FROM lab_report lr
JOIN lab_test lt ON lr.test_id = lt.test_id
JOIN users u ON lr.customer_id = u.UID
WHERE lr.pathologist_id = $pathologist_id
AND lr.result = 'Pending'
ORDER BY lr.report_id DESC
";
$result = mysqli_query($conn, $query);

// Fetch Pathologist Name
$path_q = mysqli_query($conn, "SELECT name FROM users WHERE UID = $pathologist_id");
$path = mysqli_fetch_assoc($path_q);
?>
<!DOCTYPE html>
<html>
<head>
<title>Pathologist Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<!-- HEADER WITH LOGOUT -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Welcome, <?php echo $path['name']; ?> (Pathologist)</h2>

    <button onclick="location.href='logout.php'" class="btn btn-danger">
        Logout
    </button>
</div>

<h3>Assigned Lab Reports</h3>
<hr>

<!-- SUCCESS MESSAGE -->
<?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">Result updated successfully!</div>
<?php } ?>

<?php
if (mysqli_num_rows($result) == 0) {
    echo "<p>No pending reports assigned to you.</p>";
}

while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="card p-3 mb-3 shadow-sm">

        <h4><?php echo $row['test_name']; ?></h4>
        <p><b>Customer:</b> <?php echo $row['customer_name']; ?></p>
        <p><b>Report ID:</b> <?php echo $row['report_id']; ?></p>

        <form method="POST" action="update_result.php">

            <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">

            <label><b>Update Result:</b></label>
            <select name="result" class="form-select" required>
                <option disabled selected>Select Result</option>
                <option value="Pass">Pass</option>
                <option value="Fail">Fail</option>
                <option value="Inconclusive">Inconclusive</option>
            </select>

            <button class="btn btn-primary mt-2">Submit Result</button>
        </form>

    </div>

<?php } ?>

</body>
</html>
