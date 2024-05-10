<?php

include 'database_connection.php';


$sql = "CREATE TABLE IF NOT EXISTS transactions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating transactions table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS balance (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    income DECIMAL(10, 2) DEFAULT 0.00,
    expense DECIMAL(10, 2) DEFAULT 0.00,
    total DECIMAL(10, 2) DEFAULT 0.00
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating balance table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    $description = $_POST["description"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];

    $sql = "INSERT INTO transactions (type, description, amount, date) VALUES ('$type', '$description', '$amount', '$date')";
    if ($conn->query($sql) === TRUE) {
        if ($type == 'Income') {
            $sql = "UPDATE balance SET income = income + $amount, total = total + $amount";
        } else {
            $sql = "UPDATE balance SET expense = expense + $amount, total = total - $amount";
        }
        if ($conn->query($sql) === TRUE) {
            echo "Transaction added successfully";
        } else {
            echo "Error updating balance: " . $conn->error;
        }
    } else {
        echo "Error adding transaction: " . $conn->error;
    }
}

$conn->close();
?>
