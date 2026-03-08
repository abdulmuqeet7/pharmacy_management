<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$uid = intval($_SESSION['uid']);
$success = "";
$error = "";

// Fetch user details
$q = mysqli_query($conn, "SELECT * FROM users WHERE UID = $uid LIMIT 1");
if(!$q || mysqli_num_rows($q) == 0){
    die("User not found!");
}
$user = mysqli_fetch_assoc($q);


// HANDLE PROFILE UPDATE
if(isset($_POST['update_profile'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update = "
        UPDATE users SET 
        name='$name',
        phone='$phone',
        gender='$gender',
        address='$address'
        WHERE UID = $uid
    ";

    if(mysqli_query($conn, $update)){
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile!";
    }
}


// HANDLE PASSWORD CHANGE
if(isset($_POST['change_password'])){
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if($old_pass != $user['password']){
        $error = "Old password is incorrect!";
    }
    elseif($new_pass !== $confirm_pass){
        $error = "New passwords do not match!";
    }
    else{
        mysqli_query($conn, "UPDATE users SET password='$new_pass' WHERE UID = $uid");
        $success = "Password updated successfully!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body { background:#f5f5f5; font-family:'Segoe UI'; }
        .card-box {
            background:white; padding:25px; border-radius:12px;
            box-shadow:0px 4px 15px rgba(0,0,0,0.1);
            max-width:650px; margin:auto; margin-top:35px;
        }
        .section-title {
            font-size:20px; font-weight:bold; margin-top:25px;
        }
    </style>
</head>

<body>

<div class="card-box">
    <div class="d-flex justify-content-between">
        <h2>Edit Profile</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <hr>

    <?php if($success){ echo "<div class='alert alert-success'>$success</div>"; } ?>
    <?php if($error){ echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <!-- UPDATE PROFILE FORM -->
    <form method="POST">

        <div class="section-title">Profile Information</div>

        <label><b>Name</b></label>
        <input type="text" name="name" class="form-control mb-2" 
               value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label><b>Phone Number</b></label>
        <input type="text" name="phone" class="form-control mb-2" 
               value="<?php echo htmlspecialchars($user['phone']); ?>" required>

        <label><b>Gender</b></label>
        <select name="gender" class="form-select mb-2" required>
            <option value="Male" <?php if($user['gender']=='Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if($user['gender']=='Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if($user['gender']=='Other') echo 'selected'; ?>>Other</option>
        </select>

        <label><b>Address</b></label>
        <textarea name="address" class="form-control mb-3" rows="3" required><?php 
            echo htmlspecialchars($user['address']); ?></textarea>

        <button name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>

    <!-- CHANGE PASSWORD -->
    <form method="POST">
        <div class="section-title">Change Password</div>

        <label><b>Old Password</b></label>
        <input type="password" name="old_password" class="form-control mb-2" required>

        <label><b>New Password</b></label>
        <input type="password" name="new_password" class="form-control mb-2" required>

        <label><b>Confirm New Password</b></label>
        <input type="password" name="confirm_password" class="form-control mb-3" required>

        <button name="change_password" class="btn btn-warning">Change Password</button>
    </form>

    <hr>

    <a href="account_details.php" class="btn btn-secondary">Back</a>

</div>

</body>
</html>
