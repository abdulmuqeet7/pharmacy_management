<?php
session_start();
include "../config/db.php";

// Validate ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "Invalid request!";
    exit;
}

$med_id = intval($_GET['id']);

// Fetch medicine details
$query = "SELECT * FROM MEDICINE WHERE med_id = $med_id LIMIT 1";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "Medicine not found!";
    exit;
}

$med = mysqli_fetch_assoc($result);
$stock = intval($med['qty']);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($med['med_name']); ?> - Details</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body { background: #f8f9fa; }
        .container { margin-top: 40px; margin-bottom: 40px; }
        .detail-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
        }
        .med-img {
            width: 100%;
            max-height: 330px;
            object-fit: contain;
            padding: 15px;
            border-radius: 10px;
            background: white;
            border: 1px solid #eee;
        }
        .buy-btn { padding: 12px 30px; font-size: 17px; }
        .disabled-btn { background: gray !important; border: none !important; cursor: not-allowed; }
        .share-btn { padding: 12px 25px; margin-left: 10px; }
        .low-stock { color: #d9534f; font-weight: bold; }
    </style>

    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            alert("🔗 Link copied to clipboard!");
        }
    </script>
</head>

<body>

<div class="container">

    <a href="index.php" class="btn btn-dark mb-3">
        <i class="fa fa-arrow-left"></i> Back
    </a>

    <div class="detail-card row">

        <!-- Image -->
        <div class="col-md-5">
            <img src="images/<?php echo htmlspecialchars($med['image_url']); ?>"
                 class="med-img"
                 onerror="this.src='https://via.placeholder.com/300?text=No+Image';">
        </div>

        <!-- Details -->
        <div class="col-md-7">

            <h2 class="med-title"><?php echo htmlspecialchars($med['med_name']); ?></h2>

            <?php if($stock == 0){ ?>
                <span class="badge bg-danger fs-6">Out of Stock</span>
            <?php } elseif($stock <= 5){ ?>
                <span class="low-stock">⚠ Only <?php echo $stock; ?> left!</span>
            <?php } ?>

            <p><b>Dosage:</b> <?php echo htmlspecialchars($med['dosage']); ?></p>
            <p><b>Category:</b> <?php echo htmlspecialchars($med['category']); ?></p>
            <p><b>Expiry Date:</b> <?php echo htmlspecialchars($med['expiry_date']); ?></p>
            <p><b>Price:</b> ₹<?php echo number_format($med['price'], 2); ?></p>

            <div class="desc-box p-3 bg-light border rounded mt-3">
                <h5>Description</h5>
                <p><?php echo nl2br(htmlspecialchars($med['description'])); ?></p>
            </div>

            <!-- BUY NOW + ADD TO CART + SHARE -->

<?php if($stock == 0){ ?>

    <button class="btn disabled-btn buy-btn">
        <i class="fa fa-ban"></i> Unavailable
    </button>
    <p class="text-danger mt-2">This medicine is currently out of stock.</p>

<?php } else { ?>

    <!-- BUY NOW -->
    <button class="btn btn-primary buy-btn"
        onclick="
            <?php if(!isset($_SESSION['uid'])){ ?>
                window.location.href = 'login.php';
            <?php } else { ?>
                window.location.href = 'buy_medicine.php?id=<?php echo $med_id; ?>';
            <?php } ?>
    ">
        <i class="fa fa-bolt"></i> Buy Now
    </button>

    <!-- ADD TO CART
    <button class="btn btn-warning buy-btn ms-2"
        onclick="
            <?php if(!isset($_SESSION['uid'])){ ?>
                window.location.href = 'login.php';
            <?php } else { ?>
                window.location.href = 'add_to_cart.php?id=<?php echo $med_id; ?>';
            <?php } ?>
    ">
        <i class="fa fa-cart-plus"></i> Add to Cart
    </button> -->

<?php } ?>

<!-- SHARE -->
<button class="btn btn-outline-secondary share-btn ms-2" onclick="copyLink()">
    <i class="fa fa-share-alt"></i> Share
</button>


           

        </div>

    </div>
</div>

</body>
</html>
