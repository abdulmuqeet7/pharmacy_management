<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist'){
    header("Location: login.php");
    exit;
}

$report_id = $_POST['report_id'];
$pathologist_id = $_POST['pathologist_id'];

// Update LAB_REPORT
mysqli_query($conn, "
    UPDATE lab_report
    SET pathologist_id = $pathologist_id
    WHERE report_id = $report_id
");

// Update report_assignment (optional)
mysqli_query($conn, "
    UPDATE report_assignment
    SET pathologist_id = $pathologist_id
    WHERE report_id = $report_id
");

header("Location: pharmacist_pending_reports.php?success=1");
exit;
?>
