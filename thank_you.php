<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        .thank-you-message {
            margin: 50px auto;
            max-width: 600px;
            padding: 20px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .thank-you-message h1 {
            color: #0033a0;
        }
        .thank-you-message p {
            color: #333;
        }
        .back-to-home {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0033a0;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-to-home:hover {
            background-color: #001f66;
        }
    </style>
</head>
<body>
    <div class="thank-you-message">
        <h1>Thank You!</h1>
        <p>Your order has been successfully placed.</p>
        <a href="index.php" class="back-to-home">Back to Home</a>
    </div>
</body>
</html>
