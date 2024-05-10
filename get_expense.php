<?php
session_start();

if (!isset($_SESSION['userID'])) {
    echo "User is not logged in.";
    exit;
}

include 'database_connection.php';

$userID = $_SESSION['userID'];

$sql = "SELECT SUM(amount) AS total_expense FROM transactions WHERE user_id = $userID AND type = 'expense'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_expense = $row['total_expense'];
    
    echo '₱' . number_format($total_expense, 2);
} else {
}

$conn->close();
?>