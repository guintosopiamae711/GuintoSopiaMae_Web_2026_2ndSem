<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$message = "";

if (isset($_POST['verify'])) {

    $code = trim($_POST['code']);
    $email = $_SESSION['reset_email'];

    // USE PREPARED STATEMENT TO PREVENT SQL INJECTION
    $sql = "SELECT * FROM users WHERE email=? AND reset_code=? AND reset_expiry >= NOW()";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $message = "Database error: " . $conn->error;
    } else {
        $stmt->bind_param("ss", $email, $code);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $_SESSION['verified'] = true;
                header("Location: reset_password.php");
                exit();
            } else {
                $message = "Invalid or expired code.";
            }
        } else {
            $message = "Database error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<h2>Verify Code</h2>

<form method="POST">

<input type="text" name="code" placeholder="Enter code" required>

<button name="verify">Verify</button>

</form>

<p><?php echo $message; ?></p>