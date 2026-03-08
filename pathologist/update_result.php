<?php
session_start();
include "../config/db.php";

// Only pathologist can update report
if (!isset($_SESSION['uid']) || $_SESSION['role'] != 'pathologist') {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['report_id']) || !isset($_POST['result'])) {
    die("Invalid request.");
}

$report_id = intval($_POST['report_id']);
$result = $_POST['result'];
$date = date("Y-m-d");

// Update the lab report
$update = "
    UPDATE lab_report
    SET result = '$result',
        report_date = '$date'
    WHERE report_id = $report_id
";

if (mysqli_query($conn, $update)) {
    // Redirect back with success message
    header("Location: pathologist_dashboard.php?success=1");
    exit;
} else {
    echo "Error updating report.";
}
?>
