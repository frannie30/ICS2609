<?php
session_start();

if (!isset($_SESSION['userID'])) {
    exit;
}

include 'database_connection.php';


$userID = $_SESSION['userID'];
$sql = "SELECT income FROM users WHERE id=$userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $income = $row['income'];
    $formatted_income = number_format($income, 2); // Format income to two decimal places
    echo "<span id='income'>₱$formatted_income</span>";
} else {
    echo "User's income not found.";
}

$conn->close();
?>