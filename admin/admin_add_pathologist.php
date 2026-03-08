<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$msg = "";

if(isset($_POST['add'])){

    // USERS TABLE INSERT
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $uQuery = "INSERT INTO users (name, gender, phone, email, password, role, address)
               VALUES ('$name', '$gender', '$phone', '$email', '$password', 'pathologist', '$address')";

    if(mysqli_query($conn, $uQuery)){
        $uid = mysqli_insert_id($conn);

        // PATHOLOGIST TABLE INSERT
        $qualification = $_POST['qualification'];
        $lab_name = $_POST['lab_name'];
        $pname = $_POST['pathologist_name'];
        $lic = $_POST['licence'];
        $start = $_POST['start_date'];

        $pQuery = "INSERT INTO pathologist (PATH_ID, qualification, lab_name, pathologist_name, licence, start_date)
                   VALUES ($uid, '$qualification', '$lab_name', '$pname', '$lic', '$start')";

        if(mysqli_query($conn, $pQuery)){
            $msg = "Pathologist added successfully!";
        } else {
            $msg = "Error inserting pathologist info: " . mysqli_error($conn);
        }

    } else {
        $msg = "Error creating user: " . mysqli_error($conn);
    }

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Pathologist</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<a href="admin_dashboard.php" class="btn btn-dark mb-3">⬅ Back</a>

<h3>Add Pathologist</h3>
<hr>

<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="POST" class="col-md-7">

    <h5>User Details</h5><hr>

    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
    <select name="gender" class="form-select mb-2">
        <option>Male</option>
        <option>Female</option>
    </select>
    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="text" name="password" class="form-control mb-2" placeholder="Password" required>
    <input type="text" name="address" class="form-control mb-3" placeholder="Address" required>

    <h5>Pathologist Details</h5><hr>

    <input type="text" name="qualification" class="form-control mb-2" placeholder="Qualification" required>
    <input type="text" name="lab_name" class="form-control mb-2" placeholder="Lab Name" required>
    <input type="text" name="pathologist_name" class="form-control mb-2" placeholder="Pathologist Name" required>
    <input type="text" name="licence" class="form-control mb-2" placeholder="Licence Number" required>
    <input type="date" name="start_date" class="form-control mb-3" required>

    <button name="add" class="btn btn-primary">Add Pathologist</button>
</form>
</body>
</html>
