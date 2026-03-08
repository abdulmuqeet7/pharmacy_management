<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['uid'];

$query = "
    SELECT c.cart_id, c.qty, 
           m.med_name, m.price, m.image_url, m.med_id
    FROM cart c
    JOIN medicine m ON c.med_id = m.med_id
    WHERE c.customer_id = $customer_id
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Cart</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<div class="container">
  <!-- BACK BUTTON -->
<a href="index.php" class="btn btn-dark mb-3">
    <i class="fa fa-arrow-left"></i> Back
</a>


<h2>My Cart</h2>
<hr>

<?php
$total = 0;

if(mysqli_num_rows($result) == 0){
    echo "<p>Your cart is empty.</p>";
    exit;
}

while($row = mysqli_fetch_assoc($result)){
    $subtotal = $row['qty'] * $row['price'];
    $total += $subtotal;
?>

<div class="card p-3 mb-3">
    <div class="d-flex">

        <img src="images/<?php echo $row['image_url']; ?>" 
             width="90" height="90" class="me-3" 
             onerror="this.src='images/default.jpg'">

        <div style="flex:1">
            <h5><?php echo $row['med_name']; ?></h5>
            <p><b>Price:</b> ₹<?php echo number_format($row['price'],2); ?></p>
            <p><b>Qty:</b> <?php echo $row['qty']; ?></p>
        </div>

        <form method="POST" action="remove_cart_item.php">
            <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
            <button class="btn btn-danger">Remove</button>
        </form>

    </div>
</div>

<?php } ?>

<h4>Total Amount: ₹<?php echo number_format($total,2); ?></h4>

<a href="checkout.php" class="btn btn-success mt-3">Proceed to Checkout</a>

</div>

</body>
</html>
