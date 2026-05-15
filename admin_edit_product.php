<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

$id = $_GET['id'];

$product = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM products WHERE id='$id'")
);

if (isset($_POST['update'])) {

    $name = $_POST['product_name'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $image);

        mysqli_query($conn,
            "UPDATE products
             SET product_name='$name',
                 price='$price',
                 image='$image'
             WHERE id='$id'"
        );

    } else {

        mysqli_query($conn,
            "UPDATE products
             SET product_name='$name',
                 price='$price'
             WHERE id='$id'"
        );
    }

    header("location:admin_view_products.php");
    exit();
}
?>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="product_name"
           value="<?php echo $product['product_name']; ?>"><br><br>

    <input type="number" name="price"
           value="<?php echo $product['price']; ?>"><br><br>

    <img src="uploads/<?php echo $product['image']; ?>" width="80"><br><br>

    <input type="file" name="image"><br><br>

    <button name="update">Update</button>

    <a href="admin_view_products.php" class="back-btn">
        ← Back
    </a>

</form>