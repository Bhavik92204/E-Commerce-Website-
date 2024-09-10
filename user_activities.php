<?php
session_start();


include 'db_connect.php';


include 'functions.php';

// Check if user is logged in and is an employee
if (!isset($_SESSION['user_id']) || !isEmployee($conn, $_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch user activities from the database
$sql = "SELECT activity_id, username, activity_type, activity_description, activity_timestamp FROM user_activities ORDER BY activity_timestamp DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activities</title>
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
        h1 {
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
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
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
    <h1>User Activities</h1>
</header>
<div class="container">
    <a href="employee_dashboard.php" class="home-button">Back to Dashboard</a>
    <div class="content">
        <h2>User Activities</h2>
        <table>
            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>Username</th>
                    <th>Activity Type</th>
                    <th>Activity Description</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['activity_id']) . "</td>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td>" . htmlspecialchars($row['activity_type']) . "</td>
                                <td>" . htmlspecialchars($row['activity_description']) . "</td>
                                <td>" . htmlspecialchars($row['activity_timestamp']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No user activities found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<footer>
    <p>&copy; 2024 Mirai E-Commerce. All rights reserved.</p>
</footer>
</body>
</html>

<?php
$conn->close();
?>
