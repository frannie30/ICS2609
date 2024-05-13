

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var surname = document.getElementById("surname").value;
            var email = document.getElementById("email").value;
            var income = document.getElementById("income").value;
            var password = document.getElementById("password").value;

            var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (!passwordRegex.test(password)) {
                alert("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.");
                return false;
            }

            if (income <= 0) {
                alert("Income must be more than 0.");
                return false;
            }


            return true;
        }
    </script>
</head>
<body>
    

<h2>Sign Up</h2>

<form method="post" action="signup_process.php" onsubmit="return validateForm()">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="surname">Surname:</label><br>
    <input type="text" id="surname" name="surname" required><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="income">Saving Amount:</label><br>
    <input type="number" id="income" name="income" required min="1"><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    
    <div class="checkbox-container">
        <input type="checkbox" id="confirm" name="confirm" required>
        <label for="confirm"> I hereby affirm the accuracy of the information provided.</label>
    </div><br>
    
    <input type="submit" value="Submit">
    
    <div class="centered">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</form>

</body>
</html>
