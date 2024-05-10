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
        <form id="login-form" action="login_process.php" method="POST">
        <br>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <br><br>
            <button type="submit">Login</button> 
            <br> <br>
            <div class="centered">
            <p>Create an account? <a href="signup.php">Sign Up</a></p>
            </div>
            </form>
    </div>
</body>
</html>
