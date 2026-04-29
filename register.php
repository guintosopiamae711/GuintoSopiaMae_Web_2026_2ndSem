<?php
require_once("connection.php");

$message="";

if(isset($_POST['register'])){

$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];

$check="
SELECT * FROM users
WHERE email='$email'
";

$result=$conn->query($check);

if($result->num_rows>0){

$message="Email already registered!";

}else{

$sql="
INSERT INTO users(username,email,password)
VALUES('$username','$email','$password')
";

if($conn->query($sql)===TRUE){
header("Location: login.php?success=1");
exit();
}else{
$message="Error: ".$conn->error;
}

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#43cea2;
overflow:hidden;
position:relative;
transition:.5s;
}

/* background logo image */
body::before{
content:"";
position:absolute;

width:700px;
height:700px;

background:url('local-farmers-minimalist-logo-design_904722-678.avif')
no-repeat center;

background-size:contain;

opacity:.12;

animation:floatLogo 6s ease-in-out infinite;
}

@keyframes floatLogo{
50%{
transform:
translateY(-20px)
rotate(5deg);
}
}

body.fadeout{
opacity:0;
transform:scale(1.05);
}

.box{
width:390px;
padding:40px;

background:rgba(255,255,255,.90);
backdrop-filter:blur(14px);

border-radius:22px;

box-shadow:
0 20px 45px rgba(0,0,0,.25);

text-align:center;

opacity:0;
transform:translateX(80px);

transition:.8s ease;

z-index:2;
}

.box.show{
opacity:1;
transform:translateX(0);
}

h2{
font-size:38px;
margin-bottom:28px;
color:#2c3e50;
}

input{
width:100%;
padding:14px;
margin:12px 0;

border:1px solid #ddd;
border-radius:10px;

outline:none;
transition:.3s;
}

input:focus{
border-color:#27ae60;
transform:scale(1.02);
box-shadow:0 0 8px rgba(39,174,96,.3);
}

button{
width:100%;
padding:14px;
margin-top:8px;

background:#27ae60;
color:white;
border:none;

font-size:17px;
border-radius:10px;

cursor:pointer;
transition:.3s;
}

button:hover{
background:#219150;
transform:translateY(-2px);
}

.message{
margin-top:15px;
color:red;
font-weight:bold;
}

.link{
margin-top:22px;
font-size:15px;
}

.link a{
text-decoration:none;
font-weight:bold;
color:#2980b9;
}

</style>
</head>
<body>

<div class="box">

<h2>Create Account</h2>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required
>

<input
type="email"
name="email"
placeholder="Email"
required
>

<input
type="password"
name="password"
placeholder="Password"
required
>

<button
type="submit"
name="register">
Register
</button>

</form>

<div class="message">
<?php echo $message; ?>
</div>

<div class="link">
Already have account?
<a href="login.php" class="switch">
Login here
</a>
</div>

</div>

<script>

/* form entrance animation */
window.onload=function(){
document.querySelector(".box")
.classList.add("show");
}

/* animated switch to login */
document.querySelector(".switch")
.addEventListener("click",function(e){

e.preventDefault();

document.querySelector(".box").style.opacity="0";
document.querySelector(".box").style.transform="translateX(-80px)";

document.body.classList.add("fadeout");

setTimeout(()=>{
window.location=this.href;
},500);

});

</script>

</body>
</html>