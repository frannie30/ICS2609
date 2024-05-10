<?php
session_start();

include 'database_connection.php';


$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    if (password_verify($password, $stored_password)) {
        $_SESSION['userID'] = $row['id'];

        header('Location: index.php');
        exit; 
    } else {
        echo "<script>alert('Invalid email or password!'); window.location.href = 'login.php';</script>";
    }
} else {
    echo "<script>alert('Invalid email or password!'); window.location.href = 'login.php';</script>";
}

$conn->close();
?>
