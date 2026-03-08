<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

$msg = "";

if(isset($_POST['add'])) {

    // Insert into users
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $uQuery = "INSERT INTO users (name, gender, phone, email, password, role, address)
               VALUES ('$name', '$gender', '$phone', '$email', '$password', 'delivery_agent', '$address')";

    if(mysqli_query($conn, $uQuery)){
        $uid = mysqli_insert_id($conn);

        // Insert into delivery_agent
        $salary = $_POST['salary'];
        $vehicle = $_POST['vehicle_no'];

        $aQuery = "INSERT INTO delivery_agent (AGENT_ID, agent_name, salary, vehicle_no)
                   VALUES ($uid, '$name', $salary, '$vehicle')";

        if(mysqli_query($conn, $aQuery)){
            $msg = "Delivery Agent added successfully!";
        } else {
            $msg = "Error inserting agent info: " . mysqli_error($conn);
        }

    } else {
        $msg = "Error creating user: " . mysqli_error($conn);
    }

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Delivery Agent</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<a href="admin_dashboard.php" class="btn btn-dark mb-3">⬅ Back</a>

<h3>Add Delivery Agent</h3>
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

    <h5>Job Details</h5><hr>

    <input type="number" name="salary" class="form-control mb-2" placeholder="Salary" required>
    <input type="text" name="vehicle_no" class="form-control mb-3" placeholder="Vehicle Number" required>

    <button name="add" class="btn btn-primary">Add Delivery Agent</button>
</form>

</body>
</html>
