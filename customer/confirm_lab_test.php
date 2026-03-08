<?php
session_start();
include "../config/db.php";

// 1. USER MUST BE LOGGED IN
if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['uid'];

// 2. TEST ID IS REQUIRED
if(!isset($_GET['id'])){
    die("Invalid access — No test selected.");
}

$test_id = intval($_GET['id']);

// 3. FETCH TEST DETAILS
$query = "SELECT * FROM LAB_TEST WHERE test_id = $test_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    die("Test not found.");
}

$test = mysqli_fetch_assoc($result);

// 4. WHEN USER CONFIRMS THE BOOKING
if(isset($_POST['confirm'])){

    $insert = "
    INSERT INTO lab_report (customer_id, test_id, pathologist_id, report_date, result)
    VALUES ($customer_id, $test_id, NULL, CURDATE(), 'Pending')
";


    if(mysqli_query($conn, $insert)){
        header("Location: test_success.php?id=$test_id");
        exit;
    } else {
        echo "Error booking test!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Lab Test | MedHelp</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body { background:#f5f5f5; font-family:'Segoe UI'; }
        .box {
            background:white;
            width:500px;
            margin:40px auto;
            padding:25px;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }
        .btn-confirm {
            background:#e74c3c;
            color:white;
            padding:10px 20px;
            border-radius:8px;
            border:none;
        }
        .btn-confirm:hover {
            background:#c0392b;
        }
    </style>
</head>

<body>

<div class="box">

    <h3 class="mb-3">Confirm Lab Test</h3>
    <hr>

    <h4><?php echo $test['test_name']; ?></h4>
    <p><b>Type:</b> <?php echo $test['test_type']; ?></p>
    <p><b>Cost:</b> ₹<?php echo $test['test_cost']; ?></p>
    <p><b>Description:</b> <?php echo $test['description']; ?></p>

    <form method="POST">
        <button name="confirm" class="btn-confirm">Confirm Booking</button>
        <a href="book_lab_test.php" class="btn btn-secondary">Cancel</a>
    </form>

</div>

</body>
</html>
