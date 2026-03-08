<?php
$type = $_GET['type'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<title>Success</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<div class="container col-md-6">

    <div class="alert alert-success p-4">
        <h3>Success!</h3>
        <p>
            <?php 
            if($type == "new") echo "New medicine added successfully.";
            elseif($type == "restock") echo "Medicine restocked successfully.";
            else echo "Operation completed.";
            ?>
        </p>

        <a href="order_medicines.php" class="btn btn-primary">Order More</a>
        <a href="pharmacist_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

</div>

</body>
</html>
