<?php
session_start();
include "../config/db.php";

// Only pharmacists can access
if (!isset($_SESSION['uid']) || $_SESSION['role'] != 'pharmacist') {
    header("Location: login.php");
    exit;
}

// Fetch pharmacist name
$pid = $_SESSION['uid'];
$q = mysqli_query($conn, "SELECT name FROM users WHERE UID = $pid LIMIT 1");
$pharmacist_name = mysqli_fetch_assoc($q)['name'] ?? "Pharmacist";

// Fetch all medicines
$medQuery = mysqli_query($conn, "SELECT * FROM medicine ORDER BY med_name ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Medicines | Pharmacist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .med-card {
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            transition: .3s;
        }
        .med-card:hover {
            transform: translateY(-4px);
        }
        .med-img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 8px;
        }
    </style>
</head>

<body class="p-4">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>All Medicines</h2>
        <h6 class="text-muted">Welcome, <?php echo htmlspecialchars($pharmacist_name); ?></h6>
    </div>

    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<a href="pharmacist_dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<hr>

<!-- Medicines Grid -->
<div class="row">
<?php while ($m = mysqli_fetch_assoc($medQuery)) { ?>

    <div class="col-md-4 mb-4">
        <div class="med-card">

            <img src="images/<?php echo htmlspecialchars($m['image_url']); ?>"
                 class="med-img"
                 onerror="this.src='https://via.placeholder.com/200?text=No+Image';">

            <h5 class="mt-3"><?php echo htmlspecialchars($m['med_name']); ?></h5>

            <p class="mb-1"><b>Category:</b> <?php echo htmlspecialchars($m['category']); ?></p>
            <p class="mb-1"><b>Dosage:</b> <?php echo htmlspecialchars($m['dosage']); ?></p>
            <p class="mb-1"><b>Stock:</b> 
                <?php echo intval($m['qty']); ?> 
                <?php if ($m['qty'] < 20) { ?>
                    <span class="badge bg-danger">Low</span>
                <?php } ?>
            </p>

            <p class="mb-1"><b>Price:</b> ₹<?php echo number_format($m['price'], 2); ?></p>
            <p class="mb-1"><b>Expiry:</b> <?php echo htmlspecialchars($m['expiry_date']); ?></p>

            <div class="d-grid mt-2">
                <a href="order_medicines.php?restock=<?php echo $m['med_id']; ?>" 
                    class="btn btn-primary btn-sm">
                    Restock
                </a>
            </div>

        </div>
    </div>

<?php } ?>
</div>

</body>
</html>
