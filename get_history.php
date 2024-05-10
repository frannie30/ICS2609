<?php
session_start();
include 'database_connection.php'; // Include database connection

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit;
}

$userID = $_SESSION['userID'];

$sql = "SELECT * FROM transactions WHERE user_id = '$userID' ORDER BY transaction_date DESC";
$result = $conn->query($sql);

$totalTransactions = 0; // Variable to store total number of transactions

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['transaction_date'] . "</td>";
        echo "<td>" . ucfirst($row['type']) . "</td>"; // Capitalize first letter of type
        echo "<td>" . $row['amount'] . "</td>";
        echo "</tr>";
        $totalTransactions++; // Increment total transactions count
    }
} else {
    echo "<tr><td colspan='3'>No transactions found.</td></tr>";
}
?>
