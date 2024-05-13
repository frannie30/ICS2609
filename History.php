<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="History.css">
    <script>
    var sortingStates = [true, true, true]; // Array to track sorting order for each column

    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                if (columnIndex === 0) { // For date column
                    if (sortingStates[columnIndex]) {
                        if (new Date(x.innerHTML) > new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (new Date(x.innerHTML) < new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                } else if (columnIndex === 2) { // For amount column
                    if (sortingStates[columnIndex]) {
                        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                } else {
                    if (sortingStates[columnIndex]) {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }

        // Toggle sorting order for the clicked column
        sortingStates[columnIndex] = !sortingStates[columnIndex];
    }

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
<h1>TRANSACTION HISTORY</h1>

<main class="content">

    <div class="sort-container">

    <H3>SORTING OPTIONS</H3>

    <button class="sort-button" onclick="sortTable(0)">Date</button>
    <button class="sort-button" onclick="sortTable(1)">Type</button>
    <button class="sort-button" onclick="sortTable(2)">Amount</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php include 'get_history.php'; ?>
        </tbody>
    </table>
    <br><p>Total Transactions: <?php echo $totalTransactions; ?></p> <!-- Display total number of transactions -->
</main>
</div>

</body>
</html>
