<?php

$hostname = "localhost";  
$username = "quizoni1_admin"; 
$password = "adminpass123!"; 
$database = "quizoni1_miraiProject"; 


$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match. Please try again.";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert new user into database
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        
        if ($stmt->execute()) {
            
            header("Location: landingPage.php");
            exit;
        } else {
            $error = "Error creating user. Please try again.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirai E-Commerce | Sign Up</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
         /
        body {
            font-family: Arial, sans-serif;
            background-color: #A0AEBC;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }
        html {
            height: 100%; 
        }
        .container {
            max-width: 360px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            background-color: #002366;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        h1, h2 {
            margin: 10px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #002366;
            color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin-top: auto; 
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px; 
        }
        .button:hover {
            background-color: #001f66;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<header>
    <h1>Sign Up for Mirai E-Commerce</h1>
</header>
<div class="container">
    <div class="content">
        <h2>Create Your Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <input type="submit" name="register" value="Register" class="button">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            if (!empty($error)) {
                echo "<div class='error'>$error</div>";
            }
        }
        ?>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
</footer>
</body>
</html>
