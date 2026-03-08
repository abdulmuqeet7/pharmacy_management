<?php
session_start();
include "../config/db.php";

// User must be logged in
if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$uid = intval($_SESSION['uid']);

// Fetch user info
$query = mysqli_query($conn, "SELECT name, email, phone, gender, address FROM users WHERE UID = $uid LIMIT 1");

if(!$query || mysqli_num_rows($query) == 0){
    die("User not found!");
}

$user = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Account Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI';
        }
        .card-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 40px;
        }
        .title {
            font-weight: bold;
            font-size: 26px;
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 12px;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="card-box">

    <div class="d-flex justify-content-between">
        <h2 class="title">My Account</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <hr>

    <div class="info-row">
        <label>Name:</label>
        <p><?php echo htmlspecialchars($user['name']); ?></p>
    </div>

    <div class="info-row">
        <label>Email:</label>
        <p><?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <div class="info-row">
        <label>Phone:</label>
        <p><?php echo htmlspecialchars($user['phone']); ?></p>
    </div>

    <div class="info-row">
        <label>Gender:</label>
        <p><?php echo htmlspecialchars($user['gender']); ?></p>
    </div>

    <div class="info-row">
        <label>Address:</label>
        <p><?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
    </div>

    <hr>

    <a href="index.php" class="btn btn-secondary">Back</a>
    <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>

</div>

</body>
</html>
