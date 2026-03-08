<?php
session_start();
include "../config/db.php";

if(!isset($_GET['id'])) die("Invalid Test");
$id = intval($_GET['id']);

$q = mysqli_query($conn, "SELECT * FROM LAB_TEST WHERE test_id = $id");

if(mysqli_num_rows($q) == 0) die("Test not found!");

$test = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $test['test_name']; ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-4">
    <a href="book_lab_test.php" class="btn btn-dark mb-3">Back</a>

    <div class="card p-4">
        <h2><?php echo $test['test_name']; ?></h2>
        <p><?php echo nl2br($test['test_description']); ?></p>
        <p><b>Price:</b> ₹<?php echo $test['test_price']; ?></p>

        <a href="confirm_test.php?id=<?php echo $test['test_id']; ?>" 
           class="btn btn-danger btn-lg">Confirm Booking</a>
    </div>
</div>

</body>
</html>
