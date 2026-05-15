<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

/* APPROVE */
if (isset($_GET['approve'])) {

    $id = intval($_GET['approve']);

    mysqli_query($conn,
        "UPDATE orders
         SET approval_status='Approved',
             status='Preparing'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* REJECT */
if (isset($_GET['reject'])) {

    $id = intval($_GET['reject']);

    mysqli_query($conn,
        "UPDATE orders
         SET approval_status='Rejected',
             status='Cancelled'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* OUT FOR DELIVERY */
if (isset($_GET['deliver'])) {

    $id = intval($_GET['deliver']);

    mysqli_query($conn,
        "UPDATE orders
         SET status='Out for Delivery'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* DELIVERED */
if (isset($_GET['done'])) {

    $id = intval($_GET['done']);

    mysqli_query($conn,
        "UPDATE orders
         SET status='Delivered'
         WHERE id='$id'"
    );

    header("location:admin_orders.php");
    exit();
}

/* GET ORDERS */
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");

if (!$orders) {
    die("Fetch Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .sidebar {
            position: fixed;
            width: 230px;
            height: 100%;
            background: #2c3e50;
            padding-top: 30px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .main {
            margin-left: 230px;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #3498db;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            padding: 6px 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            display: inline-block;
            font-size: 12px;
        }

        .approve { background: #27ae60; }
        .reject { background: #e74c3c; }
        .delivery { background: #2980b9; }
        .done { background: #8e44ad; }

        .payment {
            padding: 5px 10px;
            border-radius: 20px;
            background: #2c3e50;
            color: white;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="admin_add_product.php">Add Products</a>
    <a href="admin_orders.php">Orders</a>
    <a href="admin_logout.php">Logout</a>

</div>

<div class="main">

<div class="card">

<h2>Customer Orders</h2>

<table>

<tr>
    <th>Order ID</th>
    <th>Buyer</th>
    <th>Contact</th>
    <th>Address</th>
    <th>Payment Method</th>
    <th>Total</th>
    <th>Approval</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($orders)) { ?>

<tr>

    <td>#<?php echo $row['id']; ?></td>

    <td><?php echo $row['fullname']; ?></td>

    <td><?php echo $row['contact']; ?></td>

    <td><?php echo $row['address']; ?></td>

    <!-- PAYMENT METHOD -->
    <td>
        <span class="payment">
            <?php echo $row['payment_method'] ?? 'COD'; ?>
        </span>
    </td>

    <td>₱<?php echo number_format($row['total'], 2); ?></td>

    <td><?php echo $row['approval_status']; ?></td>

    <td><?php echo $row['status']; ?></td>

    <td>

        <?php if ($row['approval_status'] == "Pending Approval") { ?>

            <a class="btn approve" href="?approve=<?php echo $row['id']; ?>">
                Approve
            </a>

            <a class="btn reject" href="?reject=<?php echo $row['id']; ?>">
                Reject
            </a>

        <?php } ?>

        <?php if ($row['status'] == "Preparing") { ?>

            <a class="btn delivery" href="?deliver=<?php echo $row['id']; ?>">
                Out for Delivery
            </a>

        <?php } ?>

        <?php if ($row['status'] == "Out for Delivery") { ?>

            <a class="btn done" href="?done=<?php echo $row['id']; ?>">
                Delivered
            </a>

        <?php } ?>

    </td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>