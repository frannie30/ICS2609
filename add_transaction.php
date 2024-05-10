<?php
session_start();

include 'database_connection.php';

// SQL code to create the transactions table
$sql_create_transactions_table = "
CREATE TABLE IF NOT EXISTS transactions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// Execute the SQL code to create the transactions table
if ($conn->query($sql_create_transactions_table) === FALSE) {
    echo "Error creating transactions table: " . $conn->error;
}

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type']; 
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $userID = $_SESSION['userID']; 

    // Retrieve user's income
    $sql_income = "SELECT income FROM users WHERE id='$userID'";
    $result_income = $conn->query($sql_income);
    if ($result_income->num_rows > 0) {
        $row_income = $result_income->fetch_assoc();
        $income = $row_income['income'];

        // Check if it's a withdrawal and amount is greater than income
        if ($type == 'expense' && ($amount > $income || $income == 0)) {
            // Redirect back to index.php with a query parameter to indicate error
            header('Location: index.php?error=insufficient_funds');
            exit;
        }

        // Proceed with adding transaction
        $sql_insert_transaction = "INSERT INTO transactions (user_id, type, amount, transaction_date) VALUES ('$userID', '$type', '$amount', '$date')";
        if ($conn->query($sql_insert_transaction) === TRUE) {
            if ($type == 'income') {
                $sql_update_balance = "UPDATE users SET income = income + $amount WHERE id = '$userID'";
            } else {
                $sql_update_balance = "UPDATE users SET income = income - $amount WHERE id = '$userID'";
            }
            if ($conn->query($sql_update_balance) === TRUE) {
                header('Location: index.php');
                exit;
            } else {
                echo "Error updating balance: " . $conn->error . "<br>";
            }
        } else {
            echo "Error inserting transaction: " . $conn->error . "<br>";
        }
    } else {
        echo "User's income not found.";
    }
}

$conn->close();
?>