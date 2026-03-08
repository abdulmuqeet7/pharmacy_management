<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$msg = "";

if(isset($_POST['add'])){

    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $contact = $_POST['contact_no'];
    $lic = $_POST['license_no'];

    $query = "INSERT INTO supplier (name, address, city, contact_no, license_no)
              VALUES ('$name', '$address', '$city', '$contact', '$lic')";

    if(mysqli_query($conn, $query)){
        $msg = "Supplier added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Supplier</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-dark mb-3">⬅ Back</a>

<h3>Add Supplier</h3>
<hr>

<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="POST" class="col-md-7">
    <input type="text" name="name" class="form-control mb-2" placeholder="Supplier Name" required>
    <input type="text" name="address" class="form-control mb-2" placeholder="Address" required>
    <input type="text" name="city" class="form-control mb-2" placeholder="City" required>
    <input type="text" name="contact_no" class="form-control mb-2" placeholder="Contact No." required>
    <input type="text" name="license_no" class="form-control mb-3" placeholder="License No." required>

    <button name="add" class="btn btn-primary">Add Supplier</button>
</form>

</body>
</html>
