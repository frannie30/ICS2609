<?php
session_start();

if (!isset($_SESSION['userID'])) {
    echo "User is not logged in.";
    exit;
}

include 'database_connection.php';


$userID = $_SESSION['userID'];

$sql = "SELECT SUM(amount) AS total_income FROM transactions WHERE user_id = $userID AND type = 'income'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_income = $row['total_income'];
    
    echo '₱' . number_format($total_income, 2);
} else {
}

$conn->close();
?>
