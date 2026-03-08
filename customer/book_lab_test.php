<?php
session_start();
include "../config/db.php";

// Search
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query = "SELECT * FROM LAB_TEST WHERE test_name LIKE '%$search%' OR test_type LIKE '%$search%'";
} else {
    $query = "SELECT * FROM LAB_TEST";
}
$result = mysqli_query($conn, $query);

// If logged in → fetch username
$username = "";
if(isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    $u_query = mysqli_query($conn, "SELECT name FROM USERS WHERE UID = $uid");
    $u = mysqli_fetch_assoc($u_query);
    $username = $u['name'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Lab Test - MedHelp</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background:#f5f5f5; font-family:'Segoe UI'; }

        .top-header {
            background:#fff;
            padding:12px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            background:#e74c3c;
            color:white;
            padding:8px 22px;
            border-radius:8px;
            font-size:20px;
            font-weight:bold;
            cursor:pointer;
            text-decoration:none;
        }
        .logo:hover {
            background:#c0392b;
        }

        .test-box {
            background:white;
            padding:20px;
            border-radius:12px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }
        .btn-book {
            background:#e74c3c;
            color:white;
            padding:8px 18px;
            border-radius:8px;
            border:none;
        }
        .btn-book:hover { background:#c0392b; }

        .search-bar input {
            border-radius:50px;
            padding:12px;
            border:1px solid #ccc;
            width:70%;
        }
        .search-bar button {
            border-radius:50px;
            padding:12px 20px;
            border:none;
            background:#e74c3c;
            color:white;
        }

        .reports-btn {
            background:#0984e3;
            color:white;
            padding:8px 18px;
            border-radius:8px;
            border:none;
        }
        .reports-btn:hover {
            background:#0765b6;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="top-header">

    <!-- Clickable Logo -->
    <a class="logo" href="index.php">MedHelp</a>

    <div>
        <?php if(!isset($_SESSION['uid'])) { ?>

            <button class="btn btn-outline-dark" onclick="location.href='login.php'">
                Login
            </button>

        <?php } else { ?>

            <button class="btn btn-outline-dark">
                <i class="fa fa-user"></i> <?php echo $username; ?>
            </button>

            <button class="btn btn-outline-dark" onclick="location.href='logout.php'">
                Logout
            </button>

            <!-- My Reports Button -->
            <button class="reports-btn" onclick="location.href='my_lab_reports.php'">
                <i class="fa fa-file-medical"></i> My Lab Reports
            </button>

        <?php } ?>
    </div>
</div>

<!-- SEARCH BAR -->
<div class="container mt-4">
    <form class="search-bar text-center mb-4" method="GET">
        <input type="text" name="search" placeholder="Search tests..." value="<?php echo $search; ?>">
        <button><i class="fa fa-search"></i></button>
    </form>

    <h3 class="mb-3">Available Lab Tests</h3>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="test-box">
            <h4><?php echo $row['test_name']; ?></h4>
            <p><b>Type:</b> <?php echo $row['test_type']; ?></p>
            <p><b>Cost:</b> ₹<?php echo $row['test_cost']; ?></p>
            <p><?php echo $row['description']; ?></p>

            <button class="btn-book"
                onclick="location.href='confirm_lab_test.php?id=<?php echo $row['test_id']; ?>'">
                Book Now
            </button>
        </div>
    <?php } ?>
</div>

</body>
</html>
