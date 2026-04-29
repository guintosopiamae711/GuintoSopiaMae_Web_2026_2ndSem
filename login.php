<?php
session_start();
require_once("connection.php");

$message = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "
    SELECT * FROM users
    WHERE email='$email'
    AND password='$password'
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Wrong Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background: white;
            width: 350px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,.2);
            text-align: center;
            animation: fadeIn 1s ease;
        }

        h2 {
            margin-bottom: 25px;
            color: #2c3e50;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 7px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #27ae60;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 7px;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            background: #219150;
        }

        .message {
            color: red;
            margin-top: 12px;
            font-weight: bold;
        }

        .success {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .link {
            margin-top: 20px;
            font-size: 14px;
        }

        .link a {
            text-decoration: none;
            font-weight: bold;
            color: #2980b9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="box">

    <h2>Login Account</h2>

    <?php
    if (isset($_GET['success'])) {
        echo "<div class='success'>Registered Successfully! Login now.</div>";
    }
    ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <div class="message">
        <?php echo $message; ?>
    </div>

    <a href="forgot_password.php" class="forgot password">Forgot Password?</a>

    <div class="link">
        No account yet? <a href="register.php">Register here</a>
    </div>

</div>

</body>
</html>