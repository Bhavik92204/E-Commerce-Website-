<?php
session_start();


include 'db_connect.php';
include 'functions.php';


if (!isset($_SESSION['user_id']) || !isEmployee($conn, $_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
$conn = getDBConnection(); 

// Fetch all purchase items
$sql = "SELECT 
            id,
            order_id,
            user_id,
            product_name, 
            quantity, 
            price, 
            purchase_date 
        FROM 
            purchase_items 
        ORDER BY 
            purchase_date DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Items</title>
    <style>
        /* styles for purchase items page */
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
            max-width: 800px;
            margin: 50px auto;
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
        h2 {
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
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }
        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <h1>Purchase Items</h1>
</header>
<div class="container">
    <a href="employee_dashboard.php" class="home-button">Back to Dashboard</a>
    <div class="content">
        <h2>All Purchased Items</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Purchase Date</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['order_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$row['purchase_date']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
</footer>
</body>
</html>

<?php
// Close statement and connection
$stmt->close();
$conn->close();
?>
