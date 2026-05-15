<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$conn = new mysqli("localhost", "root", "", "farmers_db");

$message = "";

if (isset($_POST['send'])) {

    $email = $_POST['email'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows > 0) {

        $code = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $conn->query("
            UPDATE users 
            SET reset_code='$code', reset_expiry='$expiry'
            WHERE email='$email'
        ");

        $_SESSION['reset_email'] = $email;

        /* 🔥 SEND EMAIL VIA GMAIL SMTP */
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'guintosopiamae@gmail.com';   // 🔥 palitan mo
            $mail->Password   = 'qftx epfz ucni tgcb';      // 🔥 App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('guintosopiamae@gmail.com', 'Farmers Shop');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body    = "
                <h3>Your Reset Code</h3>
                <h2>$code</h2>
                <p>This code will expire in 10 minutes.</p>
            ";

            $mail->send();

            header("Location: verify_code.php");
            exit();

        } catch (Exception $e) {
            $message = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }

    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
}

.box{
    width:400px;
    margin:80px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:green;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.msg{
    text-align:center;
    color:red;
    margin-top:10px;
}
</style>

</head>

<body>

<div class="box">

<h2>Forgot Password</h2>

<form method="POST">

    <input type="email" name="email" placeholder="Enter email" required>

    <button name="send">Send Code</button>

</form>

<div class="msg">
    <?php echo $message; ?>
</div>

</div>

</body>
</html>