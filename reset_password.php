<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['verified'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";

if (isset($_POST['reset'])) {

    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $message = "Password not match.";
    } else {

        $email = $_SESSION['reset_email'];

        $conn->query("
            UPDATE users 
            SET password='$new',
                reset_code=NULL,
                reset_expiry=NULL
            WHERE email='$email'
        ");

        unset($_SESSION['verified']);
        unset($_SESSION['reset_email']);

        echo "<script>
            alert('Password reset successful!');
            window.location='login.php';
        </script>";
        exit();
    }
}
?>

<h2>Reset Password</h2>

<form method="POST">

<input type="password" name="new_password" placeholder="New Password" required>
<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button name="reset">Reset Password</button>

</form>

<p><?php echo $message; ?></p>