<?php
session_start();

include 'database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        if (password_verify($password, $stored_password)) {
            $_SESSION['userID'] = $row['id'];
            header('Location: TransactionPage.php');
            exit;
        } else {
            echo "<script>alert('Invalid email or password!'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password!'); window.location.href = 'login.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form" action="login.php" method="POST">
            <h3 style="text-align: center;">ENTER YOUR CREDENTIALS</h3>
            <br>
            <input type="email" name="email" placeholder="Email" required>
            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span id="show-password" class="toggle-password">Show</span>
            </div>
            <br><br>
            <button type="submit">Login</button> 
            <br> <br>
            <div class="centered">
                <p>Create an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showPassword = document.getElementById('show-password');
            const passwordInput = document.getElementById('password');
            
            showPassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    showPassword.textContent = 'Hide';
                } else {
                    passwordInput.type = 'password';
                    showPassword.textContent = 'Show';
                }
            });
        });
    </script>
</body>
</html>
