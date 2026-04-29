<?php
session_start();

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

/* kunin username sa session */
$username = isset($_SESSION['username'])
? $_SESSION['username']
: "Customer";


if(!isset($_SESSION['cart'])){
$_SESSION['cart']=[];
}


/* fix old cart items */
foreach($_SESSION['cart'] as $k=>$item){
if(!isset($_SESSION['cart'][$k]['qty'])){
$_SESSION['cart'][$k]['qty']=1;
}
}


/* products */
$products=[
1=>["name"=>"Bigas","price"=>50],
2=>["name"=>"Mais","price"=>30],
3=>["name"=>"Gulay","price"=>20]
];



/* ADD TO CART */
if(isset($_POST['add_cart'])){

$id=$_POST['product_id'];
$qty=(int)$_POST['qty'];

if($qty<1){
$qty=1;
}

if(isset($products[$id])){

$name=$products[$id]['name'];


/* gulay choices */
if(
$id==3 &&
isset($_POST['gulay_type'])
){
$name.=" - ".$_POST['gulay_type'];
}


/* unique key for gulay variants */
$key=$id;

if($id==3){
$key=md5($name);
}


if(isset($_SESSION['cart'][$key])){
$_SESSION['cart'][$key]['qty'] += $qty;
}
else{

$_SESSION['cart'][$key]=[
"name"=>$name,
"price"=>$products[$id]['price'],
"qty"=>$qty
];

}

}

}



/* REMOVE */
if(isset($_GET['remove'])){
$id=$_GET['remove'];
unset($_SESSION['cart'][$id]);
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Farmers Shop</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
margin:0;
}

.header{
background:#2c3e50;
color:white;
padding:15px;
text-align:center;
position:relative;
}

.logout{
position:absolute;
right:20px;
top:20px;
color:white;
text-decoration:none;
}

.orders-btn{
position:absolute;
left:20px;
top:20px;
background:#27ae60;
padding:8px 15px;
border-radius:5px;
text-decoration:none;
color:white;
}

/* greeting */
.greeting{
background:linear-gradient(135deg,#27ae60,#2ecc71);
color:white;
padding:18px;
margin:20px;
border-radius:12px;
font-size:24px;
font-weight:bold;
box-shadow:0 4px 10px rgba(0,0,0,.15);
animation:fadeIn 1s ease;
text-align:center;
}

.greeting span{
color:yellow;
}

@keyframes fadeIn{
from{
opacity:0;
transform:translateY(-15px);
}
to{
opacity:1;
transform:translateY(0);
}
}

.container{
display:flex;
padding:20px;
gap:20px;
}

.products,
.cart{
background:white;
width:50%;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,.1);
}

.product-card{
border:1px solid #ddd;
padding:15px;
margin-bottom:15px;
border-radius:8px;
}

.btn{
background:#3498db;
color:white;
border:none;
padding:8px 15px;
border-radius:5px;
cursor:pointer;
text-decoration:none;
}

.btn-remove{
background:#e74c3c;
}

.place{
background:green;
margin-top:20px;
width:100%;
padding:12px;
}

input[type=number]{
width:60px;
padding:5px;
}

select{
padding:6px;
margin-bottom:10px;
}

.total{
font-size:22px;
font-weight:bold;
margin-top:20px;
}

.order-item{
padding:12px 0;
border-bottom:1px solid #ddd;
}

</style>
</head>
<body>



<div class="header">

<a
href="view_orders.php"
class="orders-btn">
View Orders
</a>

<h2>
Farmers Shop Dashboard
</h2>

<a
href="logout.php"
class="logout">
Logout
</a>

</div>


<!-- GREETING -->
<div class="greeting">
Hi <span><?php echo ucfirst($username); ?></span> Welcome!
Mag order ka na bilis 🛒🌽🥬
</div>



<div class="container">



<!-- PRODUCTS -->
<div class="products">

<h3>Products</h3>


<?php foreach($products as $id=>$p){ ?>

<div class="product-card">

<h4>
<?php echo $p['name'];?>
</h4>

<p>
Price:
₱<?php echo $p['price'];?>
</p>



<form method="POST">

<input
type="hidden"
name="product_id"
value="<?php echo $id;?>"
>



<?php if($id==3){ ?>

<label>
Choose Vegetable:
</label>

<br><br>

<select name="gulay_type">

<option value="Kangkong">
Kangkong
</option>

<option value="Talong">
Talong
</option>

<option value="Sitaw">
Sitaw
</option>

<option value="Pechay">
Pechay
</option>

<option value="Ampalaya">
Ampalaya
</option>

</select>

<br><br>

<?php } ?>


Qty

<input
type="number"
name="qty"
value="1"
min="1"
>

<button
name="add_cart"
class="btn">
Add To Cart
</button>

</form>

</div>

<?php } ?>

</div>





<!-- CART -->
<div class="cart">

<h3>Your Order</h3>

<?php

$total=0;

if(!empty($_SESSION['cart'])){

foreach($_SESSION['cart'] as $id=>$item){

$qty=$item['qty'];

$subtotal=
$item['price']*$qty;

$total += $subtotal;

?>

<div class="order-item">

<b>
<?php echo $item['name'];?>
</b>

x<?php echo $qty;?>

=
₱<?php echo $subtotal;?>


<a
href="?remove=<?php echo $id;?>"
class="btn btn-remove"
>
Remove
</a>

</div>

<?php } ?>


<div class="total">
Total:
₱<?php echo $total;?>
</div>



<form action="place_order.php" method="POST">

<button class="btn place">
Place Order
</button>

</form>

<?php
}else{

echo "
<p>
Cart Empty.
</p>
";

}
?>

</div>


</div>

</body>
</html>