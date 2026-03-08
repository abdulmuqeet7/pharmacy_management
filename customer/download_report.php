<?php
session_start();
include "../config/db.php";

// User must be logged in
if(!isset($_SESSION['uid'])){
    die("Unauthorized access.");
}

// Must receive report_id
if(!isset($_POST['report_id'])){
    die("Invalid request.");
}

$report_id = intval($_POST['report_id']);

// Fetch report details
$query = "
    SELECT 
        lr.*, 
        lt.test_name, 
        lt.test_type, 
        p.pathologist_name,
        p.lab_name
    FROM lab_report lr
    JOIN lab_test lt ON lr.test_id = lt.test_id
    LEFT JOIN pathologist p ON lr.pathologist_id = p.PATH_ID
    WHERE lr.report_id = $report_id
";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    die("Report not found.");
}

$row = mysqli_fetch_assoc($result);

// Build text content
$content = "=========== MEDHELP LAB REPORT ===========\n\n";
$content .= "Report ID: " . $row['report_id'] . "\n";
$content .= "Test Name: " . $row['test_name'] . "\n";
$content .= "Test Type: " . $row['test_type'] . "\n";
$content .= "Lab: " . ($row['lab_name'] ?: "Not Assigned") . "\n";
$content .= "Pathologist: " . ($row['pathologist_name'] ?: "Not Assigned") . "\n";
$content .= "Report Date: " . ($row['report_date'] ?: "Pending") . "\n\n";

$content .= "=============== RESULT ===============\n";
$content .= ($row['result'] ?: "Result not uploaded yet.") . "\n";
$content .= "======================================\n\n";

// File name
$filename = "LabReport_" . $row['report_id'] . ".txt";

// Headers for download
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Length: " . strlen($content));

// Output text
echo $content;
exit;
?>
