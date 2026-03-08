<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['uid'])){
    header("Location: login.php");
    exit;
}

$customer_id = intval($_SESSION['uid']);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    die("Invalid request.");
}

$med_id = intval($_GET['id']);

// Check if item already exists in cart
$check = mysqli_query($conn,
    "SELECT qty FROM cart WHERE customer_id=$customer_id AND med_id=$med_id"
);

if(mysqli_num_rows($check) > 0){
    // increase qty
    mysqli_query($conn,
        "UPDATE cart SET qty = qty + 1 
         WHERE customer_id=$customer_id AND med_id=$med_id"
    );
} else {
    // insert new row
    mysqli_query($conn,
        "INSERT INTO cart (customer_id, med_id, qty) 
         VALUES ($customer_id, $med_id, 1)"
    );
}

header("Location: cart.php?added=1");
exit;
