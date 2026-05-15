<?php
$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>GCash Payment</title>

<style>
body{
    font-family: Arial;
    background:#1abc9c;
    text-align:center;
    color:white;
    padding:50px;
}

.box{
    background:white;
    color:black;
    max-width:400px;
    margin:auto;
    padding:20px;
    border-radius:10px;
}

.btn{
    background:#27ae60;
    color:white;
    padding:10px;
    border:none;
    width:100%;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="box">

<h2>💳 GCash Payment</h2>

<p>Order ID: #<?php echo $order_id; ?></p>

<h3>Send payment to:</h3>
<p><b>GCash Number:</b> 09104356589</p>
<p><b>Name:</b>Juan Santos</p>

<h3>After payment click confirm</h3>

<form action="view_orders.php" method="POST">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <button class="btn">I Have Paid</button>
</form>

</div>

</body>
</html>