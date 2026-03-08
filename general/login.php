<?php
session_start();

/* -----------------------------
   DATABASE CONNECTION
------------------------------ */

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pharmacy_management";

$conn = mysqli_connect($host, $user, $pass, $dbname,3307);

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* -----------------------------
   LOGIN LOGIC
------------------------------ */
if(isset($_POST['login'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM USERS WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['uid'] = $row['UID'];
        $_SESSION['role'] = $row['role'];
        if($row['status'] == 'inactive'){
    echo "Your account has been deactivated. Contact admin.";
    exit;
}


        // Redirect based on role
        if($row['role'] == "customer"){
            header("Location: index.php");  // customer goes back to homepage
        }
        elseif($row['role'] == "admin"){
            header("Location: admin_dashboard.php");  // customer goes back to homepage
        }
        elseif($row['role'] == "pharmacist"){
            header("Location: pharmacist_dashboard.php");
        }
        elseif($row['role'] == "pathologist"){
            header("Location: pathologist_dashboard.php");
        }
        elseif($row['role'] == "delivery_agent"){
            header("Location: delivery_dashboard.php");
        }
        exit;
    }
    else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | MedHelp Pharmacy</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Arial;
        }

        .login-card {
            width: 380px;
            background: rgba(255,255,255,0.97);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.3);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #c0392b;
        }

        .input-box {
            position: relative;
            margin-bottom: 15px;
        }

        .input-box i {
            position: absolute;
            top: 13px;
            left: 12px;
            font-size: 18px;
            color: #c0392b;
        }

        .input-box input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #c0392b;
            color: white;
            border-radius: 8px;
            border: none;
            margin-top: 10px;
            font-size: 17px;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #a93226;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #c0392b;
            font-weight: bold;
            text-decoration: none;
        }

        .error {
            color: red;
            background: #ffe6e6;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>

<div class="login-card">

    <div class="login-title">
        <i class="fa fa-user-circle"></i> Login
    </div>

    <?php if(isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-box">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>

        <button class="login-btn" name="login">Login</button>

        <div class="register-link">
            New user? <a href="register.php">Create an account</a>
        </div>

    </form>

</div>

</body>
</html>
