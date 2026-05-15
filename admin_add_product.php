<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

if (isset($_POST['save'])) {

    $name = $_POST['product_name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $image);

    mysqli_query($conn,
        "INSERT INTO products(product_name, price, image)
         VALUES('$name', '$price', '$image')"
    );

    header("location:admin_add_product.php");
    exit();
}
?>

<h2>Upload Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="product_name" placeholder="Product Name" required><br><br>

    <input type="number" name="price" placeholder="Price" required><br><br>

    <input type="file" name="image" required><br><br>

    <button name="save">Upload</button>

</form>

<br>
<a href="admin_view_products.php">View Products</a>

<a href="admin_orders.php" class="back-btn">
← Back
</a>
