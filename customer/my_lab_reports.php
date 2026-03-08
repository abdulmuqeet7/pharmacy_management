<?php
session_start();
include "../config/db.php";

// USER MUST BE LOGGED IN
if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['uid'];

// FETCH ALL LAB REPORTS FOR THIS CUSTOMER
$query = " 
    SELECT 
        lr.report_id,
        lr.result,

        lt.test_name,
        lt.test_type,
        lt.description,
        lt.test_cost,

        p.pathologist_name AS pathologist_name,
        p.lab_name AS lab_name,
        p.qualification AS qualification,
        p.licence AS licence,
        p.start_date AS start_date

    FROM lab_report lr

    JOIN lab_test lt 
        ON lr.test_id = lt.test_id

    LEFT JOIN pathologist p 
        ON lr.pathologist_id = p.PATH_ID

    WHERE lr.customer_id = $customer_id

    ORDER BY lr.report_id DESC
";




$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Lab Reports - MedHelp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body { background: #f5f5f5; font-family: 'Segoe UI', Arial; }
        .container-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .report-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fafafa;
            transition: 0.3s;
        }
        .report-card:hover {
            background: white;
            transform: translateY(-4px);
        }
        .no-report {
            text-align: center;
            color: #999;
            font-size: 18px;
            padding: 40px 0;
        }
        .result-box {
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="container col-md-8">

    <div class="container-box">
        <h2 class="mb-4">📄 My Lab Reports</h2>

        <?php if(mysqli_num_rows($result) == 0) { ?>

            <div class="no-report">
                <p>No lab reports found.</p>
            </div>

        <?php } else { 
            while($row = mysqli_fetch_assoc($result)) { ?>

                <div class="report-card">

                    <h4><?php echo $row['test_name']; ?></h4>
<p><b>Type:</b> <?php echo $row['test_type']; ?></p>
<p><b>Cost:</b> ₹<?php echo $row['test_cost']; ?></p>

<p><b>Pathologist:</b> <?php echo $row['pathologist_name'] ?: "Not Assigned"; ?></p>


                    <div class="result-box">
                        <b>Result:</b>
                        <p><?php echo $row['result'] ?: "Result not uploaded yet."; ?></p>
                    </div>

                    <!-- DOWNLOAD BUTTON -->
                    <form method="POST" action="download_report.php" class="mt-3">
                        <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                        <button class="btn btn-primary">
                            ⬇ Download Report
                        </button>
                    </form>

                </div>

        <?php } } ?>

    </div>
</div>

</body>
</html>
