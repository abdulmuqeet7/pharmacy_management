<?php
session_start();
include "../config/db.php";

// Must be logged in
if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = intval($_SESSION['uid']);

// Validate medicine ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid request.");
}
$med_id = intval($_GET['id']);

// Fetch medicine
$q = mysqli_query($conn, "SELECT * FROM medicine WHERE med_id = $med_id LIMIT 1");
if(!$q || mysqli_num_rows($q) == 0){
    die("Medicine not found.");
}
$med = mysqli_fetch_assoc($q);

$error = "";

if(isset($_POST['confirm_order'])){

    $qty = intval($_POST['qty']);
    $stock = intval($med['qty']);

    if($qty <= 0){
        $error = "Invalid quantity.";
    }
    elseif($qty > $stock){
        $error = "Not enough stock available.";
    }
    else {

        $price = floatval($med['price']);
        $total = $qty * $price;
        $today = date("Y-m-d");

        // Insert sale
        $ins = "INSERT INTO sales (sale_date, payment_method, total_amount, customer_id, med_id)
                VALUES ('$today', 'COD', '$total', $customer_id, $med_id)";
        mysqli_query($conn, $ins);
        $sale_id = mysqli_insert_id($conn);

        // Reduce stock
        $newStock = $stock - $qty;
        mysqli_query($conn, "UPDATE medicine SET qty = $newStock WHERE med_id = $med_id");

        // Get address
        $addrQ = mysqli_query($conn, "SELECT address FROM users WHERE UID = $customer_id LIMIT 1");
        $addr = "";
        if($addrQ){
            $addrRow = mysqli_fetch_assoc($addrQ);
            $addr = mysqli_real_escape_string($conn, $addrRow['address']);
        }

        // Create shipment
        mysqli_query($conn, "
            INSERT INTO shipment (sale_id, pharmacist_id, agent_id, shipment_address, status)
            VALUES ($sale_id, NULL, NULL, '$addr', 'Pending Assignment')
        ");

        header("Location: order_success.php?sale=$sale_id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buy <?php echo htmlspecialchars($med['med_name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
<div class="container col-md-6">

    <h3>Buy: <?php echo htmlspecialchars($med['med_name']); ?></h3>
    <hr>

    <?php if($error){ ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <p><b>Price:</b> ₹<?php echo number_format($med['price'], 2); ?></p>

    <form method="POST">

        <label><b>Quantity</b></label>
        <input type="number" name="qty" min="1" class="form-control" required>

        <button name="confirm_order" class="btn btn-success mt-3">Confirm Order</button>
        <a href="medicine_detail.php?id=<?php echo $med_id; ?>" class="btn btn-secondary mt-3">Cancel</a>

    </form>

</div>
</body>
</html>
