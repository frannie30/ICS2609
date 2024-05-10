<?php
include 'database_connection.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    income DECIMAL(10,2) NOT NULL DEFAULT 0
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

$email = $_POST['email'];
$check_email_sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($check_email_sql);

if ($result->num_rows > 0) {
    echo "<script>alert('Email already exists. Please use another email.'); window.location.href = 'signup.php';</script>";
    $conn->close();
    exit(); 
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$income = $_POST['income'];

$insert_sql = "INSERT INTO users (name, surname, email, password, income) VALUES ('$name', '$surname', '$email', '$password', '$income')";

if ($conn->query($insert_sql) === TRUE) {
    header("Location: login.php");
    exit();
} else {
    echo "Error: " . $insert_sql . "<br>" . $conn->error;
}

$conn->close();
?>
