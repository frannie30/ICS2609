<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YELLOW PURSE</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function validateAmount() {
        var amount = document.getElementById("amount").value; // Retrieve amount from input field
        if (amount <= 0 || isNaN(amount)) {
            alert("Amount must be greater than 0.");
            return false;
        }
        return true;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    // If error is present, display an alert
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
    <div class="sidenav">
        <div class="title">Yellow Purse</div>
        <a href="index.php">Transaction Page</a>
        <a href="TransactionHistory.php">Transaction History</a>
        <form action="logout_process.php" method="post" class="logout">
            <input type="submit" value="Log out">
        </form>
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