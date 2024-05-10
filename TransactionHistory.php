<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="TransactionHistory.css">

    <script>
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
                
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
    var amountAsc = true; // Flag to track sorting order
    
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
                
                if (columnIndex === 2) { // For amount column
                    if (amountAsc) {
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
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        
        // Toggle sorting order for amount column
        if (columnIndex === 2) {
            amountAsc = !amountAsc;
        }
    }
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

<main class="content">
    <h1>Transaction History</h1>
    <br>
    <button class="sort-button" onclick="sortTable(0)">Sort by Date</button>
    <button class="sort-button" onclick="sortTable(1)">Sort by Type</button>
    <button class="sort-button" onclick="sortTable(2)">Sort by Amount</button>
    


    
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


</body>
</html>
