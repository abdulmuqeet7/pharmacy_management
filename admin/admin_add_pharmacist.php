<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$msg = "";

if(isset($_POST['add'])){

    // insert into users table
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // --- PHONE VALIDATION ---
    if(!preg_match('/^[0-9]{10}$/', $phone)){
        $msg = "Phone number must be exactly 10 digits!";
    }
    else {

        $uQuery = "INSERT INTO users (name, gender, phone, email, password, role, address)
                   VALUES ('$name', '$gender', '$phone', '$email', '$password', 'pharmacist', '$address')";
        
        if(mysqli_query($conn, $uQuery)){
            $uid = mysqli_insert_id($conn);

            // insert into pharmacist table
            $lic = $_POST['licence'];
            $qual = $_POST['qualifications'];
            $salary = $_POST['salary'];
            $start = $_POST['start_date'];

            $pQuery = "INSERT INTO pharmacist (PHID, licence, qualifications, salary, start_date)
                       VALUES ($uid, '$lic', '$qual', $salary, '$start')";

            if(mysqli_query($conn, $pQuery)){
                $msg = "Pharmacist added successfully!";
            } else {
                $msg = "Error inserting pharmacist details: " . mysqli_error($conn);
            }

        } else {
            $msg = "Error creating user: " . mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Add Pharmacist</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-dark mb-3">⬅ Back</a>

<h3>Add Pharmacist</h3>
<hr>

<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="POST" class="col-md-7">

    <h5>Login / Profile Details</h5><hr>
    
    <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
    <select name="gender" class="form-select mb-2">
        <option>Male</option>
        <option>Female</option>
    </select>
    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" required>
    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="text" name="password" class="form-control mb-2" placeholder="Password" required>
    <input type="text" name="address" class="form-control mb-3" placeholder="Address" required>

    <h5>Pharmacist Details</h5><hr>

    <input type="text" name="licence" class="form-control mb-2" placeholder="Licence Number" required>
    <input type="text" name="qualifications" class="form-control mb-2" placeholder="Qualifications" required>
    <input type="number" name="salary" class="form-control mb-2" placeholder="Salary" required>
    <input type="date" name="start_date" class="form-control mb-3" required>

    <button name="add" class="btn btn-primary">Add Pharmacist</button>

</form>

</body>
</html>
