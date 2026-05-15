<?php
session_start();

if (empty($_SESSION['cart'])) {
    die("Cart is empty");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>

    <style>
        body{
            font-family: Arial;
            background:#f4f4f4;
            padding:20px;
        }

        .box{
            background:white;
            padding:20px;
            max-width:500px;
            margin:auto;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        input, textarea, select{
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #ddd;
            border-radius:6px;
        }

        button{
            width:100%;
            padding:12px;
            background:#27ae60;
            color:white;
            border:none;
            border-radius:6px;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#219150;
        }

        h2{
            text-align:center;
        }
    </style>

</head>
<body>

<div class="box">

<h2>Checkout Information</h2>

<form method="POST" action="place_order.php">

    <label>Full Name:</label>
    <input type="text" name="fullname" required>

    <label>Address:</label>
    <textarea name="address" required></textarea>

    <label>Contact Number:</label>
    <input type="text" name="contact" required>

    <!-- PAYMENT METHOD -->
    <label>Payment Method:</label>
    <select name="payment_method" required>
        <option value="">-- Select Payment --</option>
        <option value="COD">Cash on Delivery (COD)</option>
        <option value="GCASH">GCash</option>
    </select>

    <button type="submit">Place Order</button>

</form>

</div>

</body>
</html>