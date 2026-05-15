<?php
session_start();
$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    die("Cart is empty");
}

// FORM DATA
$fullname = $_POST['fullname'];
$contact  = $_POST['contact'];
$address  = $_POST['address'];
$payment  = $_POST['payment_method'];

$user_id = $_SESSION['user_id'];

// TOTAL
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['qty'];
}

// SAVE ORDER
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, fullname, contact, address, payment_method, total)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("issssd", $user_id, $fullname, $contact, $address, $payment, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

// SAVE ITEMS
foreach ($_SESSION['cart'] as $item) {

    $name = $item['name'];
    $price = $item['price'];
    $qty = $item['qty'];
    $subtotal = $price * $qty;

    $stmt2 = $conn->prepare("
        INSERT INTO order_items (order_id, product_name, price, qty, subtotal)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt2->bind_param("isdid", $order_id, $name, $price, $qty, $subtotal);
    $stmt2->execute();
}

// CLEAR CART
unset($_SESSION['cart']);

/* =========================
   REDIRECT BASED ON PAYMENT
========================= */

if ($payment == "GCASH") {
    header("Location: gcash_payment.php?order_id=" . $order_id);
    exit();
} else {
    header("Location: order_success.php?order_id=" . $order_id);
    exit();
}
?>