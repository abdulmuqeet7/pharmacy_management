<?php
session_start();
include "../config/db.php";

// Search functionality
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query = "SELECT * FROM MEDICINE WHERE med_name LIKE '%$search%'";
} else {
    $query = "SELECT * FROM MEDICINE";
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
    <title>MedHelp - Pharmacy Management System</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        /* HEADER */
        .top-header {
            background: #fff;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo {
            background: #e74c3c;
            color: white;
            padding: 8px 22px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 20px;
            text-decoration: none;
        }

        .top-icons button {
            border: 1px solid #ddd;
            background: white;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .top-icons button:hover {
            border-color: #e74c3c;
            color: #e74c3c;
        }

        .lab-btn {
            background: #e74c3c !important;
            color: white !important;
            border: none !important;
            padding: 10px 20px !important;
        }

        /* HERO SEARCH */
        .search-hero {
            background: linear-gradient(135deg, #2d3436 0%, #000 100%);
            padding: 50px 40px;
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .search-box {
            max-width: 700px;
            margin: auto;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 18px;
            border-radius: 50px;
            border: none;
            font-size: 16px;
        }
        .search-box button {
            position: absolute;
            right: 12px;
            top: 8px;
            height: 45px;
            width: 45px;
            border-radius: 50%;
            background: #e74c3c;
            border: none;
            color: white;
        }

        /* MEDICINE GRID */
        .medicine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            padding: 20px 40px;
        }

        .medicine-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
            text-decoration: none;
            color: black;
        }

        .medicine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .medicine-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        /* FOOTER */
        footer {
            background: #2d3436;
            color: white;
            text-align: center;
            padding: 25px;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="top-header">

    <!-- LOGO -->
    <a href="index.php" class="logo">MedHelp</a>

    <div class="top-icons d-flex align-items-center gap-3">

        <?php if(!isset($_SESSION['uid'])) { ?>

            <!-- LOGIN BUTTON WHEN NOT LOGGED IN -->
            <button onclick="location.href='login.php'">
                <i class="fa fa-sign-in-alt"></i> Login
            </button>

        <?php } else { ?>

            <!-- USER DROPDOWN -->
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user"></i> <?php echo htmlspecialchars($username); ?>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="account_details.php">
                            <i class="fa fa-user-circle"></i> Account Details
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="my_orders.php">
                            <i class="fa fa-box"></i> My Orders
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ⭐ VIEW CART BUTTON
            <button onclick="location.href='cart.php'">
                <i class="fa fa-shopping-cart"></i> View Cart
            </button> -->

            <!-- LOGOUT BUTTON -->
            <button onclick="location.href='logout.php'">
                <i class="fa fa-sign-out-alt"></i> Logout
            </button>

        <?php } ?>

        <!-- BOOK LAB TEST -->
        <button class="lab-btn" onclick="location.href='book_lab_test.php'">
            <i class="fa fa-vial"></i> Book Lab Test
        </button>

    </div>
</div>


<!-- SEARCH HERO -->
<div class="search-hero">
    <h2>Search Medicines & Healthcare Products</h2>
    <form method="GET">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search Medicines..." value="<?php echo $search; ?>">
            <button><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>

<!-- EXPLORE MEDICINES -->
<h2 class="text-center mb-3">Explore Medicines</h2>

<div class="medicine-grid">
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <a href="medicine_detail.php?id=<?php echo $row['med_id']; ?>" class="medicine-card">
        <img src="images/<?php echo $row['image_url']; ?>" onerror="this.src='images/default.jpg';">
        <div class="medicine-name"><?php echo $row['med_name']; ?></div>
    </a>
<?php } ?>
</div>

<footer>
    © 2025 MedHelp Pharmacy | All Rights Reserved
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
