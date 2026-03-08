<?php
session_start();
include "../config/db.php";

$success = "";
$error = "";

if(isset($_POST['register'])){

    $name     = trim($_POST['name']);
    $gender   = $_POST['gender'];
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address  = trim($_POST['address']);

    // -------------------------------
    // VALIDATION
    // -------------------------------

    // Validate phone → must be exactly 10 digits
    if(!preg_match('/^[0-9]{10}$/', $phone)){
        $error = "Phone number must be exactly 10 digits.";
    }
    else {
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM USERS WHERE email='$email'");
        
        if(mysqli_num_rows($check) > 0){
            $error = "Email already registered!";
        } 
        else {
            // Insert into USERS table
            $sql = "INSERT INTO USERS 
                    (name, gender, phone, email, password, role, address, status)
                    VALUES
                    ('$name', '$gender', '$phone', '$email', '$password', 'customer', '$address', 'active')";

            if(mysqli_query($conn, $sql)){

                // Get the auto-generated UID
                $new_uid = mysqli_insert_id($conn);

                // Insert into CUSTOMER table
                mysqli_query($conn, "INSERT INTO CUSTOMER (CID, C_name) 
                                     VALUES ($new_uid, '$name')");

                $success = "Account created successfully! You may now log in.";
            } 
            else {
                $error = "Error creating account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | MedHelp Pharmacy</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #c0392b, #8e241a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Arial;
        }

        .register-card {
            width: 420px;
            background: rgba(255,255,255,0.96);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            color: #c0392b;
        }

        .input-box {
            position: relative;
            margin-bottom: 14px;
        }

        .input-box i {
            position: absolute;
            top: 13px;
            left: 12px;
            color: #c0392b;
            font-size: 17px;
        }

        .input-box input, .input-box select {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border-radius: 8px;
            border: 1px solid #bbb;
        }

        .register-btn {
            width: 100%;
            padding: 12px;
            background: #c0392b;
            border: none;
            color: white;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 17px;
        }

        .register-btn:hover {
            background: #992d21;
        }

        .message {
            text-align: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 6px;
        }

        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }

    </style>

</head>
<body>

<div class="register-card">

    <div class="title"><i class="fa fa-user-plus"></i> Register</div>

    <?php if($success){ echo "<div class='message success'>$success</div>"; } ?>
    <?php if($error){ echo "<div class='message error'>$error</div>"; } ?>

    <form method="POST">

        <div class="input-box">
            <i class="fa fa-user"></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-box">
            <i class="fa fa-venus-mars"></i>
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>
        </div>

        <div class="input-box">
            <i class="fa fa-phone"></i>
            <input type="text" name="phone" placeholder="Phone Number"
                   pattern="[0-9]{10}" maxlength="10" minlength="10"
                   title="Phone number must be exactly 10 digits"
                   required>
        </div>

        <div class="input-box">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-box">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Create Password" required>
        </div>

        <div class="input-box">
            <i class="fa fa-home"></i>
            <input type="text" name="address" placeholder="Address" required>
        </div>

        <button class="register-btn" name="register">Create Account</button>

        <p style="text-align:center; margin-top:10px;">
            Already have an account? <a href="login.php">Login</a>
        </p>

    </form>

</div>

</body>
</html>
