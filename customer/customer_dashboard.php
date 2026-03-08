<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid']) || $_SESSION['role'] != "customer"){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['uid'];

// Fetch customer name
$query = mysqli_query($conn, "SELECT name FROM users WHERE UID = $uid");
$user = mysqli_fetch_assoc($query);
$customer_name = $user['name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .profile-btn {
            border: 1px solid #ddd;
            padding: 8px 16px;
            background: #fff;
            border-radius: 8px;
            cursor: pointer;
        }
        .profile-btn:hover {
            background: #f1f1f1;
        }
    </style>
</head>

<body>

<!-- TOP NAVBAR -->
<div class="d-flex justify-content-between align-items-center p-3 shadow-sm bg-white">

    <div>
        <h3 class="m-0">MedHelp</h3>
    </div>

    <div class="d-flex align-items-center gap-3">

        <!-- USER DROPDOWN -->
        <div class="dropdown">
            <button class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-user"></i> <?php echo htmlspecialchars($customer_name); ?>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="account_details.php">
                    <i class="fa fa-user-circle"></i> Account Details
                </a></li>

                <li><a class="dropdown-item" href="my_orders.php">
                    <i class="fa fa-box"></i> My Orders
                </a></li>
            </ul>
        </div>

        <!-- LOGOUT BUTTON -->
        <a href="logout.php" class="btn btn-outline-dark">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>

        <!-- BOOK LAB TEST -->
        <a href="book_lab_test.php" class="btn btn-danger">
            <i class="fa fa-vial"></i> Book Lab Test
        </a>

    </div>
</div>

<!-- BODY CONTENT -->
<div class="container mt-4">
    <h2>Welcome, <?php echo htmlspecialchars($customer_name); ?>!</h2>
</div>

</body>
</html>
