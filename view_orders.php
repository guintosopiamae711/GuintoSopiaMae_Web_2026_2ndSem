<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$orders = $conn->query("
    SELECT * FROM orders
    WHERE user_id='$user_id'
    ORDER BY id DESC
");

if (!$orders) {
    die("DB Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>

<style>

body{
    font-family: Arial;
    background: #f4f4f4;
    padding: 20px;
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
    padding:10px 18px;
    background:#27ae60;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
}

.order-box{
    background:white;
    padding:15px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.items{
    background:#fafafa;
    padding:10px;
    border-radius:8px;
    margin-top:10px;
}

.status{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-weight:bold;
    font-size:13px;
}

.pending{ background:orange; }
.preparing{ background:#3498db; }
.delivery{ background:#8e44ad; }
.delivered{ background:#27ae60; }
.cancelled{ background:#e74c3c; }

.payment{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    background:#2c3e50;
    color:white;
    font-weight:bold;
    font-size:13px;
    margin-top:5px;
}

</style>
</head>

<body>

<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

<h2>📦 My Orders</h2>

<?php while ($order = $orders->fetch_assoc()) { ?>

<?php
$status = $order['status'] ?? 'Pending';

$class = "pending";
if ($status == "Preparing") $class = "preparing";
if ($status == "Out for Delivery") $class = "delivery";
if ($status == "Delivered") $class = "delivered";
if ($status == "Cancelled") $class = "cancelled";

/* PAYMENT METHOD */
$payment = $order['payment_method'] ?? 'COD';
?>

<div class="order-box">

    <p><b>Order ID:</b> #<?php echo $order['id']; ?></p>

    <!-- BUYER INFO -->
    <p><b>Name:</b> <?php echo htmlspecialchars($order['fullname']); ?></p>
    <p><b>Address:</b> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><b>Contact:</b> <?php echo htmlspecialchars($order['contact']); ?></p>

    <!-- PAYMENT METHOD -->
    <p>
        <b>Payment Method:</b>
        <span class="payment">
            <?php echo $payment; ?>
        </span>
    </p>

    <p><b>Total:</b> ₱<?php echo number_format($order['total'], 2); ?></p>

    <p><b>Date:</b> <?php echo $order['created_at']; ?></p>

    <p>
        <b>Status:</b>
        <span class="status <?php echo $class; ?>">
            <?php echo $status; ?>
        </span>
    </p>

    <div class="items">

        <h4>🛒 Items</h4>

        <?php
        $order_id = (int)$order['id'];

        $items = $conn->query("
            SELECT * FROM order_items
            WHERE order_id='$order_id'
        ");

        if ($items && $items->num_rows > 0) {

            while ($item = $items->fetch_assoc()) {
        ?>

            <p>
                <?php echo $item['product_name']; ?>
                x<?php echo $item['qty']; ?>
                = ₱<?php echo number_format($item['subtotal'], 2); ?>
            </p>

        <?php
            }
        } else {
            echo "<p>No items found.</p>";
        }
        ?>

    </div>

</div>

<?php } ?>

</body>
</html>