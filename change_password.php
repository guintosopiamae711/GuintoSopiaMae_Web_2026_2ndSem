<?php
session_start();

$conn = new mysqli("localhost", "root", "", "farmers_db");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['change_password'])) {

    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {

        $message = "Passwords do not match.";

    } else {

        $stmt = $conn->prepare(
            "SELECT password FROM users WHERE id=?"
        );

        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && $current === $row['password']) {

            $update = $conn->prepare(
                "UPDATE users SET password=? WHERE id=?"
            );

            $update->bind_param("si", $new, $user_id);

            if ($update->execute()) {

                echo "
                <script>
                    alert('Password changed successfully!');
                    window.location='dashboard.php';
                </script>
                ";

                exit();

            } else {

                $message = "Update failed.";
            }

        } else {

            $message = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Change Password</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* BOX */
.box{
    width:420px;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
    position:relative;
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:25px;
    color:#2c3e50;
}

/* INPUTS */
input{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:#27ae60;
    box-shadow:0 0 5px rgba(39,174,96,.4);
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    background:#27ae60;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    background:#219150;
}

/* MESSAGE */
.msg{
    margin-top:15px;
    text-align:center;
    color:red;
    font-weight:bold;
}

/* BACK BUTTON */
.back-btn{
    position:absolute;
    top:15px;
    left:15px;
    background:#3498db;
    color:white;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
}

.back-btn:hover{
    background:#2980b9;
}

</style>

</head>

<body>

<div class="box">

    <!-- BACK BUTTON -->
    <a href="dashboard.php" class="back-btn">
        ← Back
    </a>

    <h2>🔒 Change Password</h2>

    <form method="POST">

        <input
            type="password"
            name="current_password"
            placeholder="Current Password"
            required
        >

        <input
            type="password"
            name="new_password"
            placeholder="New Password"
            required
        >

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm Password"
            required
        >

        <button name="change_password">
            Change Password
        </button>

    </form>

    <div class="msg">
        <?php echo $message; ?>
    </div>

</div>

</body>
</html>