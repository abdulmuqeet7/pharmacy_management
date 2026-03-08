<?php
session_start();
include "../config/db.php";

// Only pharmacist can access
if(!isset($_SESSION['uid']) || $_SESSION['role'] != "pharmacist"){
    header("Location: login.php");
    exit;
}

$pharmacist_id = intval($_SESSION['uid']);
$success = $error = "";

/* ---------------------------
   FETCH SUPPLIERS (TABLE NAME: supplier)
----------------------------- */

$supplierQuery = mysqli_query($conn, "SELECT * FROM supplier ORDER BY name ASC");

if(!$supplierQuery){
    die("Error fetching suppliers: " . mysqli_error($conn));
}

/* ---------------------------
   FETCH EXISTING MEDICINES
----------------------------- */

$medQuery = mysqli_query($conn, "SELECT med_id, med_name, qty FROM medicine ORDER BY med_name ASC");

?>
<!DOCTYPE html>
<html>
<head>
<title>Order Medicines</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script>
function toggleForms() {
    let type = document.querySelector('input[name=\"med_type\"]:checked').value;
    document.getElementById("existing-box").style.display = (type === "existing") ? "block" : "none";
    document.getElementById("new-box").style.display = (type === "new") ? "block" : "none";
}
</script>
</head>

<body class="p-4">
<div class="container col-md-7">

<h2>Order Medicines</h2>
<a href="pharmacist_dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>
<hr>

<?php
/* ---------------------------
   HANDLE FORM SUBMISSION
----------------------------- */

if(isset($_POST['submit_order'])) {

    if(!isset($_POST['supplier_id']) || $_POST['supplier_id'] == ""){
        $error = "Please select a supplier.";
    } else {

        $supplier_id = intval($_POST['supplier_id']);
        $quantity = intval($_POST['quantity']);
        $med_type = $_POST['med_type'];

        if($quantity <= 0){
            $error = "Quantity must be greater than 0.";
        }
        elseif($med_type == "existing") {

            $med_id = intval($_POST['existing_med_id']);

            // INSERT SUPPLY
            $supplySql = "
                INSERT INTO supply (supplier_id, med_id, quantity, supply_date, pharmacist_id)
                VALUES ($supplier_id, $med_id, $quantity, CURDATE(), $pharmacist_id)
            ";

            if(mysqli_query($conn, $supplySql)){

                mysqli_query($conn,
                    "UPDATE medicine SET qty = qty + $quantity WHERE med_id = $med_id"
                );

                $success = "Stock updated successfully!";
            } 
            else {
                $error = "Supply insert failed: " . mysqli_error($conn);
            }
        }
        else {

            // NEW MED FIELDS
            $new_name = mysqli_real_escape_string($conn, $_POST['new_med_name']);
            $new_price = floatval($_POST['new_price']);
            $new_category = mysqli_real_escape_string($conn, $_POST['new_category']);
            $new_desc = mysqli_real_escape_string($conn, $_POST['new_description']);
            $new_dosage = mysqli_real_escape_string($conn, $_POST['new_dosage']);
            $new_expiry = $_POST['new_expiry'];
            $new_img = mysqli_real_escape_string($conn, $_POST['new_image_url']);

            // INSERT NEW MEDICINE
            $insertMed = "
                INSERT INTO medicine (med_name, price, qty, category, description, dosage, expiry_date, image_url)
                VALUES ('$new_name', $new_price, $quantity, '$new_category', '$new_desc', '$new_dosage', '$new_expiry', '$new_img')
            ";

            if(mysqli_query($conn, $insertMed)){
                $new_med_id = mysqli_insert_id($conn);

                // INSERT SUPPLY RECORD
                mysqli_query($conn, "
                    INSERT INTO supply (supplier_id, med_id, quantity, supply_date, pharmacist_id)
                    VALUES ($supplier_id, $new_med_id, $quantity, CURDATE(), $pharmacist_id)
                ");

                $success = "New medicine added successfully!";
            } 
            else {
                $error = "Error adding new medicine: " . mysqli_error($conn);
            }
        }
    }
}
?>

<?php if($success): ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if($error): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<label><b>Select Supplier</b></label>
<select name="supplier_id" class="form-select mb-3" required>
    <option value="" disabled selected>-- Select Supplier --</option>

    <?php while($s = mysqli_fetch_assoc($supplierQuery)){ ?>
        <option value="<?php echo $s['supplier_id']; ?>">
            <?php echo $s['name'] . " (" . $s['city'] . ")"; ?>
        </option>
    <?php } ?>
</select>

<!-- CHOOSE TYPE -->
<div class="mb-3">
    <label><b>Medicine Type</b></label><br>
    <input type="radio" name="med_type" value="existing" checked onclick="toggleForms()"> Existing Medicine
    &nbsp;&nbsp;
    <input type="radio" name="med_type" value="new" onclick="toggleForms()"> New Medicine
</div>

<!-- EXISTING MED -->
<div id="existing-box" class="border p-3 mb-3">
    <label><b>Select Medicine</b></label>
    <select name="existing_med_id" class="form-select">
        <?php while($m = mysqli_fetch_assoc($medQuery)){ ?>
            <option value="<?php echo $m['med_id']; ?>">
                <?php echo $m['med_name'] . " (Stock: " . $m['qty'] . ")"; ?>
            </option>
        <?php } ?>
    </select>
</div>

<!-- NEW MED -->
<div id="new-box" class="border p-3 mb-3" style="display:none;">

    <label><b>Medicine Name</b></label>
    <input type="text" name="new_med_name" class="form-control mb-2">

    <label><b>Price</b></label>
    <input type="number" name="new_price" step="0.01" class="form-control mb-2">

    <label><b>Category</b></label>
    <input type="text" name="new_category" class="form-control mb-2">

    <label><b>Dosage</b></label>
    <input type="text" name="new_dosage" class="form-control mb-2">

    <label><b>Description</b></label>
    <textarea name="new_description" class="form-control mb-2"></textarea>

    <label><b>Expiry Date</b></label>
    <input type="date" name="new_expiry" class="form-control mb-2">

    <label><b>Image URL</b></label>
    <input type="text" name="new_image_url" class="form-control mb-2">
</div>

<label><b>Quantity</b></label>
<input type="number" name="quantity" min="1" class="form-control mb-3" required>

<button name="submit_order" class="btn btn-primary w-100">Place Order</button>

</form>

</div>
</body>
</html>
