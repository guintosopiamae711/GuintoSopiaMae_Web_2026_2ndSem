<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['admin'])) {
    header("location:admin_login.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

    header("location:admin_view_products.php");
    exit();
}

/* GET PRODUCTS */
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<h2>Products List</h2>

<a href="admin_add_product.php">+ Add Product</a>

<table border="1" cellpadding="10">

<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Actions</th>
</tr>

<?php while($p = mysqli_fetch_assoc($products)) { ?>

<tr>

    <td>
        <img src="uploads/<?php echo $p['image']; ?>" width="60">
    </td>

    <td><?php echo $p['product_name']; ?></td>

    <td>₱<?php echo $p['price']; ?></td>

    <td>

        <a href="admin_edit_product.php?id=<?php echo $p['id']; ?>">
            Edit
        </a>

        |

        <a href="?delete=<?php echo $p['id']; ?>"
           onclick="return confirm('Delete product?')">
            Delete
        </a>

    </td>
    <a href="admin_add_product.php" class="back-btn">
        ← Back
    </a>
</tr>

<?php } ?>

</table>