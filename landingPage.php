<?php
session_start(); 


include 'db_connect.php';

include 'functions.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch user from database
    $sql = "SELECT user_id, username, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            $_SESSION['user_id'] = $user['user_id']; 
            $_SESSION['username'] = $user['username']; 
            logActivity($conn, $username, 'Login', 'User logged into the website.'); // Corrected function call
            header("Location: index.php"); // Redirect to index page
            exit;
        } else {
            
            $error = "Incorrect username or password. Please try again.";
        }
    } else {
        
        $error = "Incorrect username or password. Please try again.";
    }

    $stmt->close();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirai E-Commerce | Login</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
       
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
    <h1>Welcome to Mirai E-Commerce</h1>
    <h2>Shop Tokyo 2020 Olympic Merchandise</h2>
</header>
<div class="container">
    <div class="content">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" name="login" value="Login" class="button">
            <a href="signup.php" class="button">Sign Up</a> <!-- Link for Sign Up -->
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</footer>
</footer>
</body>
</html>
