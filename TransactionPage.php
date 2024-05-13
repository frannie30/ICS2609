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
            // Redirect back to TransactionPage.php with a query parameter to indicate error
            header('Location: TransactionPage.php?error=insufficient_funds');
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
                header('Location: TransactionPage.php');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function validateAmount() {
        var amount = document.getElementById("amount").value; 
        if (amount <= 0 || isNaN(amount)) {
            alert("Amount must be greater than 0.");
            return false;
        }
        return true;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if (error === 'insufficient_funds') {
        alert('You have insufficient funds for this withdrawal.');
    }

    window.onload = function() {
        var currentDate = new Date().toISOString().split('T')[0];
        document.getElementById("date").value = currentDate;
    };

    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.href = 'login.php';
        }
    });
</script>
</head>
<body>
    <div class="navbar">
        <div class="title">Yellow Purse</div>
        <div class="links">
            <a href="TransactionPage.php">Transaction Page</a>
            <a href="History.php">Transaction History</a>
            <form action="logout_process.php" method="post" class="logout">
                <input type="submit" value="Log out">
            </form>
        </div>
    </div>

    <div class="main">
        <h1>TRANSACTIONS</h1>
        <main>
            <header>
                <div>
                    <h5>Total Balance</h5>
                    <?php include 'get_balance.php'; ?>
                </div>
                <div>
                    <h5> Deposit</h5>
                    <?php include 'get_income.php'; ?>
                </div>
                <div>
                    <h5> Withdraw</h5>
                    <?php include 'get_expense.php'; ?>
                </div>
            </header>
            <form action="add_transaction.php" method="post" class="transaction-form" onsubmit="return validateAmount()">
                <label for="type">Type:</label>
                <select name="type" id="type" required>
                <option value="" disabled selected>CHOOSE AN OPTION</option>
                    <option value="income">Deposit</option>
                    <option value="expense">Withdraw</option>
                </select><br>
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" required><br>
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required><br>
                <input type="submit" value="Add Transaction">
            </form>
        </main>
    </div>
</body>
</html>
